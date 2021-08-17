<?php


function get_UUID(){

  $debug = false;
  $user_id = get_current_user_id();
  if($debug) echo "get_UUID user_id:[" . $user_id . "]";
  if($user_id==0) return;

  $current_user_UUID_query = new WP_Query(array(
    'post_type'=>'userUUID',
    'author'=>$user_id,
    'post_status'=>'publish',
  ));

  wp_reset_postdata();

  if($current_user_UUID_query->have_posts()){
    $current_user_UUID_query->the_post();
    if($debug) echo "userUUID already exists. uuid:[" . get_field('uuid') . "]";
      return get_field('uuid');
  }else{
    $username =  wp_get_current_user()->user_login;
    $UUID = uniqid($username);

    $new_post_data = array(
      'post_type'=>'userUUID',
      'post_status'=>'publish',
      'post_title'=>'user_id:' . $user_id . ' UUID:' . $UUID,
      'post_author'=>$user_id,
    );
    wp_reset_postdata();

    $new_post_id = wp_insert_post($new_post_data,true);
    incrementUserData('insert',$user_id);
    if(is_wp_error($new_post_id)) return;

    update_post_meta($new_post_id, 'uuid', $UUID);
    update_post_meta($new_post_id, 'user_id', $user_id);
    return $UUID;
  }

}


function get_ID_Ajax($user_uuid){
  $debug=false;
  $user_id = 0;
  $current_user_UUID_query = new WP_Query(array(
    'post_type'=>'userUUID',
    'post_status'=>'publish',
    'meta_query'=>array(
                          array(
                          'key'=>'uuid',
                          'value'=>$user_uuid,
                        ),
                      )
  ));
  wp_reset_postdata();
  if(!$current_user_UUID_query->have_posts()) return;
  $current_user_UUID_query->the_post();
  $user_id=get_field('user_id');
  if($debug) echo "user_id:" . $user_id;
  return $user_id;
}
