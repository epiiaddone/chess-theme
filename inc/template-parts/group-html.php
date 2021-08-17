<?php

function get_group_html($type,$group,$level){
  $lessons = getAllActiveLessons($type,$group,$level);
  if($lessons==false){
    //need to put some html for no lessons here yet
    ?>
    <div class="container">
      <div class="container--title">
        No content here yet
      </div>
</div>
    <?php
    return;
  }
  get_lesson_list_html($lessons);
  $userLessons = getAllUserLessonsGroup($type,$group,$level);
  if($userLessons) set_complete_and_reviews_html($userLessons);
}

function get_lesson_list_html($lessons){
  while($lessons->have_posts()){
    $lessons->the_post();
    $display_title = get_field('display_title');
    $lesson_id = get_the_ID();
    ?>
    <div id="lesson-list-<?php echo $lesson_id;?>" class="lesson-list btn--shadow">
      <div class="lesson-list__title"><?php echo $display_title;?></div>

      <div class="lesson-list__secondary">
        <!-- it appears i'm not doing a lesson stage
      <div  id="lesson-stage-" class="lesson-list__stage hidden"></div>
             -->
      <div id="lesson-complete-<?php echo $lesson_id;?>" class="lesson-list__complete lesson-list__box">Complete</div>
      <div id="lesson-review-<?php echo $lesson_id;?>" class="lesson-list__review lesson-list__box">In Reviews</div>
    </div>
    </div>
    <script>
    document.getElementById('lesson-list-<?php echo $lesson_id;?>').addEventListener('pointerdown',
      function(){
        location.href='<?php echo site_url();?>/lesson/?num=<?php echo $lesson_id;?>';
      });
      </script>
    <?php
  }
}

function set_complete_and_reviews_html($userLessons){
  $debug=false;
  if($debug) echo "<br>DEBUG:inside set_complete_and_reviews_html<br>";
  while($userLessons->have_posts()){
    $userLessons->the_post();
    $lesson_id = get_field('lesson_id');
    $read = get_field('read');
    $active = get_field('active');
    if($read==1) set_lesson_box_html($lesson_id, 'complete');
    if($active==1)  set_lesson_box_html($lesson_id, 'review');
  }
}

function set_lesson_box_html($lesson_id, $box){
  ?>
  <script>
    $('#lesson-<?php echo $box;?>-<?php echo $lesson_id;?>').addClass('lesson-list__box--selected');
  </script>
  <?php
}
