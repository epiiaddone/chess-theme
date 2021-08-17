<?php

checkLogin();
/*

//http://chess.local/calculation/?level=11
$calc_url = $_SERVER['REQUEST_URI'];
$calc_level = substr($calc_url, strpos($calc_url, '?level=') + 7);
invalid_level_redirect($calc_level);
get_header();


$user_uuid = get_UUID();
$debug = false;
$any_content = false;
///////////////////////////

$banner_args=array();
$banner_args['title'] = 'Calculation';
$paths = buildPathToLevel($calc_level);
getNavPathHtml($paths, $banner_args);

//////////////////vis////////////////////
$number_in_set = getNumberInSet('visualisations',$calc_level);
if($debug) echo "number_in_set_vis:" . $number_in_set;
if($number_in_set>0){
$any_content = true;
$visProgressData = getProgress('userVisProgress',$calc_level,$user_uuid);
$number_seen = $visProgressData['number_seen'];
$number_correct = $visProgressData['number_correct'];

$perComp = round($number_seen * 100 / $number_in_set);

if($number_seen >0){
  $perCorrect = round($number_correct * 100 / $number_seen);
}else{
  $perCorrect = 0;
}
$title = $number_seen . ' of ' . $number_in_set;
$titleCorr = $number_correct . ' of ' . $number_seen;
?>
<div class="container" id="visContainer">
  <?php
  get_container_title_html('Board Visualisation');
  ?>
<div class="cal-dough">
  <div class="cal-dough__cont">
<?php
getDough($perComp,'blue','vis1','Attempted',$title,null);
?>
</div>
<div class="cal-dough__cont">
  <?php
getDough($perCorrect,'green','vis2','Correct',$titleCorr,null);
?>
</div>
</div>
<?php
$progressType = 'userVisProgress';
$key = 'Vis';
$level = $calc_level;
get_container_buttons($progressType,$key,$level);
?>
</div>
<?php
}
//////////////////////////remember//////////////////////////////
$number_in_set = getNumberInSet('remember',$calc_level);
if($debug) echo "number_in_set_remember:" . $number_in_set;
if($number_in_set>0){
$any_content = true;

$RemProgressData = getProgress('userRememberProgress',$calc_level,$user_uuid);
$number_seen = $RemProgressData['number_seen'];
$average_depth = $RemProgressData['average_depth'];

$perComp = round($number_seen * 100 / $number_in_set);
$max_move_depth = getRememberMaxMoves($calc_level);
$perCorrect = round($average_depth * 100 / $max_move_depth);

$title = $number_seen . ' of ' . $number_in_set;
$titleCorr = $average_depth . ' moves';
?>
<div class="container" id="RememberContainer">
  <?php
  get_container_title_html('Remember the Moves');
  ?>
<div class="cal-dough">
  <div class="cal-dough__cont">
<?php
getDough($perComp,'blue','rem1','Attempted',$title,null);
?>
</div>
<div class="cal-dough__cont">
<?php
getDough($perCorrect,'green','rem2','Average Depth',$titleCorr,null);
?>
</div>
</div>
<?php
$progressType = 'userRememberProgress';
$key = 'Remember';
$level = $calc_level;
get_container_buttons($progressType,$key,$level);
?>
</div>



<div class="hidden" id="user_uuid"><?php echo get_UUID();?></div>
<div class="hidden" id="vis_level"><?php echo $calc_level; ?></div>
<?php
}

if(!$any_content) get_no_content_html();

*/

get_footer();
