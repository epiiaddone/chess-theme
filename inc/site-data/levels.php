<?php

////////////////////////////////////////////////////
/////////////////DANGER:HARD CODED DATA/////////////////////
function get_levels(){
  $levels = array();
  array_push($levels,'10');
  array_push($levels,'11');
  array_push($levels,'12');
  array_push($levels,'13');
  array_push($levels,'14');
  array_push($levels,'15');
  array_push($levels,'16');
  return $levels;
}

function get_level_nice($level){
  $level_nice = '';
  switch($level){
    case 10 : $level_nice = 'Below 1200';  break;
    case 11 : $level_nice = '1200 - 1400'; break;
    case 12 : $level_nice = '1400 - 1600'; break;
    case 13 : $level_nice = '1600 - 1800'; break;
    case 14 : $level_nice = '1800 - 2000'; break;
    case 15 : $level_nice = '2000 - 2200'; break;
    case 16 : $level_nice = '2200 - 2400'; break;
  }
  return $level_nice;
}

///////////////////////////////////////////////////////
////////////////////END OF HARD CODED DATA////////////
//////////////////////////////////////////////////////

function is_valid_level($test_level){
  $debug = false;
  $levels = get_levels();
  $valid = false;
  if(in_array($test_level, $levels)) $valid = true;
  if($debug){
    echo "<br>valid_level:$valid<br>";
  }
  return $valid;
}

function getRememberMaxMoves($level){
  $moveCount = 0;
switch($level){
  case '11': $moveCount = 10; break;
  case '12': $moveCount = 15; break;
  case '13': $moveCount = 20; break;
  case '14': $moveCount = 25; break;
  case '15': $moveCount = 30; break;
  case '16': $moveCount = 40; break;
}
return $moveCount;
}
