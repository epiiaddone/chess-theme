<?php


$positions_meta = array(
  'game_phase'=>array(
    'title'=>'Game Phase',
    'type'=>'checkbox',
    'values'=>array(
      'Opening',
      'Early Middlegame',
      'Middlegame',
      'Late Middlegame',
      'Complex Endgame',
      'Simple Endgame',
    ),
    'active'=>true,
  ),
  'endgame_type'=>array(
    'title'=>'Endgame Type',
    'type'=>'radio',
    'values'=>array(
      'king and Pawn',
      'Rook and Pawn',
      'Rook vs Rook',
      'Double Rook',
      'Rook vs Minor',
      'Rook vs 2 Minor',
      'Rook vs Queen',
      '2 Rooks vs Queen',
      'Minor vs Pawns',
      'Bishop vs Knight',
      'Opposite Color Bishop',
      'Same Color Bishop',
      'Queens',
    ),
    'active'=>true,
  ),
  'user_difficlty_rating'=>array(
    'title'=>'User Difficulty Rating',
    'type'=>'radio',
    'values'=>array(
      'Too Easy',
      'Easy',
      'Okay',
      'Hard',
      'Too Hard'
    ),
    'active'=>true,
  ),
  'user_importance'=>array(
    'title'=>'User Importance',
    'type'=>'radio',
    'values'=>array(
      'Low',
      'Medium',
      'High',
    ),
    'active'=>true,
  ),
  'my_understaning'=>array(
    'title'=>'My Understanding',
    'type'=>'radio',
    'values'=>array(
      'Poor',
      'Okay',
      'Most',
      'Complete',
    ),
    'active'=>true,
  ),
  'opening_name'=>array(
    'title'=>'Opening Name',
    'type'=>'text',
    'values'=>,
    'active'=>false,
  ),
  'opening_variation'=>array(
    'title'=>'Opening Variaton',
    'type'=>'text',
    'values'=>null,
    'active'=>false,
  ),
  'opening_code'=>array(
    'title'=>'Opening Code',
    'type'=>'text',
    'values'=>null,
    'active'=>false,
  ),
  'features'=>array(
    'title'=>'Features',
    'type'=>'checkbox',
    'values'=>null,
    'active'=>false,
  ),
  'course'=>array(
    'title'=>'Course',
    'type'=>'text',
    'values'=>null,
    'active'=>true,
  ),
  'course_chapter'=>array(
    'title'=>'Course Chapter',
    'type'=>'text',
    'values'=>null,
    'active'=>true,
  )
);
