<?php
    require 'DB_Config.php';

    $mainlb = new DB_Config();
    $_SESSION['rank'] = '';
    $ans = '';

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

    $query = 'select *,DENSE_RANK() OVER (ORDER BY level DESC,clear_time) from users ORDER BY level DESC,clear_time LIMIT 20';

    $statement = $mainlb->conn->prepare($query);
    $statement->execute();

    $total_row = $statement->rowCount();

    if($total_row > 0)
    {
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $ans .= '<tr>';
            $ans .= '<td style="width: 140px; vertical-align: middle;">'.$row['DENSE_RANK() OVER (ORDER BY level DESC,clear_time)'].'</td>';
            $ans .= '<td style="width: 120px; vertical-align: middle;">'.$row['level'].'</td>';
            $ans .= '<td style="width: 380px; vertical-align: middle;">'.$row['firstname'].' '.$row['lastname'].'</td>';
            $ans .= '<td style="width: 190px; vertical-align: middle;">'.$row['stid'].'</td>';
            $ans .= '<td style="width: 170px; vertical-align: middle;">'.$row['institute'].'</td>';
            $ans .= '<td style="width: 170px; vertical-align: middle;">'.$row['dept'].'</td>';
            $ans .= '</tr>';

        }
        $mainlb->conn = null;

        echo CryptoJSAesEncrypt($passphrase, $ans);
    }


