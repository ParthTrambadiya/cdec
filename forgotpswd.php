<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CDEC</title>
    <link rel="icon" href="./assets/logo.png">

    <!--Bootstrap CSS CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!--Font Awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

    <!--Custom CSS-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!--OTP-->
<section class="otp">
    <div class="container">
        <div class="row align-items-center justify-content-center" style="height: 100vh;">
            <div class="col-md-7">
                <div class="card" style="box-shadow: .1px 1px 10px 0 rgba(255, 255, 255, 1);">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h1 class="font-roboto">Forgot Password</h1><div class="div2">
                                    <h6 class="font-baloo px-5">We have sent an OTP on your following email
                                        <span class="color-blue" id="disp_email"></span>. Please enter that OTP below.</h6></div>
                            </div>
                            <div class="col-12">
                                <form method="post" id="form" class="px-5">
                                    <div class="row form-group font-baloo mt-5">
                                        <div class="col-12 mb-3 mb-md-0">
                                            <div id="div1">
                                                <label class="color-second" for="otp">Email</label>
                                                <input type="email" name="email" id="email" class="form-control mb-1 rounded" placeholder="Enter Your Email">
                                            </div>
                                            <div class="div2 forgot">
                                                <label class="color-second" for="otp">New Password</label>
                                                <div class="input-group pswd">
                                                    <input type="password" id="password" name="password" class="form-control" maxlength="20" placeholder="Enter New Password" maxlength="20">
                                                    <div class="input-group-append" id="eye">
                                                        <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                                    </div>
                                                </div>
                                                <label class="color-second" for="otp">OTP</label>
                                                <input type="text" name="otp" id="otp" class="form-control rounded" maxlength="6" placeholder="Enter OTP" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" id="btn1" name="submit" class="btn btn-hover color text-white font-baloo">Next</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--!OTP-->
<!--JS-->
<script src="./jquery-3.3.1.min.js"></script>
<script src="./jquery-migrate-3.0.1.min.js"></script>

<!--Bootstrap JS CDN-->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js" integrity="sha512-nOQuvD9nKirvxDdvQ9OMqe2dgapbPB7vYAMrzJihw5m+aNcf0dX53m6YxM4LgA9u8e9eg9QX+/+mPu8kCNpV2A==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/aes.min.js" integrity="sha512-eqbQu9UN8zs1GXYopZmnTFFtJxpZ03FHaBMoU3dwoKirgGRss9diYqVpecUgtqW2YRFkIVgkycGQV852cD46+w==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/enc-hex.min.js" integrity="sha512-jDU0YCduSP8z0cvjfPFm7/zN/viOcmNWlq0GUIcjVhuv4WoKcMppghamg4aeuBtJaA0wjtYfxwQjPpVuYGEsBA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/pad-zeropadding.min.js" integrity="sha512-txZjFJoDvbM8FJj9HuAHasxA/M76UjnMCXLHwuciIGDKUW9EB9PJVA6foG0vymuK9hu2gdpL60imO9VrTlEF7w==" crossorigin="anonymous"></script>



<script>

    var passphrase = 'bhavnatahelyani';

    var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
    var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

    function CryptoJSAesDecrypt(passphrase, encrypted_json_string){
        // console.log(typeof encrypted_json_string);
        var obj_json = JSON.parse(encrypted_json_string);
        console.log(obj_json);
        var encrypted = encrypted_json_string.ciphertext;
        var salt = CryptoJS.enc.Hex.parse(encrypted_json_string.salt);
        var iv = CryptoJS.enc.Hex.parse(encrypted_json_string.iv);

        var key = CryptoJS.PBKDF2(passphrase, salt, { hasher: CryptoJS.algo.SHA512, keySize: 64/8, iterations: 999});

        var decrypted = CryptoJS.AES.decrypt(encrypted, key, { iv: iv});

        return decrypted.toString(CryptoJS.enc.Utf8);
    }

    $('.div2').hide();

    function ValidateEmail(mail) {
        var regex = /^[a-zA-Z0-9]+@+[charusat]+.edu+.in$/
        if (regex.test(mail)) return true;
        else if(mail == ''){
            swal({
                title: "Warning",
                text: "Email cannot be empty.",
                icon: "warning"
            });
            return false;
        }
        else {
            swal({
                title: "Warning",
                text: "You have entered an invalid email address!",
                icon: "warning"
            });
            return false;
        }
    }

    function CheckPassword(inputtxt) {
        var password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
        if (password.test(inputtxt))
            return true;
        else if(inputtxt.length == 0) {
            swal({
                title: "Warning",
                text: "Password cannot be empty.",
                icon: "warning"
            });
            return false;
        }
        else {
            swal({
                title: "Warning",
                text: "Password should be between 8 to 15 characters which should contain atleast one uppercase character, one lowercase character, numeric, and one special character.",
                icon: "warning"
            });
            return false;
        }
    }

    function checkotp(otpno){
        if(otpno.length != 0){
            return true;
        }
        else{
            swal({
                title: "Warning",
                text: "Please Fill OTP.",
                icon: "warning"
            });
            return false;
        }
    }

    var statusForgot = true;
    var forgotPass = $('.forgot input[type="password"]');
    $('.forgot #eye').click(function(){
        if(statusForgot)
        {
            $('.forgot #eye i').removeClass('fa');
            $('.forgot #eye i').removeClass('fa-eye');
            $('.forgot #eye i').addClass('fas');
            $('.forgot #eye i').addClass('fa-eye-slash');
            forgotPass.attr("type", "text");
            statusForgot = false;
        }
        else
        {
            $('.forgot #eye i').removeClass('fas');
            $('.forgot #eye i').removeClass('fa-eye-slash');
            $('.forgot #eye i').addClass('fa');
            $('.forgot #eye i').addClass('fa-eye');
            forgotPass.attr("type", "password");
            statusForgot = true;
        }
    });

    $(document).on('click','#btn1',function(){
        let email = $('#email').val();
        swal({
            text: "Please wait for a few seconds.",
            icon: "info"
        });
        if(ValidateEmail(email)){
            $('#disp_email').text(email);
            let hashEmail = CryptoJS.AES.encrypt(email, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

            $.ajax({
                url:'./Database/forgotPass.php',
                type:'POST',
                data:{
                    'email':hashEmail
                },
                success:function(data1){
                    //var data1 = CryptoJSAesDecrypt(passphrase, data1);
                    if(data1 == 'yes'){
                        $('.div2').show();
                        $('#div1').hide();
                        $('#btn1').text('Reset');
                        $("#btn1").attr("id", "btn2");
                    }
                    else{
                        swal({
                            title: "Warning",
                            text: "You have not Account, please register yourself.",
                            icon: "warning"
                        });
                    }
                }
            });
        }
    });

    $(document).on('click','#btn2',function(){
        let email = $('#email').val();
        let newpassword = $('#password').val();
        let otp = $('#otp').val();

        let hashEmail = CryptoJS.AES.encrypt(email, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashPass = CryptoJS.AES.encrypt(newpassword, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashOtp = CryptoJS.AES.encrypt(otp, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

        if(CheckPassword(newpassword) && checkotp(otp)){
            $.ajax({
                url:'./Database/forgotPassword.php',
                type:'POST',
                data:{
                    'email':hashEmail,
                    'password':hashPass,
                    'user_otp':hashOtp
                },
                success:function(data1){
                    //  var data1 = CryptoJSAesDecrypt(passphrase, data1);
                    if(data1 == 'Password changed succesfully') {
                        swal({
                            title: "Success",
                            text: data1,
                            icon: "success",
                            buttons: false
                        });
                        setTimeout(function () {
                            window.location.href = "index";
                        }, 2000)
                    }
                    else if(data1 == 'otp expire') {
                        swal({
                            title: "Warning",
                            text: "This OTP is expire, please request for new OTP.",
                            icon: "warning"
                        });
                    }
                    else if(data1 == 'blocked') {
                        swal({
                            title: "Blocked",
                            text: "You are blocked, Contact admin.",
                            icon: "error"
                        });
                        setTimeout(function () {
                            window.location.href = "index";
                        }, 2000)
                    }
                    else
                    {
                        swal({
                            title: "Warning",
                            text: "Otp is worng.",
                            icon: "warning"
                        });
                    }
                }
            });
        }
    });

    $('#form').submit(function(e){
        e.preventDefault();
    });
</script>
</body>
</html>