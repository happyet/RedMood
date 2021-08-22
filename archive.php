<?php get_header(); ?>
<div class="container">
	<div class="row">
		<main class="content col-lg-8" role="main">
			<?php if (have_posts()) : ?>
				<div class="breadcrumb">
					<?php
						if ( is_category() ) {
	   						$type = '分类';
					  	} elseif ( is_tag() ) {
						    $type = '标签';
						} elseif ( is_author() ) {
						    $type = '作者';
						} elseif ( is_year() ) {
						    $type = '年份';
						} elseif ( is_month() ) {
						    $type = '月份';
						} elseif ( is_day() ) {
						    $type = '日期';
						} elseif ( is_tax( 'post_format' ) ) {
						  	$type = '形式';
						} elseif ( is_post_type_archive() ) {
						    $type = '类型';
						} elseif ( is_tax() ) {
						    $type = '标签';
						} else {
						    $type = '';
						}
					?>
					<span class="genericon genericon-location"></span> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">首页</a><em>/</em><?php if($type) echo $type . '<em>/</em>'; ?><?php the_archive_title() ?>
				</div>
				<header class="archive-header">
					<?php
						the_archive_title( '<h1 class="archive-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header>
				<?php $i = 1; while (have_posts()) : the_post(); ?>
					<article class="hentry archive-entry<?php echo ($i % 2 === 0 ) ? ' even':''; ?>">
						<?php if($i % 2 <> 0 ): ?>
							<div class="post-thumb col-md-3">
								<a href="<?php the_permalink(); ?>" style="background-image:url(<?php echo lmsim_thumbnail_src(); ?>);"></a>
							</div>
						<?php endif; ?>
						<div class="post-content col-md-9">
							<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
							<div class="excerpt">
								<?php the_excerpt(); ?>
							</div>
							<div class="post-meta">
								<span class="genericon genericon-month"></span><?php the_time('Y-m-d') ?>
								<span class="genericon genericon-category"></span><?php the_category(', ') ?>
								<span class="genericon genericon-show"></span><?php echo lmsim_theme_views(); ?>
								<span class="genericon genericon-comment"></span><?php comments_popup_link('0', '1', '%', '', 'Comments Closed' ); ?>
							</div>
						</div>
						<?php if($i % 2 === 0 ): ?>
							<div class="post-thumb col-md-3">
								<a href="<?php the_permalink(); ?>" style="background-image:url(<?php echo lmsim_thumbnail_src(); ?>);"></a>
							</div>
						<?php endif; ?>
					</article>
				<?php $i++; endwhile; ?>
				<?php
					the_posts_pagination( array(
						'prev_text'          => __( 'Previous page', 'twentysixteen' ),
						'next_text'          => __( 'Next page', 'twentysixteen' ),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
					) );
				?>
			<?php else : ?>
				<h2 class="center"><?php _e('Not Found'); ?></h2>
				<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.'); ?></p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			<?php endif; ?>
		</main>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>