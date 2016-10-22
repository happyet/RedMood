<?php
require get_template_directory() . '/inc/customizer.php';
function lmsim_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array(
		'height'      => 75,
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
	add_editor_style( 'css/editor-style.css' );
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'lmsim_setup' );

function lmsim_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'lmsim' ),
		'id'            => 'sidebar-1',
		'description'   => __( '右侧边栏小工具，使用日历请填写标题，否则会出错。', 'lmsim' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2><div class="widget-box">',
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
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );
	wp_enqueue_style( 'lmsim-style', get_stylesheet_uri() );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'lmsim-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160816' );
	}
	wp_enqueue_script( 'lmsim-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160816', true );
	wp_localize_script( 'lmsim-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'lmsim' ),
		'collapse' => __( 'collapse child menu', 'lmsim' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'lmsim_scripts' );

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
  $contactmethods['notice']  = '公告';
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
  	$imgsrc = get_template_directory_uri() . '/images/rand/' . $random . '.jpg';
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