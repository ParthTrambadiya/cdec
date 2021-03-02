<?php
    session_start();
    $session_id = session_id();
    require_once "CSRF.php";
    require 'DB_Config.php';

    $register = new DB_Config();

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
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

    // Validating the request
    if (CSRF::validate_token($_POST["csrf_token"]))
    {
        if(isset($_POST['submit']))
        {
            $key = pack('H*', "0123456789abcdef0123456789abcdef");
            $iv = pack('H*', "abcdef9876543210abcdef9876543210");

            $encryptedfname = $_POST['fname'];
            $decryptedfname = openssl_decrypt($encryptedfname, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $fname = test_input($decryptedfname);

            $encryptedlname = $_POST['lname'];
            $decryptedlname = openssl_decrypt($encryptedlname, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $lname = test_input($decryptedlname);

            $gender = test_input($_POST['gender']);
            $institute = test_input($_POST['inst']);
            $department = test($_POST['dept']);

            $encryptedsid = $_POST['sid'];
            $decryptedsid = openssl_decrypt($encryptedsid, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $sid = test_input($decryptedsid);

            $encryptedemail = $_POST['emailR'];
            $decryptedemail = openssl_decrypt($encryptedemail, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $email = trim($decryptedemail);

            $encryptedphno = $_POST['phno'];
            $decryptedphno = openssl_decrypt($encryptedphno, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $contact = test_input($decryptedphno);

            $encryptedpswd = $_POST['pswd'];
            $decryptedpswd = openssl_decrypt($encryptedpswd, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
            $password =$decryptedpswd;

            $level = '0';
            //$time = '0:0';
            $active = 'not verified';

            $query = 'select * from users where email="'.$email.'" OR stid="'.$sid.'"';
            $statement = $register->conn->prepare($query);
            $statement->execute();
            $total_row = $statement->rowCount();

            if($total_row > 0)
            {
                echo '<script>alert("Already exist this email, you need to login")</script>';
                ?>
                <script type="text/javascript">
                    window.location.href = '../index';
                </script>
                <?php
            }
            else
            {
                $user_password = password_hash($password, PASSWORD_DEFAULT);
                $user_activation_code = md5(rand());
                $user_otp = rand(100000, 999999);
                $date = date("Y-m-d");

                $query = "INSERT INTO `users`(`firstname`,`lastname`,`stid`,`institute`,`dept`,`email`,`password`,`level`,`reg_date`,`contact`,`gender`,`activation_status`, `sessionid`) VALUES (:firstname,:lastname,:stid,:institute,:dept,:email,:password,:level,:reg_date,:contact,:gender,:activation_status, :session_id)";
                $stmt = $register->conn->prepare($query);

                $stmt->bindParam(':firstname', $fname);
                $stmt->bindParam(':lastname',$lname);
                $stmt->bindParam(':email', $email);

                $stmt->bindParam(':stid',$sid);
                $stmt->bindParam(':institute',$institute);
                $stmt->bindParam(':dept',$department);

                $stmt->bindParam(':level',$level);
                //$stmt->bindParam(':clear_time',$time);

                $stmt->bindParam(':reg_date', $date);
                $stmt->bindParam(':contact',$contact);
                $stmt->bindParam(':gender',$gender);

                $stmt->bindParam(':password',$user_password);
                //$stmt->bindParam(':activation_code',$user_activation_code);

                $stmt->bindParam(':activation_status',$active);
                $stmt->bindParam(':session_id',$session_id);

                if($stmt->execute()){
                    $_SESSION['email']   = $email;
                    //$_SESSION['user_activation_code']   = $user_activation_code;
                    $_SESSION['otp'] = $user_otp;

                    // Load Composer's autoloader
                    require '../PHPMailer/vendor/autoload.php';

                    // Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->isSMTP();                                            // Send using SMTP
                        //$mail->SMTPDebug = 2;
                        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                        $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->Port = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->isHTML();                                  // Set email format to HTML
                        $mail->Username   = 'cdeccharusat@gmail.com';                     // SMTP username
                        $mail->Password   = '#superioreventsudouser28*';                               // SMTP password
                        $mail->setFrom('cdeccharusat@gmail.com', 'CDEC');
                        $mail->Subject = 'Verification code to verify your email address';

                        $message_body = '<p>For verifying your email address, enter this verification code prompted: <b>' . $_SESSION['otp'] . '</b>. </p>
                                <p>The following OTP will be valid for next 3 minutes.</p>
                                <p>Best Regards,</p>
                                <p>Team CDEC</p>
                                ';
                        $mail->Body = $message_body;

                        $mail->addAddress($_SESSION['email']);

                        if ($mail->Send()) {
                            date_default_timezone_set("Asia/Calcutta");
                            $date = new DateTime();
                            //$_SESSION['registerOtpTime'] = $date->format('Y-m-d H:i:s');

                            $date->add(new DateInterval('PT3M'));
                            $_SESSION['registerOtpTime15'] = $date->format('Y-m-d H:i:s');


                            header("location:../otp");

                        } else {
                            $message = $mail->ErrorInfo;
                        }
                    } catch (Exception $e) {
                        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
                        echo "<script>window.href = 'index';</script>";
                    }


                }
                else{
                    echo '<script>alert("not send")</script>';
                }
            }
        }
    }
    else
    {
       header("location:../index");
    }




