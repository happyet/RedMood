<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="site-main">
<header class="header" role="banner">
	<div class="container">
		<div class="toggle-menu"><span class="genericon genericon-menu"></span></div>
		<?php lmsim_custom_logo(); ?>
		<div class="head-search">
			<?php get_search_form(); ?>
		</div>
		<div class="toggle-search"><span class="genericon genericon-search"></span></div>
	</div>
</header>
<nav class="nav" role="navigation">
	<div class="container">
		<?php 
			if ( has_nav_menu( 'primary' ) ) :
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class'     => 'primary-menu',
					'depth'					 => 2
			 ) );
			endif;
		?>
	</div>
</nav>
<div class="nav-bottom">
	<div class="container">
		<?php 
			$notice = get_the_author_meta( 'notice', 1 );
			if($notice) {
				echo '<p><span class="genericon genericon-audio"></span> ' . $notice .'</p>';
			}else{
				echo '<p><span class="genericon genericon-audio"></span> 公告在后台个人资料页面处更改。</p>';
			}
		?>
		<div class="alignright">
			<?php 
				$github = get_the_author_meta( 'github', 1 );
				if($github) echo '<a href="' . $github . '"><span class="genericon genericon-github"></span></a>'; 
			?>
			<?php 
				$twitter = get_the_author_meta( 'twitter', 1 );
				if($twitter) echo '<a href="' . $twitter . '"><span class="genericon genericon-twitter"></span></a>';
			?>
			<?php
				$facebook = get_the_author_meta( 'facebook', 1 );
				if($facebook) echo '<a href="' . $facebook . '"><span class="genericon genericon-facebook-alt"></span></a>';
			?>
			<?php
				$instagram = get_the_author_meta( 'instagram', 1 );
				if($instagram) echo '<a href="' . $instagram . '"><span class="genericon genericon-instagram"></span></a>';
			?>
			<a href="mailto:<?php the_author_meta( 'email', 1 ); ?>"><span class="genericon genericon-mail"></span></a>
			<a href="<?php bloginfo('rss2_url'); ?>"><span class="genericon genericon-feed"></span></a>
		</div>
	</div>
</div>
<div class="main">