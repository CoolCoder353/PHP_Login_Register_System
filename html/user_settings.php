<?php
require_once "../includes/php/user.php";
if(!isset($_SESSION))
{
    session_start();
}
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
   
    $pfp_location = "user-pfp/".$user->get_icon();
    $username = $user->get_username();
    $created_at = $user->get_created_at();
   
}else
{
    header("location: login_page.php");
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
    <img src="../<?php echo $pfp_location; ?>" alt="Your PFP">
    <h1>Hi <?php echo $username; ?></h1>
    <a href="../logout.php">Click here to Log Out</a>
</body>

</html>