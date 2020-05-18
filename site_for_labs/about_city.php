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
$page_template = file_get_contents('about_city.tpl');

if(isset($_GET['city_name']))
    $city_name = $_GET['city_name'];
else
    $city_name = '';

if ($city_name != '') {
    $dbh = new PDO('mysql:dbname=site_for_labs;host=localhost', 'root', 'MYxorowiyPAROLMySQL!');
    $sth = $dbh->prepare('SELECT * FROM `city_description` WHERE `city_name` = :city_name');
    $sth->bindValue(':city_name', $city_name);
    $sth->execute();
    $city_data = $sth->fetch(PDO::FETCH_ASSOC);

    if($city_data !== false)
        $city_img_path = $city_data['img_path'];
    else
        $city_img_path = '';
    $info_from_file = file_get_contents('../Temp_content_data/about_city.txt');
    $city_desc = trim(str_between($info_from_file, $city_name, '{end_of_info}'));
    if ($city_desc == '')
        $city_desc = 'Для этого города нет описания.';


    $page_template = str_replace('{city_name}', $city_name, $page_template);
    $page_template = str_replace('{city_image_path}', $city_img_path, $page_template);
    $page_template = str_replace('{city_info}', $city_desc, $page_template);
}
else{
    $page_template = str_replace('{city_name}', '', $page_template);
    $page_template = str_replace('{city_image_path}', '', $page_template);
    $page_template = str_replace('{city_info}', 'Для этого города нет описания.', $page_template);
}
$dbh = null;

$page_template = nav_footer($page_template, $_SESSION['is_authorised']);

echo $page_template;
