<?php

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous">
</script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
	integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
	crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site grey1-bg">
	<div id="loading-display" class="loading-display"></div>
<header class="header">
	<div class="header--content">
	<div class="header--logo">
		<a href="
		<?php if(get_current_user_id()>0) echo site_url('/dashboard');
		else echo site_url();
		?>
		">100/1 Chess</a>
	</div>
	<nav class="nav" role="navigation">
				<ul id="nav--login" class="nav--login">
	<?php
		getBlogButtonHtml();
	if(get_current_user_id()>0){
		getReviewbuttonHtml(get_current_user_id());
		getProfileButtonHtml();
		get_header_nav_logout_button();
 }else{
	 get_header_nav_register_button();
	 get_header_nav_login_button();
} ?>
</ul>
</nav>
</div>
</header>
	<div id="content" class="site-content grey1-bg">
