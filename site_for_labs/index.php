<?php
require_once 'common_funcs_lib.php';

session_start();
/*setcookie('user_id', 6, time() - 60);
setcookie('user_hash', md5('6'), time() - 60);
die();*/
if (!isset($_SESSION['is_authorised']) || !isset($_COOKIE['user_id'])
    || !isset($_COOKIE['user_hash']))
    $_SESSION['is_authorised'] = false;

if ($_SESSION['is_authorised'] == true)
    if (!check_user($_COOKIE['user_id'], $_COOKIE['user_hash']))
        $_SESSION['is_authorised'] = false;

setlocale(LC_ALL, "ru_RU.UTF-8");

if (isset($_POST["Done"])){
    $address = $_POST["town"];
    $address = trim($address);
    $pattern = '#^г\.\s*[А-ЯЁ][а-яё]*,\s*(ул\.\s*[А-ЯЁ][а-яё]*|[A-Z][a-z]* st\.),\s*дом\s*\d+$(, кв.\s*\d+$)?#u';
    $res_status = preg_match($pattern, $address);
    if ($res_status === 1)
    {
        header('Location: hotels_found.php');
        exit();
        /*$town_css_style = 'border-color: green;';*/
    } elseif ($res_status === false)
        $town_css_style = 'border-color: blue;';
        else
        $town_css_style = 'border-color: red;';
} else
    $town_css_style = '';

chdir('Templates');
$page_template = file_get_contents('index.tpl');

$index_form = file_get_contents('index_form.tpl');
$form_method = 'POST';
$form_action = 'index.php';
$index_form = str_replace('{form_method}', $form_method, $index_form);
$index_form = str_replace('{form_action}', $form_action, $index_form);
$index_form = str_replace('{town_css_style}', $town_css_style, $index_form);

$page_template = nav_footer($page_template, $_SESSION['is_authorised']);
$page_template = str_replace('{index_form}', $index_form, $page_template);

echo $page_template;

