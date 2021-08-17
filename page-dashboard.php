<?php
checkLogin();
get_header();

$user_uuid = get_UUID();
$debug = false;
///////
?>
<div class="dash">
  <?php
  $dashLevelData = array();
for($i=10; $i<17; $i++){
$dashLevelData['level'] = $i;
//$dashLevelData['tactics_count'] = getNumberInSet('tactic',$i);
//$dashLevelData['vis_count'] = getNumberInSet('visualisations',$i);
//$dashLevelData['remember_count'] = getNumberInSet('remember',$i);
$dashLevelData['lesson_count_open'] = getNumberLessonInSet('open',$i);
$dashLevelData['lesson_count_middle'] = getNumberLessonInSet('middle',$i);
$dashLevelData['lesson_count_end'] = getNumberLessonInSet('end',$i);

$dashLevelData['lesson_count_open_complete'] = getNumberLessonComplete('open',$i);
$dashLevelData['lesson_count_middle_complete'] = getNumberLessonComplete('middle',$i);
$dashLevelData['lesson_count_end_complete'] = getNumberLessonComplete('end',$i);

//$dashLevelData['tactics_seen'] = getProgress('userTacticsProgress', $i, $user_uuid)['number_seen'];
//$dashLevelData['vis_seen'] = getProgress('userVisProgress', $i, $user_uuid)['number_seen'];
//$dashLevelData['rem_seen'] = getProgress('userRememberProgress', $i, $user_uuid)['number_seen'];


if($debug){
  echo"<br><br>";
print_r($dashLevelData);
}

getDashDisplay($dashLevelData);

}



get_footer();
