<?php if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-4' ) ) { ?>
<aside class="footer-widgets" role="complementary">
	<div class="container">
		<div class="row">
			<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-3' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
				<div class="widget-area">
					<?php dynamic_sidebar( 'sidebar-4' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</aside>
<?php } ?>
<footer class="footer">
	<div class="container">
		<p>
			&copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>/"><?php bloginfo('name'); ?></a> All Rights Reserved<br /><?php
				$icp_bei = get_option( 'zh_cn_l10n_icp_num' );
				if($icp_bei) echo '<a href="http://www.miitbeian.gov.cn/" target="_blank" rel="nofollow" title="工业和信息化部ICP/IP地址/域名信息备案管理系统">' .	esc_attr( get_option( 'zh_cn_l10n_icp_num' ) ) . '</a>';
			?> 主题由 <a href="https://lms.im/" target="_blank" title="自娱自乐，不亦乐乎！" rel="nofollow">LMS</a> 倾情制作
		</p>
	</div>
</footer>
<div class="go-top">
	<span class="genericon genericon-collapse"></span>
</div>
</div>
</div>
<?php ?>

		<?php wp_footer(); ?>
</body>
</html>