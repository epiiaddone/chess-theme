<?php
checkLogin();

//http://chess.local/level/?level=11
$url = $_SERVER['REQUEST_URI'];
$level = substr($url, strpos($url, '?level=') + 7);
invalid_level_redirect($level);

get_header();

$banner_args=array();
$banner_args['title'] = get_level_nice($level);
$paths = buildPathToDash();
getNavPathHtml($paths,$banner_args);

$user_uuid = get_UUID();
$debug = false;
///////

$dashLevelData = array();

$dashLevelData['level'] = $level;
$dashLevelData['tactics_count'] = getNumberInSet('tactic',$level);

/*
$dashLevelData['vis_count'] = getNumberInSet('visualisations',$level);
$dashLevelData['remember_count'] = getNumberInSet('remember',$level);
$dashLevelData['vis_seen'] = getProgress('userVisProgress', $level, $user_uuid)['number_seen'];
$dashLevelData['rem_seen'] = getProgress('userRememberProgress', $level, $user_uuid)['number_seen'];
*/


$dashLevelData['lesson_count_open'] = getNumberLessonInSet('open',$level);
$dashLevelData['lesson_count_middle'] = getNumberLessonInSet('middle',$level);
$dashLevelData['lesson_count_end'] = getNumberLessonInSet('end',$level);

$dashLevelData['lesson_count_open_complete'] = getNumberLessonComplete('open',$level);
$dashLevelData['lesson_count_middle_complete'] = getNumberLessonComplete('middle',$level);
$dashLevelData['lesson_count_end_complete'] = getNumberLessonComplete('end',$level);

$dashLevelData['tactics_seen'] = getProgress('userTacticsProgress', $level, $user_uuid)['number_seen'];



if($debug){
  echo"<br><br>";
print_r($dashLevelData);
}
?>
<div class="container">
<div class="level__data">
  <?php
getDashDisplay($dashLevelData);
?>
</div>
</div>

<?php
get_footer();
