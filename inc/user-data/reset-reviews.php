<?php

add_action('rest_api_init', 'resetReviewsPath');

function resetReviewsPath(){
  register_rest_route('user/v1/', 'resetReviews',array(
    'methods' =>'POST',
    'callback' => 'resetReviewsCheese'
  ));
}

//assumes that userQuestion does exits
function resetReviewsCheese($data){

  $debug = true;

  $user_uuid = $data['user_uuid'];
  $level_from_js = $data['level'];
  $type_from_js = $data['type'];
  $user_id = get_ID_Ajax($user_uuid);

  if($debug){
    echo 'level_from_js:[' . $level_from_js . ']';
    echo 'type_from_js[' . $type_from_js . ']';
  }

  if(!$user_id > 0) die();

  $level = 0;
  switch($level_from_js){
    case 'below1200' : $level = 10; break;
    case '1200-1400' : $level = 11; break;
    case '1400-1600' : $level = 12; break;
    case '1600-1800' : $level = 13; break;
    case '1800-2000' : $level = 14; break;
    case '2000-2200' : $level = 15; break;
    case '2200-2400' : $level = 16; break;
    case 'all' : $level = 'all'; break;
    default : $level = 0;
  }

  $type = '';
  switch($type_from_js){
    case 'opening' : $type = 'open'; break;
    case 'middlegame' : $type = 'middle'; break;
    case 'endgame' : $type = 'end'; break;
    case 'all' : $type = 'all'; break;
    default : $type = 'invalid';
  }


if($debug){
  echo 'level:[' . $level . ']';
  echo 'type:[' . $type . ']';
  echo 'user_id:[' . $user_id . ']';
}

  if($type == ''){
    if($debug) echo '!!!!invalid type';
    die();
  }
  if( $level!= 'all' && $level == 0){//some wierd php type converstion stuff here
    if($debug) echo '!!!!invalid level';
    die();
  }

  $userLessonQuery = null;

  if($debug) echo "--[data from js okay, precedding with userLesson Query]--";

  if($level=='all' && $type=='all') $userLessonQuery = getAllUserLessons($user_id, $debug);
  elseif($level=='all' && $type!='all') $userLessonQuery = getAllUserLessonsForType($user_id, $debug, $type);
  elseif($level!='all' && $type=='all') $userLessonQuery = getAllUserLessonsForLevel($user_id, $debug, $level);
  else $userLessonQuery = getUserLessonForTypeAndLevel($user_id, $debug, $type, $level);

  $userLessonIds = array();
  $lessonIds = array();

  while($userLessonQuery -> have_posts()){
    $userLessonQuery-> the_post();
    array_push($userLessonIds, get_the_id());
    array_push($lessonIds, get_field('lesson_id'));
  }

  $deleteCount = 0;

  for($i=0; $i<count($userLessonIds); $i++){
    $deleted_post_data = wp_delete_post($userLessonIds[$i], true);
    if($debug && $deleted_post_data !=null) $deleteCount++;
  }

  if($debug) echo "deleteUserLessonCount:[" . $deleteCount . "]";

  $allUserQuestions = new WP_Query(array(
    'post_type'=>'userquestions',
    'post_status'=>'publish',
    'post_per_page'=>-1,
    'author'=>$user_id,
  ));

  wp_reset_postdata();

  while($allUserQuestions->have_posts()){
    $allUserQuestions->the_post();
    if(in_array(get_field('lesson_id'), $lessonIds)){
      wp_delete_post(get_the_id(), true);
      if($debug) echo 'DQ[' . get_field('lesson_id') . ']';
    } 
  }

}

function getUserLessonForTypeAndLevel($user_id, $debug, $type, $level){
  if($debug) echo " --inside:getUserLessonForTypeAndLevel()-- ";
  $userLessonQuery = new WP_Query(array(
    'post_type'=>'userlessons',
    'post_status'=>'publish',
    'post_per_page'=>-1,
    'author'=>$user_id,
    'meta_query'=>array(
      array(
        'key'=>'type',
        'value'=>$type,
        'compare'=>'=',
      ),
      array(
        'key'=>'level',
        'value'=>$level,
        'compare'=>'=',
        'type'=>'numeric',
      ),
    )
  ));
  wp_reset_postdata();
  return $userLessonQuery;
}

function getAllUserLessons($user_id, $debug){
  if($debug) echo " --inside:getUserLessons()-- ";
  $userLessonQuery = new WP_Query(array(
    'post_type'=>'userlessons',
    'post_status'=>'publish',
    'post_per_page'=>-1,
    'author'=>$user_id,
  ));
  wp_reset_postdata();
  return $userLessonQuery;
}

function getAllUserLessonsForType($user_id, $debug, $type){
  if($debug) echo " --inside:getUserLessonForType()-- ";
  $userLessonQuery = new WP_Query(array(
    'post_type'=>'userlessons',
    'post_status'=>'publish',
    'post_per_page'=>-1,
    'author'=>$user_id,
    'meta_query'=>array(
      array(
        'key'=>'type',
        'value'=>$type,
        'compare'=>'=',
      ),
    )
  ));
  wp_reset_postdata();
  return $userLessonQuery;
}

function getAllUserLessonsForLevel($user_id, $debug, $level){
  if($debug) echo " --inside:getUserLessonForLevel()-- ";
  $userLessonQuery = new WP_Query(array(
    'post_type'=>'userlessons',
    'post_status'=>'publish',
    'post_per_page'=>-1,
    'author'=>$user_id,
    'meta_query'=>array(
      array(
        'key'=>'level',
        'value'=>$level,
        'compare'=>'=',
        'type'=>'numeric',
      ),
    )
  ));
  wp_reset_postdata();
  return $userLessonQuery;
}
