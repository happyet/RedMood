<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="search-field" placeholder="Search &hellip;" value="<?php echo get_search_query(); ?>" name="s" required="required"/>
	<button type="submit" class="search-submit"><?php echo _x( 'Search', 'submit button', 'twentysixteen' ); ?></button>
</form>