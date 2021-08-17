<?php

function getVisHTML($question_wp_query){
  $question_wp_query->the_post();
  $vis_level = get_field('level');
  $vis_number_in_set = get_field('number_in_set');
  ?>
  <div class="question vis" id="vis-target">
    <?php
  the_content();
  ?>

  <div id="vis-ready-button" class="btn">Ready for Questions?</div>

  <div id="vis-review-identifier"></div>
  <div class="question--hidden" id="vis_id"><?php echo $question_to_play_id; ?></div>
  <div class="question--hidden" id="vis_title"><?php the_title();?></div>
  <div class="question--hidden" id="user_uuid"><?php echo get_UUID();?></div>
  <div class="question--hidden" id="vis_level"><?php echo $vis_level;?></div>
  <div class="question--hidden" id="number_seen"><?php echo $vis_number_in_set;?></div>


  <div id="vis--show-solution" class="btn">Show Solution</div>
  <div class="question--buttons">
    <div id="allCorrect" class="btn btn__okay">All Correct</div>
    <div id="someWrong" class="btn btn__hard">Some Wrong</div>
  </div>
  </div>

  <div class="report">

    <div id="visReportShowButton" class="btn">Report an error in this Question</div>
    <form id="visReportForm" action="" method="post">
    <textarea id="visReportForMmsg" name="question_report"></textarea>
    <button  type="submit" class="btn">Submit</button>
  </form>
  </div>
  <?php
}


function getRememberHTML($question_wp_query){
    $question_wp_query->the_post();
  ?>
  <div id="remember-page" class="remember">
  <?php
     $remember_level = get_field('level');
     the_content();
   ?>
   <div id="startButton" role="button">Start</div>
   <div id="whatNext">
     <div class="whatNext--title">What is the next move?</div>
     <div id="showNextButton">Show</div>
   </div>
   <div id="correctFalse" class="hidden">
     <div id="correctButton" >Correct</div>
     <div id="falseButton" >False</div>
   </div>

   <div id="endAllCorrect" class="hidden">
     <div>Well Done</div>
     <div>All moves correctly remembered</div>
     <button >Okay</button>
   </div>
   <div id="endNotAllCorrect" class="hidden">
     <div id="endNumberMoves"></div>
     <div>moves correctly remembered</div>
     <button >Okay</button>
   </div>

   <div class="remember--skip" id="remember--skip">
     Skip this for today
   </div>

   <div class="report">
     <div id="rememberReportShowButton" class="btn">Report an error in this Question</div>
     <form id="rememberReportForm" action="" method="post">
     <textarea id="rememberReportForMmsg" name="question_report"></textarea>
     <button  type="submit" class="btn">Submit</button>
   </form>
   </div>

   <div id="remember_level" class="hidden"><?php echo $remember_level;?></div>
   <div id="rememberID" class="hidden"><?php echo $remember_id;?></div>
   <div id="rememberNumberInSet" class="hidden"><?php echo $number_in_set;?></div>
   <div id="user_uuid" class="hidden"><?php echo get_UUID();?></div>
   </div>
  <?php
}


function getTacticHTML($question_wp_query){
    $question_wp_query->the_post();
  ?>
  <div id="tactics-review-identifier"></div>
  <div class="question">
    <?php
  the_content();
  ?>
  <div class="question--hidden" id="tactic_id"><?php echo get_the_ID(); ?></div>
  <div class="question--hidden" id="tactic_title"><?php the_title();?></div>
  <div class="question--hidden" id="user_uuid"><?php echo get_UUID();?></div>
  <div class="question--hidden" id="seen_number"><?php echo $start_number;?></div>
  <div class="question--hidden" id="tactics_level"><?php echo $tactics_level;?></div>
  <div class="question--hidden" id="tactic_number_in_set"><?php echo $start_number + 1;?></div>

  <div id="question--show-solution" class="container--btn">Show Solution</div>
  <div id="question--ans--buttons" class="question--buttons">
    <div id="falseButton" class="container--btn container--btn__hard">False</div>
    <div id="correctButton" class="container--btn container--btn__okay">Correct</div>
  </div>
  </div>

  <div class="report">

    <div id="tacticReportShowButton" class="container--btn">Report an error</div>
    <form id="tacticReportForm" action="" method="post">
    <textarea class="report--textarea" id="tacticReportForMmsg" name="tactic_report" placeholder="Report an error in this tactic"></textarea>
    <br>
    <button  type="submit" class="container--btn">Submit</button>
  </form>
  </div>
<?php

}


function getQuestionHTML($question_wp_query){
    $question_wp_query->the_post();
    $lesson_name = get_field('lesson_name');
    $lesson_id = get_field('lesson_id');
  ?>
  <div id="question-review-identifier" class="question">
    <?php
  the_content();
  ?>
  <div class="question--hidden" id="question_id"><?php echo get_the_id(); ?></div>
  <div class="question--hidden" id="question_title"><?php the_title();?></div>
  <div class="question--hidden" id="user_uuid"><?php echo get_UUID();?></div>

<div class="container--btn__center">
  <div id="question--show-solution" class="container--btn">Show Solution</div>
</div>
  <div id="question--ans--buttons" class="question--buttons">
    <div id="hardButton" class="container--btn container--btn__hard">Hard</div>
    <div id="okayButton" class="container--btn container--btn__okay">Okay</div>
    <div id="easyButton" class="container--btn container--btn__easy">Easy</div>
  </div>

  <div class="question--link">
    <a id="question-lesson-link" class="hidden"
    href="<?php echo site_url('/lesson/?num=' . $lesson_id)?>"
    >Lesson: <?php echo $lesson_name?>
  </a>
  </div>

  </div>

  <div class="report">

    <div id="questionReportShowButton" class="container--btn">Report an error in this Question</div>
    <form id="questionReportForm" action="" method="post">
    <textarea class="report--textarea" id="questionReportForMmsg" name="question_report" placeholder="Report an error in this question"></textarea>
    <br>
    <button  type="submit" class="container--btn">Submit</button>
  </form>
  </div>
  <?php
}
