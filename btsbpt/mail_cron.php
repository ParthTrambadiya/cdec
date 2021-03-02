<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once("db-config.php");
require './assets/plugins/vendor/autoload.php';

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();

date_default_timezone_set("Asia/Calcutta");

$stmt = $pdo->prepare("SELECT * FROM sendmails WHERE schedule=1 AND status<>'sent'");
if($stmt->execute()) {
    echo "Executed.<br>";
    if($stmt->rowCount() > 0) {
        echo "Scheduled mails found.<br>";
        while($result = $stmt->fetch()) {
            $day = date('d');
            $hour = date('H');
            $sch_date = $result['sch_date'];
            $sch_time = $result['sch_time'];
            if(date('d', strtotime($sch_date)) == $day) {
                echo "same day<br>";
                if(date('H', strtotime($sch_time)) == $hour) {
                    echo "same hour<br>";
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
                    $mail->Subject = $result['subject'];

                    $mail->Body = $result['message'];

                    if($result['mailto'] == "allusers") {
                        $sel = $pdo->prepare("SELECT email FROM users");
                        $sel->execute();
                        while($em = $sel->fetch()) {
                            $mail->addAddress($em['email']);
                        }
                        if($mail->Send()) {
                            $ins = $pdo->prepare("UPDATE sendmails SET status='sent' WHERE id=?");
                            $ins->execute([$result['id']]);
                            echo "Message sent.<br>";
                        } else {
                            echo "Message send failed.";
                        }
                    } elseif($result['mailto'] == "level25up") {
                        $sel = $pdo->prepare("SELECT email FROM users WHERE level BETWEEN 25 AND 50");
                        $sel->execute();
                        while($em = $sel->fetch()) {
                            $mail->addAddress($em['email']);
                        }
                        if($mail->Send()) {
                            $ins = $pdo->prepare("UPDATE sendmails SET status='sent' WHERE id=?");
                            $ins->execute([$result['id']]);
                            echo "Message sent.<br>";
                        } else {
                            echo "Message send failed.";
                        }
                    } elseif($result['mailto'] == "level50up") {
                        $sel = $pdo->prepare("SELECT email FROM users WHERE level>=50");
                        $sel->execute();
                        while($em = $sel->fetch()) {
                            $mail->addAddress($em['email']);
                        }
                        if($mail->Send()) {
                            $ins = $pdo->prepare("UPDATE sendmails SET status='sent' WHERE id=?");
                            $ins->execute([$result['id']]);
                            echo "Message sent.<br>";
                        } else {
                            echo "Message send failed.";
                        }
                    } elseif(substr($result['mailto'], 0, 5) == "user.") {
                        $userId = substr($result['mailto'], 5);
                        // echo $userId;
                        $sel = $pdo->prepare("SELECT email FROM users WHERE id=?");
                        $sel->execute([$userId]);
                        $em = $sel->fetch();
                        $mail->addAddress($em['email']);
                        if($mail->Send()) {
                            $ins = $pdo->prepare("UPDATE sendmails SET status='sent' WHERE id=?");
                            $ins->execute([$result['id']]);
                            echo "Message sent.<br>";
                        } else {
                            echo "Message send failed.";
                        }
                    }
                }
            }
        }
    }
}

?>