<?php
    require_once("settings.php");
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (!$conn)
    {
        die("Connection failed: ". mysqli_connect_error());
    }

?>