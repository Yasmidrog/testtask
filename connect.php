<?php
$dbname = "vkapi";
$username = "user";

$conn=new mysqli("localhost", $username, "123456", $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
return $conn;