<?php


function incrementUserData($write_type, $user_id){
  $userDataQuery = new WP_Query(array(
    'post_type'=>'userData',
    'author'=>$user_id,
    'post_status'=>'publish',
  ));
  wp_reset_postdata();
  if(!$userDataQuery->have_posts()){
    $new_post_id =   wp_insert_post(array(
      'post_author'=>$user_id,
      'post_type'=>'userData',
      'post_status'=>'publish'
    ),true);
    wp_reset_postdata();
    if(is_wp_error($new_post_id)) return;
    wp_update_post(array(
      'ID'=>$new_post_id,
      'post_title'=>"user_id:" . $user_id . " update:" . $updates . " insert:". $insert,
    ));
    update_post_meta($new_post_id,'update',0);
    update_post_meta($new_post_id, 'insert',0);
  }else{
    $userDataQuery->the_post();
    $userDataID = get_the_ID();
    $updates = get_field('update');
    $inserts = get_field('insert');

    if($inserts>100 || $updates>100){
      //wp_logout() only works on page navigation
      //it doesn't log the user out immediatley
    }

    if($write_type == 'update') update_post_meta($userDataID,'update',++$updates);
    if($write_type == 'insert') update_post_meta($userDataID, 'insert', ++$inserts);

    wp_update_post(array(
      'ID'=>$userDataID,
      'post_title'=>"user_id:" . $user_id . " update:" . $updates . " insert:". $inserts,
    ));
  }
}
