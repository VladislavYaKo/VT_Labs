<?php
require_once 'common_funcs_lib.php';

session_start();
if (!isset($_SESSION['is_authorised']) || !isset($_COOKIE['user_id'])
    || !isset($_COOKIE['user_hash']))
    $_SESSION['is_authorised'] = false;

if ($_SESSION['is_authorised'] == true)
    if (!check_user($_COOKIE['user_id'], $_COOKIE['user_hash']))
        $_SESSION['is_authorised'] = false;



chdir('Templates');
$page_template = file_get_contents('booking_1.tpl');

$index_form = file_get_contents('index_form.tpl');
$form_method = 'POST';
$form_action = 'hotels_found.php';
$index_form = str_replace('{form_method}', $form_method, $index_form);
$index_form = str_replace('{form_action}', $form_action, $index_form);

$page_template = nav_footer($page_template, $_SESSION['is_authorised']);
$page_template = str_replace('{index_form}', $index_form, $page_template);

echo $page_template;
