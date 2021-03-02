<?php

include_once('db-config.php');

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();

$key = pack('H*', "0123456789cdec0123456789cdeccdec");
$iv = pack('H*', "abcdef9876543210abcdef9876543210");

$encId = $_POST['id'];
$decId = openssl_decrypt($encId, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decId = trim($decId);

$encAct = $_POST['action'];
$decAct = openssl_decrypt($encAct, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decAct = trim($decAct);

$id = mysqli_real_escape_string($conn, $decId);
$action = mysqli_real_escape_string($conn, $decAct);

function CryptoJSAesEncrypt($passphrase, $plain_text){

    $salt = openssl_random_pseudo_bytes(256);
    $iv = openssl_random_pseudo_bytes(16);
    $iterations = 999;  
    $data = [];
    $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);
    foreach($plain_text as $key1 => $val) {
        $encrypted_data = openssl_encrypt($val, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);
        $data[$key1] = base64_encode($encrypted_data);
    }
    $data["iv"] = bin2hex($iv);
    $data["salt"] = bin2hex($salt);
    return json_encode($data);
}

$passphrase = "bhavnatahelyani";

if($action == "show") {
    $stmt = $pdo->prepare("SELECT * FROM levels WHERE id=?");
    if($stmt->execute([$id])) {
        $response = $stmt->fetch();
        $response['status'] = 1;
    } else {
        $response = [
            'status' => 0,
            'message' => "Error while fetching data"
        ];
    }
} else {
    $stmt = $pdo->prepare("DELETE FROM levels WHERE id=?");
    if($stmt->execute([$id])) {
        $response = [
            'status' => 1,
            'message' => "Level deleted successfully."
        ];
    } else {
        $response = [
            'status' => 0,
            'message' => "Error while deleting level."
        ];
    }
}

$response = CryptoJSAesEncrypt($passphrase, $response);

echo $response;

?>