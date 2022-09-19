<?php
require_once "includes/php/user.php";
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $user->logout();
} else {
    header("location: html/login_page.php");
}
