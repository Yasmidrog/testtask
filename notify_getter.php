<?php
$conn = include 'connect.php';

$id = $_SESSION['user_id'];


function last_date($conn, $id)
{
    $last = null;
    $dateres = $conn->query("SELECT last_visit FROM users WHERE id={$id}");
    if ($dateres->num_rows > 0) {
        $last = $dateres->fetch_assoc()['last_visit'];
    }
    return $last;
}

function get_users($feedback, $date, $profiles)
{

    $curr = [];
    if (!empty($feedback)) {
        foreach ($feedback as $f) {
            $p = get_profile($f->from_id, $profiles);
            if (is_null($p))
                continue;
            array_push($curr,
                (object)array("name" => $p->first_name . ' '
                    . $p->last_name,
                    "date" => $date,
                    "photo" => $p->photo_100??$p->photo_50
                )
            );
        }
    }

    return $curr;
}

function get_profile($id, $profiles)
{
    foreach ($profiles as $p) {
        if ($p->id === $id) {
            return $p;
        }
    }
}


function new_notif($conn, $id)
{
    $last = last_date($conn, $id);
    $request_params = array(
        'access_token' => $_SESSION['token'],
        'count' => 100,
        'v' => '5.52'
    );
    if (!is_null($last)) {
        $t = strtotime($last);
        $request_params['start_time'] = $t + 1;
        $_SESSION['last'] = $t;
    } else {
        $request_params['start_time'] = strtotime("-1 month");
    }
    $get_params = http_build_query($request_params);
    $result = json_decode(file_get_contents('https://api.vk.com/method/notifications.get?' . $get_params));
    $new_notifications = [];
    $profiles = $result->response->profiles;
    foreach ($result->response->items as $item) {
        $feedback = $item->feedback;
        $r = get_users(
            property_exists($feedback, "items") ? $feedback->items : [$feedback],
            $item->date,
            $profiles);
        $new_notifications = array_merge($new_notifications, $r);
    }
    return $new_notifications;

}

function write_new($conn, $new, $id)
{
    if (empty($new)) {
        return;
    }
    $date = date('Y-m-d G:i:s', ($new[0])->date);
    $conn->query("UPDATE users SET last_visit='{$date}' WHERE id={$id}");
    foreach ($new as $n) {
        $time = date('Y-m-d G:i:s', $n->date);
        $q = "INSERT INTO notifications (uid, photo, name, date)
            VALUES ({$id}, '{$n->photo}', '{$n->name}', '{$time}')";
        $conn->query($q);
    }

}

function old_notif($conn, $id)
{
    $old = [];
    $not = $conn->query("SELECT * FROM notifications WHERE uid={$id}");

    if ($not->num_rows > 0)
        while ($row = $not->fetch_assoc()) {
            $row["date"] = strtotime($row["date"]);
            array_push($old, (object)$row);
        }
    return $old;
}

$old = old_notif($conn, $id);
$newn = new_notif($conn, $id);
include 'notiview.php';
view(array_merge( $old, $newn));
write_new($conn, $newn, $id);

