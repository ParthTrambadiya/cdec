<?php

include_once('db-config.php');

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();

    $data = [];
    $stmt = $pdo->prepare("SELECT * FROM levels");
    if($stmt->execute()) {
        // $i = 0;
        // while($row = $stmt->fetch()) {
        //     $data[$i] = $row;
        //     $i++;
        // }
        $data['data'] = $stmt->fetchAll();
        // $data['data']['status'] = 1;
        // $data['status'] = 1; ;
    } else {
        $data = [
            'status' => 0,
            'message' => "Error while fetching data"
        ];
    }

    echo json_encode($data);


?>