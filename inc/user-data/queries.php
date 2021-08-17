<?php

function getReviewNumber($user_id){
  //$tactics_count = getTacticsReviewNumber($user_id);
  $questions_count = getQuestionReviewNumber($user_id);
  //$vis_count = isReviewAvailiable($user_id,'visualisation') ? 1 : 0;
  //$remember_count = isReviewAvailiable($user_id,'remember') ? 1 : 0;
  //$total = $tactics_count + $questions_count + $vis_count + $remember_count;
  //return $total;
  return $questions_count;
}


function getQuestionReviewNumber($user_id){
  $dateNow = new DateTime();
  $dateUnix = $dateNow->format('U');
  $userQuestionsQuery= new WP_Query(array(
    'post_type'=>'userQuestions',//necessary as default post type is post
    'author'=>$user_id,
    'meta_query'=>array(
      array(
        'key'=>'next_review_unix',
        'value'=>$dateUnix,
        'compare'=>'<', //change to > for testing
        'type' => 'numeric',
      ),
      array(
        'key'=>'active',
        'value'=>1,
        'compare'=>'=',
        'type'=>'numeric'
      )
    ),
    'posts_per_page'=>-1,
  ));
wp_reset_postdata();
return $userQuestionsQuery->found_posts;
}

function getTacticsReviewNumber($user_id){
  $dateNow = new DateTime();
  $dateUnix = $dateNow->format('U');
  $userTacticsQuery= new WP_Query(array(
    'post_type'=>'userTactics',//necessary as default post type is post
    'author'=>$user_id,
    'post_status'=>'publish',
    'meta_query'=>array(
      array(
        'key'=>'next_review_unix',
        'value'=>$dateUnix,
        'compare'=>'<', //change to > for testing
        'type' => 'numeric',
      ),
      array(
        'key'=>'active',
        'value'=>1,
        'compare'=>'=',
        'type'=>'numeric'
      )
    ),
    'posts_per_page'=>-1,
  ));
wp_reset_postdata();
return $userTacticsQuery->found_posts;
}


function is_progress_active($post_type, $calc_level){

  $debug=false;
  if($debug){
    echo "is_progress_active() post_type:[" . $post_type . "]<br>";
    echo "is_progress_active() calc_level[" . $calc_level . "]<br><br>";
  }

$userQuery = new WP_Query(array(
  'author'=>get_current_user_id(),
  'post_type'=>$post_type,
  'post_status'=>'publish',
  'meta_query'=>array(
                        array(
                        'key'=>'level',
                        'value'=>$calc_level
                      ),
                      array(
                        'key'=>'active',
                        'value'=>1,
                        'compare'=>'=',
                        'type'=>'numeric'
                      )
                    )

));


if($debug) print_r($userQuery);
wp_reset_postdata();
if($userQuery->have_posts()){
  if($debug){
    $userQuery->the_post();
    echo "<br><br><br>Active userTacticProgress found";
    echo "<br>number_seen:[" . get_field('number_seen') . "]<br>";
    echo "level:[" . get_field('level') . "]<br>";
    echo "active:[" . get_field('active') . "]<br>";
    echo "post_title:[" . get_the_title() . "]<br>";
    echo "author:[" . get_the_author() . "]<br>";
  }
  return true;
}else{
  if($debug){
    echo "<br>is_progress_active no active userTacticsProgress found<br>";
  }
  return false;
}

}

function getAllUserLessonsGroup($type,$group,$level){
  $query = new WP_Query(array(
  'post_type'=>'userlessons',
  'post_status'=>'publish',
  'posts_per_page'=>-1,
  'author'=>get_current_user_id(),
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
      'type'=>'numeric'
    ),
    array(
      'key'=>'group',
      'value'=>$group,
      'compare'=>'=',
    ),
  ),
));

wp_reset_postdata();
if($query->have_posts()) return $query;
else return false;
}

function getAllActiveLessons($type,$group,$level){

  $lessons = new WP_Query(array(
    'post_type'=>'lessons',
    'post_status'=>'publish',
    'posts_per_page'=>-1,
    'orderby'=>'meta_value_num',
    'meta_key'=>'number_in_group',
    'order'     => 'ASC',
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
        'type'=>'numeric'
      ),
      array(
        'key'=>'group',
        'value'=>$group,
        'compare'=>'=',
      ),
      array(
        'key'=>'active',
        'value'=>1,
        'compare'=>'=',
        'type'=>'numeric',
      ),
    )
  ));
wp_reset_postdata();
if($lessons->have_posts()) return $lessons;
else return false;
}

function getNumberLessonInSetSub($type, $group , $level){
  $debug = false;
  $lessonQuery = new WP_Query(array(
    'post_type'=>'lessons',
    'post_status'=>'publish',
    'post_per_page'=>-1,
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
      array(
        'key'=>'group',
        'value'=>$group,
        'compare'=>'=',
      ),
      array(
        'key'=>'active',
        'value'=>1,
        'compare'=>'=',
        'type'=>'numeric',
      ),
    )
  ));
  wp_reset_postdata();
  if($debug){
    print_r($lessonQuery);
    echo "found_posts:$lessonQuery->found_posts";
  }
  return $lessonQuery->found_posts;
}

function getNumberLessonCompleteSub($type,$group, $level){

  $debug = false;
  $lessonQuery = new WP_Query(array(
    'post_type'=>'userlessons',
    'post_status'=>'publish',
    'post_per_page'=>-1,
    'author'=>get_current_user_id(),
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
      array(
        'key'=>'group',
        'value'=>$group,
        'compare'=>'=',
      ),
      array(
        'key'=>'read',
        'value'=>1,
        'compare'=>'=',
        'type'=>'numeric',
      )
    )
  ));
  wp_reset_postdata();
  return $lessonQuery->found_posts;

}

function getNumberLessonComplete($type,$level){

  $debug = false;
  $lessonQuery = new WP_Query(array(
    'post_type'=>'userlessons',
    'post_status'=>'publish',
    'post_per_page'=>-1,
    'author'=>get_current_user_id(),
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
      array(
        'key'=>'read',
        'value'=>1,
        'compare'=>'=',
        'type'=>'numeric',
      )
    )
  ));
  wp_reset_postdata();
  return $lessonQuery->found_posts;
}

function getNumberLessonInSet($type,$level){
  $debug=false;
  $lessonQuery = new WP_Query(array(
    'post_type'=>'lessons',
    'post_status'=>'publish',
    'post_per_page'=>-1,
    'meta_query'=>array(
      array(
        'key'=>'active',
        'value'=>1,
        'compare'=>'=',
        'type'=>'numeric',
      ),
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
      )
    )
  ));
wp_reset_postdata();
  return $lessonQuery->found_posts;
}
//requires the number_in_set meta_key
function getNumberInSet($post_type, $level){
  $debug = false;
  try{
  global $wpdb;
  $prefix = $wpdb->prefix;

  $querystr = "
     SELECT max(p.ID) AS max_id
     FROM
     ".$prefix."posts p,
     ".$prefix."postmeta pm
     WHERE p.ID = pm.post_id
     AND pm.meta_key = 'level'
     AND pm.meta_value = $level
     AND p.post_type = '$post_type'
     AND p.post_status = 'publish'
  ";

  $maxTacticIDResult = $wpdb->get_results($querystr, OBJECT);
  wp_reset_postdata();

if($debug){
      echo "<br>inside getNumberInSet()<br> ";
      print_r($maxTacticIDResult);
}

  $max_tactic_id = $maxTacticIDResult[0]->max_id;

  if($debug){

     echo "<br>max_post_id: $max_tactic_id<br>";
   }

  wp_reset_postdata();

  if(!$max_tactic_id) return 0;

  $tactic_query = new WP_Query(array(
   'post_type'=>$post_type,
   'p'=>$max_tactic_id,
  ));

  if($tactic_query->have_posts()){
   $tactic_query->the_post();
   $number_in_set= get_field('number_in_set');
  }
  }catch(Error $e){
    wp_reset_postdata();
  }

  return $number_in_set;
}

function getUserQuery($post_type,$level,$user_uuid){

 $user_id = get_ID_Ajax($user_uuid);
if(!is_user_valid($user_id)) return false;

  $query = new Wp_Query(array(
    'author'=>$user_id,
    'post_status'=>'publish',
    'post_type'=>$post_type,
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
  if($query->have_posts()){
    return $query;
  }else{
    return false;
  }
}


function getPostCount($post_type, $level, $user_uuid){
  $debug=false;
  $user_id = get_ID_Ajax($user_uuid);
  if(!is_user_valid($user_id)) return 0;

  $query = new WP_Query(array(
    'post_status'=>'publish',
    'author'=>$user_id,
    'post_type'=>$post_type,
    'posts_per_page'=>-1,
    'meta_query'=>array(
      array(
        'key'=>'level',
        'value'=>$level,
        'type'=>'numeric',
        'compare'=>'='
      ),
    )
  ));
  wp_reset_postdata();
  if($debug) print_r($query);
  return $query->found_posts;
}


//number_seen applies to tactic,visualisations,remember
//number_correct applies to visualisations
//average_depth applies to remember
function getProgress($post_type,$level,$user_uuid){

$user__progress_query = getUserQuery($post_type,$level, $user_uuid);

$results = array();
$results['number_seen'] = 0;
$results['number_correct'] = 0;
$results['average_depth'] = 0;
if(!!$user__progress_query && $user__progress_query->have_posts()){
  $user__progress_query->the_post();
  $results['number_seen'] = get_field('number_seen');
  $results['number_correct'] = get_field('number_correct');
  $results['average_depth'] = get_field('average_depth');
}
return $results;
}
