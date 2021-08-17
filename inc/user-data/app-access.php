<?php

//this function does not work if output stream has already begun
//so you must call this function before get_header();
function hideFromUsers(){

  if(get_current_user_id()!=1){
    $url = site_url('/dashboard');
  redirect($url);
}
}

function checkLogin(){
  if(get_current_user_id()<1){
    $url = site_url();
    redirect($url);
  }
}

function invalid_level_redirect($level){
  if(!is_valid_level($level)){
    $url = site_url('/dashboard');
    redirect($url);
  }
}

function invalid_group_redirect($type,$group,$level){
  if(!is_valid_group($type,$group,$level)){
    $url = site_url('/dashboard');
    redirect($url);
  }
}

function invalid_type_redirect($type){
  if(!is_valid_type($type)){
    $url = site_url('/dashboard');
    redirect($url);
  }
}

function invalid_post_redirect($post_id,$post_type){
  if(!is_post_valid($post_id,$post_type)){
    $url = site_url('/dashboard');
    redirect($url);
  }
}

function is_user_valid($user_id){
$user = get_user_by( 'id', $user_id);
if (empty( $user )){
  echo "empty user ";
  return false;
}
return true;
}

function is_post_valid($post_id,$post_type){
  $lessonQuery = new WP_Query(array(
    'post_type'=>$post_type,
    'p'=>$post_id,
  ));
  wp_reset_postdata();
  if($lessonQuery->have_posts()) return true;
  else return false;
}


function invalid_url_HTML(){?>
  <div id="four04" class="four04">
    <h1 class="four04--text">INVALID URL
    </h1>
    <h3 class="four04--text" >Redirecting...</h3>
  </div>

  <script>
  setTimeout(function(){
  window.location.href='<?php echo get_site_url() . "/dashboard";?>';
  }, 3000);
  </script>
  <?php
}


function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

//insecure front-end redirect
// not in use
function nonProductionRedirect(){
  ?>
  <script>
(function(){
window.location.href='<?php echo get_site_url() . "/dashboard";?>';
}())
</script>
<?php
}
