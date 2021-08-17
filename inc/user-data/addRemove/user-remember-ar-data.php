<?php

add_action('rest_api_init', 'addUserRememberProg');

function addUserRememberProg(){
  register_rest_route('user/v1/', 'addUserRememberProg',array(
    'methods' =>'POST',
    'callback' => 'saveUserRememberProg'
  ));
}

function saveUserRememberProg($data){

  $debug=true;

    $user_uuid = $data['user_uuid'];
    $remember_level= $data['remember_level'];
    $user_id = get_ID_Ajax($user_uuid);

    if($debug){
      echo "user_id:[" . $user_id . "] ";
      echo "remember_level:[" . $remember_level . "] ";
    }

    if(!is_user_valid($user_id)) return;
    if(!is_valid_level($remember_level)) return;

    $currentUserRememberProgress= new WP_Query(array(
      'post_type'=>'userRememberProgress',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'level',
          'value'=>$remember_level,
        ),
        array(
          'key'=>'active',
          'value'=>0,
          'compare'=>'=',
          'type'=>'numeric'
        )
      )
    ));

    if($debug) //print_r($currentUserRememberProgress);

    wp_reset_postdata();

    if($currentUserRememberProgress->have_posts()){
      $currentUserRememberProgress->the_post();
      if($debug) echo "current userRememberProgressID:[" . get_the_ID() . "] ";
      $currentUserRememberId = get_the_ID();
      $currentNumberSeen = get_field('number_seen');
      update_post_meta($currentUserRememberId, 'active', 1);
      $post_data = array(
        'ID'=>$currentUserRememberId,
        'post_title'=>'level:' . $remember_level . ' number_seen:' . $currentNumberSeen  . ' user_id:' . $user_id . ' active:1',
      );
      wp_update_post($post_data);
      update_post_meta($new_post_id, 'average_depth', 0);
      incrementUserData('update',$user_id);
    }else{
    $number_seen = 0;
    $number_correct = 0;
    $active = true;

      $new_post_id = wp_insert_post( array(
        'post_type' => 'userRememberProgress',
        'post_title'=>'level:' . $remember_level . ' number_seen:' . $number_seen  . ' user_id:' . $user_id . ' active:1',
        'post_status'=>'publish',
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
wp_reset_postdata();
      if ( is_wp_error( $new_post_id ) ) {
          echo "error in save user remember";
      } else {
      	// Success!
        update_post_meta($new_post_id, 'level', $remember_level);
        update_post_meta($new_post_id, 'number_seen', $number_seen);
        update_post_meta($new_post_id, 'active', 1);

        //this need to change to average depth
        update_post_meta($new_post_id, 'average_depth', 0);


        $dateNow = new DateTime();
        $dateNowString = $dateNow->format('d/m/Y g:i a');
        $dateNow->modify('+1 day');
        $dateNext = $dateNow->format('d/m/Y g:i a');
        $dateNextUnix = $dateNow->format('U');

        update_post_meta($new_post_id, 'last_review_date', $dateNowString);
        update_post_meta($new_post_id, 'next_review_date', $dateNext);
        update_post_meta($new_post_id, 'next_review_unix', $dateNextUnix);
      }
    }

  }


add_action('rest_api_init', 'removeUserRememberProg');

function removeUserRememberProg(){
  register_rest_route('user/v1/', 'removeUserRememberProg',array(
    'methods' =>'POST',
    'callback' => 'deactivateUserRememberProg'
  ));
}

function deactivateUserRememberProg($data){

    $user_uuid = $data['user_uuid'];
    $remember_level= $data['remember_level'];
    $user_id = get_ID_Ajax($user_uuid);
    if(!is_user_valid($user_id)) return;
    if(!is_valid_level($remember_level)) return;

    $userRememberQuery = new WP_Query(array(
      'post_type'=>'userRememberProgress',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'level',
          'value'=>$remember_level,
        ),
        array(
          'key'=>'active',
          'value'=>1,
          'compare'=>'=',
          'type'=>'numeric'
        )
      )
    ));

wp_reset_postdata();
    $userRememberId = 0;

    while($userRememberQuery->have_posts()){
      $userRememberQuery->the_post();
      $userRememberId = get_the_ID();
      $seen_number = get_field('number_seen');

    update_post_meta($userRememberId,'active',0);

    $post_data = array(
      'ID'=>$userRememberId,
      'post_title'=>'level:' . $remember_level . ' number_seen:' . $seen_number  . ' user_id:' . $user_id . ' active:0',
    );
    wp_update_post($post_data);
    incrementUserData('update',$user_id);
  }

}


add_action('rest_api_init', 'resetUserRememberProg');

function resetUserRememberProg(){
  register_rest_route('user/v1/', 'resetUserRememberProg',array(
    'methods' =>'POST',
    'callback' => 'resetUserRememberProgMethod'
  ));
}

function resetUserRememberProgMethod($data){

  $debug = true;
  if($debug) echo "inside resetUserRememberProgMethod";

  $user_uuid = $data['user_uuid'];
  $rem_level = $data['remember_level'];
  $user_id = get_ID_Ajax($user_uuid);

  if($debug){
    echo "resetUserRememberProg():{ user_uuid:$user_uuid||";
    echo "vis_level:$vis_level||";
    echo "user_id:$user_id||}";
  }

  if(!is_user_valid($user_id)) return;
  if(!is_valid_level($rem_level)) return;

  $user_rem_query = new WP_Query(array(
    'post_type'=>'userRememberProgress',
    'author'=>$user_id,
    'post_status'=>'publish',
    'meta_query'=>array(
      array(
        'key'=>'level',
        'value'=>$rem_level,
        'compare'=>'=',
        'type' => 'numeric'
      ),
    )
  ));

  //if($debug) print_r($user_rem_query);

  wp_reset_postdata();

  if($user_rem_query->have_posts()){
    $user_rem_query->the_post();
    $user_rem_id = get_the_ID();
    $active = get_field('active');
    if($debug) echo "active:$active";
    $new_data = array(
      'ID'=>$user_rem_id,
      'post_title'=>'level:' . $rem_level . 'number_seen:0' .  'user_id:' . $user_id .  'active:'. $active,
    );

    wp_update_post($new_data);
incrementUserData('update',$user_id);
    update_post_meta($user_rem_id, 'number_seen' , 0);
    update_post_meta($user_rem_id, 'average_depth' , 0);
  }
}
