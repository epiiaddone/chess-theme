<?php

add_action('rest_api_init', 'addUserTacticsProg');

function addUserTacticsProg(){
  register_rest_route('user/v1/', 'addUserTacticsProg',array(
    'methods' =>'POST',
    'callback' => 'saveUserTacticsProg'
  ));
}

function saveUserTacticsProg($data){

  $debug=true;

    $user_uuid = $data['user_uuid'];
    $tactics_level= $data['tactics_level'];
    $user_id = get_ID_Ajax($user_uuid);

    if($debug){
      echo "user_id:[" . $user_id . "] ";
      echo "tactics_level:[" . $tactics_level . "] ";
    }

    if(!is_user_valid($user_id)) return;
    if(!is_valid_level($tactics_level)) return;

    $currentUserTacticsProgress= new WP_Query(array(
      'post_type'=>'userTacticsProgress',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'level',
          'value'=>$tactics_level,
        ),
        array(
          'key'=>'active',
          'value'=>0,
          'compare'=>'=',
          'type'=>'numeric'
        )
      )
    ));

    if($debug)//print_r($currentUserTacticsProgress);

    wp_reset_postdata();

    if($currentUserTacticsProgress->have_posts()){
      $currentUserTacticsProgress->the_post();
      if($debug) echo "current userTacticsProgressID:[" . get_the_ID() . "] ";
      $currentUserTacticsId = get_the_ID();
      $currentNumberSeen = get_field('number_seen');
      update_post_meta($currentUserTacticsId, 'active', 1);
      $post_data = array(
        'ID'=>$currentUserTacticsId,
        'post_title'=>'level:' . $tactics_level . ' number_seen:' . $currentNumberSeen  . ' user_id:' . $user_id . ' active:1',
      );
      wp_update_post($post_data);
      incrementUserData('update',$user_id);
      //setActiveUserTactics($user_id,$tactics_level,1);
    }else{
    $number_seen = 0;
    $number_correct = 0;
    $active = true;

      $new_post_id = wp_insert_post( array(
        'post_type' => 'userTacticsProgress',
        'post_title'=>'level:' . $tactics_level . ' number_seen:' . $number_seen  . ' user_id:' . $user_id . ' active:1',
        'post_status'=>'publish',
        'post_author'=>$user_id,
      ),true);
      incrementUserData('insert',$user_id);
      wp_reset_postdata();
      if ( is_wp_error( $new_post_id ) ) {
          echo "error in save user tactics";
      } else {
      	// Success!
        update_post_meta($new_post_id, 'level', $tactics_level);
        update_post_meta($new_post_id, 'number_seen', $number_seen);
        update_post_meta($new_post_id, 'active', 1);

      }
    }

  }


add_action('rest_api_init', 'removeUserTacticsProg');

function removeUserTacticsProg(){
  register_rest_route('user/v1/', 'removeUserTacticsProg',array(
    'methods' =>'POST',
    'callback' => 'deactivateUserTacticsProg'
  ));
}

function deactivateUserTacticsProg($data){

    $debug=true;

    $user_uuid = $data['user_uuid'];
    $tactics_level= $data['tactics_level'];
    $user_id = get_ID_Ajax($user_uuid);

    if($debug){
      echo "<br><br>deactivateUserTacticsProg() user_uuid:[" . $user_uuid . "]<br>";
      echo "deactivateUserTacticsProg() tactics_level:[" . $tactics_level . "]<br>";
      echo "deactivateUserTacticsProg() user_id:[" . $user_id . "]<br>";
    }

    if(!is_user_valid($user_id)) return;
    if(!is_valid_level($tactics_level)) return;

    $userTacticsQuery = new WP_Query(array(
      'post_type'=>'userTacticsProgress',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'level',
          'value'=>$tactics_level,
        ),
        array(
          'key'=>'active',
          'value'=>1,
          'compare'=>'=',
          'type'=>'numeric'
        )
      )
    ));

    //if($debug) print_r($userTacticsQuery);

wp_reset_postdata();
    $userTacticsId = 0;

    if($userTacticsQuery->have_posts()){
      $userTacticsQuery->the_post();
      $userTacticsId = get_the_ID();
      $seen_number = get_field('number_seen');

    update_post_meta($userTacticsId,'active',0);

    $post_data = array(
      'ID'=>$userTacticsId,
      'post_title'=>'level:' . $tactics_level . ' number_seen:' . $seen_number  . ' user_id:' . $user_id . ' active:0',
    );
    wp_update_post($post_data);
    incrementUserData('update',$user_id);
    //setActiveUserTactics($user_id,$tactics_level,0);
  }

}



add_action('rest_api_init', 'resetUserTacticsProg');

function resetUserTacticsProg(){
  register_rest_route('user/v1/', 'resetUserTacticsProg',array(
    'methods' =>'POST',
    'callback' => 'resetUserTacticsProgMethod'
  ));
}

function resetUserTacticsProgMethod($data){

    $debug=true;

    $user_uuid = $data['user_uuid'];
    $tactics_level= $data['tactics_level'];
    $user_id = get_ID_Ajax($user_uuid);

    if($debug){
      echo "resetUserTacticsProgMethod() user_uuid:[" . $user_uuid . "]";
      echo "resetUserTacticsProgMethod() tactics_level:[" . $tactics_level . "]";
      echo "resetUserTacticsProgMethod() user_id:[" . $user_id . "]";
    }

    if(!is_user_valid($user_id)) return;
    if(!is_valid_level($tactics_level)) return;

    $userTacticsQuery = new WP_Query(array(
      'post_type'=>'userTacticsProgress',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'level',
          'value'=>$tactics_level,
        )
      )
    ));

    //if($debug) print_r($userTacticsQuery);

wp_reset_postdata();
    $userTacticsId = 0;

    if($userTacticsQuery->have_posts()){
      if($debug) echo "--[userTacticsQuery has a post]--";
      $userTacticsQuery->the_post();
      $userTacticsId = get_the_ID();
      $seen_number = get_field('number_seen');
      $active = get_field('active');
    update_post_meta($userTacticsId,'number_seen',0);

    $post_data = array(
      'ID'=>$userTacticsId,
      'post_title'=>'level:' . $tactics_level . ' number_seen:0 user_id:' . $user_id . ' active:' . $active,
    );
    wp_update_post($post_data);
    incrementUserData('update',$user_id);

    $tacticReviewQuery = new WP_Query(array(
      'post_type'=>'userTactics',
      'post_status'=>'publish',
      'author'=>$user_id,
      'posts_per_page'=>-1,
      'meta_query'=>array(
        array(
          'key'=>'level',
          'value'=>$tactics_level,
          'compare'=>'=',
          'type'=>'numeric',
        ),
      )
    ));

    wp_reset_postdata();

    while($tacticReviewQuery->have_posts()){
      $tacticReviewQuery->the_post();
      $temp_id = get_the_ID();
      if($debug) echo "userTacticID:" . $temp_id;
      wp_delete_post($temp_id,true);
    }
  }else{
    if($debug) echo "--no userTactics found--";
  }

}

/*
have removed the active from the user tactic as it is duplicate data
function setActiveUserTactics($user_id,$tactics_level,$active){
  $tacticReviewQuery = new WP_Query(array(
    'post_type'=>'userTactics',
    'post_status'=>'publish',
    'author'=>$user_id,
    'posts_per_page'=>-1,
    'meta_query'=>array(
      array(
        'key'=>'tactic_level',
        'value'=>$tactics_level,
        'compare'=>'=',
        'type'=>'numeric',
      ),
    )
  ));

  wp_reset_postdata();

  while($tacticReviewQuery->have_posts()){
    $tacticReviewQuery->the_post();
    $temp_id = get_the_ID();
    if($debug) echo "userTacticID:" . $temp_id;
    update_post_meta($temp_id,'active',$active);
  }
}
*/
