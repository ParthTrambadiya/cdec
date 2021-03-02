<?php

include_once('db-config.php');


$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();

$stmt = $pdo->prepare("SELECT  @rank := @rank + 1 AS 'rank', CONCAT(firstname, ' ', lastname) as fullname, stid, level, institute, dept, activation_status, id
FROM  users
JOIN  ( SELECT  @rank := 0 ) AS init
ORDER BY level DESC, clear_time ASC");

    $data = [];
    $stmt->execute();
    $data['data'] = $stmt->fetchAll();

echo json_encode($data);

?>