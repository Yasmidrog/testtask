<html>
<head>
    <meta name="viewport" content=" initial-scale=1">
    <link rel="stylesheet" href="stylesheets/main.css">

</head>
<body>
<div class="wrapper">

    <?php
    date_default_timezone_set('Europe/Moscow');
    include 'vkconf.php';
    $link = "https://oauth.vk.com/authorize?client_id={$clientid}&display=page&redirect_uri=http://localhost:8080/auth.php&scope=notifications&response_type=token&v=5.65&state=123456";
    session_start();
    if (!isset($_SESSION['user_id'])) {
        include 'mysqlinit.php';
        ?>
        <div class="enter">
            <p class=" enter_text">Чтобы воспользоваться сервисом, необходимо
                <a class="enter_btn"
                   href="<?php echo $link ?>">
                    войти</a></p>
        </div>
        <?php
    } else {
        $r = $_SESSION['logout_time'] - (new DateTime())->getTimestamp();
        header("Refresh: ${r}; url=https://oauth.vk.com/authorize?client_id={$clientid}&display=page&redirect_uri=http://localhost:8080/auth.php&scope=notifications&response_type=token&v=5.65&state=123456");
        ?>
        <a class="exit_btn" href="/auth.php?action=logout"> Выйти</a>
        <?php
        include 'notify_getter.php';
    }
    ?>
</div>
</body>
</html>