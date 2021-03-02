var tab;
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

$('document').ready(function() {
    $('#msg_row').hide();
    tab = $("#dataTable").DataTable({
        "responsive": true,
        "autoWidth": false,
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"B><"col-md-4"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                },
                filename: 'CDec'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5,6]
                },
                filename: 'CDec'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5,6]
                },
                filename: 'CDec'
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5,6]
                },
                filename: 'CDec'
            }
        ]
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

function initTable(id) {
    tab = $(id).DataTable({
        "responsive": true,
        "autoWidth": false,
    });
}

$('#reloadTab').click(function() {
    $('#updTime').load("users.php #updTime");
    $("#dataTable").DataTable().clear().destroy();
    $("#tableCard").load('users.php #dataTable', function() {
        initTable('#dataTable');
    });
})

$('#showUserModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever').toString() // Extract info from data-* attributes
    var modal = $(this)
    
    let hashId = CryptoJS.AES.encrypt(recipient, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    var act = "show";
    let hashAction = CryptoJS.AES.encrypt(act, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    $.ajax({
        url:"show-user.php",
        type: "POST",
        data: {id: hashId, action: hashAction},
        dataType:"json",
        success:function(response) {
            var data = CryptoJSAesDecrypt(passphrase, response);
            if(data.status == 0) {
                toastr.remove();
                toastr.error(data.message, "Error");
            } else {
                modal.find('#fullname').html(data.firstname + " " + data.lastname);
                modal.find('#stId').html(data.stid);
                modal.find('#gender').html(data.gender);
                modal.find('#contact').html(data.contact);
                modal.find('#institute').html(data.institute);
                modal.find('#dept').html(data.dept);
                modal.find('#email').html(data.email);
                modal.find('#level').html(data.level);
                modal.find('#clearTime').html(data.clear_time);
                modal.find('#credits').html(data.credits);
                modal.find('#activation').html(data.activation_status);
                if(data.activation_status == "active") {
                    modal.find("#activation").removeClass("badge-danger");
                    modal.find("#activation").removeClass("badge-warning");
                    modal.find("#activation").addClass("badge badge-success");
                } else if(data.activation_status == "pending") {
                    modal.find("#activation").removeClass("badge-danger");
                    modal.find("#activation").removeClass("badge-success");
                    modal.find("#activation").addClass("badge badge-warning");
                } else if(data.activation_status == "blocked") {
                    modal.find("#activation").removeClass("badge-success");
                    modal.find("#activation").removeClass("badge-warning");
                    modal.find("#activation").addClass("badge badge-danger");
                }
                modal.find('#regTime').html(data.reg_date);
            }
        },
        error: function(error) {
            console.log(error);
        }
    })
})

$('#tableCard').on('click', '.delUser', function() {

    var recipient = $(this).data('whatever').toString();
    let hashId = CryptoJS.AES.encrypt(recipient, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    let hashAction = CryptoJS.AES.encrypt("del", key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    toastr.error("<button type='button' class='btn' style='color:red;background:white' id='deleteUser'>Yes</button>",'The user data will be deleted from the database. Do you want to continue?',
    {
        closeButton: true,
        allowHtml: true,
        timeOut: 0,
        extendedTimeOut: 0,
        onShown: function (toast) {
            $("#deleteUser").click(function(){
                $.ajax({
                    url:"show-user.php",
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
                            toastr.success(data.message, "Success");
                            var r = $('tbody tr#userRow' + recipient);
                            tab.row(r).remove().draw();
                        }
                    }
                })
            });
          }  
    })
})

$('#tableCard').on('click', '.block-user', function() {

    var recipient = $(this).data('whatever').toString();

    let hashId = CryptoJS.AES.encrypt(recipient, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    var act = "block";
    let hashAction = CryptoJS.AES.encrypt(act, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    toastr.remove();
    toastr.warning("<button type='button' class='btn' style='color:black;background:white' id='blockUser'>Yes</button>",'The user will not be able to access the site. Do you want to block the user anyway?',
    {
        closeButton: true,
        allowHtml: true,
        timeOut: 0,
        extendedTimeOut: 0,
        onShown: function (toast) {
            $("#blockUser").click(function(){
                $.ajax({
                    url:"show-user.php",
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
                            toastr.success(data.message, "Success");
                            $('.statusBadge' + recipient).addClass("badge-danger");
                            $('.statusBadge' + recipient).removeClass("badge-success");
                            $('.statusBadge' + recipient).html("Blocked");
                            var b = $('.block-user[data-whatever="' + recipient + '"]');
                            b.find('.fas').removeClass("fa-times");
                            b.find('.fas').addClass("fa-check");
                            b.removeClass('btn-outline-primary');
                            b.addClass('btn-outline-success');
                            b.addClass('unblock-user');
                            b.find("span.stat").html("Unblock");
                            b.removeClass('block-user');
                        }
                    }
                })
            });
          }  
    })
})

$('#tableCard').on('click', '.unblock-user', function() {

    var recipient = $(this).data('whatever').toString();
    let hashId = CryptoJS.AES.encrypt(recipient, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    var act = "unblock";
    let hashAction = CryptoJS.AES.encrypt(act, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    toastr.remove();
    toastr.warning("<button type='button' class='btn' style='color:black;background:white' id='unblockUser'>Yes</button>",'The user will get access to the site. Do you want to unblock the user anyway?',
    {
        closeButton: true,
        allowHtml: true,
        timeOut: 0,
        extendedTimeOut: 0,
        onShown: function (toast) {
            $("#unblockUser").click(function(){
                $.ajax({
                    url:"show-user.php",
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
                            toastr.success(data.message, "Success");
                            $('.statusBadge' + recipient).addClass("badge-warning");
                            $('.statusBadge' + recipient).removeClass("badge-danger");
                            $('.statusBadge' + recipient).html("Pending");
                            var b = $('.unblock-user[data-whatever="' + recipient + '"]').remove();
                        }
                    }
                })
            });
          }  
    })
})