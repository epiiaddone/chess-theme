<?php

add_action('rest_api_init', 'addUserLesson');

function addUserLesson(){
  register_rest_route('user/v1/', 'addUserLesson',array(
    'methods' =>'POST',
    'callback' => 'saveUserLesson'
  ));
}

function saveUserLesson($data){

$debug = false;

    $user_uuid = $data['user_uuid'];
    $lesson_id= $data['lesson_id'];
    $user_id = get_ID_Ajax($user_uuid);

if($debug){
    echo "user_id:[" . $user_id . "] ";
    echo "lesson_id:[" . $lesson_id . "] ";
}

if(!is_user_valid($user_id)) return;
if(!is_post_valid($lesson_id, 'lessons')) return;

  $lesson_query = new Wp_Query(array(
    'post_type'=>'lessons',
    'p'=>$lesson_id,
  ));
  wp_reset_postdata();
  if($lesson_query->have_posts()) $lesson_query->the_post();
  $lesson_title = get_field('display_title');
  $lesson_type = get_field('type');
  $group = get_field('group');
  $level = get_field('level');

  $user_lesson_query = new WP_Query(array(
    'post_type'=>'userLessons',
    'author'=>$user_id,
    'post_status'=>'publish',
    'meta_query'=>array(
      array(
        'key'=>'lesson_id',
        'value'=>$lesson_id,
        'compare'=>'=',
        'type'=>'numeric',
      ),
    )
  ));
wp_reset_postdata();
  if($user_lesson_query->have_posts()){
    $user_lesson_query->the_post();
    $user_lesson_id = get_the_ID();

    update_post_meta($user_lesson_id, 'active',1);
    update_post_meta($user_lesson_id, 'read',1);
    wp_update_post(array(
      'ID'=>$user_lesson_id,
      'post_title'=>'lesson_title:' . $lesson_title . ' lesson_id:' . $lesson_id . ' user_id:' . $user_id . ' active:1',
    ));
    incrementUserData('update',$user_id);
    setUserQuestionsActive(1,$user_id,$lesson_id);
  }else{
      $new_post_id = wp_insert_post( array(
        'post_type' => 'UserLessons',
        'post_title'=>$lesson_title . ' lesson_id:' . $lesson_id . ' user_id:' . $user_id . ' active:1',
        'post_status'=>'publish',
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
wp_reset_postdata();
      if( is_wp_error( $new_post_id ) ) return;
        update_post_meta($new_post_id, 'lesson_id', $lesson_id);
        update_post_meta($new_post_id, 'lesson_title', $lesson_title);
        update_post_meta($new_post_id, 'active',1);
        update_post_meta($new_post_id, 'read',1);
        update_post_meta($new_post_id, 'type', $lesson_type);
        update_post_meta($new_post_id, 'group', $group);
        update_post_meta($new_post_id, 'level', $level);
        addUserQuestions($user_id, $lesson_id);
    }
  }

  function addUserQuestions($user_id, $lesson_id){

    $debug = false;

    if($debug) echo "inside addUSerQuestions ";

         $questionsQuery = new WP_Query(array(
          'post_type'=>'questions',
          'post_status'=>'publish',
          'meta_query'=>array(
            array(
              'key'=>'lesson_id',
              'value'=>$lesson_id,
              'compare'=>'=',
              'type' => 'numeric'
            )
          ),
          'posts_per_page'=>-1,
        ));

        wp_reset_postdata();

        while($questionsQuery->have_posts()){
          $questionsQuery->the_post();
          $questionId = get_the_ID();

          $dateNow = new DateTime();
          $dateNowString = $dateNow->format('d/m/Y g:i a');
          $dateNow->modify('+1 day');
          $dateNext = $dateNow->format('d/m/Y g:i a');
          $dateNextUnix = $dateNow->format('U');

          $userQuestionId = wp_insert_post(array(
            'post_type'=>'userQuestions',
            'post_author'=>$user_id,
            'post_status'=>'publish',
            'post_title'=> 'user_id:' . $user_id . ' question_id:' . $questionId .  ' stage:1' .  ' active:1',
          ),true);
          incrementUserData('insert',$user_id);
          if(is_wp_error($userQuestionId)) return;
wp_reset_postdata();
          update_post_meta($userQuestionId, 'lesson_id', $lesson_id);
          update_post_meta($userQuestionId, 'question_id', $questionId);
          update_post_meta($userQuestionId, 'stage', 1);
          update_post_meta($userQuestionId, 'next_review_date', $dateNext);
          update_post_meta($userQuestionId, 'next_review_unix', $dateNextUnix);
          update_post_meta($userQuestionId, 'active', 1);
          update_post_meta($userQuestionId, 'last_review_unix', 0);


        }

  }

  function setUserQuestionsActive($active,$user_id,$lesson_id){
    $questionsQuery = new WP_Query(array(
     'post_type'=>'userQuestions',
     'post_status'=>'publish',
     'author'=>$user_id,
     'meta_query'=>array(
       array(
         'key'=>'lesson_id',
         'value'=>$lesson_id,
         'compare'=>'=',
         'type' => 'numeric'
       )
     ),
     'posts_per_page'=>-1,
   ));

   wp_reset_postdata();

   while($questionsQuery->have_posts()){
     $questionsQuery->the_post();
     $userQuestionId = get_the_ID();
     $stage = get_field('stage');
     $questionId = get_field('question_id');
     wp_update_post(array(
       'ID'=> $userQuestionId,
       'post_title'=> 'user_id:' . $user_id . ' question_id:' . $questionId .  ' stage:' . $stage .  ' active:' . $active,
     ));
incrementUserData('update',$user_id);
    update_post_meta($userQuestionId, 'active', $active);

   }
  }


add_action('rest_api_init', 'removeUserLesson');

function removeUserLesson(){
  register_rest_route('user/v1/', 'removeUserLesson',array(
    'methods' =>'POST',
    'callback' => 'removeUserLessonMethod'
  ));
}

function removeUserLessonMethod($data){

    $user_uuid = $data['user_uuid'];
    $lesson_id= $data['lesson_id'];
    $user_id = get_ID_Ajax($user_uuid);

    // echo "user_id:[" . $user_id . "] ";
    // echo "lesson_id:[" . $lesson_id . "] ";
    // echo "lesson_title:[" . $lesson_title . "] ";

    if(!is_user_valid($user_id)) return;
    if(!is_post_valid($lesson_id, 'lessons')) return;

    $lesson_query = new Wp_Query(array(
      'post_type'=>'lessons',
      'p'=>$lesson_id,
    ));
    wp_reset_postdata();
    $lesson_title = "";
    if($lesson_query->have_posts()){
    $lesson_query->the_post();
    $lesson_title = get_field('display_title');;
  }

    $userLessonQuery = new WP_Query(array(
      'post_type'=>'userLessons',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'lesson_id',
          'value'=>$lesson_id,
          'compare'=>'=',
        )
      )
    ));
wp_reset_postdata();
    $userLessonId = 0;

    if($userLessonQuery->have_posts()){
      $userLessonQuery->the_post();
      $userLessonId = get_the_ID();

      update_post_meta($userLessonId, 'active',0);
      wp_update_post(array(
        'ID'=>$userLessonId,
        'post_title'=>'lesson_title:' . $lesson_title . ' lesson_id:' . $lesson_id . ' user_id:' . $user_id . ' active:0',
      ));
incrementUserData('update',$user_id);
      setUserQuestionsActive(0,$user_id,$lesson_id);
    }
}


add_action('rest_api_init', 'resetUserLesson');

function resetUserLesson(){
  register_rest_route('user/v1/', 'resetUserLesson',array(
    'methods' =>'POST',
    'callback' => 'resetUserLessonMethod'
  ));
}

function resetUserLessonMethod($data){

    $user_uuid = $data['user_uuid'];
    $lesson_id= $data['lesson_id'];
    $user_id = get_ID_Ajax($user_uuid);

    // echo "user_id:[" . $user_id . "] ";
    // echo "lesson_id:[" . $lesson_id . "] ";
    // echo "lesson_title:[" . $lesson_title . "] ";

    if(!is_user_valid($user_id)) return;
    if(!is_post_valid($lesson_id, 'lessons')) return;

    $questionsQuery = new WP_Query(array(
     'post_type'=>'userQuestions',
     'post_status'=>'publish',
     'author'=>$user_id,
     'meta_query'=>array(
       array(
         'key'=>'lesson_id',
         'value'=>$lesson_id,
         'compare'=>'=',
         'type' => 'numeric'
       )
     ),
     'posts_per_page'=>-1,
   ));

   wp_reset_postdata();


   while($questionsQuery->have_posts()){
     $questionsQuery->the_post();
     $userQuestionId = get_the_ID();
     $question_id = get_field('question_id');
     $active = get_field('active');

     wp_update_post(array(
       'ID'=>$userQuestionId,
       'post_title'=> 'user_id:' . $user_id . ' question_id:' . $question_id .  ' stage:1' .  ' active:' . $active,

     ));
incrementUserData('update',$user_id);
     update_post_meta($userQuestionId, 'stage' , 1);
     updateReviewDates($userQuestionId, '+1 days');

}
}

add_action('rest_api_init', 'updateLessonRead');
function updateLessonRead(){
  register_rest_route('user/v1/', 'updateLessonRead',array(
    'methods' =>'POST',
    'callback' => 'updateLessonReadMethod'
  ));
}
function updateLessonReadMethod($data){

  $debug = false;
  $user_uuid = $data['user_uuid'];
  $lesson_id= $data['lesson_id'];
  if($debug) echo "read from js:[" . $data['read'] . "]";
  $read = $data['read'] == 'true' ? 1 : 0;
  $user_id = get_ID_Ajax($user_uuid);

if($debug){
  echo "user_id:[" . $user_id . "] ";
  echo "lesson_id:[" . $lesson_id . "] ";
  echo "read:[" . $read . "]";
}

  if(!is_user_valid($user_id)) return;
  if(!is_post_valid($lesson_id, 'lessons')) return;

  $userLessonQuery = new WP_Query(array(
    'post_type'=>'userLessons',
    'author'=>$user_id,
    'post_status'=>'publish',
    'meta_query'=>array(
      array(
        'key'=>'lesson_id',
        'value'=>$lesson_id,
        'compare'=>'=',
        'type'=>'numeric',
      ),
    )
  ));
  wp_reset_postdata();

  if($userLessonQuery->have_posts()){
  $userLessonQuery->the_post();
  $userLessonID = get_the_ID();
  if($debug) echo "userLessonID:[" . $userLessonID . "]";
  update_post_meta($userLessonID, 'read', $read);
  incrementUserData('update',$user_id);
}else{
  $lessonQuery = new WP_Query(array(
    'post_type'=>'lessons',
    'p'=>$lesson_id,
  ));
  wp_reset_postdata();
  $title = "";
  $lesson_type = "";
  if($lessonQuery->have_posts()){
    $lessonQuery->the_post();
    $title = get_field('display_title');
    $lesson_type = get_field('type');
    $level = get_field('level');
    $group = get_field('group');
  }
  $newUserLessonID = wp_insert_post(array(
    'post_type'=>'userLessons',
    'post_author'=>$user_id,
    'post_status'=>'publish',
    'post_title'=>$title . ' lesson_id:' . $lesson_id . ' user_id:' . $user_id . ' active:0',
  ),true);
  incrementUserData('insert',$user_id);
  if(is_wp_error($newUserLessonID)) return;
  update_post_meta($newUserLessonID, 'read', 1);
  update_post_meta($newUserLessonID, 'lesson_id', $lesson_id);
  update_post_meta($newUserLessonID, 'lesson_title', $title);
  update_post_meta($newUserLessonID, 'active', 0);
  update_post_meta($newUserLessonID, 'type', $lesson_type);
  update_post_meta($newUserLessonID, 'group', $group);
  update_post_meta($newUserLessonID, 'level', $level);
}

}
