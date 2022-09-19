<?php
if (!isset($_SESSION)) {

    session_start();
}
if (isset($_SESSION['user'])) {
    $location =  "html/user_settings.php";
} else {
    $location = "html/login_page.php";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="html/login_page.php">Login</a>
    <a href="html/register_page.php">Register</a>
</body>

</html>