<?php
session_start();
$display_style = 'none';
$error_text = '';

$dbpass = file_get_contents('verysecretpass.txt');
try {
    $dbh = new PDO('mysql:dbname=site_for_labs;host=localhost', 'root', $dbpass);
}catch(PDOException $e){
    $error_text = $e->getMessage();
}

function make_user_info_record(PDO $req_dbh, $user_id){
    $sth = $req_dbh->prepare('INSERT INTO 
                             user_info(sec_name, first_name, patronymic, contact_phone, contact_email) 
                             VALUES(NULL, NULL, NULL, NULL, NULL)');
    $res = $sth->execute();

    $last_info_id = $req_dbh->lastInsertId();
    //echo $last_info_id.'<br>'.$user_id;
    $sth = $req_dbh->prepare('UPDATE `user` SET `user_info_id` = ? WHERE `id` = ?');
    $res = $res && $sth->execute(array($last_info_id, $user_id));

    return $res;
}

if (isset($_POST['login'])) {
    $sth = $dbh->prepare('SELECT `login` FROM `user` WHERE `login` = ?');
    $sth->execute(array($_POST['login']));
    $login_is_taken = $sth->fetch(PDO::FETCH_ASSOC);
    if ($login_is_taken != false){
        $error_text = 'Логин занят';
        $display_style = '';
    }elseif ($_POST['first_pass'] != $_POST['second_pass']) {
        $error_text = 'Пароли не совпадают';
        $display_style = '';
    }else{
        $pass_hash = password_hash($_POST['first_pass'], PASSWORD_BCRYPT);
        try {
            $sth = $dbh->prepare('INSERT INTO `user` SET `login` = :login, `password_hash` = :pass_hash');
        } catch(PDOException $e){
            $error_text = $e->getMessage();
        }
        $res = $sth->execute(array('login' => $_POST['login'], 'pass_hash' => $pass_hash));
        $last_id = $dbh->lastInsertId();
        $display_style = '';
        if ($res) {
            $error_text = 'Вы успешно зарегистрированы!';
            $res = make_user_info_record($dbh, $last_id);
            if (!$res)
                $error_text .= ' Проблемы с базой данных';
        }
        else
            $error_text .= 'Что-то пошло не так. Вы не зарегистрированы';
    }
}
$dbh = null;


require_once 'common_funcs_lib.php';

chdir('Templates');
$page_template = file_get_contents('registration.tpl');

$page_template = nav_footer($page_template);
$page_template = str_replace('{display_style}', $display_style, $page_template);
$page_template = str_replace('{error_text}', $error_text, $page_template);

echo $page_template;


