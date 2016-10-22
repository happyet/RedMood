<?php get_header(); ?>
	<div class="main">
		<div class="container clearfix">
			<main class="content" role="main">
				<?php if (have_posts()) : ?>
					<div class="breadcrumb">
						<span class="genericon genericon-location"></span> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">首页</a><em>/</em><?php the_category(', ') ?><em>/</em><?php the_title(); ?>
					</div>
					<?php while (have_posts()) : the_post(); ?>
						<article class="hentry clearfix">
							<header class="hentry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
								<div class="post-meta entry-meta">
									<span class="genericon genericon-month"></span><?php the_time('Y-m-d') ?>
									<span class="genericon genericon-category"></span><?php the_category(', ') ?>
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
							<footer class="entry-footer">
								<div class="dianp alignright"><span class="genericon genericon-digg"></span> +10086</div>
								<?php the_tags( '<p><span class="genericon genericon-tag"></span> ', ', ', '</p>'); ?>
								<div class="author-info">
									<div class="author-avatar">
										<?php
											$author_bio_avatar_size = apply_filters( 'twentysixteen_author_bio_avatar_size', 60 );
											echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
										?>
									</div>

									<div class="author-description">
										<h2 class="author-title"><a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a></h2>

										<p class="author-bio">
											<?php the_author_meta( 'description' ); ?>											
										</p>
									</div>
								</div>
							</footer>
						</article>
						<?php
							the_post_navigation( array(
								'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentysixteen' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'twentysixteen' ) . '</span> ' .
									'<span class="post-title">%title</span>',
								'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentysixteen' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'twentysixteen' ) . '</span> ' .
									'<span class="post-title">%title</span>',
							) );
							if( comments_open() || get_comments_number() ) comments_template();
						?>
					<?php endwhile; ?>
				<?php endif; ?>
			</main>
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php get_footer(); ?>