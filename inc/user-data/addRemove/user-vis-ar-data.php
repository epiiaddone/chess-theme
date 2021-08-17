<?php

add_action('rest_api_init', 'addUserVisProg');

function addUserVisProg(){
  register_rest_route('user/v1/', 'addUserVisProg',array(
    'methods' =>'POST',
    'callback' => 'addUserVisProgMethod'
  ));
}

function addUserVisProgMethod($data){

  $debug=true;

    $user_uuid = $data['user_uuid'];
    $vis_level= $data['vis_level'];

    if($debug){
      echo "user_id:[" . $user_id . "] ";
      echo "vis_level:[" . $vis_level . "] ";
    }

    $user_id = get_ID_Ajax($user_uuid);
    if(!is_user_valid($user_id)) return;
    if(!is_valid_level($vis_level)) return;

    if($debug) echo "[addUserVisProgMethod() level and user both valid]";


    $currentUserVisProgress= new WP_Query(array(
      'post_type'=>'userVisProgress',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'level',
          'value'=>$vis_level,
        ),
        array(
          'key'=>'active',
          'value'=>0,
          'compare'=>'=',
          'type'=>'numeric'
        )
      )
    ));

    if($debug)  //print_r($currentUserVisProgress);

    wp_reset_postdata();

    if($currentUserVisProgress->have_posts()){
      $currentUserVisProgress->the_post();
      if($debug) echo "current userVisProgressID:[" . get_the_ID() . "] ";
      $currentUserVisId = get_the_ID();
      $currentNumberSeen = get_field('number_seen');
      update_post_meta($currentUserVisId, 'active', 1);
      $post_data = array(
        'ID'=>$currentUserVisId,
        'post_title'=>'level:' . $vis_level . ' number_seen:' . $currentNumberSeen  . ' user_id:' . $user_id . ' active:1',
      );
      wp_update_post($post_data);
      incrementUserData('update',$user_id);
    }else{
    $number_seen = 0;
    $number_correct = 0;
    $active = true;

      $new_post_id = wp_insert_post( array(
        'post_type' => 'userVisProgress',
        'post_title'=>'level:' . $vis_level . ' number_seen:' . $number_seen  . ' user_id:' . $user_id . ' active:1',
        'post_status'=>'publish',
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
wp_reset_postdata();
      if ( is_wp_error( $new_post_id ) ) {
          echo "error in save user vis";
      } else {
      	// Success!
        update_post_meta($new_post_id, 'level', $vis_level);
        update_post_meta($new_post_id, 'number_seen', $number_seen);
        update_post_meta($new_post_id, 'active', 1);
        update_post_meta($new_post_id, 'number_correct', $number_correct);

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


add_action('rest_api_init', 'deactivateUserVisProg');

function deactivateUserVisProg(){
  register_rest_route('user/v1/', 'deactivateUserVisProg',array(
    'methods' =>'POST',
    'callback' => 'deactivateUserVisProgMethod'
  ));
}

function deactivateUserVisProgMethod($data){

    $user_uuid = $data['user_uuid'];
    $vis_level= $data['vis_level'];
    $user_id = get_ID_Ajax($user_uuid);
    if(!is_user_valid($user_id)) return;
    if(!is_valid_level($vis_level)) return;

    $userVisQuery = new WP_Query(array(
      'post_type'=>'userVisProgress',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'level',
          'value'=>$vis_level,
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
    $userVisId = 0;

    while($userVisQuery->have_posts()){
      $userVisQuery->the_post();
      $userVisId = get_the_ID();
      $seen_number = get_field('number_seen');

    update_post_meta($userVisId,'active',0);

    $post_data = array(
      'ID'=>$userVisId,
      'post_title'=>'level:' . $vis_level . ' number_seen:' . $seen_number  . ' user_id:' . $user_id . ' active:0',
    );
    wp_update_post($post_data);
    incrementUserData('update',$user_id);
  }
}


add_action('rest_api_init', 'resetUserVisProg');

function resetUserVisProg(){
  register_rest_route('user/v1/', 'resetUserVisProg',array(
    'methods' =>'POST',
    'callback' => 'resetUserVisProgMethod'
  ));
}

function resetUserVisProgMethod($data){

  $debug = false;

  $user_uuid = $data['user_uuid'];
  $vis_level = $data['vis_level'];
  $user_id = get_ID_Ajax($user_uuid);

  if($debug){
    echo "resetUserVisProg():{ user_uuid:$user_uuid||";
    echo "vis_level:$vis_level||";
    echo "user_id:$user_id||}";
  }

  if(!is_user_valid($user_id)) return;
  if(!is_valid_level($vis_level)) return;

  $user_vis_query = new WP_Query(array(
    'post_type'=>'userVisProgress',
    'author'=>$user_id,
    'post_status'=>'publish',
    'meta_query'=>array(
      array(
        'key'=>'level',
        'value'=>$vis_level,
        'compare'=>'=',
        'type' => 'numeric'
      ),
    )
  ));

  if($debug) print_r($user_vis_query);

  wp_reset_postdata();

  if($user_vis_query->have_posts()){
    $user_vis_query->the_post();
    $user_vis_id = get_the_ID();
    $active = get_field('active');
    if($debug) echo "active:$active";
    $new_data = array(
      'ID'=>$user_vis_id,
      'post_title'=>'level:' . $vis_level . 'number_seen:0' .  'user_id:' . $user_id .  'active:'. $active,
    );

    wp_update_post($new_data);
incrementUserData('update',$user_id);
    update_post_meta($user_vis_id, 'number_seen' , 0);
    update_post_meta($user_vis_id, 'number_correct' , 0);
  }
}
