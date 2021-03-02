var tab;
var passphrase = 'bhavnatahelyani';

var key = CryptoJS.enc.Hex.parse("0123456789cdec0123456789cdeccdec");
var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

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

$('document').ready(function() {
    $('#msg_row').hide();
    tab = $("#dataTable").DataTable({
        "autoWidth": false,
        "responsive": true,
        "ajax": "show-table.php",
        "columns": [
            { "data": "level_no" },
            { "data": "level_name" },
            { "data": "question" },
            { "data" : "img" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                "<object data=\"../assets/levelImg/" + data + "\" class='level-img'>no-image</object>":
                data;
            }},
            { "data": "answer" },
            { "data": "hint" },
            { "data" : "id" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                "<a href='#' class='btn btn-primary' data-toggle='modal' data-whatever=\"" + data + "\" data-target=\".editLevelModal\"><i class=\"fas fa-edit\"></i></a>":
                  data;
            }},
        ],
        'columnDefs': [ {
            'targets': [3, 6],  /* column index */
            'orderable': false, /* true or false */
        }]
    });

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": true,
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

})

$('.editLevelModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever').toString() // Extract info from data-* attributes
    var modal = $(this)

    let hashId = CryptoJS.AES.encrypt(recipient, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    var act = "show";
    let hashAction = CryptoJS.AES.encrypt(act, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    $.ajax({
        url:"show-level.php",
        type: "POST",
        data: {id: hashId, action: hashAction},
        dataType:"json",
        success:function(response) {
            var data = CryptoJSAesDecrypt(passphrase, response);
            if(data.status == 0) {
                toastr.remove();
                toastr.error(data.message, "Error");
            } else {
                $('#elevel_name').removeClass('is-invalid');
                $('#elevel_name').removeClass('is-valid');
                $('#elevel_no').removeClass('is-invalid');
                $('#elevel_no').removeClass('is-valid');
                $('#equestion').removeClass('is-invalid');
                $('#equestion').removeClass('is-valid');
                $('#eanswer').removeClass('is-invalid');
                $('#eanswer').removeClass('is-valid');
                $('#ehint').removeClass('is-invalid');
                $('#ehint').removeClass('is-valid');
                modal.find('#elevel_name').val(data.level_name);
                modal.find('#elevel_no').val(data.level_no);
                modal.find('#equestion').val(data.question);
                modal.find('#eanswer').val(data.answer);
                modal.find('#ehint').val(data.hint);
                modal.find('#id').val(data.id);
            }
        },
        error: function(error) {
            console.log(error.responseText);
        }
    })
})

const form = document.querySelector('#level_form');
const forme = document.querySelector('#edit_level_form');

const levName_reg = /^[a-zA-Z0-9\s]{1,30}$/;
const ans_reg = /^[a-zA-Z0-9!@#$%^&*()-_=/;'".,?+}\[\]\s]{1,50}$/;
const hint_reg = /^[a-zA-Z0-9!@#$%^&*()-_=/;'".,?+}\[\]\s]{1,500}$/;
const levNo_reg = /^[0-9]{1,2}$/;
const elevNo_reg = /^[0-9]{1,3}$/;
const que_reg = /^[a-zA-Z0-9!@#$%^&*()-_=/;'".,?+}\[\]\s]{1,}$/;

var lnm = 0, lno = 0, que = 0, ans = 0, hn = 1;
var elnm = 1, elno = 1, eque = 1, eans = 1, ehn = 1;

let levelName = form.elements.namedItem('level_name');
let levelNo = form.elements.namedItem('level_no');
let question = form.elements.namedItem('question');
let answer = form.elements.namedItem('answer');
let hint = form.elements.namedItem('hint');

levelName.addEventListener('input', validate);
levelNo.addEventListener('input', validate);
question.addEventListener('input', validate);
answer.addEventListener('input', validate);
hint.addEventListener('input', validate);

levelName.addEventListener('blur', validate);
levelNo.addEventListener('blur', validate);
question.addEventListener('blur', validate);
answer.addEventListener('blur', validate);
hint.addEventListener('blur', validate);

let elevelName = forme.elements.namedItem('elevel_name');
let elevelNo = forme.elements.namedItem('elevel_no');
let equestion = forme.elements.namedItem('equestion');
let eanswer = forme.elements.namedItem('eanswer');
let ehint = forme.elements.namedItem('ehint');

elevelName.addEventListener('input', validate);
elevelNo.addEventListener('input', validate);
equestion.addEventListener('input', validate);
eanswer.addEventListener('input', validate);
ehint.addEventListener('input', validate);

elevelName.addEventListener('blur', validate);
elevelNo.addEventListener('blur', validate);
equestion.addEventListener('blur', validate);
eanswer.addEventListener('blur', validate);
ehint.addEventListener('blur', validate);

form.addEventListener('submit', function(e) {
    e.preventDefault();
})
forme.addEventListener('submit', function(e) {
    e.preventDefault();
})

function validate (e) {
    let target = e.target;

    if(target.name == 'level_name') {
        if(levName_reg.test(target.value)) {
            lnm = 1;
            $('#level_name').removeClass('is-invalid');
            $('#level_name').addClass('is-valid');
        } else {
            lnm = 0;
            $('#level_name').removeClass('is-valid');
            $('#level_name').addClass('is-invalid');
        }
    } else if(target.name == 'level_no') {
        if(levNo_reg.test(target.value)) {
            lno = 1;
            $('#level_no').removeClass('is-invalid');
            $('#level_no').addClass('is-valid');
        } else {
            lno = 0;
            $('#level_no').removeClass('is-valid');
            $('#level_no').addClass('is-invalid');
        }
    } else if(target.name == 'question') {
        if(que_reg.test(target.value)) {
            que = 1;
            $('#question').removeClass('is-invalid');
            $('#question').addClass('is-valid');
        } else {
            que = 0;
            $('#question').removeClass('is-valid');
            $('#question').addClass('is-invalid');
        }
    } else if(target.name == 'answer') {
        if(ans_reg.test(target.value)) {
            ans = 1;
            $('#answer').removeClass('is-invalid');
            $('#answer').addClass('is-valid');
        } else {
            $('#answer').removeClass('is-valid');
            $('#answer').addClass('is-invalid');
            ans = 0;
        }
    }
    else if(target.name == 'hint') {
        if(target.value.length != 0) {
            if(hint_reg.test(target.value)) {
                $('#hint').removeClass('is-invalid');
                $('#hint').addClass('is-valid');
                hn = 1;
            } else {
                $('#hint').removeClass('is-valid');
                $('#hint').addClass('is-invalid');
                hn = 0;
            }
        }
    } else if(target.name == 'elevel_name') {
        if(levName_reg.test(target.value)) {
            elnm = 1;
            $('#elevel_name').removeClass('is-invalid');
            $('#elevel_name').addClass('is-valid');
        } else {
            elnm = 0;
            $('#elevel_name').removeClass('is-valid');
            $('#elevel_name').addClass('is-invalid');
        }
    } else if(target.name == 'elevel_no') {
        if(elevNo_reg.test(target.value) && parseInt(target.value) <= 100) {
            elno = 1;
            $('#elevel_no').removeClass('is-invalid');
            $('#elevel_no').addClass('is-valid');
        } else {
            elno = 0;
            $('#elevel_no').removeClass('is-valid');
            $('#elevel_no').addClass('is-invalid');
        }
    } else if(target.name == 'equestion') {
        if(que_reg.test(target.value)) {
            eque = 1;
            $('#equestion').removeClass('is-invalid');
            $('#equestion').addClass('is-valid');
        } else {
            eque = 0;
            $('#equestion').removeClass('is-valid');
            $('#equestion').addClass('is-invalid');
        }
    } else if(target.name == 'eanswer') {
        if(ans_reg.test(target.value)) {
            eans = 1;
            $('#eanswer').removeClass('is-invalid');
            $('#eanswer').addClass('is-valid');
        } else {
            $('#eanswer').removeClass('is-valid');
            $('#eanswer').addClass('is-invalid');
            eans = 0;
        }
    }
    else if(target.name == 'ehint') {
        if(target.value.length != 0) {
            if(hint_reg.test(target.value)) {
                $('#ehint').removeClass('is-invalid');
                $('#ehint').addClass('is-valid');
                ehn = 1;
            } else {
                $('#ehint').removeClass('is-valid');
                $('#ehint').addClass('is-invalid');
                ehn = 0;
            }
        }
    }
}

$('.delLevel').click(function() {
    var id = $('#id').val();
    let hashId = CryptoJS.AES.encrypt(id, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    let hashAction = CryptoJS.AES.encrypt("delete", key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    $.ajax({
        url:"show-level.php",
        type: "POST",
        data: {id: hashId, action: hashAction},
        dataType:"json",
        success:function(response) {
            var data = CryptoJSAesDecrypt(passphrase, response);
            if(data.status == 0) {
                toastr.remove();
                toastr.error(data.message, "Error");
            } else {
                toastr.remove();
                toastr.success(data.message);
                tab.ajax.reload();
                $('.modal-backdrop').remove();
                $(".editLevelModal").modal('hide');
                $("#edit_level_form").trigger("reset");
            }
        }
    })
})

$('#level_form').on('submit', function(e) {

    var allOk = 1;

    toastr.remove();
    if(lnm == 0) {
        allOk = 0;
        toastr.error("Level name must be of 1 to 30 characters.", "Error");
        $('#level_name').addClass('is-invalid');
    }
    if(lno == 0) {
        allOk = 0;
        toastr.error("Level number must be from 0 to 99.", "Error");
        $('#level_no').addClass('is-invalid');
    }
    if(que == 0) {
        allOk = 0;
        toastr.error("Question must be of 1 to 1000 characters.", "Error");
        $('#question').addClass('is-invalid');
    }
    if(ans == 0) {
        allOk = 0;
        toastr.error("Answer must be of 1 to 100 characters.", "Error");
        $('#answer').addClass('is-invalid');
    }
    if(hn == 0) {
        allOk = 0;
        toastr.error("Hint must be of 1 to 300 characters.", "Error");
        $('#hint').addClass('is-invalid');
    }

    if(allOk == 1) {
        var lnumber = $('#level_no').val();
        var lname = $('#level_name').val();
        var ques = $('#question').val();
        var answ = $('#answer').val();
        var htn = $('#hint').val();

        let hashLno = CryptoJS.AES.encrypt(lnumber, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashLname = CryptoJS.AES.encrypt(lname, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashQues = CryptoJS.AES.encrypt(ques, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashAns = CryptoJS.AES.encrypt(answ, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashHint = CryptoJS.AES.encrypt(htn, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

        $.ajax({
            url:"add-level.php",
            type: "POST",
            data:  {
                level_no: hashLno,
                level_name: hashLname,
                question: hashQues,
                answer: hashAns,
                hint: hashHint
            },
            dataType:"json",
            success:function(response) {
                var data = CryptoJSAesDecrypt(passphrase, response);
                if(data.status == 0) {
                    toastr.remove();
                    toastr.error(data.message, "Error");
                } else {
                    toastr.remove();
                    toastr.success(data.message);
                    
                    tab.ajax.reload();
                    $('.modal-backdrop').remove();
                    $("#addLevelModal").modal('hide');
                    $("#level_form").trigger("reset");
                    $.each($("#level_form input"), function() {
                        $(this).removeClass('is-valid');
                        $(this).removeClass('is-invalid');
                    })
                }
            },
            error: function(error) {
                console.log(error.responseText);
            }
        })
    }
})

$('#edit_level_form').on('submit', function(e) {

    var allOk = 1;

    toastr.remove();
    if(elnm == 0) {
        toastr.error("Level name must be of 1 to 30 characters.", "Error");
        $('#elevel_name').addClass('is-invalid');
        allOk = 0;
    }
    if(elno == 0) {
        toastr.error("Level number must be from 0 to 99.", "Error");
        $('#elevel_no').addClass('is-invalid');
        allOk = 0;
    }
    if(eque == 0) {
        toastr.error("Question must be of 1 to 1000 characters.", "Error");
        $('#equestion').addClass('is-invalid');
        allOk = 0;
    }
    if(eans == 0) {
        toastr.error("Answer must be of 1 to 100 characters.", "Error");
        $('#eanswer').addClass('is-invalid');
        allOk = 0;
    }
    if(ehn == 0) {
        toastr.error("Hint must be of 1 to 100 characters.", "Error");
        $('#ehint').addClass('is-invalid');
        allOk = 0;
    }

    if(allOk == 1) {
        var lnumber = $('#elevel_no').val();
        var lname = $('#elevel_name').val();
        var ques = $('#equestion').val();
        var answ = $('#eanswer').val();
        var htn = $('#ehint').val();
        var id = $('#id').val();
        let hashLno = CryptoJS.AES.encrypt(lnumber, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashLname = CryptoJS.AES.encrypt(lname, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashQues = CryptoJS.AES.encrypt(ques, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashAns = CryptoJS.AES.encrypt(answ, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashHint = CryptoJS.AES.encrypt(htn, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashId = CryptoJS.AES.encrypt(id, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

        $.ajax({
            url:"edit-level.php",
            type: "POST",
            data:  {
                level_no: hashLno,
                level_name: hashLname,
                question: hashQues,
                answer: hashAns,
                hint: hashHint,
                id: hashId
            },
            dataType:"json",
            success:function(response) {
                var data = CryptoJSAesDecrypt(passphrase, response);
                if(data.status == 0) {
                    toastr.remove();
                    toastr.error(data.message, "Error");
                } else {
                    toastr.remove();
                    toastr.success(data.message);
                    
                    $('.modal-backdrop').remove();
                    tab.ajax.reload();

                    $('.editLevelModal').modal('hide');
                    // $("#edit_level_form").trigger("reset");
                    $.each($("#edit_level_form input"), function() {
                        $(this).removeClass('is-valid');
                        $(this).removeClass('is-invalid');
                    })
                    elnm = 1;
                    elno = 1;
                    eque = 1;
                    eans = 1; 
                    ehn = 1;
                }
            },
            error:function(error){
                console.log(error);
            }
        })
    }
})