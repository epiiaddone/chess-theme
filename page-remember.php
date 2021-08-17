<?
checkLogin();
hideFromUsers();
/*
$remember_url = $_SERVER['REQUEST_URI'];
$remember_id = substr($remember_url, strpos($remember_url, '?num=') + 5);
invalid_post_redirect($remember_id,'remember');
get_header();

 $rememberQuery = new WP_Query(array(
   'post_type'=>'remember',
   'post_status'=>'publish',
   'p'=>$remember_id,
 ));
 wp_reset_postdata();
 if(!$rememberQuery->have_posts()){
   invalid_url_HTML();
   return;
 }
   getRememberHTML($rememberQuery);

*/
get_footer();
