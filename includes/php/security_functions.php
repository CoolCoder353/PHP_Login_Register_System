<?php

function _cleaninjections($test) {

    $find = array(
        "/[\r\n]/", 
        "/%0[A-B]/",
        "/%0[a-b]/",
        "/bcc\:/i",
        "/Content\-Type\:/i",
        "/Mime\-Version\:/i",
        "/cc\:/i",
        "/from\:/i",
        "/to\:/i",
        "/Content\-Transfer\-Encoding\:/i"
    );
    $ret = preg_replace($find, "", $test);
    return $ret;
}

function generate_csrf_token() {

    if (!isset($_SESSION)) {

        session_start();
    }

    if (empty($_SESSION['token'])) {

        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
}

function insert_csrf_token() {

    generate_csrf_token();

    echo '<input type="hidden" id="token" name="token" value="' . $_SESSION['token'] . '" />';
}


function verify_csrf_token($token) {

    generate_csrf_token();

    if (!empty($token)) {

        if (hash_equals($_SESSION['token'], $token)) {

            return true;
        } 
        else {
            
            return false;
        }
    }
    else {

        return false;
    }
}


function availableUsername($conn, $username){

    $sql = "SELECT * from users where username=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        echo "sql error of " . mysqli_errno($conn);
        return false;
    } 
    else {

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if ($resultCheck > 0) {
            
            return false;
        } else {

            return true;
        }
    }
}

function generate_email_token($conn,$username) : string 
{
    $token = bin2hex(random_bytes(32));
    $sql = "INSERT (username, token) INTO email_tokens VALUES (?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        echo "sql error of " . mysqli_errno($conn);
        return false;
    } 
    else {

        mysqli_stmt_bind_param($stmt, "ss", $username, $token);
        mysqli_stmt_execute($stmt);
        return $token;
    }
    return false;
}
