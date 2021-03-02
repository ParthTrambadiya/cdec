<?php

//logout.php

session_start();
require_once "CSRF.php";
CSRF::create_token();
session_destroy();

header("location:../index");

?>
