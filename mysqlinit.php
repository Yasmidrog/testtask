<?php
$mysqli = include 'connect.php';
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
$val = $mysqli->query('SELECT 1 FROM `users` LIMIT 1');
if ($val === FALSE) {


    $mysqli->query("CREATE TABLE users (
                                  id INT(32) UNSIGNED PRIMARY KEY NOT NULL , 
                                  last_visit  TIMESTAMP(6) NULL DEFAULT NULL ,
                                  access_token VARCHAR(110) NOT NULL 
                                  )");
}

$val = $mysqli->query('SELECT 1 FROM `notifications` LIMIT 1');

if ($val === FALSE) {
    $mysqli->query("CREATE TABLE notifications (
                                    uid INT(16) UNSIGNED NOT NULL, 
                                    photo  VARCHAR(110) NOT NULL,
                                    name     NVARCHAR(110),
                                    date TIMESTAMP(6) NULL ,
                                    FOREIGN KEY (uid) REFERENCES users(id)
                                          )");
}
return $mysqli

?>