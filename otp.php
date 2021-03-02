<?php
    session_start();
    if(!isset($_SESSION['email'])) {
        header("location:index");
    }

    require './Database/DB_Config.php';
    require './Database/sendmail.php';
    $otpdb = new DB_Config();

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $error_user_otp = '';
    $msg = '';
    $resendmsg = '';

    if(isset($_GET['action'])) {
        if($_GET['action'] == 'resend'){

            $user_otp = rand(100000, 999999);
            $message_body = '
   <p>For verifying your email address, enter this verification code prompted: <b>'.$user_otp.'</b>. </p>
   <p>The following OTP will be valid for next 3 minutes.</p>
   <p>Best Regards,</p>
   <p>Team CDEC</p>
   ';

            //Load Composer's autoloader
            require './PHPMailer/vendor/autoload.php';

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                //$mail->SMTPDebug = 2;
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->isHTML();                                  // Set email format to HTML
                $mail->Username   = 'cdeccharusat@gmail.com';                     // SMTP username
                $mail->Password   = '#superioreventsudouser28*';                               // SMTP password
                $mail->setFrom('cdeccharusat@gmail.com', 'CDec');
                $mail->Subject = 'Verification code to verify your email address';

                $mail->Body = $message_body;
                $mail->addAddress($_SESSION['email']);

                if($mail->send()){
                    date_default_timezone_set("Asia/Calcutta");
                    $date = new DateTime();
                    //$_SESSION['registerOtpTime'] = $date->format('Y-m-d H:i:s');

                    $date->add(new DateInterval('PT3M'));
                    $_SESSION['registerOtpTime15'] = $date->format('Y-m-d H:i:s');

                    $query = 'select * from users where email="'.$_SESSION['email'].'"';

                    $statement = $otpdb->conn->prepare($query);
                    $statement->execute();
                    $total_row = $statement->rowCount();


                    if($total_row > 0)
                    {
                        $_SESSION['otp'] = $user_otp;
                        $resendmsg = '<label class="color-blue pl-2 pt-2">Please check your registered email for new OTP.</label>';
                    }
                    else{
                        echo '<script>alert("First register your email")</script>';
                    }
                }
                else{
                    echo '<script>alert("Something went wrong..")</script>';
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }
    }

    if(isset($_POST['submit'])){
        if(empty($_POST['otp']))
        {
            $error_user_otp = '<label class="text-danger pl-2 pt-2">Enter your otp</label>';
        }
        else
        {
            $user_otp = $_POST['otp'];

            date_default_timezone_set("Asia/Calcutta");
            $date = new DateTime();
            $d = $date->format('Y-m-d H:i:s');

            if($d > $_SESSION['registerOtpTime15']) {
                $msg = '<label class="text-danger pl-2 pt-2">This OTP is expired, please request for new OTP.</label>';
            }
            else {
                if($user_otp == $_SESSION['otp']) {
                    $query = "
                UPDATE users 
                SET activation_status = 'verified' 
                WHERE email = '".$_SESSION['email']."'
                ";
                    $statement = $otpdb->conn->prepare($query);

                    if($statement->execute()){
                        header('location:index');
                    }
                }
                else{
                    $msg = '<label class="text-danger pl-2 pt-2">Invalid OTP Number</label>';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CDEC</title>
    <link rel="icon" href="./assets/logo.png">

    <!--Bootstrap CSS CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!--Custom CSS-->
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <!--OTP-->
    <section class="otp">
        <div class="container">
            <div class="row align-items-center justify-content-center" style="height: 100vh;">
                <div class="col-md-7">
                    <div class="card" style="box-shadow: .1px 1px 10px 0 rgba(255, 255, 255, 1);">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-justify">
                                    <h1 class="font-roboto text-center">Email Verification</h1>
                                    <h6 class="font-baloo px-5">We have sent an OTP on your following email <span class="color-blue"><?php echo $_SESSION['email'];?></span>. Please enter that OTP below.</h6>
                                </div>
                                <div class="col-12">
                                    <form method="post" id="otpform" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" class="px-5">
                                        <div class="row form-group font-baloo mt-5">
                                            <div class="col-12 mb-3 mb-md-0">
                                                <label class="color-second" for="otp">OTP</label>
                                                <input type="text" id="otp" name="otp" class="form-control rounded" maxlength="6" placeholder="Enter OTP">
                                                <?php echo $error_user_otp;?>
                                                <?php echo $msg;?>
                                                <?php echo $resendmsg;?>
                                                <div class="text-right">
                                                    <label><a href="otp.php?action=resend" name="resend" class="font-baloo color-blue outline-none btn">Resend OTP</a></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group font-baloo">
                                            <div class="g-recaptcha" data-sitekey="6LcyN8gZAAAAACRWo9vaOoIbkc1odTVurr1G4CgE"></div>
                                            <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" name="submit" class="btn btn-hover color text-white font-baloo">Verify</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--!OTP-->
    <!--JS-->
    <script src="./jquery-3.3.1.min.js"></script>
    <script src="./jquery-migrate-3.0.1.min.js"></script>

    <!--Bootstrap JS CDN-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <!--validation-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

    <script>
        $.validator.setDefaults({
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element)
                    .closest('.form-control, .custom-control-input')
                    .addClass('is-invalid');
                $(element).addClass('shadow-none');
            },
            unhighlight: function(element) {
                $(element)
                    .closest('.form-control, .custom-control-input')
                    .removeClass('is-invalid');
                $(element).removeClass('shadow-none');
            }
        });
        $('#otpform').validate({
            ignore: ".ignore",
            rules: {
                hiddenRecaptcha: {
                    required: function () {
                        if (grecaptcha.getResponse() == '') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            },
            messages: {
                hiddenRecaptcha: "CAPTCHA is required"
            }
        });
    </script>
</body>
</html>
