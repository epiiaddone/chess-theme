<?php

checkLogin();
//http://chess.local/tacticsdd/?level=11
$tactics_url = $_SERVER['REQUEST_URI'];
$tactics_level = substr($tactics_url, strpos($tactics_url, '?level=') + 7);
invalid_level_redirect($tactics_level);
get_header();
?>
<div id="tactics-level-div" class="hidden"><?php echo $tactics_level;?></div>
<?php
$banner_args = array();
$banner_args['title'] = "Tactics Overview";
$paths = buildPathToLevel($tactics_level);
getNavPathHtml($paths, $banner_args);

$user_uuid = get_UUID();
//get max number in set
$number_in_set = getNumberInSet('tactic',$tactics_level);
//get number seen
$number_seen = getProgress('userTacticsProgress',$tactics_level,$user_uuid)['number_seen'];
//calculate % complete
$perComp = $number_in_set >0 ? round($number_seen * 100 / $number_in_set) : 0;
//get number in review
$userTacticCount = getPostCount('userTactics',$tactics_level,$user_uuid);
//calculate number correct
$numberCorrect = $number_seen - $userTacticCount;
$number_remaining = $number_in_set - $number_seen;

if($number_remaining>0){
  ?>
  <div id = "tacticsHeroBtn" class="action-hero">
    <div class="action-hero__title">
    Solve Tactics
  </div>
  <div class="action-hero__subtitle">
    <?php echo $number_remaining;?> Remaining
  </div>
  </div>
  <?php
}

if($number_seen ==0 ){
  $correctPercent = 0;
}
else{
  $correctPercent = round($numberCorrect *100 / $number_seen);
}

?>
<div class="hidden" id="user_uuid"><?php echo $user_uuid;?></div>
<div class="hidden" id="tactics_level"><?php echo $tactics_level; ?></div>

<div class="container" id="visContainer">
  <?php
  get_container_title_html('Progress');
  ?>
<?php
$title = $number_seen . ' of ' . $number_in_set;
$titleCorr = $numberCorrect . ' of ' . $number_seen;
?>
<div class="cal-dough">
  <div class="cal-dough__cont">
    <?php
getDough($perComp,'blue','tdd1','Attempted',$title,null);
?>
</div>
<div class="cal-dough__cont">
  <?php
getDough($correctPercent,'green','ttd2','Correct',$titleCorr,null);
?>
</div>
</div>
<!--
<div><?php //echo $userTacticCount;?> in reviews</div>
-->
<?php

$level = $tactics_level;

get_tacticdd_container_buttons($level);
?>
</div>
<?php




get_footer();
