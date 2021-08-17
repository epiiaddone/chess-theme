<?php
get_header();
?>
<div class="blog">
<div class="blog__title">Blog</div>


<?php

$posts_query = new WP_Query(array(
  'post_status'=>'publish',
  'post_per_page'=>-1,
  'author'=>1,
  'post_type'=>'post'
));

wp_reset_postdata();
?>

<div class="blog__list">

<?php
while($posts_query->have_posts()){
  $posts_query->the_post();
  ?>
  <div class="blog__list--item">
  <a class="blog__link" href="<?php echo '/post' .'?id=' . get_the_id()?>"><?php the_title();?></a>
  <div class="blog__date"><?php echo get_the_date(); ?></div>
</div>
  <?php
}

 ?>
</div>
</div>

<?php
get_footer();
