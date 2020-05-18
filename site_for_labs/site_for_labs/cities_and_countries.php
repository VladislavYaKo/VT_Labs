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
$page_template = file_get_contents('cities_and_countries.tpl');

$data_arr = array();
try {
    $dbh = new PDO('mysql:dbname=site_for_labs;host=localhost', 'root', 'MYxorowiyPAROLMySQL!', array(
        PDO::ATTR_PERSISTENT => false
    ));
} catch (PDOException $e)
{
    die($e->getMessage());
}
$sth = $dbh->prepare('SELECT * FROM `cities_and_countries`');
$sth->execute();
$data_arr = $sth->fetchAll(PDO::FETCH_ASSOC);


/*$div_class = 'cities_and_countries_block';
$ul_class = 'cities_and_countries_list';*/
$req_href = 'about_city.php';
$block_tmpl = file_get_contents('cities_and_countries_block.tpl');
$blocks_arr = array();
$prev_country = '';
$i = 0;
while ($i < count($data_arr)){
    $cities_list = '';
    //$cur_block = str_replace('{div_class}', $div_class, $block_tmpl);
    if ($prev_country != $data_arr[$i]['country']) {
        $cur_block = $block_tmpl;
        $prev_country = $data_arr[$i]['country'];
        $cur_block = str_replace('{cur_country}', $data_arr[$i]['country'], $cur_block);
        $cities_list .= "<li><a href=\"".$req_href.'?city_name='.$data_arr[$i]['city']."\">".$data_arr[$i]['city']."</a></li>\n";//"<li><a href=\"$req_href\">".$data_arr[$i]['city']."</a></li>\n";
        $i++;
    }
    while($prev_country == $data_arr[$i]['country']){
        $cities_list .= "<li><a href=\"".$req_href.'?city_name='.$data_arr[$i]['city']."\">".$data_arr[$i]['city']."</a></li>\n";
        $i++;
        if ($i >= count($data_arr))
            break;
    }
    $cur_block = str_replace('{cities_list}', $cities_list, $cur_block);
    $blocks_arr[] = $cur_block;
}
$dbh = null;

$cities_and_countries_list = implode("\n", $blocks_arr);
$cities_and_countries_list .= "<hr>\n";

$page_template = nav_footer($page_template, $_SESSION['is_authorised']);
$page_template = str_replace('{cities_and_countries_list}', $cities_and_countries_list, $page_template);


echo $page_template;
