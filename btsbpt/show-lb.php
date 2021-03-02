<?php

include_once('db-config.php');

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();

$key = pack('H*', "0123456789cdec0123456789cdeccdec");
$iv = pack('H*', "abcdef9876543210abcdef9876543210");

$encInst = $_POST['inst'];
$decInst = openssl_decrypt($encInst, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
$decInst = trim($decInst);

$inst = $decInst;

// function CryptoJSAesEncrypt($passphrase, $plain_text){

//     $salt = openssl_random_pseudo_bytes(256);
//     $iv = openssl_random_pseudo_bytes(16);
//     $iterations = 999;  
//     $data = [];
//     $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);
//     foreach($plain_text as $key1 => $val) {
//         $encrypted_data = openssl_encrypt($val, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);
//         $data[$key1] = base64_encode($encrypted_data);
//     }
//     $data["iv"] = bin2hex($iv);
//     $data["salt"] = bin2hex($salt);
//     return json_encode($data);
// }

// $passphrase = "bhavnatahelyani";

if($inst == "all") {
    $stmt = $pdo->prepare("SELECT * FROM (SELECT RANK() OVER (ORDER BY level DESC, clear_time ASC) AS 'rank', CONCAT(firstname, ' ', lastname) as fullname, stid, level, dept, clear_time, institute FROM users) AS a");
    
    $data = [];
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT * FROM (SELECT RANK() OVER (ORDER BY level DESC, clear_time ASC) AS 'rank', CONCAT(firstname, ' ', lastname) as fullname, stid, level, dept, clear_time, institute FROM users) AS a WHERE institute=?");
    
    $data = [];
    $stmt->execute([$inst]);
}
    // $response['data'] = CryptoJSAesEncrypt($passphrase, $stmt->fetchAll());
    $response['data'] = $stmt->fetchAll();
    echo json_encode($response);
?>