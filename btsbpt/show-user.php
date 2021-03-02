<?php

include_once('db-config.php');

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();

$key = pack('H*', "0123456789cdec0123456789cdeccdec");
$iv = pack('H*', "abcdef9876543210abcdef9876543210");

$encId = $_POST['id'];
$decId = openssl_decrypt($encId, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decId = trim($decId);

$encAct = $_POST['action'];
$decAct = openssl_decrypt($encAct, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decAct = trim($decAct);

$id = $decId;
$action = $decAct;

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
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
    if($stmt->execute([$id])) {
        $data = $stmt->fetch();
        $data['status'] = 1;
    } else {
        $data = [
            "status" => 0,
            "message" => "Error while fetching data."
        ];
    }
} elseif($action == "block") {
    $stmt = $pdo->prepare("UPDATE users SET activation_status='blocked' WHERE id=?");
    if($stmt->execute([$id])) {
        $data = [
            "status" => 1,
            "message" => "User blocked."
        ];
    } else {
        $data = [
            "status" => 0,
            "message" => "Error while blocking user."
        ];
    }
} elseif($action == "del") {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
    if($stmt->execute([$id])) {
        $data = [
            "status" => 1,
            "message" => "User deleted successfully."
        ];
    } else {
        $data = [
            "status" => 0,
            "message" => "Error while deleting user."
        ];
    }
} elseif($action == "unblock") {
    $stmt = $pdo->prepare("UPDATE users SET activation_status='not verified', attempt=0 WHERE id=?");
    if($stmt->execute([$id])) {
        $data = [
            "status" => 1,
            "message" => "User unblocked."
        ];
    } else {
        $data = [
            "status" => 0,
            "message" => "Error while unblocking user."
        ];
    }
}
                                            $pdo = null;
$data = CryptoJSAesEncrypt($passphrase, $data);

echo $data;

?>