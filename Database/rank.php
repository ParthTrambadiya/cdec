<?php
    session_start();
    require 'DB_Config.php';
    $_SESSION['rank'] = '';
    $rankDB = new DB_Config();

    $query = 'select *,DENSE_RANK() OVER (ORDER BY level DESC,clear_time) from users ORDER BY level DESC,clear_time';

    $statement = $rankDB->conn->prepare($query);
    $statement->execute();

    $total_row = $statement->rowCount();

    if($total_row > 0) {
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            if (isset($_SESSION['emailUser']) && ($row['email'] == $_SESSION['emailUser'])) {
                $_SESSION['rank'] = $row['DENSE_RANK() OVER (ORDER BY level DESC,clear_time)'];
            }
        }
    }
    $rankDB->conn = null;
    echo $_SESSION['rank'];
