<?php

require 'DB_Config.php';
$getQ = new DB_Config();

session_start();
$session_id = session_id();

$qSession = 'select sessionid from users where email="'.$_SESSION['emailUser'].'"';
$statement = $getQ->conn->prepare($qSession);
$statement->execute();
$row = $statement->fetchAll();

if(($row['sessionid'] == $session_id)) {
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        $q = 'select * from levels where level_no="'.$id.'"';

        $ans = '';

        $statement = $getQ->conn->prepare($q);
        $statement->execute();

        $row = $statement->fetchAll();
        foreach ($row as $result) {
            $ans = $result['level_no'] .'$' .$result['level_name'] .'$'.$result['question'].'$'.$result['img'];
        }

        echo $ans;
    }
}
else {
    echo 'already_login';
}
