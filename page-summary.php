<?php
checkLogin();
get_header();

$debug = false;

$dateNow = new DateTime();
$dateNowUnix = $dateNow->format('U');
$dateNowUnix = $dateNowUnix - 7*24*60*60;

$userQuestionQuery = new WP_Query(array(
  'post_type'=> 'userQuestions',
  'author'=>get_current_user_id(),
  'post_status'=>'publish',
  'meta_query'=>array(
    array(
      'key'=>'last_review_unix',
      'compare'=>'>',
      'value'=>$dateNowUnix,
      'type'=>'numeric',
    ),
  )
));
wp_reset_postdata();
$userQuestionResults = array();

while($userQuestionQuery->have_posts()){
  $userQuestionQuery->the_post();
  array_push($userQuestionResults, array( get_field('lesson_id'), get_field('last_result')));
}
if($debug){
echo "<br><br>";
print_r($userQuestionResults);
echo "<br><br>";
}

$userLessonQuery = new WP_Query(array(
    'post_type'=>'userLessons',
    'author'=>get_current_user_id(),
    'post_status'=>'publish',
    'order_by'=>'meta_value_num',
    'meta_key'=>'level',
    'order'     => 'ASC',
));
wp_reset_postdata();
$userLessons = array();

while($userLessonQuery->have_posts()){
  $userLessonQuery->the_post();
  array_push($userLessons, array(get_field('lesson_id'), get_field('lesson_title'), get_field('level')));
}
if($debug){
echo "<br><br>userLessons:";
print_r($userLessons);
echo "<br><br>";
}

//array(array(lesson_id,result,amount,lesson_title,level))
$lessonResults = array();

  foreach($userQuestionResults as $userQuestionResult){
    if($debug)echo"<br>inside the top foreach";
    $lesson_id = $userQuestionResult[0];
    $current_question_result = $userQuestionResult[1];
    foreach($userLessons as $userLesson){
      $userLesson_lesson_id = $userLesson[0];
      if($debug)echo"<br>inside the second foreach";
    if($userLesson_lesson_id==$lesson_id){
      //there is a match on userQestion id and user_lesson_id
      //so there must be a addition to the data
      if($debug)echo "<br>userQuestion userLessonMatch--lesson_id:$lesson_id";
      //iterate through all the lesson results to find a mactch on the last_result
      $lessonResultEntryNumber = -1;
      foreach($lessonResults as $lessonResult){
        $lessonResultEntryNumber++;
        if($debug)echo"<br>inside the third for each";
        $current_lesson_result = $lessonResult[1];
        if($lessonResult[0]==$lesson_id && $current_lesson_result==$current_question_result){
          //already a lesson_result match id and last_result
          //so need to increment the amount +1
          if($debug)echo"<br>currentLessonResult:";
          if($debug)print_r($lessonResult);
            $current_count = $lessonResult[2];
            $current_count++;
            //$lessonResults entries are immutable?
            //each $lessonResult is just a copy?
            $lessonResults[$lessonResultEntryNumber][2] = $current_count;
            if($debug)echo"<br>continue 3 called";
            if($debug)echo"<br>after the continue lesson results:";
            if($debug)print_r($lessonResults);
            continue 3;
        }
    }
    //after all lesson results iterated and no match need to add
    //a new lesson_result with a count of 1
    if($debug)echo"<br>new lessonResult added lesson_id:$lesson_id";
    array_push($lessonResults, array($lesson_id,$current_question_result,1,$userLesson[1], $userLesson[2]));
  }
}
if($debug)echo"<br>end of first outerloop lesson results:";
if($debug)print_r($lessonResults);
}

if($debug){
echo "<br><br>";
print_r($lessonResults);
echo "<br><br>";
}

get_summary_html($lessonResults)

?>
<div id="reviewsummary">


</div>
<?php

get_footer();
