<?php

add_action('rest_api_init', 'saveRememberReport');

function saveRememberReport(){
  register_rest_route('user/v1/', 'saveRememberReport',array(
    'methods' =>'POST',
    'callback' => 'saveRememberReportData'
  ));
}

function saveRememberReportData($data){
  $debug = false;
  if($debug==true) echo "inside saveRememberReportData  ";


    $text = $data['text'];
    $user_uuid = $data['user_uuid'];
    $remember_id= $data['remember_id'];
    $remember_level=$data['remember_level'];
    $remember_number_in_set = $data['remember_number_in_set'];
    $user_id = get_ID_Ajax($user_uuid);

    if($debug==true){
    echo "user_id:[" . $user_id . "] ";
    echo "text:[" . $text . "] ";
    echo "remember_id:[" . $remember_id . "] ";
    echo "remember_level:[" . $remember_level . "] ";
    echo "remember_number_in_set:[" . $remember_number_in_set . "] ";
}

if(!is_user_valid($user_id)) return;

    $text = formatRememberReportText($text);
    if($text==null){
    //  echo "text failed varification";
      return false;
    }

    $existing_report_query = new WP_Query(array(
      'post_type'=>'rememberReports',
      'author'=>$user_id,
      'post_status'=>'publish',
       'meta_query'=>array(
         array(
           'key'=>'remember_id',
           'value'=>$remember_id
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
        'post_type' => 'rememberReports',
        'post_content'=> $text,
        'post_title'=>'remember_level:' . $remember_level . ' number_in_set:' . $remember_number_in_set . ' remember_id:' . $remember_id . ' user_id:' . $user_id,
        'post_status'=>'publish',
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
wp_reset_postdata();
      if ( is_wp_error( $new_post_id ) ) return;
        update_post_meta($new_post_id, 'user_id', $user_id);
        update_post_meta($new_post_id, 'remember_id', $remember_id);
        update_post_meta($new_post_id, 'remember_level', $remember_level);
        update_post_meta($new_post_id, 'number_in_set', $remember_number_in_set);

}
}

function formatRememberReportText($text){
  $text = trim($text);
  $text = strip_tags($text);
  $text = substr($text,0,500);
  return $text;
}
