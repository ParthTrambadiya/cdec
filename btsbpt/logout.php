<?php

include_once('db-config.php');

$dbObj = new DBConfig();

session_start();

if(session_unset()){
    header("Location: index.php");
}

?>