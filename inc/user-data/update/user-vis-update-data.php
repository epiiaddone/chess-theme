<?php

add_action('rest_api_init', 'updateUserVis');

function updateUserVis(){
  register_rest_route('user/v1/', 'updateUserVis',array(
    'methods' =>'POST',
    'callback' => 'updateUserVisMethod'
  ));
}

function updateUserVisMethod($data){


    $user_uuid = $data['user_uuid'];
    $vis_id = $data['vis_id'];
    $vis_level = $data['vis_level'];
    $button_hit = $data['button_hit'];
    $user_id = get_ID_Ajax($user_uuid);

    if(!is_user_valid($user_id)) return;
    if(!is_post_valid($vis_id, 'visualisations')) return;


    $correct = 0;
    if($button_hit=='correct') $correct = 1;

  //echo "user_id:[" . $user_id . "] ";
    //echo "vis_id:[" . $vis_id . "] ";
    //echo "button_hit:[" . $button_hit . "] ";



  $userVisProgressDataQuery = new WP_Query(array(
    'post_type'=>'userVisProgress',
    'author'=>$user_id,
    'post_status'=>'publish',
    'meta_query'=>array(
      array(
        'key'=>'level',
        'value'=>$vis_level,
      ),
    ),
  ));

  wp_reset_postdata();

if($userVisProgressDataQuery->have_posts()){
  $userVisProgressDataQuery->the_post();
  $userVisProgressID = get_the_ID();
  $currentCorrect = get_field('number_correct');
  $seen_number = get_field('number_seen');
  $seen_number++;

  //echo "userVissProgressID:" . $userVisProgressID;

  update_post_meta($userVisProgressID, 'number_seen', $seen_number);
  update_post_meta($userVisProgressID, 'number_correct', $currentCorrect + $correct);
  $new_post_data = array(
    'ID'=>$userVisProgressID,
    'post_title'=>'level:' . $vis_level . ' number_seen:' . $seen_number  . ' user_id:' . $user_id,
  );
  wp_update_post($new_post_data);
  incrementUserData('update',$user_id);

  updateReviewDates($new_post_data, '+2 day');

  update_post_meta($userVisProgressID, 'next_review_date', $dateNext);
  update_post_meta($userVisProgressID, 'next_review_unix', $dateNextUnix);

}else{
  echo "no user vis progress";
  return;
}
}
