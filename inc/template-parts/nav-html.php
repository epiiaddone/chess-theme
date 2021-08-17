<?php


function get_header_nav_html(){
  $types = get_types();
  foreach($types as $type){
    get_header_nav_button_html($type);
  }
}

function get_header_nav_button_html($type){
  $type_display_name = get_type_display_name($type);
  ?>
  <li class="nav--login__button <?php echo $type;?>Color-bord-hover <?php echo $type;?>Color-hover">
    <div class="nav--login__button--toggle"><?php echo $type_display_name;?></div>
    <?php get_nav_level_html($type);?>
  </li>
<?php
}

function get_nav_level_html($type){
  $levels = get_levels();
  $levelData = array();
  foreach($levels as $level){
    $url = build_nav_level_url($type,$level);
    $level_display_name = get_level_nice($level);
    $levelData[$level_display_name] =$url;
  }
  get_nav_level_rows_html($levelData);
}

/////////////////DANGER:HARD CODED DATA/////////////////////
function build_nav_level_url($type,$level){
  $url = '';
  switch($type){
    case "tact" : $url = "/tacticsdd"; break;
    case "calc" : $url = "/calculation"; break;
    case "open" : $url = "/type/?type=open"; break;
    case "middle" : $url = "/type/?type=middle"; break;
    case "end" : $url = "/type/?type=end"; break;
  }
  $url = $url . "/?level=" . $level;
  return $url;
}


function get_nav_level_rows_html($levelData){
  ?>
    <div class="nav--levels">
      <?php
      foreach($levelData as $label => $url){
    ?>
    <div class="nav--levels__row">
      <a href="<?php echo $url;?>"><?php echo $label;?></a>
    </div>

  <?php
} ?>
  </div>
  <?php
}


////////////////////////////////////////////////////////////////////

function getReviewbuttonHtml($user_id){
  $review_count = getReviewNumber($user_id);
  ?>
  <div class="nav--login__button nav--login__button--review reviewColor-bord-hover reviewColor-hover">
  <a href="/review">Reviews <?php echo $review_count;?></a>
</div>
  <?php
}

function getProfileButtonHtml(){
  ?>
  <div class="nav--login__button reviewColor-bord-hover reviewColor-hover">
  <a href="/profile">Profile</a>
</div>
<?php
}

function getBlogButtonHtml(){
  ?>
  <div class="nav--login__button reviewColor-bord-hover reviewColor-hover">
  <a href="/blog">Blog</a>
</div>
<?php
}

function get_header_nav_logout_button(){
 $url = wp_logout_url();
 $label = "logout";
 get_header_nav_access_button_html($url,$label);
}

function get_header_nav_login_button(){
  $url = wp_login_url();
  $label = "login";
  get_header_nav_access_button_html($url,$label);
}

function get_header_nav_register_button(){
  $url = wp_registration_url();
  $label = "sign up";
  get_header_nav_access_button_html($url,$label);
}

function get_header_nav_access_button_html($url,$label){
  ?>
  <li class="nav--login__button loginColor-bord-hover loginColor-hover">
    <a href="<?php echo $url;?>"><?php echo $label;?></a>
  </li>
  <?php
}
