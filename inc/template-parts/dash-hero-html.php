<?php

/*
$dashLevelData['level']
$dashLevelData['tactics_count']
$dashLevelData['vis_count']
$dashLevelData['remember_count']
$dashLevelData['lesson_count_open']
$dashLevelData['lesson_count_middle']
$dashLevelData['lesson_count_end']

$dashLevelData['lesson_count_open_complete']
$dashLevelData['lesson_count_middle_complete']
$dashLevelData['lesson_count_end_complete']

$dashLevelData['tactics_seen']
$dashLevelData['vis_seen']
$dashLevelData['rem_seen']
*/
function getDashDisplay($dashLevelData){
  $level = $dashLevelData['level'];

?>
<div class="container">
  <div class=container--title><?php echo get_level_nice($level);?></div>
<div class="dash--level">

  <?php /*
  <div class="dash--level__dough dash-level__tactics">
  <?php
$amount = $dashLevelData['tactics_count'];
$seen = $dashLevelData['tactics_seen'];
$title = "Tactics";
$url = site_url('/tacticsdd/?level=' . $level);
//generateDashDough($amount,$seen,$title,$color,$url,$level)
generateDashDough($amount,$seen,$title,"blue",$url,$level);
   ?>
 </div>
 */
 ?>
<?php /*
 <div class="dash--level__dough dash-level__calc">
   <?php
   $amount = $dashLevelData['vis_count'] +  $dashLevelData['remember_count'];
   $seen = $dashLevelData['vis_seen'] +   $dashLevelData['rem_seen'];
   $title = "Calculation";
   $url = site_url('/calculation/?level=' . $level);
   //generateDashDough($amount,$seen,$title,$color,$url,$level)
   generateDashDough($amount,$seen,$title,"purple",$url,$level);
    ?>
 </div>
 */
 ?>
 <div class="dash--level__dough dash-level__open">
   <?php
   $amount = $dashLevelData['lesson_count_open'];
   $seen = $dashLevelData['lesson_count_open_complete'];
   $title = "Openings";
   $url = site_url('/type/?type=open/?level=' . $level);
   //generateDashDough($amount,$seen,$title,$color,$url,$level)
   generateDashDough($amount,$seen,$title,"#2c97de",$url,$level);
    ?>
 </div>
 <div class="dash--level__dough dash-level__middle">
   <?php
   $amount = $dashLevelData['lesson_count_middle'];
   $seen = $dashLevelData['lesson_count_middle_complete'];
   $title = "Middlegame";
   $url = site_url('/type/?type=middle/?level=' . $level);
   //generateDashDough($amount,$seen,$title,$color,$url,$level)
   generateDashDough($amount,$seen,$title,"#2c97de",$url,$level);
    ?>
 </div>
 <div class="dash--level__dough dash-level__end">
   <?php
   $amount = $dashLevelData['lesson_count_end'];
   $seen = $dashLevelData['lesson_count_end_complete'];
   $title = "Endgame";
   $url = site_url('/type/?type=end/?level=' . $level);
   //generateDashDough($amount,$seen,$title,$color,$url,$level)
   generateDashDough($amount,$seen,$title,"#2c97de",$url,$level);
    ?>
 </div>
</div>
</div>

<?php
}
