<?php

function getQuestion($user_id){

  $debug=false;

  $questionID = getQuestionID($user_id);

    if($questionID==null || $questionID==0){?>
      <div class="container">
        <div class="container--title">no reviews currently available
        </div>
      </div>
      <?php
    return;
    }

  $question_wp_query= new WP_Query(array(
    'post_type'=>'questions',//necessary as default post type is post
    'p'=>$questionID,
  ));
wp_reset_postdata();
  if(!$question_wp_query->have_posts()) return;
  if($debug){
    ?>
    <div>$question query: <?php print_r($question_wp_query);?></div>
  <?php }

    getQuestionHTML($question_wp_query);

}

function getQuestionID($user_id){

  $debug=false;

      $dateNow = new DateTime();
      $dateUnix = $dateNow->format('U');

    $userQuestionsQuery= new WP_Query(array(
      'post_type'=>'userQuestions',//necessary as default post type is post
      'author'=>$user_id,
      'post_status'=>'publish',
      'posts_per_page'=>-1,
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

    ));
  wp_reset_postdata();

    if($debug) print_r($userQuestionsQuery);
    if($debug) echo "<br>found userQuestions:[" . $userQuestionsQuery->found_posts .  "]";

    $questionIds = [];
    $i=0;

     while($userQuestionsQuery->have_posts()){
      $userQuestionsQuery->the_post();
      $questionIds[$i]=get_field('question_id');
      $i++;
    }

    if($debug) print_r($questionIds);
    shuffle($questionIds);
    if($debug) print_r($questionIds);

    if(!empty($questionIds)) return $questionIds[0];
    else return null;
  }


//for given posttype [supports:remember,visulisation]
//check if review date is due then
//check if there are any left for that level
//if not will return false

/*
  function isReviewAvailiable($user_id,$post_type){

    $debug=false;

    $user_post_type = '';
    $query_post_type = '';
    if($post_type=='visualisation'){
      $user_post_type = 'userVisProgress';
      $query_post_type = 'visualisations';
    }elseif($post_type=='remember'){
      $user_post_type = 'userRememberProgress';
      $query_post_type = 'remember';
    }

    $date = new DateTime();
    $dateUnix = (int)$date->format('U');

    $userVisualisationQuery = new WP_Query(array(
      'post_type'=>$user_post_type,
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
          'type'=>'numeric',
        )
      ),
      'posts_per_page'=>-1,
    ));

    wp_reset_postdata();

    while($userVisualisationQuery->have_posts()){
      $userVisualisationQuery->the_post();
      $visLevel = get_field('level');
      $number_seen = get_field('number_seen');
    if($debug){
      ?>
      <div>UserVis query: <?php echo get_the_title();?></div>
      <?php
      ?>
      <div>level:<?php echo get_field('level')?></div>
      <div>ns:<?php echo get_field('number_seen')?></div>
      <div>lrd:<?php echo get_field('last_review_date')?></div>
      <div>nrd:<?php echo get_field('next_review_date')?></div>
      <div>nrunix:<?php echo get_field('next_review_unix')?></div>
      <div>cunix:<?php echo $dateUnix;?></div>
      <div>nc:<?php echo get_field('number_correct')?></div>
    <?php }
      $number_in_set = 0;
if($debug){
      ?>
      <div>vis level: <?php echo $visLevel; ?></div>
      <?php
      ?>
      <div>query post type: <?php echo $query_post_type; ?></div>
      <?php }

    try{
    global $wpdb;
    $prefix = $wpdb->prefix;

    $querystr = "
       SELECT max(p.ID) AS max_id
       FROM
       ".$prefix."posts p,
       ".$prefix."postmeta pm
       WHERE p.ID = pm.post_id
       AND p.post_type = '$query_post_type'
       AND p.post_status = 'publish'
       AND pm.meta_key = 'level'
       AND pm.meta_value = $visLevel
    ";
if($debug){
    ?>
    <div>query string: <?php echo $querystr; ?></div>
    <?php }

    wp_reset_postdata();
    $maxVisIDResult = $wpdb->get_results($querystr, OBJECT);
    if($debug){
    ?>
    <div>max id query: <?php print_r($maxVisIDResult); ?></div>
    <?php }

    $max_vis_id = $maxVisIDResult[0]->max_id;
    if($debug){
    ?>
    <div>max id: <?php echo $max_vis_id; ?></div>
    <?php }
    wp_reset_postdata();

    $vis_query = new WP_Query(array(
     'post_type'=>$query_post_type,
     'p'=>$max_vis_id,
    ));
wp_reset_postdata();
    if($vis_query->have_posts()){
     $vis_query->the_post();
     $number_in_set= get_field('number_in_set');
     if($debug==true){
     ?>
     <div>Max Vis number in set:<?php echo $number_in_set;?></div>
     <div>Number seen: <?php echo $number_seen;?></div>
     <?php }
    }
    }catch(Error $e){
      wp_reset_postdata();
    }

     if($number_seen >= $number_in_set){
       continue;
     }else{
       $visToShowQuery = new WP_Query(array(
         'post_type'=>$query_post_type,
         'post_status'=>'publish',
         'author'=>$user_id,
         'meta_query'=>array(
           array(
             'key'=>'level',
             'value'=>$visLevel,
             'compare'=>'=',
             'type'=>'numeric'
           ),
           array(
             'key'=>'number_in_set',
             'value'=>$number_seen + 1,
             'compare'=>'=',
             'type'=>'numeric',
           ),
         ),
       ));
       wp_reset_postdata();
if($debug){
       ?>

       <div>vis to show query:<?php print_r($visToShowQuery);?></div>
       <?php }

       if($visToShowQuery->have_posts()){
         $visToShowQuery->the_post();
         $visID = get_the_ID();
         if($debug){
            ?>

         <div>vis id:<?php echo $visID;?></div>
         <?php }
         return array(
           'question_type'=>$query_post_type,
           'question_id'=>$visID,
         );
       }
     }
   }
   return false;

  }

  */
