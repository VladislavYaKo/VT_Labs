<?php
require_once 'common_funcs_lib.php';

session_start();
if (isset($_POST['exit'])){
    $_SESSION['is_authorised'] = false;
    setcookie('user_id', $_COOKIE['user_id'], time() - 60);
    setcookie('user_hash', $_COOKIE['user_hash'], time() - 60);
    unset($_POST['exit']);
}
if (isset($_SESSION['is_authorised']) && $_SESSION['is_authorised']
        && isset($_COOKIE['user_id']) && isset($_COOKIE['user_hash']))
    if (check_user($_COOKIE['user_id'], $_COOKIE['user_hash']))
        header('Location: user_personal_page.php');

$display_style = 'none';
$error_text = '';
$is_authorised = false;
$dbh = new PDO('mysql:dbname=site_for_labs;host=localhost', 'root', 'MYxorowiyPAROLMySQL!');
if (isset($_POST['login'])) {
    $sth = $dbh->prepare('SELECT * FROM `user` WHERE `login` = ?');
    $sth->execute(array($_POST['login']));
    $cur_user = $sth->fetch(PDO::FETCH_ASSOC);
    if ($cur_user == false){
        $display_style = '';
        $error_text = 'Пользователь с таким логином не зарегистрирован';
    }elseif (!password_verify($_POST['password'], $cur_user['password_hash'])){
        $display_style = '';
        $error_text = 'Неверный пароль';
    }else {
        $is_authorised = true;
    }
}
$dbh = null;
if ($is_authorised){
    $_SESSION['is_authorised'] = true;
    $_SESSION['login'] = $_POST['login'];
    //$_SESSION['user_id'] = $cur_user['id'];
    setcookie('user_id', $cur_user['id']);
    setcookie('user_hash', md5($cur_user['id'].'hhh'));
    //$_SESSION['is_authorised'] = true;
    //header('Location: user_personal_page.php');
    header('Location: buffer_page.php');
    die();
}



chdir('Templates');
$page_template = file_get_contents('authorisation.tpl');

$page_template = nav_footer($page_template);
$page_template = str_replace('{display_style}', $display_style, $page_template);
$page_template = str_replace('{error_text}', $error_text, $page_template);

echo $page_template;

