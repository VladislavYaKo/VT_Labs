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
$page_template = file_get_contents('service_conditions.tpl');

$text_content = file_get_contents('../Temp_content_data/service_conditions.txt');
$conditions_arr = array('Возможность получания визы', '18+', 'Не зэк', 'Толерантен', '+1', 'и пр.');
$conditions_list = "<ul>\n";
foreach ($conditions_arr as $condition){
    $cur_condition = '<li>'.$condition.'</li>'."\n";
    $conditions_list .= $cur_condition;
}
$conditions_list .= "</ul>\n";


$page_template = nav_footer($page_template, $_SESSION['is_authorised']);
$page_template = str_replace('{conditions_list}', $conditions_list, $page_template);
$page_template = str_replace('{text_content}', $text_content, $page_template);

echo $page_template;