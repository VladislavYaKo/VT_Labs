<?php
session_start();

//setcookie('user_id', $_SESSION['user_id']);
//setcookie('user_hash', md5($_SESSION['user_id']));
//$_SESSION['is_authorised'] = true;
//$_SESSION['user_id'] = $cur_user['id'];
header('Location: user_personal_page.php');
die();