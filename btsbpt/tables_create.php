<?php

include_once('db-config.php');

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();

$sql = "CREATE TABLE admin (
    id VARCHAR(6) DEFAULT 'ADMIN' PRIMARY KEY,
    fullname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    img VARCHAR(50),
    sessionid VARCHAR(255) DEFAULT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
if ($conn->query($sql) === TRUE) {
    echo "Table admin created successfully<br>";

    $level = "CREATE TABLE levels (
        id BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        level_no INT(4) NOT NULL,
        level_name VARCHAR(30) NOT NULL,
        question TEXT NOT NULL,
        answer VARCHAR(50) NOT NULL,
        hint VARCHAR(300) DEFAULT NULL,
        img VARCHAR(100),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

    if ($conn->query($level) === TRUE) {
        echo "Table levels created successfully<br>";

        $users = "CREATE TABLE users (
            id BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(20) NOT NULL,
            lastname VARCHAR(20) NOT NULL,
            stid VARCHAR(20) NOT NULL,
            institute VARCHAR(15) NOT NULL,
            dept VARCHAR(15) NOT NULL,
            email VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            level INT(4) DEFAULT 0,
            gender VARCHAR(10) NOT NULL,
            contact VARCHAR(20) NOT NULL,
            clear_time DATETIME DEFAULT NULL,
            credits FLOAT NOT NULL DEFAULT 5,
            activation_status VARCHAR(15) DEFAULT NULL,
            sessionid VARCHAR(255) DEFAULT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

            FOREIGN KEY (level)
            REFERENCES levels(level_no)
            ON UPDATE CASCADE ON DELETE CASCADE
            )";

        if ($conn->query($users) === TRUE) {
            echo "Table users created successfully<br>";

            $contact = "CREATE TABLE contactus (
                id BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                fullname VARCHAR(100) NOT NULL,
                sid VARCHAR(20) NOT NULL,
                email VARCHAR(50) NOT NULL,
                subject VARCHAR(500) DEFAULT NULL,
                message TEXT DEFAULT NULL,
                read_stat VARCHAR(7) DEFAULT 'unread',
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
    
            if ($conn->query($contact) === TRUE) {
                echo "Table contactus created successfully<br>";
                
                $mails = "CREATE TABLE sendmails (
                    id BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    mailto VARCHAR(50) NOT NULL,
                    subject VARCHAR(500) DEFAULT NULL,
                    message TEXT DEFAULT NULL,
                    schedule int(1) DEFAULT 0,
                    sch_date DATE DEFAULT NULL,
                    sch_time TIME DEFAULT NULL,
                    status VARCHAR(10) DEFAULT 'Not Sent',
                    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    ) CHARACTER SET utf8mb4";
        
                if ($conn->query($mails) === TRUE) {
                    echo "Table sendmails created successfully<br>";
                } else {
                    echo "Error creating table sendmails: $conn->error <br>";
                }
            } else {
                echo "Error creating table contactus: $conn->error <br>";
            }

        } else {
            echo "Error creating table users: $conn->error <br>";
        }
    } else {
        echo "Error creating table levels: $conn->error <br>";
    }
} else {
    echo "Error creating table admin: $conn->error <br>";
}

?>