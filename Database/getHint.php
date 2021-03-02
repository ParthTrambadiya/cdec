<?php
    session_start();
    require 'DB_Config.php';
    $getHint = new DB_Config();
    $ans = '';

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

    $passphrase = "bhavnatahelyani";

    if(isset($_POST['credits'], $_POST['levelHint'])) {
        $key = pack('H*', "0123456789abcdef0123456789abcdef");
        $iv = pack('H*', "abcdef9876543210abcdef9876543210");

        $encryptedcredit = $_POST['credits'];
        $decryptedcredit = openssl_decrypt($encryptedcredit, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $credit = $decryptedcredit;

        $encryptedlevelhint = $_POST['levelHint'];
        $decryptedlevelhint = openssl_decrypt($encryptedlevelhint, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $levelhint = $decryptedlevelhint;

        if($credit > 0 && $levelhint < 95)
        {
            $q = 'select hint from levels where level_no="'.$levelhint.'"';

            $statement = $getHint->conn->prepare($q);
            $statement->execute();

            $row = $statement->fetchAll();
            $dbhint = $row[0]['hint'];

            $newCredits = (int)$credit;
            $newCredits = $newCredits - 1;
            $q = 'UPDATE users SET credits="'.$newCredits.'" where email="'.$_SESSION['emailUser'].'"';

            $statement = $getHint->conn->prepare($q);
            $statement->execute();

            $_SESSION['credits'] = $newCredits;

            $ans = $dbhint.'$'.$newCredits;
            $getHint->conn = null;
            $ans = CryptoJSAesEncrypt($passphrase, $ans);
            echo $ans;
        }
        else
        {
            if($credit <= 0)
            {
                $getHint->conn = null;
                echo CryptoJSAesEncrypt($passphrase, 'credit0');
            }
            else
            {
                $getHint->conn = null;
                echo CryptoJSAesEncrypt($passphrase, 'level95');
            }
        }
    }