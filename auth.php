
    <script>
        if(window.location.href.includes("#"))
        window.location.href=window.location.href.replace('#',"?")
    </script>
<?php

session_start();
$id = (integer)$_GET['user_id'];
$token = (string)$_GET['access_token'];


if (isset($token)&&isset($id)) {
    $request_params = array(
        'access_token' => $_GET['access_token'],
        'v' => '5.52'
    );
    if ($token) {
        $db = include "mysqlinit.php";
        $_SESSION['user_id'] = $id;
        $_SESSION['token'] = $token;
        if ($db->query("SELECT id FROM users WHERE id = '{$_GET['user_id']}'")->num_rows == 0) {
            {
                $q = "INSERT INTO users (id, access_token) VALUES ($id,'{$token}')";
                if ($db->query($q) === TRUE
                ) {
                    ;
                } else {
                    echo "Error: " . $db->error;
                }

                $db->close();

            }
        }

        header("Location: http://" . $_SERVER['HTTP_HOST'] . "");
    }
}

if (isset($_GET['action']) AND $_GET['action'] == "logout") {
    session_start();
    session_destroy();
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
    exit;
}
