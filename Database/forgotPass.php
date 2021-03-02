<?php
session_start();
session_destroy();
session_start();
require 'DB_Config.php';

$forgot = new DB_Config();
$ismailsend = 'no';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$passphrase = "bhavnatahelyani";
function CryptoJSAesEncrypt($passphrase, $plain_text){

    $salt = openssl_random_pseudo_bytes(256);
    $iv = openssl_random_pseudo_bytes(16);
    //on PHP7 can use random_bytes() istead openssl_random_pseudo_bytes()

    $iterations = 999;
    $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

    $encrypted_data = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

    $data = array("ciphertext" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "salt" => bin2hex($salt));
    return json_encode($data);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$key = pack('H*', "0123456789abcdef0123456789abcdef");
$iv = pack('H*', "abcdef9876543210abcdef9876543210");

if(isset($_POST['email'])){
    $encryptedemail = $_POST['email'];
    $decryptedemail = openssl_decrypt($encryptedemail, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $email = test_input($decryptedemail);

    $system_otp = rand(100000, 999999);
    $message_body = '
     <p>For reset your password, you have to enter this verification code prompted: <b>'.$system_otp.'</b>.</p>
     <p>The following OTP will be valid for next 3 minutes.</p>
     <p>Sincerely,</p>
     ';

    $query = "
           SELECT * FROM users 
           WHERE email = '".$email."'
           ";

    $statement = $forgot->conn->prepare($query);
    $statement->execute();
    $total_row = $statement->rowCount();

    if($total_row > 0){
        //Load Composer's autoloader
        require '../PHPMailer/vendor/autoload.php';

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
            $mail->addAddress($email);

            if($mail->send()){
                $_SESSION['new_otp'] = $system_otp;
                $_SESSION['emailForgot'] = $email;

                date_default_timezone_set("Asia/Calcutta");
                $date = new DateTime();
                //$_SESSION['registerOtpTime'] = $date->format('Y-m-d H:i:s');

                $date->add(new DateInterval('PT10M'));
                $_SESSION['forgotPassOtp15'] = $date->format('Y-m-d H:i:s');


                $ismailsend = 'yes';
                echo 'yes';
            }
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>