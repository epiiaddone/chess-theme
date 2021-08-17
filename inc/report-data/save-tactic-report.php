<?php

add_action('rest_api_init', 'saveTacticReport');

function saveTacticReport(){
  register_rest_route('user/v1/', 'saveTacticReport',array(
    'methods' =>'POST',
    'callback' => 'saveTacticReportData'
  ));
}

function saveTacticReportData($data){
//echo "inside saveTacticReportData  ";


    $text = $data['text'];
    $user_uuid = $data['user_uuid'];
    $tactic_id= $data['tactic_id'];
    $tactic_level=$data['tactic_level'];
    $tactic_number_in_set = $data['tactic_number_in_set'];
    $user_id = get_ID_Ajax($user_uuid);

    // echo "user_id:[" . $user_id . "] ";
    // echo "text:[" . $text . "] ";
    // echo "tactic_id:[" . $tactic_id . "] ";
    // echo "tactic_title:[" . $tactic_level . "] ";

if(!is_user_valid($user_id)) return;

    $text = formatTacticReportText($text);
    if($text==null){
    //  echo "text failed varification";
      return false;
    }

    $existing_report_query = new WP_Query(array(
      'post_type'=>'tacticReports',
      'author'=>$user_id,
      'post_status'=>'publish',
       'meta_query'=>array(
         array(
           'key'=>'tactic_id',
           'value'=>$tactic_id
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
        'post_type' => 'tacticReports',
        'post_content'=> $text,
        'post_title'=>'tactic_level:' . $tactic_level . ' number_in_set:' . $tactic_number_in_set . ' tactic_id:' . $tactic_id . ' user_id:' . $user_id,
        'post_status'=>'publish',
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
wp_reset_postdata();
      if( is_wp_error( $new_post_id ) ) return;
        update_post_meta($new_post_id, 'tactic_id', $tactic_id);
        update_post_meta($new_post_id, 'tactic_level', $tactic_level);
        update_post_meta($new_post_id, 'tactic_number_in_set', $tactic_number_in_set);

}
}

function formatTacticReportText($text){
  $text = trim($text);
  $text = strip_tags($text);
  $text = substr($text,0,500);
  return $text;
}
