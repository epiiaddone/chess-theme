<?php
checkLogin();
hideFromUsers();

get_header();



$question_url = $_SERVER['REQUEST_URI'];
$question_to_play_id = substr($question_url, strpos($question_url, '?num=') + 5);




  $question_wp_query= new WP_Query(array(
    'post_type'=>'questions',//necessary as default post type is post
    'post_status'=>'publish',
    'p'=>$question_to_play_id,
  ));

  //print_r($question_wp_query);

  if(!$question_wp_query->have_posts() ){
    invalid_url_HTML();
    return;
  }
    getQuestionHTML($question_wp_query);

get_footer();
