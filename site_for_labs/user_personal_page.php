<?php
require_once 'common_funcs_lib.php';
$display_style = 'none';
$hidden_text = '';

session_start();
if (isset($_COOKIE['user_id']) && $_COOKIE['user_hash']){
    if (!check_user($_COOKIE['user_id'], $_COOKIE['user_hash'])) {
        //header("Location: error403.php" );
        //header('HTTP/1.0 403 Forbidden');
        http_response_code(403);
        die('You need log in first!');
    }
}

$dbpass = file_get_contents('verysecretpass.txt');
$dbh = new PDO('mysql:dbname=site_for_labs;host=localhost', 'root', $dbpass, array(
    PDO::ATTR_PERSISTENT => false
));
$sth = $dbh->prepare('SELECT `user_info_id` FROM `user` WHERE `id` = '.$_COOKIE['user_id']);
$sth->execute();
$user_info_id = $sth->fetch(PDO::FETCH_COLUMN);

if (isset($_POST['save'])){
    $sth = $dbh->prepare('UPDATE `user_info` SET `sec_name` = :sec_name, 
                                                                `first_name` = :first_name,
                                                                `patronymic` = :patronymic,
                                                                `contact_phone` = :cont_phone,
                                                                `contact_email` = :cont_email
                                                                WHERE `id` = :info_id');
    $res = $sth->execute(array(':sec_name' => $_POST['second_name'],
                               ':first_name' => $_POST['first_name'],
                               ':patronymic' => $_POST['patronymic'],
                               ':cont_phone' => $_POST['cont_phone'],
                               ':cont_email' => $_POST['cont_email'],
                               'info_id' => $user_info_id));
    if (!$res){
        $hidden_text = 'Что-то пошло не так. Данные не сохранены.';
        $display_style = '';
    }else{
        $hidden_text = 'Данные сохранены.';
        $display_style = '';
    }

    unset($_POST['save']);
}

$sth = $dbh->prepare('SELECT * FROM `user_info` WHERE `id` = '.$user_info_id);
$sth->execute();
$user_info_arr = $sth->fetchAll(PDO::FETCH_ASSOC);

chdir('Templates');
$user_order = file_get_contents('user_order.tpl');
$page_template = file_get_contents('user_personal_page.tpl');
if ($user_info_arr != false) {
    foreach ($user_info_arr[0] as $key => $value) {
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
$page_template = str_replace('{login}', $_SESSION['login'], $page_template);
$page_template = str_replace('{display_style}', $display_style, $page_template);
$page_template = str_replace('{hidden_text}', $hidden_text, $page_template);

echo $page_template;