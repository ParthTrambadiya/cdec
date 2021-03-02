const form = document.querySelector('#login_form');

const name_reg = /^[a-zA-Z\s]{1,30}$/;
const email_reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
const pass_reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9!@#$%^&*]{8,16}$/;

var fn = 1, em = 1, pw = 1;

var email = form.elements.namedItem('emailTemp');
var password = form.elements.namedItem('passwordTemp');
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
        var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
        var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");
        var eml = $("input[name='emailTemp']").val();
        var pwd = $("input[name='passwordTemp']").val();
        let hashPwd = CryptoJS.AES.encrypt(pwd, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashEmail = CryptoJS.AES.encrypt(eml, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        $('#email').val(hashEmail);
        $('#password').val(hashPwd);
        form.submit();
    } else {
        alert('Please fill the form properly'); 
        e.preventDefault();
    }
});

function validate (e) {
    var target = e.target;

    if(target.name == 'passwordTemp') {
        if(pass_reg.test(target.value)) {
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

    if(target.name == 'emailTemp') {
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