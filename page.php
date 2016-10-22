<?php get_header(); ?>
	<div class="main">
		<div class="container clearfix">
			<main class="content" role="main">
				<?php if (have_posts()) : ?>
					<div class="breadcrumb">
						<span class="genericon genericon-location"></span> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">首页</a><em>/</em>页面<em>/</em><?php the_title(); ?>
					</div>
					<?php while (have_posts()) : the_post(); ?>
						<article class="hentry clearfix">
							<header class="hentry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
								<div class="post-meta entry-meta">
									<span class="genericon genericon-month"></span><?php the_time('Y-m-d') ?>
									<?php edit_post_link(__('Edit'), '<span>','</span>'); ?>
									<span class="genericon genericon-show"></span><?php echo lmsim_theme_views(); ?>
									<span class="genericon genericon-comment"></span><?php comments_popup_link('0', '1', '%', '', 'Comments Closed' ); ?>
								</div>
							</header>
							<?php if ( has_post_thumbnail() ) { ?>
								<div class="post-thumbnail"><?php the_post_thumbnail('full'); ?></div>
							<?php } ?>
							<div class="entry-content">
								<?php
									the_content();

									wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
										'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
										'separator'   => '<span class="screen-reader-text">, </span>',
									) );
								?>
							</div>
						</article>
						<?php
							if( comments_open() || get_comments_number() ) comments_template();
						?>
					<?php endwhile; ?>
				<?php endif; ?>
			</main>
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php get_footer(); ?>