<?php
require_once "includes/php/user.php";
require_once "includes/php/settings.php";
if(isset($_POST))
{
   
    $user = new user($_POST['fingerprint']);
    if(ALLOW_FINGERPRINT_LOGIN == true && $user->login_fingerprint($_POST['token']) == true)
    {
       
        header("Location: html/user_settings.php");
    }
    else
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        var_dump($_POST);
        if($user->login($username, $password, $_POST['token']) == true)
        {
           
            header("Location: html/user_settings.php");
        }
        else
        {
            header("Location: html/login_page.php");
        }
    }
}


?>