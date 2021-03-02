<?php
session_start();
require 'DB_Config.php';

$otpdb = new DB_Config();

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['email']))
{
    $_SESSION['emailNew'] = $_GET['email'];

    $user_new_otp =  rand(100000, 999999);

    $message_body_new = '
   <p>For verifying your email address, enter this verification code prompted: <b>'.$user_new_otp.'</b>. </p>
   <p>The following OTP will be valid for next 3 minutes.</p>
   <p>Best Regards,</p>
   <p>Team CDEC</p>
   ';

    //Load Composer's autoloader
    require '../PHPMailer/vendor/autoload.php';

    $mailNew = new PHPMailer(true);

    try {
        //Server settings
        $mailNew->isSMTP();                                            // Send using SMTP
        //$mail->SMTPDebug = 2;
        $mailNew->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mailNew->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mailNew->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mailNew->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mailNew->isHTML();                                  // Set email format to HTML
        $mailNew->Username   = 'cdeccharusat@gmail.com';                     // SMTP username
        $mailNew->Password   = '#superioreventsudouser28*';                               // SMTP password
        $mailNew->setFrom('cdeccharusat@gmail.com', 'CDec');
        $mailNew->Subject = 'Verification code to verify your email address';

        $mailNew->Body = $message_body_new;
        $mailNew->addAddress($_GET['email']);

        if($mailNew->send()){

            $query = 'SELECT email FROM users WHERE email="'.$_SESSION['emailNew'].'"';

            $statement = $otpdb->conn->prepare($query);
            $statement->execute();
            $total_row = $statement->rowCount();

            if($total_row > 0)
            {
                $_SESSION['user_new_otp'] = $user_new_otp;
                date_default_timezone_set("Asia/Calcutta");
                $date = new DateTime();
                //$_SESSION['registerOtpTime'] = $date->format('Y-m-d H:i:s');

                $date->add(new DateInterval('PT3M'));
                $_SESSION['emailVerifyTime15'] = $date->format('Y-m-d H:i:s');

                header('location:../emailVerifyOtp');
            }
            else{
                echo '<script>alert("First register your email")</script>';
            }
        }
        else{
            echo '<script>alert("Something went wrong..")</script>';
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mailNew->ErrorInfo}";
    }
}
