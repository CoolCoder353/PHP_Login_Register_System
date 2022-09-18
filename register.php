<?php

require_once "includes/php/settings.php";
require_once "includes/php/image_class.php";
$image_file = $_FILES["img"];
$username = $_POST["username"];
var_dump($image_file);
var_dump($_POST);
$image_cl = new Image();

$image_cl->load($image_file);
$image_cl->resize(PFP_WIDTH,PFP_HEIGHT);
$image_cl->save(PFP_SAVE_LOCATION. "/". $username. "_pfp.png", IMAGETYPE_PNG, 75, 0770);

$user = new User($_POST['fingerprint']);
$user->register($username, $_POST["password"], $username. "_pfp.png", "", $_POST["token"]);


?>