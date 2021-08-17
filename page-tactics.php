<?php
checkLogin();
hidefromUsers();
//http://chess.local/tactics/?level=11
$tactics_url = $_SERVER['REQUEST_URI'];
$tactics_level = substr($tactics_url, strpos($tactics_url, '?level=') + 7);
invalid_level_redirect($tactics_level);
get_header();

$banner_args = array();
$banner_args['title'] = 'Exercises';
$paths = buildPathToTacticsDD($tactics_level);
getNavPathHtml($paths, $banner_args);

$debug = false;
$user_uuid = get_UUID();
$start_number = 0;
$number_in_set = 0;

$number_in_set = getNumberInSet('tactic', $tactics_level);

$start_number = getProgress('userTacticsProgress',$tactics_level,$user_uuid)['number_seen'];

  if($debug){
    echo "<br>tactics_level:" . $tactics_level . "<br>";
     echo "<br>start_number:" . $start_number . "<br>";
     echo "<br>number_in_set:" . $number_in_set . "<br>";
   }


 if($start_number == $number_in_set){
   ?>
   <div class="container">
   <div class="container--title">All Tactics For This Level Are Complete</div>
 </div>
   <?php
}else{
  $tactics_wp_query= new WP_Query(array(
    'post_type'=>'tactic',//necessary as default post type is post
    'post_status'=>'publish',
    'meta_query'=>array(
      array(
        'key'=>'level',
        'value'=>$tactics_level,
        'compare'=>'='
      ),
      array(
        'key'=>'number_in_set',
        'value'=>$start_number + 1,
        'compare'=> '=',
      ),
    ),
  ));

  if($debug) print_r($tactics_wp_query);
wp_reset_postdata();
  if ( $tactics_wp_query->have_posts() ) {
    $tactics_wp_query->the_post();
    ?>
    <div id="tactics-page-identifier"></div>
    <div class="question">
      <?php
    the_content();
    ?>
    <div class="question--hidden" id="tactic_id"><?php echo the_id(); ?></div>
    <div class="question--hidden" id="user_uuid"><?php echo get_UUID();?></div>
    <div class="question--hidden" id="tactic_level"><?php echo $tactics_level;?></div>
    <div class="question--hidden" id="tactic_number_in_set"><?php echo $start_number + 1;?></div>



    <div id="question--show-solution" class="container--btn">Show Solution</div>
    <div id="question--ans--buttons" class="question--buttons">
      <div id="falseButton" class="container--btn container--btn__hard">False</div>
      <div id="correctButton" class="container--btn container--btn__easy">Correct</div>
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
}

get_footer();
