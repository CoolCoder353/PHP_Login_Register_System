$(function () {
    console.log("Page finished Loading");
    document.addEventListener("OnFingerprintSet", function () {
        console.log("checking user fingerprint");
        fingerprint = $("#fingerprint").val();
        if (fingerprint == "") {
            throw "Cant find fingerprint";
        }
        else {
            token = $("#token").val();

            console.log("token: " + token);
            console.log("fingerprint: " + fingerprint);
            $.ajax({
                url: '../checkUserFingerprint.php',
                type: 'get',
                dataType: 'text',
                data: { fingerprint: fingerprint, token: token },
                success: function (result) {
                    console.log(result);
                }
            });

        }


    });
});