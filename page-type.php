<?php
checkLogin();
$url = $_SERVER['REQUEST_URI'];
//chess.local/type/?type=end/?level=11
//chess.local/type/?type=mid/?level=11
$type = substr($url, strpos($url,'/?type=') + 7, strpos($url, '/?level=') - strpos($url,'/?type=') - 7 );
$level = substr($url, strpos($url, '/?level=') + 8);
invalid_level_redirect($level);
invalid_type_redirect($type);
get_header();

$debug = false;
if($debug){
  echo "<br>level:$level";
  echo "<br>type:$type";
}

$banner_args = array();
$banner_args['title'] = get_type_display_name($type);
$paths = buildPathToLevel($level);
getNavPathHtml($paths, $banner_args);


$groups = getGroups($type,$level);
$total_in_set = 0;
$total_complete = 0;


if(!$groups){
  ?>
  <div class="container">
    <div class="container--title">No Content Here Yet</div>
  </div>
  <?php
}else{
  ?>
  <div class="container">
    <div class="cal-dough">
    <?php
foreach($groups as $group){
  $number_in_set = getNumberLessonInSetSub($type, $group , $level);
  $number_complete = getNumberLessonCompleteSub($type, $group, $level);
  $total_in_set += $number_in_set;
  $total_complete += $number_complete;
  $percentage = $number_in_set >0 ? round($number_complete * 100 / $number_in_set) : 0;
  $title = getGroupTitle($group);
  $subtitle = $number_complete . " of " . $number_in_set . " complete";
  $color = getGroupColor($group);
  $color = "#2c97de";
  $unique = $group . 'end';
  if($debug){
    echo "<br><br>group:$group<br>";
    echo "number_in_set:$number_in_set<br>";
    echo "number complete:$number_complete<br>";
    echo "percentage:$percentage<br>";
    echo "title:$title<br>";
    echo "subtitle:$subtitle<br>";
    echo "color:$color<br>";
  }
  $url = site_url('/group/?level=' . $level . '/?type=' . $type . '/?group=' . $group);
  ?>
      <div class="cal-dough__cont">
        <?php
getDough($percentage,$color,$unique,$title,$subtitle,$url);
?>
</div>
<?php
}
?>
</div>
</div>
<?php
}//end else
/*
$total_percentage = $total_in_set >0 ? round($total_complete * 100 / $total_in_set) : 0;
$title = "Total";
$subtitle = $total_complete . " of " . $total_in_set . " complete";
getDough($total_percentage,'yellow','total',$title,$subtitle,null);
*/


get_footer();
