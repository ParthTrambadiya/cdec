<?php
session_start();
require 'DB_Config.php';

$checkQus = new DB_Config();

$passphrase = "bhavnatahelyani";
function CryptoJSAesEncrypt($passphrase, $plain_text){

    $salt = openssl_random_pseudo_bytes(256);
    $iv = openssl_random_pseudo_bytes(16);
    //on PHP7 can use random_bytes() istead openssl_random_pseudo_bytes()

    $iterations = 999;
    $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

    $encrypted_data = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

    $data = array("ciphertext" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "salt" => bin2hex($salt));
    return json_encode($data);
}

function test_input($string) {
    $string = str_replace(array('--', '\'', '1=1', 'script','drop', 'alter', 'select', 'insert', 'into', 'update', 'table', 'sleep', 'order by', 'from', 'union', 'onload', 'where', 'alert', 'src', 'svg', 'img',  'href' ,'delete', 'sudo' , 'onmouseover', 'xss', 'xml', 'nc', '.tf', '.yaml' , 'javascript', 'xxs', 'onerror','DROP', 'document', 'ALTER', 'ONMOUSEOVER', 'SELECT', 'INSERT', 'INTO', 'UPDATE', 'TABLE', 'SLEEP', 'ORDER BY', 'FROM', 'UNION', 'ONLOAD', 'WHERE', 'ALERT', 'SRC', 'HREF', 'SUDO', 'XSS', 'XML', 'NC', '.TF', '.YAML', 'DELETE', 'JAVASCRIPT', 'XXS', 'ONERROR', 'IMG', 'SVG', 'EMBED', 'DOCUMENT'), '', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-\s]/', '', $string); // Removes special chars.
}

if(isset($_POST['level'],$_POST['ans']))
{
    $key = pack('H*', "0123456789abcdef0123456789abcdef");
    $iv = pack('H*', "abcdef9876543210abcdef9876543210");

    $level = $_POST['level'];

    $encAns = $_POST['ans'];
    $decAns = openssl_decrypt($encAns, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $decAns = test_input($decAns);
    
    $q = 'select answer from levels where level_no=?';

    $statement = $checkQus->conn->prepare($q);
    if($statement->execute([$level])) {

        $row = $statement->fetch();

        $dbans = $row['answer'];
        $userans = $decAns;

        if (strtolower($dbans) == strtolower($userans)) {
            $newLevel = (int)$level + 1;
            date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
            $time = date('Y-m-d H:i:s');
            $q = 'UPDATE users SET level="'.$newLevel.'",clear_time="'.$time.'" where email="'.$_SESSION['emailUser'].'"';

            $statement = $checkQus->conn->prepare($q);
            $statement->execute();

            $_SESSION['level'] = $newLevel;
            $checkQus->conn = null;

            echo CryptoJSAesEncrypt($passphrase, 'true'.'$'.$newLevel);
        }
        else {
            $checkQus->conn = null;
            echo CryptoJSAesEncrypt($passphrase, 'false'.'$'.$level.'$'.$userans.'$'.$dbans);
        }
    } else {
        $checkQus->conn = null;
        echo CryptoJSAesEncrypt($passphrase, 'false'.'$'.$statement->error);
    }
}