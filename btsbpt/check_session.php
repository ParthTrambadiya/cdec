<?php

include_once('db-config.php');

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();

$key = pack('H*', "0123456789cdec0123456789cdeccdec");
$iv = pack('H*', "abcdef9876543210abcdef9876543210");

$encSid = $_POST['session'];
$decSid = openssl_decrypt($encSid, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decSid = trim($decSid);

$session_id = mysqli_real_escape_string($conn, $decSid);

$stmt = $pdo->prepare("SELECT sessionid FROM admin WHERE id='ADMIN'");
$stmt->execute();
$result = $stmt->fetch();

if($result['sessionid'] != $session_id) {
    session_id($session_id);
    session_start();
    session_destroy();
    echo "destroy";
} else {
    echo "run";
}

?>