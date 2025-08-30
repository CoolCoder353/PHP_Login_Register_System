<?php

require_once "includes/php/settings.php";
require_once "includes/php/image_class.php";
require_once "includes/php/user.php";

if (isset($_POST) && file_exists($_FILES['img']['tmp_name']) && is_uploaded_file($_FILES['img']['tmp_name'])) {


    $image_file = $_FILES["img"];
    $username = $_POST["username"];

    $image_cl = new Image();

    $image_cl->load($image_file);
    $image_cl->resize(PFP_WIDTH, PFP_HEIGHT);
    $image_cl->save(PFP_SAVE_LOCATION . "/" . $username . "_pfp.png", IMAGETYPE_PNG, 75, 0770);


    $user = new User($_POST['fingerprint']);
    $result = $user->register($username, $_POST["password"], $_POST['confirm_password'], $username . "_pfp.png", "",$_POST['email']);
    if($result == true){
        echo "success";
    }else{
        echo "failed";
    }
} else {
    echo "Invalid input";
}
