<?php
checkLogin();
hideFromUsers();

get_header();


$questions_query = new WP_Query( array(
  'post_type'=>'questions',
  'post_status'=>'publish',
  'posts_per_page'=>-1,
) );
wp_reset_postdata();

$question_data = array();
// The Loop

	while ( $questions_query->have_posts() ) {
		$questions_query->the_post();
    $title = get_the_title();
    $id = get_the_id();
    $lesson_id = get_field('lesson_id');
    $temp = array($lesson_id, $id, $title);
    array_push( $question_data, $temp);
	}


$lessons_query = new WP_Query( array(
  'post_type'=>'lessons',
  'post_status'=>'publish',
  'posts_per_page'=>-1,
) );

wp_reset_postdata();

$lesson_data = array();

for($i=10; $i<19; $i++){
  $temp = array();
  $temp['open'] = array();
  $temp['middle'] = array();
  $temp['end'] = array();
$lesson_data[$i] = $temp;
}


	while ( $lessons_query->have_posts() ) {
		$lessons_query->the_post();
    $id = get_the_id();
    $level = (int)get_field('level');
    $type = get_field('type');
    //echo '<br>id:' . $id . ' $level:' . $level . ' type:' . $type;
    array_push($lesson_data[$level][$type], $id);
	}

  //print_r($lesson_data);

  for($level=10; $level<19; $level++){
    get_question_level_links($lesson_data, $question_data, $level, 'open');
    get_question_level_links($lesson_data, $question_data, $level, 'middle');
    get_question_level_links($lesson_data, $question_data, $level, 'end');
    }


function get_question_level_links($lesson_data, $question_data, $level, $type){
  ?>
  <div class="question-list__level">Level <?php echo $level;?></div>
  <div class="question-list__type"><?php echo $type;?></div>
  <?php
    for($j=0; $j<count($lesson_data[$level][$type]); $j++){
    $lesson_id = $lesson_data[$level][$type][$j];
    //echo 'lesson_id:' . $lesson_id;
    for($k=0; $k<count($question_data); $k++){
      if($lesson_id == $question_data[$k][0]){
        $question_id = $question_data[$k][1];
        $question_title = $question_data[$k][2];
        ?>
        <a href="<?php echo site_url('question/?num=') . $question_id;?> "><?php echo $question_title;?></a><br>
        <?php
      }
    }
  }
}



get_footer();
