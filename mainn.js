setInterval(function() {
    
    var isLoggedIn = $('#isLoggedIn').html();
    if(isLoggedIn == 'true') {
    
        var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
        var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

        var s_id = $('#sessionCheck').html();
        var s_email = $('#sessionEmail').html();
        let hashId = CryptoJS.AES.encrypt(s_id, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashEmail = CryptoJS.AES.encrypt(s_email, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

        $.ajax({
            url: "./Database/check_session.php",
            type: "POST",
            data: {session: hashId, email: hashEmail},
            success: function(data) {
                if(data == "destroy") {
                    swal({
                        title: "Warning",
                        text: "You are already logged in somewhere.",
                        icon: "warning",
                        closeOnClickOutside: false,
                        buttons: false
                    });
                    setTimeout(function (){
                        window.location.href="./Database/logout.php";
                    }, 3000);
                } else if(data == "over") {
                    swal({
                        title: "Warning",
                        text: "The event time is over",
                        icon: "warning",
                        closeOnClickOutside: false,
                        buttons: false
                    });
                    setTimeout(function (){
                        window.location.href="./Database/logout.php";
                    }, 3000);
                } else {
                    // console.log('continue');
                }
            },
            error: function(error) {
                console.log(error.responseText);
            }
        })
    }
}, 60000); 

$(document).ready(function(){
    //navbar
    let nav_offset_top = $('.landing-photo').height() - 550;

    function navBarFixed()
    {
        if($('.landing-photo').length)
        {
            $(window).scroll(function(){
                let scroll = $(window).scrollTop();
                if(scroll >= nav_offset_top)
                {
                    $('.hd nav').addClass('navbar_fixed');
                    $('.hd nav a').addClass('color-black');
                }
                else
                {
                    $('.hd nav').removeClass('navbar_fixed');
                    $('.hd nav a').removeClass('color-black');
                }
            })
        }
    }
    navBarFixed();

    let data = {
        CSPIT:['Select Department','BTECH(CE)','BTECH(CL)','BTECH(CSE)','BTECH(EC)','BTECH(EE)','BTECH(IT)','BTECH(ME)','DRCE','DRCL','DREC','DREE','DRME','MTECH(AMT)','MTECH(CE)','MTECH(CL)','MTECH(CSE)','MTECH(EC)','MTECH(EE)','MTECH(EVD)','MTECH(ICT)','MTECH(IT)','MTECH(ME)','MTECH(PE)','MTECH(TE)',' MTM'],
        DEPSTAR:['Select Department','BTECH(CE)','BTECH(CS)','BTECH(IT)','DRCE'],
        CMPICA:['Select Department','B.Sc.(IT)','BCA','DRMCA','M.Sc(IT)','MCA','MCAL','PGDCA'],
        RPCP:['Select Department','B.Pharm','CPCT','CPPAT','CPPV','DRPC','DRPHC','DRPHCOG','DRPHCOL','DRPHT','M.PHARM(CT)','M.PHARM(DRA)','M.PHARM(CP)','M.PHARM(PT)','M.PHARM(QA)','MPHPCL','MPHPPP','MPHPQA','MPHPRGA','MPHTCH','MPM','PGDCT','PGDPT'],
        IIIM:['Select Department','BBA','DRLSC','DRMBA','MBA-CH','PGDM'],
        PDPIAS:['Select Department','B.Sc','BSCPHY','DRBC','DRBIO','DRCHEM','DRCSMCRI','DRMTH','DRNST','M Phill','M.Sc.(AOC)','M.Sc.(BC)','M.Sc.(BT)','M.Sc.(MI)','M.Sc.(MTH)','M.Sc.(NST)','M.Sc.(PHY)'],
        ARIP:['Select Department','BPT','CCAPT','DRPT','MPT(CS)','MPT(MS)','MPT(NS)','MPT(PA)','MPT(RE)','MPT(SS)','MPT(WH)'],
        MTIN:['Select Department','BSC.Nursing','DNR','GNM','MNCH','MNMH','MNMS','MNOG','MNPN'],
        CIPS:['Select Department','BMIT','BOP','BOTAT','BSMT','DRMLT','DROTAT','M.Sc. MIT','MSMLT','PGDCH','PGDHAT','PGDMLT']
    };

    $('#inst').change(function(){

        let Institue = $('#inst').val();
        $('#dept').html('');

        if(Institue != ''){
            for(let i=0;i<data[Institue].length;i++)
                $('#dept').append(new Option(data[Institue][i],data[Institue][i]));
        }
        else{
            $('#dept').append(new Option('First Select Institue',''));
        }
    });

    //leaderborad
    $('#instLB').change(function(){

        let Institue = $('#instLB').val();
        $('#deptLB').html('');

        if(Institue != 'all'){
            for(let i=0;i<data[Institue].length;i++)
                $('#deptLB').append(new Option(data[Institue][i],data[Institue][i]));
        }
        else{
            $('#deptLB').append(new Option('First Select Institue',''));
        }
    });

    //counter
    $(function(){
        $('#myFlipper').flipper('init');
    });

    //stellar
    $.stellar();

    //AOS Library
    AOS.init();

    //tilt.js
    VanillaTilt.init(document.querySelector(".gif-container"), {
		max: 1,
        speed: 400,
	});
	
	//It also supports NodeList
    VanillaTilt.init(document.querySelectorAll(".gif-container"));

    //Swiper Carousel------------
    var swiper = new Swiper('.swiper-container', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        loop: true,
        loopFillGroupWithBlank: true,
        coverflowEffect: {
            rotate: 30,
            stretch: 0,
            depth: 470,
            modifier: 1,
            slideShadows : true,
        },
        autoplay: {
            delay: 1500,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    });

    //depended select
    var $select1 = $( '#select1' ),
		$select2 = $( '#select2' ),
    $options = $select2.find( 'option' );
    
    $select1.on( 'change', function() {
        $select2.html( $options.filter( '[value="' + this.value + '"]' ) );
    } ).trigger( 'change' );

    var statusLogin = true;
    var loginPass = $('.login input[type="password"]');
    $('.login #eye i').click(function(){
        if(statusLogin)
        {
            $('.login #eye i').removeClass('fa');
            $('.login #eye i').removeClass('fa-eye');
            $('.login #eye i').addClass('fas');
            $('.login #eye i').addClass('fa-eye-slash');
            loginPass.attr("type", "text");
            statusLogin = false;
        }
        else
        {
            $('.login #eye i').removeClass('fas');
            $('.login #eye i').removeClass('fa-eye-slash');
            $('.login #eye i').addClass('fa');
            $('.login #eye i').addClass('fa-eye');
            loginPass.attr("type", "password");
            statusLogin = true;
        }
    });

    var statusRegi = true;
    var regiPass = $('.registerModal input[type="password"]');
    $('.registerModal #eye i').click(function(){
        if(statusRegi)
        {
            $('.registerModal #eye i').removeClass('fa');
            $('.registerModal #eye i').removeClass('fa-eye');
            $('.registerModal #eye i').addClass('fas');
            $('.registerModal #eye i').addClass('fa-eye-slash');
            regiPass.attr("type", "text");
            statusRegi = false;
        }
        else
        {
            $('.registerModal #eye i').removeClass('fas');
            $('.registerModal #eye i').removeClass('fa-eye-slash');
            $('.registerModal #eye i').addClass('fa');
            $('.registerModal #eye i').addClass('fa-eye');
            regiPass.attr("type", "password");
            statusRegi = true;
        }
    });

    var $button = $.backToTop({
        // background color
        backgroundColor: '#007bff',

        // text color
        color: '#FFFFFF',

        // container element
        container: this._body, 

        // 'nonn', 'spin', 'fade', 'zoom', or 'spin-inverse'
        effect: 'spin',

        // enable the back to top button
        enabled: true, 

        // width/height of the back to top button
        height: 50,  
        width: 50,

        // icon
        icon: 'fas fa-chevron-up',

        // margins 
        marginX: 10,
        marginY: 10,  

        // bottom/top left/right
        position: 'bottom right',           

        // trigger position
        pxToTrigger: 200,

        // or 'fawesome'
        theme: 'fawesome',
    });

    $('[data-toggle="tooltip"]').tooltip();
    
    //floating
    $('#myLink').dockedLink({
        position: 'left',
        pixelsFromTop: 270
        })
        .css({
            border: '3px solid #3498DB',
            borderLeft: 'none'
    });

    $.socialfloating({
        icons:"semanticui",
        showHideButton: false,
        container: 'socialbtn',
        buttons:
            [
                {icon:"instagram",enabled:!0,link:"https://www.instagram.com/cdeccharusat",color:"#c13584"},
                {icon:"linkedin",enabled:!0,link:"https://www.linkedin.com/company/cdeccharusat/",color:"#0E76A8"},
                {icon:"youtube",enabled:!0,link:"https://youtu.be/c2rLLhOw9PE",color:"#FF0000"}
            ]
    });

    $.validator.setDefaults({
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element)
                .closest('.form-control, .custom-control-input')
                .addClass('is-invalid');
            $(element).addClass('shadow-none');
        },
        unhighlight: function(element) {
            $(element)
                .closest('.form-control, .custom-control-input')
                .removeClass('is-invalid');
            $(element).removeClass('shadow-none');
        },
        errorPlacement: function (error, element) {
            if (element.prop('type') === 'radio') {
                error.insertAfter('.female');
            }
            else if(element.prop('type') === 'password') {
                error.insertAfter('.pswd');
            }
            else {
                error.insertAfter(element);
            }
        }
    });

    $.validator.addMethod('checkdept', function (value, element){
        if(value != 'Select Department'){
            return true;
        }
    }, 'This field is required.');

    $.validator.addMethod('checksid', function (value, element){
        var letterNumber = /^[0-9a-zA-Z]+$/;
        if(letterNumber.test(value)){
            return true;
        }
    }, 'Please enter your correct Student ID.');

    $.validator.addMethod('checkphone', function (value, element){
        var phoneno = /^\d{10}$/;
        if(phoneno.test(value)){
            return true;
        }
    }, 'You have entered an invalid Mobile Number!');

    $.validator.addMethod('checkemail', function (value, element){
        var email = /^[a-zA-Z0-9]+@+[charusat]+.edu+.in$/;
        if(email.test(value)){
            return true;
        }
    }, 'Please enter your CHARUSAT Email id.');

    $.validator.addMethod('checkpswd', function (value, element){
        var pswd = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$/;
        if(pswd.test(value)){
            return true;
        }
    }, 'Password should be between 8 to 20 characters which should contain atleast one uppercase character, one lowercase character, numeric, and one special character.');

    $('#myf').validate({
        ignore: ".ignore",
        rules: {
            fnameTemp: {
                required: true,
                maxlength: 25,
                nowhitespace: true,
                lettersonly: true
            },
            lnameTemp: {
                required: true,
                maxlength: 25,
                nowhitespace: true,
                lettersonly: true
            },
            gender: {
                required: true
            },
            inst: {
                required: true
            },
            dept: {
                required: true,
                checkdept: true
            },
            sidTemp: {
                required: true,
                nowhitespace: true,
                maxlength: 15,
                checksid: true
            },
            phnoTemp: {
                required: true,
                nowhitespace: true,
                maxlength: 10,
                digits: true,
                checkphone: true,
            },
            emailRTemp: {
                required: true,
                email: true,
                checkemail: true
            },
            pswdTemp: {
                required:true,
                checkpswd: true,
                maxlength: 20,
                nowhitespace: true
            },
            hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        },
        messages: {
            hiddenRecaptcha: "CAPTCHA is required"
        }
    });

    $('#myf').submit(function () {
        var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
        var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

        var fn = $("input[name='fnameTemp']").val();
        var ln = $("input[name='lnameTemp']").val();
        var sid = $("input[name='sidTemp']").val();
        var contact = $("input[name='phnoTemp']").val();
        var email = $("input[name='emailRTemp']").val();
        var pswd = $("input[name='pswdTemp']").val();

        let hashFN = CryptoJS.AES.encrypt(fn, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashLN = CryptoJS.AES.encrypt(ln, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashSID = CryptoJS.AES.encrypt(sid, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashCONTACT = CryptoJS.AES.encrypt(contact, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashEMAIL = CryptoJS.AES.encrypt(email, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashPSWD = CryptoJS.AES.encrypt(pswd, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

        $('#fname').val(hashFN);
        $('#lname').val(hashLN);
        $('#sid').val(hashSID);
        $('#phno').val(hashCONTACT);
        $('#emailR').val(hashEMAIL);
        $('#pswd').val(hashPSWD);
    });

    $('#contactform').validate({
        rules: {
            fnameCTemp: {
                required: true,
                maxlength: 50
            },
            sidCTemp: {
                required: true,
                nowhitespace: true,
                maxlength: 15,
                checksid: true
            },
            emailCTemp: {
                required: true,
                email: true,
                checkemail: true
            },
            subjectCTemp: {
                required: true
            },
            messageCTemp: {
                required: true
            }
        }
    });

    $('#contactform').submit(function () {
        // e.preventDefault();
        var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
        var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

        var fn = $("input[name='fnameCTemp']").val();
        var emailC = $("input[name='emailCTemp']").val();
        var sidC = $("input[name='sidCTemp']").val();
        var subC = $("input[name='subjectCTemp']").val();
        var msgC = $("textarea#messageCTemp").val();

        let hashFULLNAME = CryptoJS.AES.encrypt(fn, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashEMAILC = CryptoJS.AES.encrypt(emailC, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashSIDC = CryptoJS.AES.encrypt(sidC, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashSUBJECTC = CryptoJS.AES.encrypt(subC, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashMSGC = CryptoJS.AES.encrypt(msgC, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

        // console.log(hashMSGC);
        $('#fullnameC').val(hashFULLNAME);
        $('#emailC').val(hashEMAILC);
        $('#sidC').val(hashSIDC);
        $('#subjectC').val(hashSUBJECTC);
        $('#messageC').val(hashMSGC);
        // console.log($('#messageC').val());
    });

    function escape(input) {
        // filter potential start-tags
        input = input.replace(/<([a-zA-Z])/g, '<_$1');
        // use all-caps for heading
        input = input.toUpperCase();

        // sample input: you shall not pass! => YOU SHALL NOT PASS!
        return input;
    }

    $('#messageCTemp').on('keydown', function () {
        let msg = escape($(this).val());
        $(this).val(msg);
    })

    var passphrase = 'bhavnatahelyani';

    function CryptoJSAesDecrypt(passphrase, encrypted_json_string){

        console.log(typeof encrypted_json_string);
        // var obj_json = JSON.parse(encrypted_json_string);
        //
        // var encrypted = obj_json.ciphertext;
        // var salt = CryptoJS.enc.Hex.parse(obj_json.salt);
        // var iv = CryptoJS.enc.Hex.parse(obj_json.iv);
        //
        // var key = CryptoJS.PBKDF2(passphrase, salt, { hasher: CryptoJS.algo.SHA512, keySize: 64/8, iterations: 999});
        //
        // var decrypted = CryptoJS.AES.decrypt(encrypted, key, { iv: iv});
        //
        // return decrypted.toString(CryptoJS.enc.Utf8);

        var encrypted = encrypted_json_string.ciphertext;

        var salt = CryptoJS.enc.Hex.parse(encrypted_json_string.salt);
        var iv1 = CryptoJS.enc.Hex.parse(encrypted_json_string.iv);

        var key = CryptoJS.PBKDF2(passphrase, salt, { hasher: CryptoJS.algo.SHA512, keySize: 64/8, iterations: 999});
        var decrypted = CryptoJS.AES.decrypt(encrypted, key, { iv: iv1});
        return decrypted.toString(CryptoJS.enc.Utf8);
    }

    $('#loginHome').submit(function (e) {
        e.preventDefault();
    });

    $('#homeLoginbtn').click(function () {
        console.log('called');
        var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
        var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

        var emailUser = $("#emailHome").val();
        var pswdUser = $("#passwordHome").val();

        let hashEMAIL = CryptoJS.AES.encrypt(emailUser, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashPSWD = CryptoJS.AES.encrypt(pswdUser, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();


        function CharusatEmail(mail) {
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

        if(CharusatEmail(emailUser)) {
            let token =  $('input[name="csrf_token"]').attr('value');

            let hashtoken = CryptoJS.AES.encrypt(token, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

            $.ajax({
                url: 'Database/login.php',
                type: 'POST',
                data: {
                    'CSRFToken' : hashtoken,
                    'emailUser': hashEMAIL,
                    'passwordUser': hashPSWD
                },
                dataType: 'json',
                success: function (data) {
                    var data = CryptoJSAesDecrypt(passphrase, data);
                    if(data == "wait")
                    {
                        swal({
                            text: "Thank you for registering, please wait untill event start.",
                            icon: "info"
                        });
                    }
                    else if(data == 'index') {
                        window.location.href="index";
                    }
                    else if(data == 'blocked') {
                        swal({
                            title: "Blocked",
                            text: "You are blocked, now you can contact Admin.",
                            icon: "error"
                        });
                    }
                    else if(data == "not verified")
                    {
                        swal({
                            title: "Warning",
                            text: "Your email is not verified, we will provide you verification window soon please wait.",
                            icon: "warning",
                            buttons: false
                        });
                        setTimeout(function (){
                            window.location.href="./Database/emailVerify.php?email=" + emailUser;
                        }, 3000);
                    }
                    else if(data == "not matched")
                    {
                        swal({
                            title: "Warning",
                            text: "Invalid Password",
                            icon: "warning"
                        });
                    }
                    else if(data == "success")
                    {
                        swal({
                            title: "Success",
                            text: "Login successful",
                            icon: "success",
                            buttons: false
                        });
                        setTimeout(function (){
                            window.location.href="session";
                        }, 3000);
                    }
                    else if(data == "Email not found")
                    {
                        swal({
                            text: "Email not found, please register yourself.",
                            icon: "info"
                        });
                    }
                    else
                    {
                        swal({
                            title: "Error",
                            text: "Something went wrong.",
                            icon: "error"
                        });
                    }
                }
            });
        }
    });

    function escape(input) {
        // tags stripping mechanism from ExtJS library
        // Ext.util.Format.stripTags
        var stripTagsRE = /<\/?[^>]+>/gi;
        input = input.replace(stripTagsRE, '');

        return input;
    }

    $.ajax({
        url:'./Database/timer.php',
        type: 'POST',
        success: function (data) {
            $('.counter').npyScorecount({
                startDate: data,
                endDate: '2020-09-13 23:00:00',
                gmt: '+0530',
                displayDays: false,
                digitSize: [100, 140],
                tokens: ['&nbsp;', ':', ':', '&nbsp;']
            });
        }
    })
});

var passphrase = 'bhavnatahelyani';

function CryptoJSAesDecrypt(passphrase, encrypted_json_string){

    var obj_json = JSON.parse(encrypted_json_string);

    var encrypted = obj_json.ciphertext;
    var salt = CryptoJS.enc.Hex.parse(obj_json.salt);
    var iv = CryptoJS.enc.Hex.parse(obj_json.iv);

    var key = CryptoJS.PBKDF2(passphrase, salt, { hasher: CryptoJS.algo.SHA512, keySize: 64/8, iterations: 999});

    var decrypted = CryptoJS.AES.decrypt(encrypted, key, { iv: iv});

    return decrypted.toString(CryptoJS.enc.Utf8);
}

var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

window.addEventListener("load", function(){
    const loader = document.querySelector(".preloader");
    loader.className += " hidden";
});

