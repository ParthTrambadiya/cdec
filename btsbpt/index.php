<?php

    include_once("db-config.php");

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();
    session_start();

    $session_id = session_id();
    session_commit();

    if(isset($_SESSION['email'])) {
        header("Location: dashboard.php");
    }

    if(!isset($_SESSION['attempts'])) {
        $_SESSION['attempts'] = 0;
    }

    $table_check = $pdo->prepare("SELECT * FROM admin");
    $table_check->execute();
    $result = $table_check->rowCount();
	if($result == 0) {
        // return TRUE;
        header("Location: create-admin-account.php");
	}
	else
	{
        if(isset($_POST['submit'])) {
            $key = pack('H*', "0123456789abcdef0123456789abcdef");
            $iv = pack('H*', "abcdef9876543210abcdef9876543210");

            $encryptedEmail = $_POST['email'];
            $decryptedEmail = openssl_decrypt($encryptedEmail, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $decryptedEmail = trim($decryptedEmail);

            $encryptedPwd = $_POST['password'];
            $decryptedPwd = openssl_decrypt($encryptedPwd, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $decryptedPwd = trim($decryptedPwd);

            $email = mysqli_real_escape_string($conn, $decryptedEmail);
            $password = mysqli_real_escape_string($conn, $decryptedPwd);

            if(!empty($email) || !empty($password)){

                $sql = $pdo->prepare("SELECT * From admin where email=? limit 1");
                if($sql->execute([$email])) {
                    if($sql->rowCount() != 0) {
                        $row = $sql->fetch();
                        if(password_verify($password, $row['password'])) {
                            // echo "<script type='text/javascript'>window.alert('".count($row)."');</script>";
                            if($_SESSION['attempts'] > 2) {
                                $message = "Too many failed attempts!";
                                echo "<script type='text/javascript'>window.alert('$message');</script>";
                                echo "<script type='text/javascript'>history.go(-1);</script>";
                            } else {
                                session_id($row['sessionid']);
                                session_start();
                                session_destroy();
                                session_commit(); 
                                
                                session_id($session_id);
                                session_start();
                                
                                $_SESSION['sessionid'] = $session_id;
                                $_SESSION['id'] = $row['id'];
                                $_SESSION['fullname'] = $row['fullname'];
                                $_SESSION['email'] = $row['email'];
                                $_SESSION['password'] = $row['password'];
                                $_SESSION['img'] = $row['img'];
                                $_SESSION['reg_date'] = $row['reg_date'];

                                $update = $pdo->prepare("UPDATE admin SET sessionid=? WHERE id='ADMIN'");
                                $update->execute([$_SESSION['sessionid']]);

                                if(isset($_SESSION['email'])){
                                    echo "<script type='text/javascript'>window.location.href='dashboard.php';</script>";
                                } else {
                                    $_SESSION['attempts'] += 1;
                                    if($_SESSION['attempts'] > 2) {
                                        $message = "Too many failed attempts!";
                                        echo "<script type='text/javascript'>window.alert('$message');</script>";
                                        echo "<script type='text/javascript'>history.go(-1);</script>";
                                    } else {
                                        $message = "Incorrect email or password!";
                                        echo "<script type='text/javascript'>window.alert('$message');</script>";
                                        echo "<script type='text/javascript'>history.go(-1);</script>";
                                    }
                                }
                            }
                        } else {
                            $_SESSION['attempts'] += 1;
                            if($_SESSION['attempts'] > 2) {
                                $message = "Too many failed attempts!";
                                echo "<script type='text/javascript'>window.alert('$message');</script>";
                                echo "<script type='text/javascript'>history.go(-1);</script>";
                            } else {
                                $message = "Incorrect password!";
                                echo "<script type='text/javascript'>window.alert('$message');</script>";
                                echo "<script type='text/javascript'>history.go(-1);</script>";
                            }
                        }
                    } else {
                        $_SESSION['attempts'] += 1;
                        if($_SESSION['attempts'] > 2) {
                            $message = "Too many failed attempts!";
                            echo "<script type='text/javascript'>window.alert('$message');</script>";
                            echo "<script type='text/javascript'>history.go(-1);</script>";
                        } else {
                            $message = "Incorrect email!";
                            echo "<script type='text/javascript'>window.alert('$message');</script>";
                            echo "<script type='text/javascript'>history.go(-1);</script>";
                        }
                    }
                } else {
                    $message = "Error while logging in!";
                    echo "<script type='text/javascript'>window.alert('$message');</script>";
                }
            } else {
                $message = "Please enter email and password!";
                echo "<script type='text/javascript'>window.alert('$message');</script>";
                echo "<script type='text/javascript'>history.go(-1);</script>";
            }
        }
    }
    $pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CDec</title>

    <!--Bootstrap CSS CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js" integrity="sha512-nOQuvD9nKirvxDdvQ9OMqe2dgapbPB7vYAMrzJihw5m+aNcf0dX53m6YxM4LgA9u8e9eg9QX+/+mPu8kCNpV2A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/aes.min.js" integrity="sha512-eqbQu9UN8zs1GXYopZmnTFFtJxpZ03FHaBMoU3dwoKirgGRss9diYqVpecUgtqW2YRFkIVgkycGQV852cD46+w==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/enc-hex.min.js" integrity="sha512-jDU0YCduSP8z0cvjfPFm7/zN/viOcmNWlq0GUIcjVhuv4WoKcMppghamg4aeuBtJaA0wjtYfxwQjPpVuYGEsBA==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/pad-zeropadding.min.js" integrity="sha512-txZjFJoDvbM8FJj9HuAHasxA/M76UjnMCXLHwuciIGDKUW9EB9PJVA6foG0vymuK9hu2gdpL60imO9VrTlEF7w==" crossorigin="anonymous"></script>
    <script src="./assets/plugins/jquery/jquery.min.js"></script>

    <!--Custom CSS-->
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
    <!-- form action="index.php" -->
    <div class="col-lg-6 m-auto">
        <form id="login_form" action="index.php" method="POST">
            <br><br><br><br><br>
            <div class="card p-3">
                <div class="card-header">
                    <h1 class="text-white text-center">Login</h1>
                </div>
                <div class="card-body">
                    <label>Email:</label>
                    <input type="text" name="emailTemp" placeholder="Email" class="form-control" required/>
                    <input type="text" name="email" placeholder="Email" hidden id="email" class="form-control"/>
                    <br>
                    <label>Password:</label>
                    <input type="password" name="passwordTemp" placeholder="Password" class="form-control" required/>
                    <input type="password" name="password" placeholder="Password" hidden id="password" class="form-control"/>
                    <br>
                    <input type="submit" class="btn btn-secondary my-3" name="submit" value="Login">
                </div>
            </div>
        </form>
    </div>
    <script>
      if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
      }
    </script>
    <script src="inpval.js"></script>

    <!--Bootstrap JS CDN-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>