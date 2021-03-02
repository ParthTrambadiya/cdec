const form = document.querySelector('#login_form');

const name_reg = /^[a-zA-Z\s]{1,30}$/;
const email_reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
const pass_reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9!@#$%^&*]{8,16}$/;

var fn = 1, em = 1, pw = 1;

var email = form.elements.namedItem('email');
var password = form.elements.namedItem('password');
var fullname = form.elements.namedItem('fullname');

email.addEventListener('input', validate);
password.addEventListener('input', validate);
if(fullname != null)
    fullname.addEventListener('input', validate);

email.addEventListener('blur', validate);
password.addEventListener('blur', validate);
if(fullname != null)
    fullname.addEventListener('blur', validate);

form.addEventListener('submit', function(e) {
    if((fn === 1) && (em === 1) && (pw === 1)) {
        e.preventDefault();
    } else {
        alert('Please fill the form properly'); 
        e.preventDefault();
    }
});

function validate (e) {
    var target = e.target;

    if(target.name == 'password') {
        if(pass_reg.test(target.value) || target.value.length == 0) {
            target.classList.add('validInp');
            target.classList.remove('invalidInp');
            pw = 1;
        } else {
            target.classList.add('invalidInp');
            target.classList.remove('validInp');
            pw = 0;
        }
    }

    if(target.name == 'fullname') {
        if(name_reg.test(target.value)) {
            target.classList.add('validInp');
            target.classList.remove('invalidInp');
            fn = 1;
        } else {
            target.classList.add('invalidInp');
            target.classList.remove('validInp');
            fn = 0;
        }
    }

    if(target.name == 'email') {
        if(email_reg.test(target.value)) {
            target.classList.add('validInp');
            target.classList.remove('invalidInp');
            em = 1;
        } else {
            target.classList.add('invalidInp');
            target.classList.remove('validInp');
            em = 0;
        }
    }
}

$('document').ready(function() {
    $('#changeImg').hide();
    $('#msg_row').hide();
})
$("#profile_img").click(function(e) {
    $("#imageUpload").click();
});
$('#msg_row').click(function() {
    $(this).hide();
})

function fasterPreview( uploader ) {
    if ( uploader.files && uploader.files[0] ){
        $('#profile_img').attr('src', 
            window.URL.createObjectURL(uploader.files[0]) );
        $('#changeImg').show();
    }
}

$("#imageUpload").change(function(){
    fasterPreview( this );
});

$("#profile_Form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'update_image.php',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        // beforeSend: function(){
        //     $('.submitBtn').attr("disabled","disabled");
        //     $('#profile_Form').css("opacity",".5");
        // },
        success: function(response){ 
            if(response.status == 1){
                $('#changeImg').hide();
                showMessage(response.message, 'success');
            }else{
                showMessage(response.message, 'danger');
            }
        }
    });
});

$('#submit_form').click(function() {
    var fullname = $('#fullname').val();
    var email = $('#email').val();
    var password = $('#password').val();

    if((fn === 1) && (em === 1) && (pw === 1)) {
        var change;
        if(password.length == 0) {
            change = 0;
        } else {
            change = 1;
        }
        $.ajax({
            url:"admin_update.php",
            method:"POST",
            data:{
                fullname:fullname,
                email:email,
                password:password,
                change: change},
            dataType:"json",
            success:function(data) {
                showMessage(data.message, data.status);
            }
        })
    }
})

function showMessage(message, status) {
    $('#msg_row').show();
    $('#msg_row').text(message);
    $('#msg_row').addClass('btn-' + status);
}