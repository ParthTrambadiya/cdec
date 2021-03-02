<?php

	function sendmail($email,$message){
        try {
            // Load Composer's autoloader
            require '../PHPMailer/vendor/autoload.php';

            $mail = new PHPMailer(true);

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
            $mail->From = 'cdeccharusat@gmail.com';
            $mail->Subject = 'Verification code for Verify Your Email Address';

            $mail->Body = $message;

            $mail->addAddress($email);

               if($mail->Send())
                return true;
               else
                return false;

        } catch (Exception $e) {
            return false;
        }
	}
?>