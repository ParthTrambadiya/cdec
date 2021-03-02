<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once("db-config.php");
require './assets/plugins/vendor/autoload.php';

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();

$key = pack('H*', "0123456789cdec0123456789cdeccdec");
$iv = pack('H*', "abcdef9876543210abcdef9876543210");

$encSubject = $_POST['subject'];
$decSubject = openssl_decrypt($encSubject, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decSubject = trim($decSubject);

$encMailTo = $_POST['mailTo'];
$decMailTo = openssl_decrypt($encMailTo, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decMailTo = trim($decMailTo);

$encMessage = $_POST['message'];
$decMessage = openssl_decrypt($encMessage, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decMessage = trim($decMessage);

$subject = mysqli_real_escape_string($conn, $decSubject);
$mailTo = mysqli_real_escape_string($conn, $decMailTo);
$message = mysqli_real_escape_string($conn, $decMessage);

if(isset($_POST['date'])) {
    $encDate = $_POST['date'];
    $decDate = openssl_decrypt($encDate, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $decDate = trim($decDate);
    $date = mysqli_real_escape_string($conn, $decDate);
}
if(isset($_POST['time'])) {
    $encTime = $_POST['time'];
    $decTime = openssl_decrypt($encTime, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $decTime = trim($decTime);
    $time = mysqli_real_escape_string($conn, $decTime);
}

$restrictedKeywords = ['alert', 'script', 'onload', 'onerror', 'img', 'href', 'prompt', 'iframe', 'input', 'update'];

$valid = 1;
foreach($restrictedKeywords as $key) {
    if(strpos(strtolower($message), $key) !== false) {
        $valid = 0;
        $msg = "Message could not be sent due to security issues.";
        echo "<script>alert('$msg');</script>";
        echo "<script>history.go(-1);</script>";
        break;
    }
}

if($valid == 1) {
    if(isset($_POST['schedule'])) {
        $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);
            $ins = $pdo->prepare("INSERT INTO sendmails(mailto, subject, message, schedule, sch_date, sch_time) VALUES (?, ?, ?, ?, ?, ?)");
            if($ins->execute([$mailTo, $subject, $message, $schedule, $date, $time])) {
                $msg = "Message added to schedule send.";
                echo "<script>alert('$msg');</script>";
                echo "<script>location.href='messages.php';</script>";
            } else {
                $msg = "Message schedule failed.";
                echo "<script>alert('$msg');</script>";
                echo "<script>history.go(-1);</script>";
            }
    } else {
        $schedule = 0;
        
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
        $mail->setFrom('cdeccharusat@gmail.com', 'Team CDEC');
        $mail->Subject = $subject;

        $mail->Body = $message;

        if($mailTo == "allusers") {
            $sel = $pdo->prepare("SELECT email FROM users");
            $sel->execute();
            while($em = $sel->fetch()) {
                $mail->addAddress($em['email']);
            }
            if($mail->Send()) {
                $ins = $pdo->prepare("INSERT INTO sendmails(mailto, subject, message, schedule, status) VALUES (?, ?, ?, ?, ?)");
                $st = "sent";
                $ins->execute([$mailTo, $subject, $message, $schedule, $st]);
                $msg = "Message sent.";
                echo "<script>alert('$msg');</script>";
                echo "<script>location.href='messages.php';</script>";
            } else{
                $msg = "Message send failed.";
                echo "<script>alert('$msg');</script>";
                echo "<script>history.go(-1);</script>";
            }
        } elseif($mailTo == "level25up") {
            $sel = $pdo->prepare("SELECT email FROM users WHERE level BETWEEN 25 AND 50");
            $sel->execute();
            while($em = $sel->fetch()) {
                $mail->addAddress($em['email']);
            }
            if($mail->Send()) {
                $ins = $pdo->prepare("INSERT INTO sendmails(mailto, subject, message, schedule, status) VALUES (?, ?, ?, ?, ?)");
                $st = "sent";
                $ins->execute([$mailTo, $subject, $message, $schedule, $st]);
                $msg = "Message sent.";
                echo "<script>alert('$msg');</script>";
                echo "<script>location.href='messages.php';</script>";
            } else{
                $msg = "Message send failed.";
                echo "<script>alert('$msg');</script>";
                echo "<script>history.go(-1);</script>";
            }
        } elseif($mailTo == "level50up") {
            $sel = $pdo->prepare("SELECT email FROM users WHERE level>=50");
            $sel->execute();
            while($em = $sel->fetch()) {
                $mail->addAddress($em['email']);
            }
            if($mail->Send()) {
                $ins = $pdo->prepare("INSERT INTO sendmails(mailto, subject, message, schedule, status) VALUES (?, ?, ?, ?, ?)");
                $st = "sent";
                $ins->execute([$mailTo, $subject, $message, $schedule, $st]);
                $msg = "Message sent.";
                echo "<script>alert('$msg');</script>";
                echo "<script>location.href='messages.php';</script>";
            } else{
                $msg = "Message send failed.";
                echo "<script>alert('$msg');</script>";
                echo "<script>history.go(-1);</script>";
            }
        } elseif(substr($mailTo, 0, 5) == "user.") {
            $userId = substr($mailTo, 5);
            // echo $userId;
            $sel = $pdo->prepare("SELECT email FROM users WHERE id=?");
            $sel->execute([$userId]);
            $em = $sel->fetch();
            $mail->addAddress($em['email']);
            if($mail->Send()) {
                $ins = $pdo->prepare("INSERT INTO sendmails(mailto, subject, message, schedule, status) VALUES (?, ?, ?, ?, ?)");
                $st = "sent";
                $ins->execute([$mailTo, $subject, $message, $schedule, $st]);
                $msg = "Message sent.";
                echo "<script>alert('$msg');</script>";
                echo "<script>location.href='messages.php';</script>";
            } else{
                $msg = "Message send failed.";
                echo "<script>alert('$msg');</script>";
                echo "<script>history.go(-1);</script>";
            }
        }
    }
}

?>