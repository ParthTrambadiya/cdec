$(document).ready(function () {
    $('#search_text').keyup(function(){
        let search = $(this).val();
        if(search != '')
        {
            updateSearch(search);
        }
    });

    changedept();
    setInterval(function () {
        var search = $('#search_text').val();
        if(search != '')
        {
            updateSearch(search);
        }
        else
        {
            changedept();
        }
    }, 60000);

    $('#instLB').change(function(){
        changeinst();
    });

    $('#deptLB').change(function(){
        changedept();
    });
});

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


function updateSearch(search) {
    let instLB = $('#instLB').val();
    let deptLB = $('#deptLB').val();

    let hashSEARCH = CryptoJS.AES.encrypt(search, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    let hashINST = CryptoJS.AES.encrypt(instLB, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    let hashDEPT = CryptoJS.AES.encrypt(deptLB, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    $.ajax({
        url: './Database/searchLB.php',
        type: 'POST',
        data: {
            s: hashSEARCH,
            inst: hashINST,
            dept: hashDEPT
        },
        success: function (data) {
            var data = CryptoJSAesDecrypt(passphrase, data);
            $('#tbodyLB').html(data);
        }
    })
}
function changeinst() {
    var inst = $('#instLB').val();
    $('#search_text').val('');

    let hashINST = CryptoJS.AES.encrypt(inst, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    if(inst === 'all'){
        updateLB();
        $('#deptLB').html('<option value="all">First Select Institute</option>');
    }
    else {
        $.ajax({
            url:'./Database/sortingLB.php',
            type:'POST',
            data:{
                inst: hashINST
            },
            success:function(data){
                var data = CryptoJSAesDecrypt(passphrase, data);
                $('#tbodyLB').html(data);
            }
        });
    }
}

function changedept() {
    $('#search_text').val('');

    let hashINST = CryptoJS.AES.encrypt($('#instLB').val(), key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    let hashDEPT = CryptoJS.AES.encrypt($('#deptLB').val(), key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    if($('#instLB').val() === 'all'){
        updateLB();
    }
    else if($('#deptLB').val() == 'Select Department') {

    }
    else{
        $.ajax({
            url:'./Database/sortingLB.php',
            type:'POST',
            data:{
                inst: hashINST,
                dept: hashDEPT
            },
            success:function(data){
                var data = CryptoJSAesDecrypt(passphrase, data);
                $('#tbodyLB').html(data);
            }
        });
    }
}

function updateLB () {
    $.ajax({
        url: './Database/mainLB.php',
        type: 'POST',
        success: function (data) {
            var data = CryptoJSAesDecrypt(passphrase, data);
            $('#tbodyLB').html(data);
            $('table #tbodyLB tr:eq(0)').css({'background-color': '#e3b11e'});
            $('table #tbodyLB tr:eq(1)').css({'background-color': '#c4c4c4'});
            $('table #tbodyLB tr:eq(2)').css({'background-color': '#a57334'});
        }
    });
}