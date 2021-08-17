<?php

add_action('rest_api_init', 'saveVisReport');

function saveVisReport(){
  register_rest_route('user/v1/', 'saveVisReport',array(
    'methods' =>'POST',
    'callback' => 'saveVisReportData'
  ));
}

function saveVisReportData($data){

  ;

  $debug=false;

  if($debug==true) echo "inside saveVisReportData  ";


    $text = $data['text'];
    $user_uuid = $data['user_uuid'];
    $vis_id= $data['vis_id'];
    $vis_level=$data['vis_level'];
    $vis_number_in_set = $data['vis_number_in_set'];
    $user_id = get_ID_Ajax($user_uuid);

    if($debug==true){

    echo "user_uuid:[" . $user_uuid . "] ";
    echo "text:[" . $text . "] ";
    echo "vis_id:[" . $vis_id . "] ";
    echo "vis_level:[" . $vis_level . "] ";
}

if(!is_user_valid($user_id)) return;

    $text = formatVisReportText($text);
    if($text==null){
    //  echo "text failed varification";
      return false;
    }

    $existing_report_query = new WP_Query(array(
      'post_type'=>'visualisationReports',
      'author'=>$user_id,
      'post_status'=>'publish',
       'meta_query'=>array(
         array(
           'key'=>'vis_id',
           'value'=>$vis_id
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
        'post_type' => 'visualisationReports',
        'post_content'=> $text,
        'post_title'=>'vis_level:' . $vis_level . ' number_in_set:' . $vis_number_in_set . ' vis_id:' . $vis_id . ' user_id:' . $user_id,
        'post_status'=>'publish',
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
wp_reset_postdata();
      if ( is_wp_error( $new_post_id ) ) return;
        update_post_meta($new_post_id, 'user_id', $user_id);
        update_post_meta($new_post_id, 'vis_id', $vis_id);
        update_post_meta($new_post_id, 'vis_level', $vis_level);
        update_post_meta($new_post_id, 'number_in_set', $vis_number_in_set);

}
}

function formatVisReportText($text){
  $text = trim($text);
  $text = strip_tags($text);
  $text = substr($text,0,500);
  return $text;
}
