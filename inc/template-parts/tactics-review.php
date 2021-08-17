<?php


function getTacticForReview($user_id){

  $debug=false;

  $tacticID = getTacticID($user_id);

    if($tacticID==null || $tacticID==0){?>
      <div class="container">
        <div class="container--title">no reviews currently available
        </div>
      </div>
      <?php
    return;
    }

    $tactic_wp_query= new WP_Query(array(
      'post_type'=>'tactic',//necessary as default post type is post
      'p'=>$tacticID,
    ));
wp_reset_postdata();

if(!$tactic_wp_query->have_posts()) return;

getTacticHTML($tactic_wp_query);
}


function getTacticID($user_id){

  $dateNow = new DateTime();
  $dateUnix = $dateNow->format('U');


  $userTacticsQuery= new WP_Query(array(
    'post_type'=>'userTactics',//necessary as default post type is post
    'author'=>$user_id,
    'post_status'=>'publish',
    'meta_query'=>array(
      array(
        'key'=>'next_review_unix',
        'value'=>$dateUnix,
        'compare'=>'<', //change to > for testing
        'type' => 'numeric',
      ),
      array(
        'key'=>'active',
        'value'=>1,
        'compare'=>'=',
        'type'=>'numeric'
      )
    ),
    'posts_per_page'=>-1,
  ));
  wp_reset_postdata();

  $tacticIds = [];
  $i = 0;

  while($userTacticsQuery->have_posts()){
   $userTacticsQuery->the_post();
   $tacticIds[$i]=get_field('tactic_id');
   $i++;
  }

  shuffle($tacticIds);
  return $tacticIds[0];

}
