<?php
require get_template_directory() . '/inc/customizer.php';
function lmsim_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array(
		'height'      => 61,
		'width'       => 240,
		'flex-height' => true,
	) );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 210, 210, array( 'center', 'center') );
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'lmsim' ),
		'social'  => __( 'Social Links Menu', 'lmsim' ),
	) );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );
	add_editor_style( 'static/css/editor-style.css' );
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'lmsim_setup' );

function lmsim_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'lmsim' ),
		'id'            => 'sidebar-1',
		'description'   => __( '右侧边栏小工具，使用日历请填写标题，否则会出错。', 'lmsim' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Top 1', 'lmsim' ),
		'id'            => 'sidebar-2',
		'description'   => __( '页面底部小工具 1.', 'lmsim' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Top 2', 'lmsim' ),
		'id'            => 'sidebar-3',
		'description'   => __( '页面底部小工具 2.', 'lmsim' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Top 3', 'lmsim' ),
		'id'            => 'sidebar-4',
		'description'   => __( '页面底部小工具 3.', 'lmsim' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
}
add_action( 'widgets_init', 'lmsim_widgets_init' );

function lmsim_scripts() {
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/static/genericons/genericons.css', array(), '3.4.1' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/static/css/bootstrap-grid.min.css', array(), '5.0.2' );
	wp_enqueue_style( 'lmsim', get_stylesheet_uri() );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'lmsim-keyboard-image-navigation', get_template_directory_uri() . '/static/js/keyboard-image-navigation.js', array( 'jquery' ), '20160816' );
	}
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/static/js/bootstrap.min.js', array(), '5.0.2', true );
	wp_enqueue_script( 'lmsim', get_template_directory_uri() . '/static/js/functions.js', array( 'jquery' ), '2.0', true );
	wp_localize_script( 'lmsim', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'lmsim' ),
		'collapse' => __( 'collapse child menu', 'lmsim' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'lmsim_scripts' );
function get_cravatar_url( $url ) {
    $sources = array(
        'www.gravatar.com',
        '0.gravatar.com',
        '1.gravatar.com',
        '2.gravatar.com',
        'secure.gravatar.com',
        'cn.gravatar.com'
    );
    return str_replace( $sources, 'cravatar.cn', $url );
}
add_filter( 'get_avatar_url', 'get_cravatar_url', 1 );
function lmsim_record_views(){
  if (is_singular()) {
    global $post, $user_ID;
    $post_ID = $post->ID;
    if (empty($_COOKIE[USER_COOKIE]) && intval($user_ID) == 0) {
      if ($post_ID) {
        $post_views = (int) get_post_meta($post_ID, 'views', true);
        if (!update_post_meta($post_ID, 'views', ($post_views + 1))) {
          add_post_meta($post_ID, 'views', 1, true);
        }
      }
    }
  }
}
add_action('wp_head', 'lmsim_record_views');

function lmsim_post_views($echo = true, $before = '', $after = ''){
  global $post;
  $post_ID = $post->ID;
  $views   = number_format((int) get_post_meta($post_ID, 'views', true));
  if ($echo) {
    echo $before, $views, $after;
  } else {
    return $views;
  }
}

function lmsim_theme_views(){
  if (function_exists('the_views')) {
    return the_views(false);
  } else {
    return lmsim_post_views(false);
  }
}

function lms_auto_excerpt_more( $more ) {
        return ' &hellip;';
}
add_filter( 'excerpt_more', 'lms_auto_excerpt_more' );

function lmsim_widget_tag_cloud_args( $args ) {
	$args['largest'] = 12;
	$args['smallest'] = 12;
	$args['unit'] = 'px';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'lmsim_widget_tag_cloud_args' );

function lmsim_custom_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$description = get_bloginfo( 'description', 'display' );
	if($custom_logo_id){
		$html = sprintf(
			'<div class="logo img-logo"><a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a></div>',
			esc_url( home_url( '/' ) ),
			wp_get_attachment_image( $custom_logo_id, 'full', false, array(
				'class'    => 'custom-logo',
				'itemprop' => 'logo',
				'alt'			 => get_bloginfo( 'name' ),
				'title'		 => $description
			) )
		);
	}else{
		$html = '<div class="logo text-logo"><h1><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a></h1>';
		if ( $description || is_customize_preview() )
			$html .= '<p class="site-description">' . $description . '</p>';
		$html .= '</div>';
	}
	echo $html;
}

function add_remove_contactmethods($contactmethods){
  $contactmethods['twitter'] = 'Twitter';
  $contactmethods['github'] = 'Github';
  $contactmethods['facebook'] = 'Facebook';
  $contactmethods['instagram']  = 'Instagram';
  $contactmethods['shang']  = '求赏二维码';
  if( current_user_can ('manage_options') ) $contactmethods['notice']  = '一句话公告';
  // Remove Contact Methods
  unset($contactmethods['aim']);
  unset($contactmethods['yim']);
  unset($contactmethods['jabber']);

  return $contactmethods;
}
add_filter('user_contactmethods', 'add_remove_contactmethods', 10, 1);

function lmsim_thumbnail_src() {
	global $post;
	ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	if(has_post_thumbnail()) {
    $thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(),'post-thumbnail');
    $imgsrc = $thumb_src[0];
  }elseif($output > 0){
  	$imgsrc = $matches[1][0];
  }else{
  	$random = mt_rand(1, 10);
  	$imgsrc = get_template_directory_uri() . '/static/images/rand/' . $random . '.jpg';
  }
  return $imgsrc;
}

function lmsim_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}
	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('pre_post_update', 'wp_save_post_revision');
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );	
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_action('pre_ping', 'lmsim_noself_ping');
add_filter('show_admin_bar', 'hide_admin_bar');
add_filter('pre_get_posts', 'search_filter_page');
add_filter('use_default_gallery_style', '__return_false');
add_filter('pre_option_link_manager_enabled', '__return_true');
add_filter( 'tiny_mce_plugins', 'classic_smilies_rm_tinymce_emoji' );
function classic_smilies_rm_tinymce_emoji( $plugins ) {
	return array_diff( $plugins, array( 'wpemoji' ) );
}
function hide_admin_bar($flag){
  return false;
}
function lmsim_noself_ping(&$links){
  $home = get_option('home');
  foreach ($links as $l => $link) {
    if (0 === strpos($link, $home)) {
      unset($links[$l]);
    }
  }
}
function search_filter_page($query){
  if ($query->is_search) {
    $query->set('post_type', 'post');
  }
  return $query;
}
function comment_links_in_new_tab($text) {
	$return = str_replace('<a', '<a target="_blank"', $text);
	return $return;
}
add_filter('get_comment_author_link', 'comment_links_in_new_tab');
function lmsim_custom_archive_title() {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  } elseif ( is_author() ) {
    $title = get_the_author();
  } elseif ( is_year() ) {
    $title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
  } elseif ( is_month() ) {
    $title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
  } elseif ( is_day() ) {
    $title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
  } elseif ( is_tax( 'post_format' ) ) {
    if ( is_tax( 'post_format', 'post-format-aside' ) ) {
      $title = _x( 'Asides', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
      $title = _x( 'Galleries', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
      $title = _x( 'Images', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
      $title = _x( 'Videos', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
      $title = _x( 'Quotes', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
      $title = _x( 'Links', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
      $title = _x( 'Statuses', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
      $title = _x( 'Audio', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
      $title = _x( 'Chats', 'post format archive title' );
    }
  } elseif ( is_post_type_archive() ) {
    $title = post_type_archive_title( '', false );
  } elseif ( is_tax() ) {
    $title = single_term_title( '', false );
  } else {
    $title = __( 'Archives' );
  }
  return $title;
}
add_filter('get_the_archive_title', 'lmsim_custom_archive_title');
/*
默认侧栏最新评论排除博主
查看wp-includes/comment.php中WP_Comment_Query::query部分
根据传入参数完善查询条件
*/
add_filter( 'comments_clauses', 'wpdit_comments_clauses', 2, 10);
function wpdit_comments_clauses( $clauses, $comments ) {
    global $wpdb;
    if ( isset( $comments->query_vars['not_in__user'] ) && ( $user_id = $comments->query_vars['not_in__user'] ) ) {
         
        if ( is_array( $user_id ) ) {
            $clauses['where'] .= ' AND user_id NOT IN (' . implode( ',', array_map( 'absint', $user_id ) ) . ')';
        } elseif ( '' !== $user_id ) {
            $clauses['where'] .= $wpdb->prepare( ' AND user_id <> %d', $user_id );
        }
    }
    //var_dump($clauses);
    return $clauses;
}
/*
默认侧栏最新评论排除博主
详细查看wp-includes/default-widgets.php中 WP_Widget_Recent_Comments 部分
增加参数not_in__user
*/
add_filter( 'widget_comments_args', 'wpdit_widget_comments_args' );
function wpdit_widget_comments_args( $args ){
    $args['not_in__user'] = array(1); //这里放你的ID；
    return $args;
}
/**new comments widget */
class lms_recentcomments extends WP_Widget {
	function __construct() {
		parent::__construct(
			'lms-recentcomments', // ID.
			esc_html__( 'LMS-最新评论' ), // Name.
			array(
				'classname' => 'widget_recentcomments',
				'description' => esc_html__( '显示带头像最新评论。' ),
				'customize_selective_refresh' => true,
			)
		);
	}
	function widget( $args, $instance ) {
		ob_start();
		$title = apply_filters( 'widget_title', $instance['title'] );
		$exclude_admin = $instance['exclude_admin'];
		$limit_number = $instance['limit_number'];
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		$recent_comments_cache = '';

			$comments_args = array(
				'type' 				=> 'comment',
				'status'			=> 'approve',
				'post_status'		=> 'publish',
				'author__not_in' 	=> $exclude_admin,
				'number'  			=> $limit_number
			);
			$recent_comments = get_comments($comments_args);
			if($recent_comments){
				$recent_comments_cache = '<ul>';
					foreach($recent_comments as $rc_comment):
						$recent_comments_cache .= '<li><div class="rc-avatar">'.get_avatar($rc_comment->comment_author_email, 45).'</div>
							<div class="rc-comment">	
								<div class="rc-comment-meta">
									<span class="author">'.$rc_comment->comment_author.'</span>
									<span class="date">'.$rc_comment->comment_date.'</span>
								</div>
								<p><a href="'.get_comment_link($rc_comment->comment_ID).'">'. wp_trim_words($rc_comment->comment_content,28).'...</a></p>
							</div>
						</li>';
					endforeach; 
				$recent_comments_cache .= '</ul>';
			}
		
		echo $recent_comments_cache;
		echo $args['after_widget'];
		// End Output Buffering.
		ob_end_flush();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['exclude_admin'] = (int) $new_instance['exclude_admin'];
		$instance['limit_number'] = (int) $new_instance['limit_number'];
		return $instance;
	}
	function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '最新评论';
		$exclude_admin = ! empty( $instance['exclude_admin'] ) ? $instance['exclude_admin'] : '1';
		$limit_number = ! empty( $instance['limit_number'] ) ? $instance['limit_number'] : '5';
		?>
		<p>
 			<label for="<?php echo $this->get_field_id( 'title'); ?>"><?php esc_html_e( '标题:' ); ?></label>
 			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_admin' ); ?>"><?php esc_html_e( '排除作者ID:' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'exclude_admin' ); ?>" name="<?php echo $this->get_field_name( 'exclude_admin' ); ?>" value="<?php echo esc_attr( $exclude_admin ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'limit_number' ); ?>"><?php esc_html_e( '显示评论数量:' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'limit_number' ); ?>" name="<?php echo $this->get_field_name( 'limit_number' ); ?>" value="<?php echo esc_attr( $limit_number ); ?>" />
		</p>

		<?php
	}
}
function lms_register_recentcomments_widget() {
	register_widget( 'lms_recentcomments' );
}
add_action( 'widgets_init', 'lms_register_recentcomments_widget' );
/**new POSTs widget */
class lms_recentposts extends WP_Widget {
	function __construct() {
		parent::__construct(
			'lms-recentposts', // ID.
			esc_html__( 'LMS-最新文章' ), // Name.
			array(
				'classname' => 'widget_recentposts',
				'description' => esc_html__( '自定义最新文章。' ),
				'customize_selective_refresh' => true,
			)
		);
	}
	function widget( $args, $instance ) {
		ob_start();
		$title = apply_filters( 'widget_title', $instance['title'] );
		$exclude_cat = $instance['exclude_cat'];
		$limit_number = $instance['limit_number'];
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];
		$post_args = array(
			'posts_per_page'  	=> absint($limit_number),
			'ignore_sticky_posts' => true,
			'no_found_rows'		=> true
		);
		if($exclude_cat) $post_args['category__not_in'] = $exclude_cat;
		$recent_posts = get_posts($post_args);
		if($recent_posts){
			echo '<ul>';
				global $post;
				foreach($recent_posts as $post): setup_postdata( $post ); ?>
					<li>
						<div class="rc-post-thumb"><a href="<?php the_permalink(); ?>" style="background-image:url(<?php echo lmsim_thumbnail_src(); ?>);"></a></div>
						<div class="rc-post-head">
							<h4><a class="text-link stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<div class="rc-post-meta">
								<span><?php the_category(' '); ?></span>
								<span><?php the_time('Y-m-d'); ?></span>
								<span><i class="genericon genericon-comment"></i><?php echo get_comments_number(); ?></span>
							</div>
						</div>
					</li>
				<?php endforeach; wp_reset_postdata();
			echo '</ul>';
		}
		echo $args['after_widget'];
		// End Output Buffering.
		ob_end_flush();
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['exclude_cat'] = (int) $new_instance['exclude_cat'];
		$instance['limit_number'] = (int) $new_instance['limit_number'];
		return $instance;
	}
	function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '最新文章';
		$exclude_cat = ! empty( $instance['exclude_cat'] ) ? $instance['exclude_cat'] : '';
		$limit_number = ! empty( $instance['limit_number'] ) ? $instance['limit_number'] : '5';
		?>
		<p>
 			<label for="<?php echo $this->get_field_id( 'title'); ?>"><?php esc_html_e( '标题:' ); ?></label>
 			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_cat' ); ?>"><?php esc_html_e( '排除分类ID:' ); ?></label>
			<?php
				$args = array(
					'show_option_all'    => esc_html__( '所有分类' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $exclude_cat,
					'name'               => $this->get_field_name( 'exclude_cat' ),
					'id'                 => $this->get_field_id( 'exclude_cat' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'limit_number' ); ?>"><?php esc_html_e( '显示文章数量:' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'limit_number' ); ?>" name="<?php echo $this->get_field_name( 'limit_number' ); ?>" value="<?php echo esc_attr( $limit_number ); ?>" />
		</p>

		<?php
	}
}
function lms_register_recentposts_widget() {
	register_widget( 'lms_recentposts' );
}
add_action( 'widgets_init', 'lms_register_recentposts_widget' );