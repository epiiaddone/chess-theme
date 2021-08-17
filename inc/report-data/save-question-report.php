<?php

add_action('rest_api_init', 'saveQuestionReport');

function saveQuestionReport(){
  register_rest_route('user/v1/', 'saveQuestionReport',array(
    'methods' =>'POST',
    'callback' => 'saveQuestionReportData'
  ));
}

function saveQuestionReportData($data){
$debug = true;

if($debug) echo "inside saveQuestionReportData  ";


    $text = $data['text'];
    $user_uuid = $data['user_uuid'];
    $question_id= $data['question_id'];
    $question_title=$data['question_title'];
    $user_id = get_ID_Ajax($user_uuid);

    // echo "user_id:[" . $user_id . "] ";
    // echo "text:[" . $text . "] ";
    // echo "question_id:[" . $question_id . "] ";
    // echo "question_title:[" . $question_title . "] ";

if(!is_user_valid($user_id)) return;

    $text = formatQuestionReportText($text);
    if($text==null){
    //  echo "text failed varification";
      return false;
    }

    $existing_report_query = new WP_Query(array(
      'post_type'=>'questionReports',
      'author'=>$user_id,
      'post_status'=>'publish',
       'meta_query'=>array(
         array(
           'key'=>'question_id',
           'value'=>$question_id
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
        'post_type' => 'questionReports',
        'post_content'=> $text,
        'post_title'=>'question_title:' . $question_title . ' question_id:' . $question_id . ' user_id:' . $user_id,
        'post_status'=>'publish',
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
wp_reset_postdata();
      if ( is_wp_error( $new_post_id ) ) return;
        update_post_meta($new_post_id, 'question_id', $question_id);
        update_post_meta($new_post_id, 'question_title', $question_title);


}
}

function formatQuestionReportText($text){
  $text = trim($text);
  $text = strip_tags($text);
  $text = substr($text,0,500);
  return $text;
}
