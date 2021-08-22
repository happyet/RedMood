<?php get_header(); ?>
<div class="container">
	<div class="row">
  		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		  	<main class="content col-lg-9" role="main">
				<div class="breadcrumb">
					<span class="genericon genericon-location"></span> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">首页</a><em>/</em>附件<em>/</em><?php the_title(); ?>
				</div>
				<article class="attach-entry" style="text-align:center">
					<p class="attachment"><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a></p> 
					<div class="caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></div>

					<?php the_content('<p class="serif">' . __('Read the rest of this entry &raquo;', 'kubrick') . '</p>'); ?>

					<?php wp_link_pages(array('before' => '<p><strong>' . __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				</article>
				<div class="navigation" style="display:flex">
					<div style="width:50%"><?php previous_image_link() ?></div>
					<div style="width:50%"><?php next_image_link() ?></div>
				</div>

				<?php comments_template(); ?>
			</main>
			<aside class="postmetadata col-lg-3">
					<small>
						<?php printf(__('This entry was posted on %1$s at %2$s and is filed under %3$s.', 'kubrick'),  get_the_time(__('l, F jS, Y', 'kubrick')), get_the_time(), get_the_category_list(', ')); ?>
						<?php the_taxonomies(); ?>
						<?php edit_post_link(__('Edit this entry.', 'kubrick'),'',''); ?>

					</small>
			</aside>
		<?php endwhile; endif; ?>						
	</div>
</div>

<?php get_footer(); ?>
