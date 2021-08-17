<?php

function get_lesson_list_page(){
  $lessons_query = new WP_Query( array(
    'post_type'=>'lessons',
    'post_status'=>'publish',
    'posts_per_page'=>-1,
    'meta_query'=>array(
      'active_clause'=>array(
        'key'=>'active',
        'value'=>1,
        'type'=>'numeric'
      ),
      'level_clause'=>array(
        'key'=>'level',
        'value'=>0,
        'compare'=>'>',
        'type'=>'numeric'
      ),
      'type_clause'=>array(
        'key'=>'type',
        'value'=>'a',
        'compare'=>'!='
      ),
      'number_clause'=>array(
        'key'=>'number_in_group',
        'value'=>0,
        'compare'=>'>',
        'type'=>'numeric',
      ),
      'group_clause'=>array(
        'key'=>'group',
        'value'=>'a',
        'compare'=>'!=',
      ),
    ),
    'orderby'=>array(
      'level_clause'=>'ASC',
      'type_clause'=>'ASC',
      'group_clause'=>'ASC',
      'number_clause'=>'ASC',
    )
  ) );
    wp_reset_postdata();

  if ( $lessons_query->have_posts() ) {
  	echo '<ul>';
    $type = '';
    $level = '';
    $group = '';
  	while ( $lessons_query->have_posts() ) {
  		$lessons_query->the_post();
      if($level != get_field('level')){?>
        <h2>Level:<?php echo get_field('level'); ?></h2>
        <h3>Type:<?php echo get_field('type'); ?></h3>
        <h4>Group:<?php echo get_field('group');?></h4>
    <?php }
      elseif($type != get_field('type')){?>
        <h3>Type:<?php echo get_field('type'); ?></h3>
        <h4>Group:<?php echo get_field('group');?></h4>
    <?php }
      elseif($group != get_field('group')){?> <h4>Group:<?php echo get_field('group');?></h4>
    <?php }
      $level = get_field('level');
      $type = get_field('type');
      $group = get_field('group');
      ?>
      <li>
        <span> No:<?php echo get_field('number_in_group');?></span>
        <span> Active:<?php echo get_field('active');?></span>
  		<a href="<?php echo site_url('lesson/?num=') . get_the_id() ?>"><?php echo get_the_title() ?> </a><br>
    </li>
      <?php
  	}
  	echo '</ul>';

  } else {
  	echo 'no lessons found';
  }

}

function get_page_list(){
  $page_query = new WP_Query(array(
    'post_type'=>'page',
    'post_status'=>'publish',
    'posts_per_page'=>-1
  ));
wp_reset_postdata();
?>
    <ul>
      <?php
  while($page_query->have_posts()){
        $page_query->the_post();
    ?>
    <li>
      <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title();?></a>
    </li>
    <?php
  }
  ?>
</ul>
<?php
}

function get_vis_list(){
  return get_list('visualisations', 'visualisation');
}

function get_rem_list(){
  return get_list('remember', 'remember');
}


//can user for remember and vis
function get_list($type,$url){
  $visualisations_query = new WP_Query( array(
    'post_type'=>$type,
    'post_status'=>'publish',
    'posts_per_page'=>-1,
    'meta_query'=>array(
      'relation'=>'AND',
      'active_clause'=>array(
                          'key'=>'active',
                          'value'=>1,
                        ),
      'level_clause'=>array(
                        'key'=>'level',
                        'value'=>0,
                        'compare'=>'>',
                        'type'=>'numeric',
                        ),
      'number_clause'=>array(
                        'key'=>'number_in_set',
                        'value'=>0,
                        'compare'=>'>',
                        'type'=>'numeric',
                        ),
    ),
    'orderby'=>array(
      'level_clause' =>'ASC',
      'number_clause'=> 'ASC')
  ) );
wp_reset_postdata();
  if ( $visualisations_query->have_posts() ) {
    echo '<ul>';
    while ( $visualisations_query->have_posts() ) {
      $visualisations_query->the_post();?>
      <li class="list--item">
        <span class="list--item__level">Level:<?php echo get_field('level');?></span>
        <span class="list--item__number">No:<?php echo get_field('number_in_set');?></span>
      <a href="<?php echo site_url($url . '/?num=') . get_the_id() ?>"><?php echo get_the_title() ?> </a>
    </li>
      <?php
    }
    echo '</ul>';

  } else {
    echo 'no [' .  $type . '] found';
  }
}
