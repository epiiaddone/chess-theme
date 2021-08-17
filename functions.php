<?php
//General
require get_theme_file_path('/inc/storageGeneral.php');
//reports-data
require get_theme_file_path('/inc/report-data/save-question-report.php');
require get_theme_file_path('/inc/report-data/save-lesson-report.php');
require get_theme_file_path('/inc/report-data/save-tactic-report.php');
require get_theme_file_path('/inc/report-data/save-vis-report.php');
require get_theme_file_path('/inc/report-data/save-remember-report.php');

//site-data
require get_theme_file_path('/inc/site-data/groups.php');
require get_theme_file_path('/inc/site-data/levels.php');
require get_theme_file_path('/inc/site-data/types.php');
require get_theme_file_path('/inc/site-data/utils.php');
require get_theme_file_path('/inc/site-data/lists.php');

//template-parts
require get_theme_file_path('/inc/template-parts/form-builder-html.php');
require get_theme_file_path('/inc/template-parts/user-question-html.php');
require get_theme_file_path('/inc/template-parts/question-html-parts.php');
require get_theme_file_path('/inc/template-parts/summary-html.php');
require get_theme_file_path('/inc/template-parts/dash-hero-html.php');
require get_theme_file_path('/inc/template-parts/dough-html.php');
require get_theme_file_path('/inc/template-parts/group-html.php');
require get_theme_file_path('/inc/template-parts/cookie-banner-html.php');
require get_theme_file_path('/inc/template-parts/no-content-html.php');
require get_theme_file_path('/inc/template-parts/container-html.php');
require get_theme_file_path('/inc/template-parts/nav-html.php');
require get_theme_file_path('/inc/template-parts/nav-path-html.php');
require get_theme_file_path('/inc/template-parts/tactics-review.php');

//user-data
require get_theme_file_path('/inc/user-data/user-uuid.php');
require get_theme_file_path('/inc/user-data/user-data.php');
require get_theme_file_path('/inc/user-data/queries.php');
require get_theme_file_path('/inc/user-data/app-access.php');
require get_theme_file_path('/inc/user-data/reset-reviews.php');
    //addRemove
    require get_theme_file_path('/inc/user-data/addRemove/user-lesson-ar-data.php');
    require get_theme_file_path('/inc/user-data/addRemove/user-vis-ar-data.php');
    require get_theme_file_path('/inc/user-data/addRemove/user-tactic-ar-data.php');
    require get_theme_file_path('/inc/user-data/addRemove/user-remember-ar-data.php');
    //update
    require get_theme_file_path('/inc/user-data/update/user-question-update-data.php');
    require get_theme_file_path('/inc/user-data/update/user-tactic-update-data.php');
    require get_theme_file_path('/inc/user-data/update/user-vis-update-data.php');
    require get_theme_file_path('/inc/user-data/update/user-remember-update-data.php');



function load_scripts_bundled(){
  wp_register_script('sb-js', get_theme_file_uri('/scripts-bundled-2.js'), array('jquery'), '0.1', true);
  wp_enqueue_script('sb-js');
  wp_localize_script('sb-js', 'chessAppData', array(
    'root_url'=> get_site_url(),
    'nonce' => wp_create_nonce('wp_rest'),
  ));
}
add_action('wp_enqueue_scripts', 'load_scripts_bundled');


function chess_files(){
//this neads a call to wp_head() to work
wp_enqueue_style('chess_main_styles', get_stylesheet_uri());
}
add_action( 'wp_enqueue_scripts', 'chess_files' );



function remove_admin_bar() {
  if (!current_user_can('administrator')) {
    show_admin_bar(false);
  }
}
add_action('after_setup_theme', 'remove_admin_bar');



function blockusers_init() {
  //is_admin() is referring to weather the user is on the admin page or not
  // i have no idea what the doing_ajax is
  if ( is_admin() && !current_user_can( 'administrator' ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX )){
    wp_redirect('/dashboard');
    exit;
  }
}
add_action( 'init', 'blockusers_init' );

 add_filter( 'wp_mail_from', 'custom_wp_mail_from' );
 function custom_wp_mail_from( $original_email_address ) {
 	//Make sure the email is from the same domain
 	//as your website to avoid being marked as spam.
 	return 'admin@100to1chess.com';
 }

 add_filter( 'wp_mail_from_name', 'custom_wp_mail_from_name' );
 function custom_wp_mail_from_name( $original_email_from ) {
 	return '100to1 Chess';
 }
