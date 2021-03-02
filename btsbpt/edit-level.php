<?php

include_once('db-config.php');


$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();

$response = [ 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
];

    $key = pack('H*', "0123456789cdec0123456789cdeccdec");
    $iv = pack('H*', "abcdef9876543210abcdef9876543210");

    $encLno = $_POST['level_no'];
    $decLno = openssl_decrypt($encLno, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $decLno = trim($decLno);

    $encLnm = $_POST['level_name'];
    $decLnm = openssl_decrypt($encLnm, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $decLnm = trim($decLnm);

    $encQue = $_POST['question'];
    $decQue = openssl_decrypt($encQue, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $decQue = trim($decQue);

    $encAns = $_POST['answer'];
    $decAns = openssl_decrypt($encAns, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $decAns = trim($decAns);

    $encHin = $_POST['hint'];
    $decHin = openssl_decrypt($encHin, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $decHin = trim($decHin);

    $encId = $_POST['id'];
    $decId = openssl_decrypt($encId, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
    $decId = trim($decId);

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

    $level_no = mysqli_real_escape_string($conn, $decLno);
    $level_name = mysqli_real_escape_string($conn, $decLnm);
    $question = $decQue;
    $answer = mysqli_real_escape_string($conn, $decAns);
    $hint = $decHin;
    $id = mysqli_real_escape_string($conn, $decId);

    $stmt = $pdo->prepare("SELECT level_no FROM levels WHERE level_no = ? AND id<>?");
    $stmt->execute([$level_no, $id]);
    if($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("SELECT level_no FROM levels WHERE level_name = ? AND id<>?");
        $stmt->execute([$level_name, $id]);
        if($stmt->rowCount() == 0) {
            $stmt = $pdo->prepare("UPDATE levels SET level_no = ?, level_name = ?, question = ?, answer = ?, hint = ? WHERE id = ?");
            if($stmt->execute([$level_no, $level_name, $question, $answer, $hint, $id])) {
                $response['status'] = 1;
                $response['message'] = "Level details updated successfully";
            } else {
                $response['message'] = "There was an error while updating level.";
            }
        } else {
            $response['message'] = "Level name already exists.";
        }
    } else {
        $response['message'] = "Level number already exists.";
    }

    $response = CryptoJSAesEncrypt($passphrase, $response);

echo $response;

?>