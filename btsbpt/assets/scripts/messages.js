var passphrase = 'bhavnatahelyani';

var key = CryptoJS.enc.Hex.parse("0123456789cdec0123456789cdeccdec");
var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

function CryptoJSAesDecrypt(passphrase, encrypted_json_string){
 
    var response = {};

    var salt = CryptoJS.enc.Hex.parse(encrypted_json_string.salt);
    var iv1 = CryptoJS.enc.Hex.parse(encrypted_json_string.iv);
    
    $.each(encrypted_json_string, function(k, r) {
        if(k != 'salt' && k!= 'iv') {
            response[k] = r;
            var key1 = CryptoJS.PBKDF2(passphrase, salt, { hasher: CryptoJS.algo.SHA512, keySize: 64/8, iterations: 999});

            response[k] = CryptoJS.AES.decrypt(response[k], key1, { iv: iv1}).toString(CryptoJS.enc.Utf8);
        }
    })
    return response;
}

setInterval(function() {
    var s_id = $('#sessionCheck').html();
    let hashId = CryptoJS.AES.encrypt(s_id, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    $.ajax({
        url: "check_session.php",
        type: "POST",
        data: {session: hashId},
        success: function(data) {
            if(data == "destroy") {
                window.alert("You are already logged in somewhere.");
                window.location.href = "logout.php";
            }
        },
        error: function(error) {
            console.log(responseText);
        }
    })
}, 60000);

$(document).ready(function() {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": true,
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $('.schDiv').hide()
    $('.select2').select2()
    $('#summernote').summernote({
        placeholder: 'Type here...',
        tabsize: 2,
        height: 300,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });
    $('#sendMsgForm').on('submit', function(e) {
        if($('#summernote').summernote('isEmpty')) {
            toastr.error("Please type message");
            e.preventDefault();
        }
        else {
            var subject = $("#subjectI").val();
            var mailTo = $("#mailToSelect option:selected").val();
            var message = $('#summernote').summernote('code');
            var dt = $("#date").val();
            var tm = $("#time").val();

            let hashSubject = CryptoJS.AES.encrypt(subject, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
            let hashMailTo = CryptoJS.AES.encrypt(mailTo, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
            let hashMessage = CryptoJS.AES.encrypt(message, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
            let hashDate = CryptoJS.AES.encrypt(dt, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
            let hashTime = CryptoJS.AES.encrypt(tm, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

            $('#subjectOriginal').attr('value', hashSubject);
            $('#mailToOriginal').val(hashMailTo);
            $('#messageOriginal').text(hashMessage);
            $('#dateOriginal').val(hashDate);
            $('#timeOriginal').val(hashTime);

            $(this).submit();
        }
    })
    $('#schedule').on('change', function() {
        if($(this).prop("checked") == true) {
            $('.schDiv').show()
            $('.schInp').attr("required", true);
        } else {
            $('.schDiv').hide()
            $('.schInp').attr("required", false);
        }
    })
});
$('.msgRow').click(function() {
    var id = $(this).data('id').toString();

    let hashId = CryptoJS.AES.encrypt(id, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    let hashCat = CryptoJS.AES.encrypt("contact", key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    $.ajax({
        url: "show-message.php",
        type: "POST",
        data: {id: hashId, category: hashCat},
        dataType: "json",
        success: function(response) {
            var data = CryptoJSAesDecrypt(passphrase, response);
            if(data.status == 0) {
                $('#message').html(data.response);
            } else {
                $('#msgFrom').html(data.fullname);
                $('#stId').html(data.sid);
                $('#emailMsg').html(data.email);
                $('#subjectMsg').html(data.subject);
                $('#message').html(data.message);
                if(data.stat_change == 1) {
                    $('#unread_badge').load("messages.php #unread_badge");
                    $('i.mail_stat[data-id=' + id + ']').removeClass('pe-7s-mail');
                    $('i.mail_stat[data-id=' + id + ']').addClass('pe-7s-mail-open');
                }
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})
$('.mailRow').click(function() {
    var id = $(this).data('id').toString();
    let hashId = CryptoJS.AES.encrypt(id, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    let hashCat = CryptoJS.AES.encrypt("sent", key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    $.ajax({
        url: "show-message.php",
        type: "POST",
        data: {id: hashId, category: hashCat},
        dataType: "json",
        success: function(response) {
            var data = CryptoJSAesDecrypt(passphrase, response);
            if(data.stat == 0) {
                $('#messageM').html(data.response);
            } else {
                if(data.mailto == "allusers") {
                    $('#msgTo').html("All users");
                } else if(data.mailto == "level25up") {
                    $('#msgTo').html("Level 25-50 users");
                } else if(data.mailto == "level50up") {
                    $('#msgTo').html("Level 50 up users");
                } else if(data.mailto.substring(0, 5) == "user.") {
                    $('#msgTo').html($('.mailRow[data-id=' + id + '] .showName').html());
                }
                if(data.schedule == 0) {
                    $('#sch').html("Not Scheduled");
                    $('#sch-time').html("-");
                    $('#msgStat').html("Sent");
                } else {
                    $('#sch').html("Yes");
                    $('#sch-time').html(data.sch_time + " " + data.sch_date);
                    $('#msgStat').html(data.status);
                }
                $('#subjectMail').html(data.subject);
                $('#messageM').html(data.message);
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})