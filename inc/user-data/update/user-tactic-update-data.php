<?php

add_action('rest_api_init', 'updateUserTactic');

function updateUserTactic(){
  register_rest_route('user/v1/', 'updateUserTactic',array(
    'methods' =>'POST',
    'callback' => 'saveUserTactic'
  ));
}

function saveUserTactic($data){

  $debug=false;

    $user_uuid = $data['user_uuid'];
    $tactic_id = $data['tactic_id'];
    $button_hit = $data['button_hit'];
    $tactics_level = $data['tactics_level'];
    $user_id = get_ID_Ajax($user_uuid);
    $active = 0;

    if($debug){
      echo "tactic_id:" . $tactic_id;
      echo "---button_hit:" . $button_hit;
      echo "----user_uuid:" . $user_uuid;
      echo "---user_id:" . $user_id;
    }

  if(!is_user_valid($user_id)) return;
  if(!is_post_valid($tactic_id, 'tactic')) return;

  $userTacticProgressDataQuery = new WP_Query(array(
    'post_type'=>'userTacticsProgress',
    'author'=>$user_id,
    'post_status'=>'publish',
    'meta_query'=>array(
      array(
        'key'=>'level',
        'value'=>$tactics_level,
      ),
    ),
  ));
wp_reset_postdata();
if($userTacticProgressDataQuery->have_posts()){
  $userTacticProgressDataQuery->the_post();
  $userTacticProgressID = get_the_ID();
  $seen_number = get_field('number_seen');
  $active = get_field('active');
  if($debug) echo "userTacticsProgressID:" . $userTacticProgressID;

  update_post_meta($userTacticProgressID, 'number_seen', $seen_number + 1);
  $new_post_data = array(
    'ID'=>$userTacticProgressID,
    'post_title'=>'level:' . $tactics_level . ' number_seen:' . ($seen_number + 1) . ' user_id:' . $user_id . 'active:' . $active,
  );
  wp_update_post($new_post_data);
incrementUserData('update',$user_id);
}else{
  $seen_number = 0;
  $new_post_id = wp_insert_post( array(
    'post_type' => 'userTacticsProgress',
    'post_title'=>'level:' . $tactics_level . ' number_seen:' . ($seen_number + 1) . ' user_id:' . $user_id . ' active:0',
    'post_status'=>'publish',
    'post_author'=>$user_id,
  ),true);
  incrementUserData('insert',$user_id);
wp_reset_postdata();
  if ( is_wp_error( $new_post_id ) ) {
      echo "error in save userTacticProgress";
  } else {
    // Success!
    update_post_meta($new_post_id, 'level', $tactics_level);
    update_post_meta($new_post_id, 'number_seen', $seen_number + 1);
    update_post_meta($new_post_id, 'active', 0);
  }
}


  if($button_hit=='false'){
      $newUserTacticID = wp_insert_post(array(
        'post_type'=>'userTactics',
        'post_status'=>'publish',
        'post_title'=>'level:' . $tactics_level . ' tactic_id:' . $tactic_id . ' user_id:' . $user_id,
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
      if(is_wp_error( $newUserTacticID )) return;
wp_reset_postdata();
      update_post_meta($newUserTacticID,'level',$tactics_level);
      update_post_meta($newUserTacticID, 'tactic_id', $tactic_id);
      update_post_meta($newUserTacticID, 'active',$active);
      updateReviewDates($newUserTacticID, '+7 day');
        }
  }

  add_action('rest_api_init', 'updateUserTacticReview');

  function updateUserTacticReview(){
    register_rest_route('user/v1/', 'updateUserTacticReview',array(
      'methods' =>'POST',
      'callback' => 'saveUserTacticReview'
    ));
  }

  function saveUserTacticReview($data){

    $debug = false;

    $user_uuid = $data['user_uuid'];
    $tactic_id = $data['tactic_id'];
    $button_hit = $data['button_hit'];
    $userTacticId = 0;
    $user_id = get_ID_Ajax($user_uuid);

    if($debug){
      echo "tactic_id:" . $tactic_id;
      echo "---button_hit:" . $button_hit;
      echo "----user_uuid:" . $user_uuid;
      echo "---user_id:" . $user_id;
    }

    if(!is_user_valid($user_id)) return;
    if(!is_post_valid($tactic_id, 'tactic')) return;

    $userTacticQuery = new WP_Query(array(
      'post_type'=>'userTactics',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'tactic_id',
          'value'=>$tactic_id,
        ),
      )
    ));

    if($userTacticQuery->have_posts()){
      $userTacticQuery->the_post();
      $userTacticId = get_the_ID();

    wp_reset_postdata();

    if($button_hit == 'false'){
      updateReviewDates($userTacticId, '+7 day');

    }else{
      wp_delete_post($userTacticId,true);
    }

  }

  }
