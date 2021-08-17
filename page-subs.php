<?php
checkLogin();
hideFromUsers();

get_header();


//will also need
//author as current user id
//and payment status completed
//but how to check that the monthy subscriptoins are not being cancelled??
$subs_query = new WP_Query(array(
  'post_type'=>'wp_paypal_order'
));
wp_reset_postdata();

while($subs_query->have_posts()){
  $subs_query->the_post();
  echo "<br>post_id:" . get_the_id();
}



get_footer();
