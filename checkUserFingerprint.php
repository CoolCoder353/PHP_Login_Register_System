<?php
require_once "includes/php/user.php";
require_once "includes/php/security_functions.php";

if(isset($_GET) && isset($_GET['fingerprint']) && isset($_GET["token"]))
{
    $fingerprint = $_GET['fingerprint'];
    $token = $_GET['token'];
    $user = new user($fingerprint);
    $result = $user->login_fingerprint($token);
    if($result == true)
    {
        return [true, $user->get_icon()];
    }
}

return [false, ""];

 
?>