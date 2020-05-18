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

chdir('Templates');
$page_template = file_get_contents('hotels_found.tpl');

$data_arr = array();
$block_tpl = file_get_contents('hotels_found_block.tpl');
//$hotels_info_arr = explode('{end_of_info}', file_get_contents('../Temp_content_data/hotels_found_info.txt'));
$info_file_path = '../Temp_content_data/hotels_found_info.txt';
$hotels_info_str = file_get_contents($info_file_path);

$dbh = new PDO('mysql:dbname=site_for_labs;host=localhost', 'root', 'MYxorowiyPAROLMySQL!');
$sth = $dbh->prepare('SELECT `hotel_name`, `img_path` FROM `hotel`');
$sth->execute();
$data_arr = $sth->fetchAll(PDO::FETCH_ASSOC);
$dbh = null;

$all_hotels = '';
foreach ($data_arr as $data_block){
    $cur_info_about = trim(str_between($hotels_info_str, $data_block['hotel_name'], '{end_of_info}'));
    $data_block[] = $cur_info_about;
    $cur_block = str_replace(array('{*hotel_name*}', '{*image_path*}', '{*info_about*}'), $data_block, $block_tpl);
    $all_hotels .= $cur_block;
}

$page_template = nav_footer($page_template, $_SESSION['is_authorised']);
$page_template = str_replace('{hotels}', $all_hotels, $page_template);

echo $page_template;