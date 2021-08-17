<?php
checkLogin();

get_header();

$banner_args=array();
$banner_args['title'] = 'Reviews';
$paths = buildPathToDash();
getNavPathHtml($paths,$banner_args);


getQuestion(get_current_user_id());
get_footer();
