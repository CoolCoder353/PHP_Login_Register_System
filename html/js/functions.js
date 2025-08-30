function insertToken() {
    console.log("inserting token");
    $.get("../insertToken.php", function (result) {
        $("body").append(result);
    });
}
