$(document).ready(function () {

    updateRank();
    setInterval(function () {
        updateRank();
    }, 60000);

    function updateRank() {
        $.ajax({
            url: './Database/rank.php',
            success: function (data) {
                if(!isNaN(data)) {
                    $('#rank').text(data);
                }
            },
            error: function(error) {
                // console.log(error.responseText);
            }
        });
    }

    var passphrase = 'bhavnatahelyani';

    var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
    var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

    function CryptoJSAesDecrypt(passphrase, encrypted_json_string){
        // console.log(encrypted_json_string);
        var obj_json = JSON.parse(encrypted_json_string);

        var encrypted = obj_json.ciphertext;
        var salt = CryptoJS.enc.Hex.parse(obj_json.salt);
        var iv = CryptoJS.enc.Hex.parse(obj_json.iv);

        var key = CryptoJS.PBKDF2(passphrase, salt, { hasher: CryptoJS.algo.SHA512, keySize: 64/8, iterations: 999});

        var decrypted = CryptoJS.AES.decrypt(encrypted, key, { iv: iv});

        return decrypted.toString(CryptoJS.enc.Utf8);
    }

    $('#hintwarning').on("click", function(){
        let credits = $('#credits').text();
        let levelHint = $('#levelNo').text();

        let hashCREDIT = CryptoJS.AES.encrypt(credits, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        let hashLEVELHINT = CryptoJS.AES.encrypt(levelHint, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

        swal({
            title: "Are you sure?",
            text: "You will lose your 1 credit if credits are available.",
            icon: "warning",
            buttons: true,
            closeOnClickOutside: false
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: './Database/getHint.php',
                        type: 'POST',
                        data: {
                            credits: hashCREDIT,
                            levelHint: hashLEVELHINT
                        },
                        success: function (data) {
                            var data = CryptoJSAesDecrypt(passphrase, data);
                            let array = data.split('$');
                            if(array[0] != 'credit0' && array[0] != 'level95') {
                                swal({
                                    title: "Hint",
                                    text: "Your hint is : " + array[0] + "\n\n\n" + "Note: If you close this hint window, you will have to again use the Credit to view to hint.",
                                    icon: "success",
                                    closeOnClickOutside: false
                                });
                                $('#credits').text('');
                                $('#credits').text(array[1]);
                            }
                            else
                            {
                                if(array[0] == 'credit0') {
                                    swal({
                                        title: "Warning",
                                        text: "Your credits is finshed.",
                                        icon: "warning",
                                        closeOnClickOutside: false
                                    });
                                }
                                else {
                                    swal({
                                        title: "Warning",
                                        text: "You cannot use your hint in above 95 level.",
                                        icon: "warning",
                                        closeOnClickOutside: false
                                    });
                                }
                            }
                        }
                    });
                }
            });
    });


    //session
    let levelNo = $('#levelNo').text();

    function getque(levelU){
        let hashLEVEL = CryptoJS.AES.encrypt(levelU, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

        $.ajax({
            url:'./Database/getque.php',
            type:'POST',
            data:{
                'id':hashLEVEL
            },
            success:function(data){
                var data = CryptoJSAesDecrypt(passphrase, data);
                var arr = (data.split('$'));
                $('#levelName').text(arr[1]);
                $('#question').text(arr[2]);

                if($('#imgQus').attr('data-display') == 1) {
                    $('#imgQus').removeClass('d-block');
                    $('#imgQus').addClass('d-none');
                }

                if($('#downloadImg').attr('data-display') == 1) {
                    $('#downloadImg').removeClass('d-block');
                    $('#downloadImg').addClass('d-none');
                }

                if(arr[3] != '') {
                    if(arr[0] == 31 || arr[0] == 95 || arr[0] == 99) {
                        $('#downloadImg').removeClass('d-none');
                        if($('#downloadImg').attr('data-display') == 0) {
                            $('#downloadImg').attr('data-display', '1');
                        }
                        $('#downloadImg').attr('href', '');
                        $('#downloadImg').attr('href', './assets/levelImg/');
                        $('#downloadImg').attr('href', $('#downloadImg').attr('href') + arr[3]);
                    }

                    $('#imgQus').removeClass('d-none');
                    $('#imgQus').addClass('d-block');

                    if($('#imgQus').attr('data-display') == 0) {
                        $('#imgQus').attr('data-display', '1');
                    }
                    $('#imgQus').attr('src', '');
                    $('#imgQus').attr('src', './assets/levelImg/');
                    $('#imgQus').attr('src', $('#imgQus').attr('src') + arr[3]);
                }
            }
        });
    }
    getque(levelNo);

    $('#qusBtn').click(function(e){
        e.preventDefault();
        let ans = $('#ans').val();
        let hashAns = CryptoJS.AES.encrypt(ans, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();
        if(ans.length != 0)
        {
            $.ajax({
                url: './Database/checkAns.php',
                type: 'POST',
                data: {
                    level: levelNo,
                    ans: hashAns
                },
                success: function (response) {
                    var data = CryptoJSAesDecrypt(passphrase, response);
                    let templevel = data.split('$');
                    if(templevel[0] == 'true') {
                        $('#levelNo').text('');
                        $('#levelNo').text(templevel[1]);
                        swal({
                            title: "Success",
                            text: "Congratulation Your answer is correct.",
                            icon: "success"
                        });
                        levelNo=templevel[1];
                        if(levelNo == 100) {
                            swal({
                                title: "Success",
                                text: "Congratulation you have completed the Event.",
                                icon: "success",
                                buttons: false,
                                closeOnClickOutside: false
                            });
                            setTimeout(function () {
                                window.location.href="./Database/complete";
                            },2000)
                        }
                        getque(templevel[1]);
                    }
                    else {
                        swal({
                            title: "Warning",
                            text: "Your answer is incorrect.",
                            icon: "warning"
                        });
                    }
                    $('#ans').val('');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        else
        {
            swal({
                title: "Warning",
                text: "Please fill the Answer.",
                icon: "warning"
            });
        }
    });
});