<?php

add_action('rest_api_init', 'saveLessonReport');

function saveLessonReport(){
  register_rest_route('user/v1/', 'saveLessonReport',array(
    'methods' =>'POST',
    'callback' => 'saveLessonReportData'
  ));
}

function saveLessonReportData($data){
//echo "inside saveLessonReportData  ";


    $text = $data['text'];
    $user_uuid = $data['user_uuid'];
    $lesson_id= $data['lesson_id'];
    $lesson_title=$data['lesson_title'];
    $user_id = get_ID_Ajax($user_uuid);

    // echo "user_id:[" . $user_id . "] ";
    // echo "text:[" . $text . "] ";
    // echo "lesson_id:[" . $lesson_id . "] ";
    // echo "lesson_title:[" . $lesson_title . "] ";

if(!is_user_valid($user_id)) return;

    $text = formatLessonReportText($text);
    if($text==null){
      //echo "text failed varification";
      return false;
    }

    $existing_report_query = new WP_Query(array(
      'post_type'=>'lessonReports',
      'author'=>$user_id,
      'post_status'=>'publish',
       'meta_query'=>array(
         array(
           'key'=>'lesson_id',
           'value'=>$lesson_id
         ),
       ),
    ));
wp_reset_postdata();
    if($existing_report_query->have_posts()){
      $existing_report_query->the_post();
      $existing_report_id = get_the_id();
      $new_report_data = array(
        'post_content'=> $text,
        'ID'=>$existing_report_id,
      );
      wp_update_post($new_report_data);
      incrementUserData('update',$user_id);
    }else{

      $new_post_id = wp_insert_post( array(
        'post_type' => 'lessonReports',
        'post_content'=> $text,
        'post_title'=>'lesson_title:' . $lesson_title . ' lesson_id:' . $lesson_id . ' user_id:' . $user_id,
        'post_status'=>'publish',
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
wp_reset_postdata();
      if ( is_wp_error( $new_post_id ) ) return;
      	// Success!
        update_post_meta($new_post_id, 'lesson_id', $lesson_id);
        update_post_meta($new_post_id, 'lesson_title', $lesson_title);
}
}

function formatLessonReportText($text){
  $text = trim($text);
  $text = strip_tags($text);
  $text = substr($text,0,500);
  return $text;
}
