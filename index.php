<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    include  'mysqlinit.php';
   ?>
    <p>Чтобы воспользоваться сервисом, необходимо войти</p>
    <a href="https://oauth.vk.com/authorize?client_id=6083076&display=page&redirect_uri=http://localhost:8080/auth.php&scope=notifications&response_type=token&v=5.65&state=123456">Войти</a>
    <?php
} else {
    ?>
    <a href="/auth.php?action=logout"> Выйти</a>
    <?php


    include 'notify_getter.php';
}
?>