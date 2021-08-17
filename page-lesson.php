<?php
checkLogin();
$lesson_url = $_SERVER['REQUEST_URI'];
$lesson_to_play_id = substr($lesson_url, strpos($lesson_url, '?num=') + 5);
invalid_post_redirect($lesson_to_play_id, 'lessons');
get_header();

$debug = false;

  $lesson_wp_query= new WP_Query(array(
    'post_type'=>'lessons',//necessary as default post type is post
    'post_status'=>'publish',
    'p'=>$lesson_to_play_id,
  ));
wp_reset_postdata();
  //print_r($lesson_wp_query);

if( !$lesson_wp_query->have_posts() ){
  invalid_url_HTML();
  return;
}else{

  $lesson_wp_query->the_post();
  $lesson_level = get_field('level');
  $lesson_type = get_field('type');
  $lesson_group = get_field('group');
  $banner_args = array();
  $banner_args['title']  = get_field("display_title");
  $paths = buildPathToGroup($lesson_group, $lesson_type, $lesson_level);
  if($debug) print_r($paths);
  getNavPathHtml($paths, $banner_args);
  ?>
  <div class="lesson--wrapper">
    <?php
  the_content();
  ?>
</div>
<?php

    $userLessonQuery = new WP_Query(array(
      'post_type'=>'userLessons',
      'author'=>get_current_user_id(),
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'lesson_id',
          'value'=>$lesson_to_play_id,
          'compare'=>'=',
          'type'=>'numeric',
        ),
      )
    ));
    wp_reset_postdata();
    $active = 0;
    $read = 0;
    $userLesson = 0;
    if($userLessonQuery->have_posts()){
      $userLessonQuery->the_post();
      $active = get_field('active');
      $read = get_field('read');
      $userLesson = 1;
  }

  if($debug){
     echo "active:[" . $active . "]";
     echo "read:[" . $read . "]";
   }

   get_lesson_container_buttons($read,$active);

   ?>

<div class="lesson--hidden" id="lesson_id"><?php echo $lesson_to_play_id; ?></div>
<div class="lesson--hidden" id="lesson_title"><?php echo get_the_title(); ?></div>
<div class="lesson--hidden" id="lesson_display_title"><?php echo $banner_args['title']; ?></div>
<div class="lesson--hidden" id="user_uuid"><?php echo get_UUID();?></div>



<div class="report">
  <div id="lessonReportShowButton" class="container--btn">Report an error</div>
  <form id="lessonReportForm" action="" method="post">
  <textarea class="report--textarea" id="lessonReportForMmsg" name="lesson_report" placeholder="Report an error in this lesson"></textarea>
  <br>
  <button  type="submit" class="container--btn">Submit</button>
</form>
</div>

<?php
}

get_footer();
