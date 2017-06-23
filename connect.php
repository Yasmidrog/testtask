<?php
include 'dbconf.php';
$conn=new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
return $conn;