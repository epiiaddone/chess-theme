<?php

add_action('rest_api_init', 'updateUserRemember');

function updateUserRemember(){
  register_rest_route('user/v1/', 'updateUserRemember',array(
    'methods' =>'POST',
    'callback' => 'updateUserRememberMethod'
  ));
}

function updateUserRememberMethod($data){

$debug = false;

    $user_uuid = $data['user_uuid'];
    $remember_level = $data['remember_level'];
    $moves_correct = $data['moves_correct'];
    $user_id = get_ID_Ajax($user_uuid);

if($deug){
  echo "user_id:[" . $user_id . "] ";
  }

    if(!is_user_valid($user_id)) return;
    if(!is_valid_level($remember_level)) return;

    $userRememberQuery = new WP_Query(array(
      'post_type'=>'userRememberProgress',
      'post_status'=>'publish',
      'author'=>$user_id,
      'meta_query'=>array(
        array(
          'key'=>'level',
          'value'=>$remember_level,
        ),
      )
    ));
    wp_reset_postdata();
    if(!$userRememberQuery->have_posts()) return;

    $userRememberQuery->the_post();
    $userRememberID = get_the_ID();
    $current_average_depth = get_field('average_depth');
    $number_seen = get_field('number_seen');
    $active = get_field('active');
    $new_average = ($number_seen * $current_average_depth + $moves_correct) / ++$number_seen;

    update_post_meta($userRememberID, 'average_depth', $new_average);
    update_post_meta($userRememberID, 'number_seen', $number_seen);

    wp_update_post(array(
      'ID'=>$userRememberID,
      'post_title'=>'level:' .  $remember_level . 'number_seen:' .  $number_seen . 'user_id:' . $user_id . 'active:' . $active,
    ));

    updateReviewDates($userRememberID, '+1 day');

    incrementUserData('update',$user_id);
  }

  add_action('rest_api_init', 'skipUserRemember');
  function skipUserRemember(){
    register_rest_route('user/v1/', 'skipUserRemember',array(
      'methods' =>'POST',
      'callback' => 'skipUserRememberMethod'
    ));
  }
  function skipUserRememberMethod($data){
    $debug = false;

        $user_uuid = $data['user_uuid'];
        $remember_level = $data['remember_level'];
        $user_id = get_ID_Ajax($user_uuid);

    if($deug){
      echo "user_id:[" . $user_id . "] ";
      }

        if(!is_user_valid($user_id)) return;
        if(!is_valid_level($remember_level)) return;

        $userRememberQuery = new WP_Query(array(
          'post_type'=>'userRememberProgress',
          'post_status'=>'publish',
          'author'=>$user_id,
          'meta_query'=>array(
            array(
              'key'=>'level',
              'value'=>$remember_level,
            ),
          )
        ));
        wp_reset_postdata();
        if(!$userRememberQuery->have_posts()) return;
        $userRememberQuery->the_post();
        $userRememberID = get_the_ID();
        updateReviewDates($userRememberID, '+1 day');

        incrementUserData('update',$user_id);

}
