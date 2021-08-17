<?php
checkLogin();
$page_url = $_SERVER['REQUEST_URI'];
//url of the form ?level=11/?type=end/?group=pawn
//chess.local/group/?level=11/?type=end/?group=pawn
$level_string_start = strpos($page_url,'/?level=') + 8;
$type_string_start = strpos($page_url, '/?type=') + 7;
$group_string_start = strpos($page_url, '/?group=') + 8;
$level = substr($page_url, $level_string_start,2);
$type = substr($page_url, $type_string_start, $group_string_start - $type_string_start - 8 );
$group = substr($page_url, $group_string_start);
invalid_level_redirect($level);
invalid_group_redirect($type,$group,$level);
invalid_type_redirect($type);
get_header();

$debug = false;
if($debug){
  echo "level:" . $level;
  echo "<br>group:" . $group;
  echo "<br>type:" . $type;
}

$banner_args = array();
$banner_args['title'] = getGroupTitle($group);
$paths = buildPathToType($level,$type);
getNavPathHtml($paths, $banner_args);


?>
<?php
get_group_html($type,$group,$level);



get_footer();
