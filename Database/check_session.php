<?php

require 'DB_Config.php';
$check_session = new DB_Config();

$key = pack('H*', "0123456789abcdef0123456789abcdef");
$iv = pack('H*', "abcdef9876543210abcdef9876543210");

$encSid = $_POST['session'];
$decSid = openssl_decrypt($encSid, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decSid = trim($decSid);

$encEmail = $_POST['email'];
$decEmail = openssl_decrypt($encEmail, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decEmail = trim($decEmail);

$stmt = $check_session->conn->prepare("SELECT sessionid FROM users WHERE email=?");
$stmt->execute([$decEmail]);
$result = $stmt->fetch();

if($result['sessionid'] != $decSid) {
    session_id($decSid);
    session_start();
    session_destroy();
    if($result['sessionid'] == '000000000000000000000000000000') {
        echo 'over';
    } else {    
        echo "destroy";
    }
} else {
    echo "run";
}

?>