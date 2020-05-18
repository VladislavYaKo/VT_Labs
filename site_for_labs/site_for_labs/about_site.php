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
$page_template = file_get_contents('for_clients.tpl');

$central__part = file_get_contents('text_page.tpl');
$content = file_get_contents('../Temp_content_data/about_site.txt');

$page_template = nav_footer($page_template, $_SESSION['is_authorised']);
$content = nl2br($content);
$page_template = str_replace('{central_part_for_text}', $central__part, $page_template);
$page_template = str_replace('{central_part_content}', $content, $page_template);

echo $page_template;


