<?php

include_once('db-config.php');

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();

$stmt = $pdo->prepare("SELECT sessionid FROM users");
if($stmt->execute()) {
    echo "Done<br>";
    while($result = $stmt->fetch()) {
        session_id($result['sessionid']);
        session_start();
        session_destroy();
        session_commit(); 
    }
    $stmt1 = $pdo->prepare("UPDATE users SET sessionid=?");
    $sid = '000000000000000000000000000000';
    if($stmt1->execute([$sid])) {
        echo "Done<br>";
    } else {
            echo "Error while fetching data: " . $stmt1->error;
    }
} else {
    echo "Error while fetching data: " . $stmt->error;
}

?>