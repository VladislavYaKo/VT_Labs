<?php
require_once 'common_funcs_lib.php';

session_start();
if (!isset($_SESSION['is_authorised']) || !isset($_COOKIE['user_id'])
    || !isset($_COOKIE['user_hash']))
    $_SESSION['is_authorised'] = false;

if ($_SESSION['is_authorised'] == true)
    if (!check_user($_COOKIE['user_id'], $_COOKIE['user_hash']))
        $_SESSION['is_authorised'] = false;

function str_between($str, $beginning, $end){
    $start_pos = stripos($str, $beginning);
    if ($start_pos === false)
        return '';

    $start_pos += strlen($beginning) + 1;
    $end_pos = stripos($str, $end, $start_pos);
    if ($end_pos === false)
        return '';
    $substr_len = $end_pos - $start_pos;
    if ($substr_len <= 0)
        return '';

    return substr($str, $start_pos, $substr_len);
}

if (isset($_POST['date_from']) )
    if ((strtotime($_POST['date_from']) >= strtotime($_POST['date_to']))){
        $_SESSION['wrong_dates'] = true;
        header('Location: booking_1.php');
        die();
    }else{}
else{
    header('Location: booking_1.php');
    die();
}


if (isset($_POST['location'])) {
    $_SESSION['location'] = $_POST['location'];
    $_SESSION['date_from'] = $_POST['date_from'];
    $_SESSION['date_to'] = $_POST['date_to'];
    $_SESSION['persons_num'] = $_POST['persons_num'];
}else {
    header('Location: booking_1.php');
    die();
}


chdir('Templates');
$page_template = file_get_contents('hotels_found.tpl');

$data_arr = array();
$block_tpl = file_get_contents('hotels_found_block.tpl');
//$hotels_info_arr = explode('{end_of_info}', file_get_contents('../Temp_content_data/hotels_found_info.txt'));
$info_file_path = '../Temp_content_data/hotels_found_info.txt';
$hotels_info_str = file_get_contents($info_file_path);

$dbh = new PDO('mysql:dbname=site_for_labs;host=localhost', 'root', 'MYxorowiyPAROLMySQL!');
$location_arr = explode(',', $_POST['location']);
foreach ($location_arr as &$value) {
    $value = trim($value);
    $value = ucfirst(strtolower($value));
}

if (count($location_arr) == 2){
    $sth = $dbh->prepare('SELECT * FROM hotel WHERE country = ? AND city = ?');
    $sth->execute(array($location_arr[0], $location_arr[1]));
}elseif (count($location_arr) == 1){
    if ($location_arr[0] != '') {
        $sth = $dbh->prepare('SELECT * FROM hotel WHERE country = ? OR city = ?');
        $sth->execute(array($location_arr[0], $location_arr[0]));
    }else{
        $sth = $dbh->prepare('SELECT * FROM hotel');
        $sth->execute();
    }
}else{
    $sth = null;
}
if ($sth != null)
    $data_arr = $sth->fetchAll(PDO::FETCH_ASSOC);
else
    $data_arr = array();

$dbh = null;

$all_hotels = '';
foreach ($data_arr as $data_block){
    $cur_info_about = 'Страна: '.$data_block['country'].'<br>';
    $cur_info_about .= 'Город: '.$data_block['city'].'<br>';
    $cur_info_about .= 'Адрес: '.$data_block['address'].'<br>';
    $cur_info_about .= 'Конт. телефон: '.$data_block['contact_number'].'<br>';
    $cur_info_about .= 'Конт. e-mail: '.$data_block['contact_email'].'<br>';
    $cur_info_about .= trim(str_between($hotels_info_str, $data_block['hotel_name'], '{end_of_info}'));
    $data_block[] = $cur_info_about;
    $cur_block = str_replace(array('{*hotel_name*}', '{*image_path*}', '{*info_about*}'),
                             array($data_block['hotel_name'], $data_block['img_path'], $cur_info_about), $block_tpl);
    $cur_block = str_replace('{hotel_id}', $data_block['id'], $cur_block);
    $all_hotels .= $cur_block;
}

if ($all_hotels == '')
    $all_hotels = 'Отели по вашему запросу не найдены. Убедитесь, что вы ввели названия в формате:<br> 
                   Страна, город;<br>
                   Страна;<br>
                   Город.<br>
                   Убедитесь, что все названия написаны правильно.';

$page_template = nav_footer($page_template, $_SESSION['is_authorised']);
$page_template = str_replace('{hotels}', $all_hotels, $page_template);

echo $page_template;