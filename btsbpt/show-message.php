<?php

include_once('db-config.php');

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();

$key = pack('H*', "0123456789cdec0123456789cdeccdec");
$iv = pack('H*', "abcdef9876543210abcdef9876543210");

$encId = $_POST['id'];
$decId = openssl_decrypt($encId, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decId = trim($decId);

$encCat = $_POST['category'];
$decCat = openssl_decrypt($encCat, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decCat = trim($decCat);

$id = $decId;
$cat = $decCat;

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

if($cat == 'contact') {

    $stmt = $pdo->prepare("SELECT * FROM contactus WHERE id=?");
    if($stmt->execute([$id])) {
        $data = $stmt->fetch();
        if($data['read_stat'] == 'unread') {
            $upd = $pdo->prepare("UPDATE contactus SET read_stat = 'read' WHERE id=?");
            if($upd->execute([$id])) {
                $data['stat_change'] = 1;
            } else {
                $data['stat_change'] = 0;
            }
        } else {
            $data['stat_change'] = 0;
        }
        $data['status'] = 1;
    } else {
        $data = [
            "status" => 0,
            "response" => "Error while fetching data"
        ];
    }
} else {
    $stmt = $pdo->prepare("SELECT * FROM sendmails WHERE id=?");
    if($stmt->execute([$id])) {
        $data = $stmt->fetch();
        $data['stat'] = 1;
    } else {
        $data = [
            "stat" => 0,
            "response" => "Error while fetching data"
        ];
    }
}

$response = CryptoJSAesEncrypt($passphrase, $data);

echo $response;

?>