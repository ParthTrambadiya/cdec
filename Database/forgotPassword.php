<?php
session_start();
require 'DB_Config.php';
$forgot = new DB_Config();

date_default_timezone_set("Asia/Calcutta");
$date = new DateTime();
$d = $date->format('Y-m-d H:i:s');

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

if($d > $_SESSION['forgotPassOtp15'])
{
    echo 'otp expire';
}
else
{
    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['user_otp'])){

        $encryptedemail = $_POST['email'];
        $decryptedemail = openssl_decrypt($encryptedemail, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $email = test_input($decryptedemail);

        $encryptedpass = $_POST['password'];
        $decryptedpass = openssl_decrypt($encryptedpass, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $pass = $decryptedpass;

        $encryptedotp = $_POST['user_otp'];
        $decryptedotp = openssl_decrypt($encryptedotp, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $otp = trim($decryptedotp);

        if(($_SESSION['emailForgot'] == $email) && ($_SESSION['new_otp'] == $otp)){
            $user_password = password_hash($pass, PASSWORD_DEFAULT);

            $query = "
                      UPDATE users SET password = '".$user_password."'  
                      WHERE email = '".$email."'
                     ";

            $statement = $forgot->conn->prepare($query);

            if($statement->execute()){
                $qAttemptUp = "UPDATE users SET attempt='0' WHERE email='".$_SESSION['emailForgot']."'";
                $stAttemptUp = $forgot->conn->prepare($qAttemptUp);
                $stAttemptUp->execute();

                echo 'Password changed succesfully';
            }
        }
        else{
            $qAttempt = 'SELECT attempt FROM users where email="'.$_SESSION['emailForgot'].'"';
            $stAttempt = $forgot->conn->prepare($qAttempt);
            $stAttempt->execute();

            $dbValue = $stAttempt->fetch();

            $newValue = $dbValue['attempt'];

            $newValue = $newValue + 1;

            $qAttemptUp = "UPDATE users SET attempt='".$newValue."' WHERE email='".$_SESSION['emailForgot']."'";
            $stAttemptUp = $forgot->conn->prepare($qAttemptUp);
            $stAttemptUp->execute();

            if($newValue > 2) {
                $upStatus = "UPDATE users SET activation_status='blocked' WHERE email='".$_SESSION['emailForgot']."'";
                $stUpStatus = $forgot->conn->prepare($upStatus);
                $stUpStatus->execute();
                echo 'blocked';
            }
            else
            {
                echo 'otp is wrong';
            }

        }
    }
}

