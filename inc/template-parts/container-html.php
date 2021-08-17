<?php

function get_container_title_html($title){
  ?>
  <div class="container--title"><?php echo $title;?></div>
  <?php
}

function get_tacticdd_container_buttons($level){
  $key = 'Tactics';
  $userActive = is_progress_active('userTacticsProgress',$level);
  ?>
  <div class="container--buttons">
  <div id="remove<?php echo $key;?>FromReviewsBtn"  class="container--btn" <?php if(!$userActive){echo 'style="display:none;"';}?>>
    Remove from Reviews
  </div>
  <div id="add<?php echo $key;?>ToReviewsBtn" class="container--btn" <?php if($userActive){echo 'style="display:none;"';}?>>
    Add to Reviews
  </div>
    <div id="reset<?php echo $key;?>Button" class="container--btn" >
    Reset Progress
  </div>
  <div id="reset<?php echo $key;?>ButtonConf" class="container--confirm" style="display:none;">
    <div class="container--confirm__content">Really Reset?</div>
    <div id="reset<?php echo $key;?>ButtonYes" class="container--confirm__content container--btn">
      Yes
    </div>
    <div id="reset<?php echo $key;?>ButtonNo" class="container--confirm__content container--btn">
      No
    </div>
  </div>
  </div>
  <?php
}

function get_lesson_container_buttons($read, $active){
$key = 'Lesson';

  ?>
  <div class="container--buttons">
  <div id="remove<?php echo $key;?>FromReviewsBtn"  class="container--btn" <?php if(!$active){echo 'style="display:none;"';}?>>
    Remove from Reviews
  </div>
  <div id="add<?php echo $key;?>ToReviewsBtn" class="container--btn" <?php if($active){echo 'style="display:none;"';}?>>
    Add to Reviews
  </div>
  <?php if($key=='Lesson'){?>

  <div id="mark<?php echo $key;?>AsReadBtn" class="container--btn"
  <?php if($read){echo 'style="display:none;"';}?>>Mark as complete
  </div>

  <div id="mark<?php echo $key;?>AsNotReadBtn" class="container--btn"
  <?php if(!$read){echo 'style="display:none;"';}?>>Mark as incomplete
  </div>

<?php } ?>
    <div id="reset<?php echo $key;?>Btn" class="container--btn" >
    Reset Progress
  </div>
  <div id="reset<?php echo $key;?>ButtonConf" class="container--confirm" style="display:none;">
    <div class="container--confirm__content">Really Reset?</div>
    <div id="reset<?php echo $key;?>ButtonYes" class="container--confirm__content container--btn">
      Yes
    </div>
    <div id="reset<?php echo $key;?>ButtonNo" class="container--confirm__content container--btn">
      No
    </div>
  </div>
  </div>
  <?php
}
