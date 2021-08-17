<?php

/////////////////DANGER:HARD CODED DATA/////////////////////
////////////////////////////////////////////////////////////
function get_types(){
  $types = array();
  array_push($types,'open');
  array_push($types,'middle');
  array_push($types,'end');
  array_push($types,'calc');
  array_push($types,'tact');
  return $types;
}

function get_type_display_name($type){
  $type_display_name = '';
    switch($type){
      case 'end': $type_display_name = 'endgame';break;
      case 'middle': $type_display_name = 'middlegame'; break;
      case 'open': $type_display_name = 'opening'; break;
      case 'calc': $type_display_name = 'calculation'; break;
      case 'tact' : $type_display_name = 'tactics'; break;
    }
  return $type_display_name;
}
////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////

function is_valid_type($type){
  $result = false;
    if(in_array($type,get_types())) $result = true;
  return $result;
}
