<?php
require 'DB_Config.php';
$getQ = new DB_Config();

function CryptoJSAesEncrypt($passphrase, $plain_text){

    $salt = openssl_random_pseudo_bytes(256);
    $iv = openssl_random_pseudo_bytes(16);
    //on PHP7 can use random_bytes() istead openssl_random_pseudo_bytes()
    //or PHP5x see : https://github.com/paragonie/random_compat

    $iterations = 999;
    $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

    $encrypted_data = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

    $data = array("ciphertext" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "salt" => bin2hex($salt));
    return json_encode($data);
}

$passphrase = "bhavnatahelyani";

if(isset($_POST['id'])){
    $key = pack('H*', "0123456789abcdef0123456789abcdef");
    $iv = pack('H*', "abcdef9876543210abcdef9876543210");

    $encryptedid = $_POST['id'];
    $decryptedid = openssl_decrypt($encryptedid, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $id = $decryptedid;

    $q = 'select * from levels where level_no="'.$id.'"';

    $ans = '';

    $statement = $getQ->conn->prepare($q);
    $statement->execute();

    $row = $statement->fetchAll();
    foreach ($row as $result) {
        $ans = $result['level_no'] .'$' .$result['level_name'] .'$'.$result['question'].'$'.$result['img'];
    }
    $getQ->conn = null;

    $ans = CryptoJSAesEncrypt($passphrase, $ans);

    echo $ans;
}
$getQ->conn = null;
