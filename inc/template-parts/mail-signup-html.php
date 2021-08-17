<?php
function get_mail_signup_html(){?>
  <div id="mail-content">
    <div id="mail-content--mask"></div>
    <div id="mail-content--close">
    <i class="fas fa-times-circle fa-2x"></i>
  </div>
  <span id="mail-content--title">Sign up to our Mailing List to Receive Spring Sale Discount Code</span>

  <div id="mail-content--container">
    <?php
    wp_reset_postdata();

  $page_query = new WP_Query(array(
    'post_type'=>'post',
    'post_title'=>'MCFWP',
  ));
  if($page_query->have_posts()){
    $page_query->the_post();
    the_content();
  }
  wp_reset_postdata();
    ?>
  </div>
  </div>
  <?php
}
