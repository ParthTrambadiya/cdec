<?php
    require 'DB_Config.php';

    $sortingLB = new DB_Config();
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

    $key = pack('H*', "0123456789abcdef0123456789abcdef");
    $iv = pack('H*', "abcdef9876543210abcdef9876543210");

    function test_input($string) {
        $string = str_replace(array(' ', '--', '\'', '1=1', 'script', 'php','drop', 'alter', 'select', 'insert', 'into', 'update', 'set', 'delete', 'table', 'sleep', 'order by', 'from', 'union', 'onload', 'where', 'onmouseover', 'alert', 'src', 'svg', 'img',  'href', 'ping' , 'sudo' , 'xss', 'xml', 'nc', '.tf', '.yaml' , 'javascript', 'xxs', 'java', 'onerror','DROP', 'document', 'ALTER', 'SELECT', 'INSERT', 'INTO', 'DELETE', 'UPDATE', 'SET', 'TABLE', 'SLEEP', 'ORDER BY', 'FROM', 'UNION', 'ONLOAD', 'WHERE', 'ONMOUSEOVER', 'ALERT', 'SRC', 'HREF', 'PING', 'SUDO', 'XSS', 'XML', 'NC', '.TF', '.YAML', 'JAVASCRIPT', 'XXS', 'ONERROR', 'JAVA', 'IMG', 'SVG', 'EMBED', 'DOCUMENT'), '', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z\-]/', '', $string); // Removes special chars.
    }

    function test($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST['inst']) && isset($_POST['dept'])){

        $encryptedinst = $_POST['inst'];
        $decryptedinst = openssl_decrypt($encryptedinst, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $inst = test_input($decryptedinst);

        $encrypteddept = $_POST['dept'];
        $decrypteddept = openssl_decrypt($encrypteddept, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $dept = test($decrypteddept);

        //$q = 'select *,DENSE_RANK() OVER (ORDER BY level DESC) from users ORDER BY level DESC, clear_time';
        $q = 'select * from (select *,DENSE_RANK() OVER (ORDER BY level DESC,clear_time) from users ORDER BY level DESC,clear_time) AS T where institute ="'.$inst.'" && dept ="'.$dept.'" order by level DESC, clear_time';
    }

    else if(isset($_POST['inst'])){
        $encryptedinst = $_POST['inst'];
        $decryptedinst = openssl_decrypt($encryptedinst, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $inst = test_input($decryptedinst);

        $q = 'select * from (select *,DENSE_RANK() OVER (ORDER BY level DESC,clear_time) from users ORDER BY level DESC,clear_time) AS T where institute ="'.$inst.'" order by level DESC, clear_time';
    }

    $statement = $sortingLB->conn->prepare($q);
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
$sortingLB->conn = null;
        echo CryptoJSAesEncrypt($passphrase, $ans);
    }
    else{
        $ans .= '<tr>';
        $ans .= '<td colspan="6">No Data Found.</td>';
$sortingLB->conn = null;
        echo CryptoJSAesEncrypt($passphrase, $ans);
    }