<?php

$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "eventify";

$conn = new mysqli($db_server, $db_user, $db_password, $db_name);

if ($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

?>