<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

include_once("db-config.php");
require './assets/plugins/vendor/autoload.php';

$message = "This is sample mail send by me using gmail API and PHPMailer XOAUTH2 Authentication.";

// echo phpinfo();

$mail = new PHPMailer;
$mail->isSMTP();

//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->Host = 'smtp.gmail.com';
$mail->Port = '587';

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

$mail->SMTPAuth= true;

//Set AuthType to use XOAUTH2
$mail->AuthType = 'XOAUTH2';

$clientId = '406106251966-fj6urilf676g3qbrpkn77hthiikv967c.apps.googleusercontent.com';
$clientSecret = '8CRiGfAXN6rNqTlUP2GQogkj';

//Obtained by configuring and running get_oauth_token.php
//after setting up an app in Google Developer Console.
$refreshToken = '1//0ggAnDSuQVWM-CgYIARAAGBASNwF-L9IrdoU0o_eyhNIO8_FpNHxVG-n5Nz7SdHN6frqdCukIhnbH9mIJn7G044c8UMMgoFp0gRI';

//Create a new OAuth2 provider instance
$provider = new Google(
    [
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]
);

//Pass the OAuth provider instance to PHPMailer
$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => 'cdeccharusat@gmail.com',
        ]
    )
);

$mail->isHTML();

$mail->setFrom('cdeccharusat@gmail.com', 'Team CDEC');

$mail->Subject = "Trial message - CDEC";
$mail->Body = $message;
// $mail->AddStringAttachment($attachment, 'Membership_Payment.pdf', 'base64', 'application/pdf');
$mail->AddAddress('ccna1304@gmail.com');
$mail->AddAddress('18ce127@charusat.edu.in');
$mail->AddAddress('18ce130@charusat.edu.in');
$mail->AddAddress('18ce129@charusat.edu.in');

if($mail->Send()) {
    echo "Success";
    echo "<script>alert('Success!');</script>";
} else {
    echo "Mail not sent: " . $mail->ErrorInfo;
    echo "<script>window.alert('Mailer Error: ' + $mail->ErrorInfo)</script>";
}

?>