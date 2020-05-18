<?php
require_once 'common_funcs_lib.php';

session_start();
if (!isset($_SESSION['is_authorised']) || !isset($_COOKIE['user_id'])
    || !isset($_COOKIE['user_hash']))
    $_SESSION['is_authorised'] = false;

if ($_SESSION['is_authorised'] == true)
    if (!check_user($_COOKIE['user_id'], $_COOKIE['user_hash']))
        $_SESSION['is_authorised'] = false;

if (isset($_POST['hotel_id']))
    $_SESSION['hotel_id'] = $_POST['hotel_id'];

$dbpass = file_get_contents('verysecretpass.txt');
$dbh = new PDO('mysql:dbname=site_for_labs;host=localhost', 'root', $dbpass, array(
    PDO::ATTR_PERSISTENT => false
));
$sth = $dbh->prepare('SELECT user_info_id FROM user WHERE id = ?');
$sth->execute(array($_COOKIE['user_id']));
$user_info_id = $sth->fetch(PDO::FETCH_COLUMN);


chdir('Templates');
$page_template = file_get_contents('booking_2.tpl');

$sth = $dbh->prepare('SELECT * FROM user_info WHERE id = ?');
$sth->execute(array($user_info_id));
$user_info_arr = $sth->fetch(PDO::FETCH_ASSOC);
if ($user_info_arr != false) {
    foreach ($user_info_arr as $key => $value) {
        //echo "{$key} => {$value}<br>";
        $page_template = str_replace('{' . $key . '}', $value, $page_template);
    }
}else{
    $page_template = str_replace('{sec_name}', '', $page_template);
    $page_template = str_replace('{first_name}', '', $page_template);
    $page_template = str_replace('{patronymic}', '', $page_template);
    $page_template = str_replace('{contact_phone}', '', $page_template);
    $page_template = str_replace('{contact_email}', '', $page_template);
}

$page_template = nav_footer($page_template, $_SESSION['is_authorised']);

echo $page_template;
