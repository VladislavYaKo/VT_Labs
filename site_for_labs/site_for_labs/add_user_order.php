<?php
function dates_interval_is_free($date_from, $date_to, $date_from_taken, $date_to_taken){
    if (strtotime($date_from) <= strtotime($date_from_taken) && strtotime($date_to) >= strtotime($date_to_taken))
        return false;

    if (strtotime($date_from) > strtotime($date_from_taken) && strtotime($date_from) < strtotime($date_to_taken))
        return false;

    if (strtotime($date_to) > strtotime($date_from_taken) && strtotime($date_to) < strtotime($date_to_taken))
        return false;

    return true;
}

function find_max_room_number($orders_arr){
    $max_room_number = 0;
}

$order_info_arr = array(
    'hotel_id' => $_SESSION['hotel_id'],
    'user_id' => $_COOKIE['user_id'],
    'booked_from' => $_SESSION['date_from'],
    'booked_to' => $_SESSION['date_to']
);

$dbpass = file_get_contents('verysecretpass.txt');
$dbh = new PDO('mysql:dbname=site_for_labs;host=localhost', 'root', $dbpass, array(
    PDO::ATTR_PERSISTENT => false
));
$sth = $dbh->prepare('SELECT * FROM order WHERE hotel_id = ?');
$sth->execute(array($_SESSION['hotel_id']));
$orders_for_hotel_arr = $sth->fetchAll(PDO::FETCH_ASSOC);
$i = 0;
$arr_size = count($orders_for_hotel_arr);
while ($i < $arr_size){
    if (dates_interval_is_free($_SESSION['date_from'], $_SESSION['date_to'],
        $orders_for_hotel_arr[$i]['booked_from'], $orders_for_hotel_arr[$i]['booked_to'])){
        $order_info_arr['room_number'] = $orders_for_hotel_arr[$i]['room_number'];
    }elseif ($i >= $arr_size - 1){
        $order_info_arr['room_number'] = $orders_for_hotel_arr[$i]['room_number'] + 1;
    }else
        $i++;
}