<?php
    session_start();
    require_once "CSRF.php";
    require 'DB_Config.php';

    $contact = new DB_Config();

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function test($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function test_input($string) {
        $string = str_replace(array(' ', '--', '\'', '1=1', 'script', 'php','drop', 'alter', 'select', 'insert', 'into', 'update', 'set', 'delete', 'table', 'sleep', 'order by', 'from', 'union', 'onload', 'where', 'onmouseover', 'alert', 'src', 'svg', 'img',  'href', 'ping' , 'sudo' , 'xss', 'xml', 'nc', '.tf', '.yaml' , 'javascript', 'xxs', 'java', 'onerror','DROP', 'document', 'ALTER', 'SELECT', 'INSERT', 'INTO', 'DELETE', 'UPDATE', 'SET', 'TABLE', 'SLEEP', 'ORDER BY', 'FROM', 'UNION', 'ONLOAD', 'WHERE', 'ONMOUSEOVER', 'ALERT', 'SRC', 'HREF', 'PING', 'SUDO', 'XSS', 'XML', 'NC', '.TF', '.YAML', 'JAVASCRIPT', 'XXS', 'ONERROR', 'JAVA', 'IMG', 'SVG', 'EMBED', 'DOCUMENT'), '', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    $key = pack('H*', "0123456789abcdef0123456789abcdef");
    $iv = pack('H*', "abcdef9876543210abcdef9876543210");

    // Validating the request
    if (CSRF::validate_token($_POST["csrf_token"])) {
        if(isset($_POST['sendbtn']))
        {
            $stmt = $contact->conn->prepare("INSERT INTO `contactus` (`sid`, `fullname`, `email`, `subject`, `message`) VALUES (:sid, :fullname, :email, :subject, :message)");

            $stmt->bindParam(':sid', $sid);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':message', $message);

            $encryptedfullname = $_POST['fnameC'];
            $decryptedfullname = openssl_decrypt($encryptedfullname, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $fullname = test_input($decryptedfullname);

            $encryptedsid = $_POST['sidC'];
            $decryptedsid = openssl_decrypt($encryptedsid, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $sid = test_input($decryptedsid);

            $encryptedemail = $_POST['emailC'];
            $decryptedemail = openssl_decrypt($encryptedemail, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $email = test($decryptedemail);

            $encryptedsub = $_POST['subjectC'];
            $decryptedsub = openssl_decrypt($encryptedsub, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $subject = $decryptedsub;

            $encryptedmsg = $_POST['messageC'];
            $decryptedmsg = openssl_decrypt($encryptedmsg, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $message = $decryptedmsg;

            $body_message = 'Name: '.$fullname.'<br/>';
            $body_message .='Student ID: '.$sid.'<br/>';
            $body_message .='Email: '.$email.'<br/><br/>';
            $body_message .= $message;

            if($stmt->execute())
            {
                // Load Composer's autoloader
                require '../PHPMailer/vendor/autoload.php';

                // Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->isSMTP();                                            // Send using SMTP
                    //$mail->SMTPDebug = 2;
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->isHTML();                                  // Set email format to HTML
                    $mail->Username   = 'cdeccharusat@gmail.com';                     // SMTP username
                    $mail->Password   = '#superioreventsudouser28*';                               // SMTP password
                    $mail->setFrom('cdeccharusat@gmail.com', 'Contact Us Query');
                    $mail->Subject = $subject;
                    $mail->Body    = $body_message;
                    $mail->addAddress('cdeccharusat@gmail.com');

                    if($mail->Send()) {
                        header("location:../contactus");
                    } else {
                        echo "Mail not sent: " . $mail->ErrorInfo;
                        echo "<script>window.alert('Mailer Error: ' + $mail->ErrorInfo)</script>";
                    }
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    } else {
        header('location:../index');
    }
