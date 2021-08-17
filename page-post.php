<?php
get_header();

$url = $_SERVER['REQUEST_URI'];
$id = substr($url, strpos($url, '?id=') + 4);


$post_query = new WP_Query(array(
  'p'=>$id,
  'post_type'=>'post'
));

if($post_query->have_posts()){
  $post_query->the_post();
?>
<div class="post__title"><?php echo get_the_title(); ?></div>
<div class="post__date"><?php echo get_the_date();?></div>
<div class="post__content"><?php the_content();?></div>
<?php
}

get_footer();
