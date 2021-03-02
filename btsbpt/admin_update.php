<?php

include_once("db-config.php");

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    $change = $_POST['change'];

    if($change == 0) {
        $update = $pdo->prepare("UPDATE admin SET fullname=?, email=? WHERE id='ADMIN'");
        $update->execute([$fullname, $email]);

        $result = array();

        if($update) {
            $_SESSION['fullname'] = $fullname;
            $_SESSION['email'] = $email;

            $message = "Admin account details updated!";
            $result['message'] = $message;
            $result['status'] = "success";
        } else {
            $message = "Admin account details not updated!";
            $result['message'] = $message;
            $result['status'] = "danger";
        }
    } else {
        $password = password_hash($pwd, PASSWORD_DEFAULT);

        $update = $pdo->prepare("UPDATE admin SET fullname=?, email=?, password=? WHERE id='ADMIN'");
        $update->execute([$fullname, $email, $password]);

        $result = array();

        if($update) {
            $_SESSION['fullname'] = $fullname;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            $message = "Admin account details updated!";
            $result['message'] = $message;
            $result['status'] = "success";
        } else {
            $message = "Admin account details not updated!";
            $result['message'] = $message;
            $result['status'] = "danger";
        }
    }
    echo json_encode($result);

?>