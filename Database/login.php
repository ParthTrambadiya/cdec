<?php
    session_start();
    require_once 'CSRF.php';
    require 'DB_Config.php';

    $login = new DB_Config();
    $status = '';
    $session_id_login_new = session_id();
    $session_id_login_old = '';
    session_commit();

    date_default_timezone_set("Asia/Calcutta");
    $date1 = new DateTime();
    $d1 = $date1->format('Y-m-d H:i:s');

    $date2 = new DateTime('2020-09-12 09:00:00');
    $d2 = $date2->format('Y-m-d H:i:s');

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

$passphrase = "bhavnatahelyani";
    function CryptoJSAesEncrypt($passphrase, $plain_text){

        $salt = openssl_random_pseudo_bytes(256);
        $iv = openssl_random_pseudo_bytes(16);
        //on PHP7 can use random_bytes() istead openssl_random_pseudo_bytes()

        $iterations = 999;
        $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

        $encrypted_data = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);
        $data = [];
        $data['ciphertext'] = base64_encode($encrypted_data);
        $data["iv"] = bin2hex($iv);
        $data["salt"] = bin2hex($salt);
        return json_encode($data);
    }

    $key = pack('H*', "0123456789abcdef0123456789abcdef");
    $iv = pack('H*', "abcdef9876543210abcdef9876543210");

    $encryptedtoken = $_POST['CSRFToken'];
    $decryptedtoken = openssl_decrypt($encryptedtoken, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $token = $decryptedtoken;

    // Validating the request
    if (true)
    {
        if (isset($_POST['emailUser']) && isset($_POST['passwordUser']))
        {
            $encryptedemail = $_POST['emailUser'];
            $decryptedemail = openssl_decrypt($encryptedemail, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $email = test_input($decryptedemail);

            $encryptedpswd = $_POST['passwordUser'];
            $decryptedpswd = openssl_decrypt($encryptedpswd, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $pswd = test_input($decryptedpswd);

            $query = 'SELECT * FROM users where email="'.$email.'"';
            $statement = $login->conn->prepare($query);
            $statement->execute();

            $total_row = $statement->rowCount();

            if($total_row > 0 )
            {
                if($d1 >= $d2)
                {
                    $result = $statement->fetchAll();

                    foreach ($result as $row)
                    {
                        $status = $row["activation_status"];
                        $session_id_login_old = $row["sessionid"];
                    }

                    if($status == 'blocked') {
                        echo CryptoJSAesEncrypt($passphrase, 'blocked');
                    }
                    else {
                        session_id($session_id_login_old);
                        session_start();
                        session_destroy();
                        session_commit();

                        session_id($session_id_login_new);
                        session_start();
                        foreach ($result as $row)
                        {
                            $_SESSION['fnameUser'] = $row["firstname"];
                            $_SESSION['lnameUser'] = $row["lastname"];
                            $_SESSION['emailUser'] = $row["email"];
                            $_SESSION['stid'] = $row['stid'];
                            $_SESSION['passUser'] = $row["password"];
                            $_SESSION['credits'] = $row['credits'];
                            $_SESSION['level'] = $row['level'];
                            $_SESSION['statusUser'] = $row["activation_status"];
                            $_SESSION['sessionid'] = $session_id_login_new;
                            $_SESSION['last_login_timestamp'] = time();
                        }
                        $update = $login->conn->prepare("UPDATE users SET sessionid='".$session_id_login_new."' WHERE email='".$email."'");
                        $update->execute();

                        if($_SESSION['statusUser'] == "not verified")
                        {
                            $login->conn = null;
                            echo CryptoJSAesEncrypt($passphrase, 'not verified');
                        }
                        else if (!password_verify($pswd, $_SESSION['passUser']))
                        {
                            $qAttempt = 'SELECT attempt FROM users where email="'.$_SESSION['emailUser'].'"';
                            $stAttempt = $login->conn->prepare($qAttempt);
                            $stAttempt->execute();

                            $dbValue = $stAttempt->fetchAll();

                            foreach ($dbValue as $row) {
                                $newValue = $row['attempt'];
                            }

                            $newValue = $newValue + 1;

                            $qAttemptUp = "UPDATE users SET attempt='".$newValue."' WHERE email='".$_SESSION['emailUser']."'";
                            $stAttemptUp = $login->conn->prepare($qAttemptUp);
                            $stAttemptUp->execute();

                            if($newValue > 3) {
                                $upStatus = "UPDATE users SET activation_status='blocked' WHERE email='".$_SESSION['emailUser']."'";
                                $stUpStatus = $login->conn->prepare($upStatus);
                                $stUpStatus->execute();
                            }
                            $login->conn = null;
                            $ans = CryptoJSAesEncrypt($passphrase, 'not matched');
                            echo $ans;
                        }
                        else if(password_verify($pswd, $_SESSION['passUser']))
                        {
                            $qAttemptUp = "UPDATE users SET attempt='0' WHERE email='".$_SESSION['emailUser']."'";
                            $stAttemptUp = $login->conn->prepare($qAttemptUp);
                            $stAttemptUp->execute();

                            if($_SESSION['statusUser'] == 'verified') {
                                $_SESSION['checklogin'] = "yes";
                            }
                            $login->conn = null;
                            echo CryptoJSAesEncrypt($passphrase, 'success');
                        }
                        else
                        {
                            $login->conn = null;
                            echo CryptoJSAesEncrypt($passphrase, 'Something went wrong');
                        }
                    }
                }
                else
                {
                    $login->conn = null;
                    echo CryptoJSAesEncrypt($passphrase, 'wait');
                }
            }
            else
            {
                $login->conn = null;
                echo CryptoJSAesEncrypt($passphrase, 'Email not found');
            }
        }
    }
    else
    {
        $login->conn = null;
        echo CryptoJSAesEncrypt($passphrase, 'index');
    }


