<?php

    require 'DB_Config.php';
    $sLB = new DB_Config();

    $search = '';
    $query = '';
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

    $key = pack('H*', "0123456789abcdef0123456789abcdef");
    $iv = pack('H*', "abcdef9876543210abcdef9876543210");

    function test_input($string) {
        $string = str_replace(array(' ', '--', '\'', '1=1', 'script', 'php','drop', 'alter', 'select', 'insert', 'into', 'update', 'set', 'delete', 'table', 'sleep', 'order by', 'from', 'union', 'onload', 'where', 'onmouseover', 'alert', 'src', 'svg', 'img',  'href', 'ping' , 'sudo' , 'xss', 'xml', 'nc', '.tf', '.yaml' , 'javascript', 'xxs', 'java', 'onerror','DROP', 'document', 'ALTER', 'SELECT', 'INSERT', 'INTO', 'DELETE', 'UPDATE', 'SET', 'TABLE', 'SLEEP', 'ORDER BY', 'FROM', 'UNION', 'ONLOAD', 'WHERE', 'ONMOUSEOVER', 'ALERT', 'SRC', 'HREF', 'PING', 'SUDO', 'XSS', 'XML', 'NC', '.TF', '.YAML', 'JAVASCRIPT', 'XXS', 'ONERROR', 'JAVA', 'IMG', 'SVG', 'EMBED', 'DOCUMENT'), '', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    function test($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST['s']) && (isset($_POST['inst']) || isset($_POST['dept'])) && ($_POST['inst'] != '' || $_POST['dept'] != '')){
        $encryptedsearch = $_POST['s'];
        $decryptedsearch = openssl_decrypt($encryptedsearch, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $search = test_input($decryptedsearch);

        $encryptedinst = $_POST['inst'];
        $decryptedinst = openssl_decrypt($encryptedinst, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $inst = test_input($decryptedinst);

        $encrypteddept = $_POST['dept'];
        $decrypteddept = openssl_decrypt($encrypteddept, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $dept = test($decrypteddept);

        $query = "select *,DENSE_RANK() OVER (ORDER BY level DESC,clear_time) FROM users 
                    WHERE institute='".$inst."' OR dept='".$dept."' AND (firstname LIKE '%".$search."%' 
                    OR lastname LIKE '%".$search."%' OR stid LIKE '%".$search."%') ORDER BY level DESC,clear_time";
    }

    if(isset($_POST['s'])) {
        $search = test_input($search);
        $query = "select *,DENSE_RANK() OVER (ORDER BY level DESC,clear_time) FROM users 
          WHERE firstname LIKE '%".$search."%'
          OR lastname LIKE '%".$search."%' 
          OR stid LIKE '%".$search."%' ORDER BY level DESC,clear_time";
    }

    $statement = $sLB->conn->prepare($query);
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
        $sLB->conn = null;
        echo CryptoJSAesEncrypt($passphrase, $ans);
    }
    else{
        $ans .= '<tr>';
        $ans .= '<td colspan="6">No Data Found.</td>';
        $sLB->conn = null;
        echo CryptoJSAesEncrypt($passphrase, $ans);
    }

