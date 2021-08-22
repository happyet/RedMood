<?php get_header(); ?>
<div class="container">
	<div class="row">
		<main class="content col-lg-8" role="main">
			<div class="breadcrumb">
				<span class="genericon genericon-location"></span> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">首页</a><em>/</em>404 - page not found.
			</div>
			<article class="hentry 404-notfound">
				<h2 class="text-center" style="font-size:20px;padding: 25px 0;"><?php _e('Error 404 - Not Found'); ?></h2>
				<div class="entry-content">
					<div class="row justify-content-md-center">
						<div class="col col-lg-8"><?php include (TEMPLATEPATH . "/searchform.php"); ?></div>
					</div>
				</div>
			</article>
			
		</main>
		
		<?php get_sidebar(); ?>
		
	</div>
</div>
<?php get_footer(); ?>