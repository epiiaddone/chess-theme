<?php
/////////////////DANGER:HARD CODED DATA/////////////////////
function getGroups($type,$level){
  if($type == 'end'){
    return array(
      'pawn',
      'rook',
      'minor',
      'queen',
      'diff',
      'multi',
    );
  }
  if($type == 'middle' && $level ==11){
    return array(
      'attack',
      'pawnplay',
    );
  }
  if($type == 'middle' && $level ==12){
    return array(
      'pawnstructures',
    );
  }
    if($type == 'middle' && $level ==13){
      return array(
        'pawnstructures',
        'minorpp',
        'technique',
      );
    }
    if($type == 'middle' && $level ==14){
      return array(
        'pawnstructures',
        'minorpp',
        'majorpp'
      );
  }
  if($type == 'middle' && $level ==15){
    return array(
      'pawnstructures',
    );
}
  if($type== 'open' && $level == 12){
    return array(
      'sicilian'
    );
  }
  if($type=='open' && $level == 13){
    return array(
      'caro'
    );
  }
  return false;
}


function getGroupTitle($group){
  $title = "";
  switch($group){
    case "pawn" : $title =  "King And Pawn"; break;
    case "rook" : $title =  "Rook"; break;
    case "minor" : $title =  "Minor Piece"; break;
    case "queen" : $title =  "Queen"; break;
    case "diff" : $title =  "Imbalanced Pieces"; break;
    case "multi" : $title =  "Multiple Pieces"; break;
    //mid
    case "pawnplay": $title = "Pawn Play"; break;
    case "pawnstructures": $title = "Pawn Structures"; break;
    case "attack": $title = "Attacking Play"; break;
    case "minorpp": $title = "Minor Piece Play"; break;
    case "majorpp": $title = "Major Piece Play"; break;
    case "technique": $title = "Technique"; break;
    //open
    case "sicilian": $title = "Sicilian"; break;
    case "caro": $title = "Caro Kann"; break;
  }
  return $title;
}

function getGroupColor($group){
  $color = 'blue';
    switch($group){
      //end
      case "pawn" : $color = 'blue'; break;
      case "rook" : $color = 'red'; break;
      case "minor" : $color = 'green'; break;
      case "queen" : $color = 'wheat'; break;
      case "diff": $color = 'pink'; break;
      //mid
      case "pawnplay": $color = 'wheat'; break;
      case "attack": $color = 'red'; break;
    }
  return $color;
}

function is_valid_group($type,$group,$level){
  if($type =='end'){
    switch($group){
      case 'pawn': return true; break;
      case 'rook': return true; break;
      case 'queen': return true; break;
      case 'minor': return true; break;
      case 'diff': return true; break;
      case 'multi': return true; break;
    }
  }
  if($type=='middle' && $level==11){
    switch($group){
    case "pawnplay": return true; break;
    case "attack": return true; break;
  }
  }
  if($type=='middle' && $level==12){
    switch($group){
    case "pawnstructures": return true; break;
  }
  }
  if($type=='middle' && $level==13){
    switch($group){
    case "pawnstructures": return true; break;
    case "minorpp": return true; break;
    case "technique": return true; break;
  }
}
  if($type=='middle' && $level==14){
    switch($group){
    case "pawnstructures": return true; break;
    case "minorpp": return true; break;
    case "majorpp": return true; break;
  }
  }
  if($type=='middle' && $level==15){
    switch($group){
    case "pawnstructures": return true; break;
  }
  }
  if($type== 'open' && $level == 12){
    switch($group){
      case "sicilian": return true; break;
    }
  }
  if($type=='open' && $level == 13){
    switch($group){
      case "caro" : return true; break;
    }
  }
  return false;
}
