<?php
session_start();
/*function dates_interval_is_free($date_from, $date_to, $date_from_taken, $date_to_taken){
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
    foreach ($orders_arr as $order){
        if ($order['room_number'] > $max_room_number)
            $max_room_number = $order['room_number'];
    }

    return $max_room_number;
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
print_r($orders_for_hotel_arr);
$i = 0;
$arr_size = count($orders_for_hotel_arr);
print_r($arr_size);
while ($i < $arr_size){
    if (dates_interval_is_free($_SESSION['date_from'], $_SESSION['date_to'],
        $orders_for_hotel_arr[$i]['booked_from'], $orders_for_hotel_arr[$i]['booked_to'])){
        $order_info_arr['room_number'] = $orders_for_hotel_arr[$i]['room_number'];
        break;
    }elseif ($i >= $arr_size - 1){
        $max_number = find_max_room_number($orders_for_hotel_arr);
        $order_info_arr['room_number'] = $max_number + 1;
        break;
    }else
        $i++;
}

if ($arr_size == 0)
    $order_info_arr['room_number'] = 1;

print_r($order_info_arr);
$sth = $dbh->prepare('INSERT INTO order SET 
    hotel_id = :hotel_id,
    user_id = :user_id,
    booked_from = :booked_from,
    booked_to = :booked_to,
    room_number = :room_number');
echo $sth->execute($order_info_arr);

$dbh = null;*/
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$my_pass =file_get_contents('verysecretmailpass.txt');

$sec_name = $_POST['second_name'];
$first_name = $_POST['first_name'];
$patronymic = $_POST['patronymic'];
$client_email = $_POST['cont_email'];
$_SESSION['cont_email'] = $_POST['cont_email'];

$title = 'Бронирование номера';
$body = "
<h2>Ваша бронь</h2>
<b>Фамилия :</b> $sec_name<br>
<b>Имя:</b> $first_name<br>
<b>Отчество:</b> $patronymic<br>
<b>Почта:</b> $client_email<br><br>
<b>Город:</b>{$_SESSION['location']}<br>
<b>С:</b> {$_SESSION['date_from']} <b>По:</b> {$_SESSION['date_to']} <br>
<b>ID отеля:</b> {$_SESSION['hotel_id']}<br>
";

$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    //$mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.mail.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'korsunov_2000@mail.ru'; // Логин на почте
    $mail->Password   = $my_pass; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('korsunov_2000@mail.ru', 'Your Company'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress($client_email);

// Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    if ($mail->send()) {
        $result = true;
        $status = 'OK';
    }
    else {
        $result = false;
        $status = $mail->ErrorInfo;
    }

} catch (Exception $e) {
    $result = false;
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

$_SESSION['sending_result'] = $result;

/*echo $client_email."<br>";
echo $status;*/
header('Location: user_personal_page.php');
die();