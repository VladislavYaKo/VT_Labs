<?php
function nav_footer($req_page_template, $is_authorised = false)
{
    if ($is_authorised) {
        $nav = file_get_contents('navigation_authorised.tpl');
    }
    else {
        $nav = file_get_contents('navigation.tpl');
    }
    $footer = file_get_contents('footer.tpl');

    $new_page_template = str_replace('{nav}', $nav, $req_page_template);
    $new_page_template = str_replace('{footer}', $footer, $new_page_template);

    return $new_page_template;
}

function check_user($user_id, $user_hash){
    $correct_hash = md5($user_id.'hhh');
    if (hash_equals($correct_hash, $user_hash))
        return true;
    else
        return false;
}


