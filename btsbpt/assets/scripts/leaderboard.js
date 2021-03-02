$('document').ready(function() {

    var ins = "CSPIT";
    var instTab;
    $('#msg_row').hide();

    // function CryptoJSAesDecrypt(passphrase, encrypted_json_string){
 
    //     var response = {};
    
    //     var salt = CryptoJS.enc.Hex.parse(encrypted_json_string.salt);
    //     var iv1 = CryptoJS.enc.Hex.parse(encrypted_json_string.iv);
        
    //     $.each(encrypted_json_string, function(k, r) {
    //         if(k != 'salt' && k!= 'iv') {
    //             response[k] = r;
    //             var key1 = CryptoJS.PBKDF2(passphrase, salt, { hasher: CryptoJS.algo.SHA512, keySize: 64/8, iterations: 999});
    
    //             response[k] = CryptoJS.AES.decrypt(response[k], key1, { iv: iv1}).toString(CryptoJS.enc.Utf8);
    //         }
    //     })
    //     return response;
    // }

    var insKeyAll = "all";

    var key = CryptoJS.enc.Hex.parse("0123456789cdec0123456789cdeccdec");
    var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");
    let hashInsAll = CryptoJS.AES.encrypt(insKeyAll, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    let hashInst = CryptoJS.AES.encrypt(ins, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
    
    tab = $("#dataTable").DataTable({
        "autoWidth": false,
        "responsive": true,
        "ajax":  {'url': "show-lb.php", 'type': "POST", 'data': {'inst': hashInsAll} },
        "columns": [
            { "data" : "rank" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                "#" + data:
                data;
            }},
            { "data": "level" },
            { "data": "fullname" },
            { "data": "stid" },
            { "data": "institute" },
            { "data": "dept" },
            { "data": "clear_time" }
        ],
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        'columnDefs': [ {
            'targets': [2,3], /* column index */
            'orderable': false, /* true or false */
        }]
    });

    instTab = $("#instDataTable").DataTable({
        "retrieve": true,
        "autoWidth": false,
        "responsive": true,
        "ajax": {'url': "show-lb.php",
            'type': "POST", 
            'data': {'inst': function() {
                return hashInst;
            }} 
        },
        "columns": [
            { "data" : "rank" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                "#" + data:
                data;
            }},
            { "data": "level" },
            { "data": "fullname" },
            { "data": "stid" },
            { "data": "institute" },
            { "data": "dept" },
            { "data": "clear_time" }
        ],
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        'columnDefs': [ {
            'targets': [2,3], /* column index */
            'orderable': false, /* true or false */
        }]
    });

    $("a[href='#inst-tab']").click(function() {
        ins = $(this).data('whatever');
        hashInst = CryptoJS.AES.encrypt(ins, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        instTab.ajax.reload();
    })

    setInterval(function() {
        tab.ajax.reload();
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
})