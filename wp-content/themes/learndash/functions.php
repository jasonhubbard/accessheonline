<?php
/**
 * nmbs functions and definitions
 *
 * @package nmbs
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'nmbs_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function nmbs_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on nmbs, use a find and replace
	 * to change 'nmbs' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'nmbs', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * Add featured image for pages&posts
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nmbs' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	

}
endif; // nmbs_setup
add_action( 'after_setup_theme', 'nmbs_setup' );

/**
 * nmbs_scripts_styles
 */
function nmbs_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'nmbs-theme', get_template_directory_uri() . '/js/nmbs.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'nmbs-child-theme', get_template_directory_uri() . '/js/nmbschild.js', array('jquery'), '1.0', true );

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'nmbs' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'nmbs' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800',
			'subset' => $subsets,
		);
		wp_enqueue_style( 'nmbs-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}
	
	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array( 'nmbs-style'));
	wp_enqueue_style( 'icomoon-icons', get_template_directory_uri() . '/css/icons.css', array( 'nmbs-style'));
	wp_enqueue_style( 'nmbs-css', get_template_directory_uri() . '/css/nmbs.css', array( 'nmbs-style'));
	wp_enqueue_style( 'nmbs-child-style',  get_template_directory_uri() . '/css/nmbschild.css');

	wp_enqueue_style( 'nmbs-style', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'nmbs_scripts_styles' );

/**
 * For IE
 */
function nmbs_scripts_ie() {
	?>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js" type="text/javascript"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js" type="text/javascript"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/lte-ie7.js" type="text/javascript"></script>
	<![endif]-->
	<?php
}
add_action( 'wp_head', 'nmbs_scripts_ie' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function nmbs_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Widgets area for head on home page', 'nmbs' ),
		'description' 	=> __( '' ),
		'id'            => 'sidebar-0',
		'class'         => 'nav nav-pills nav-stacked',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar', 'nmbs' ),
		'description' 	=> __( '' ),
		'id'            => 'sidebar-1',
		'class'         => 'nav nav-pills nav-stacked',
		'before_widget' => '<aside id="%1$s" class="widget %2$s panel panel-default"><div class="panel-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar for single courses', 'nmbschild' ),
		'description' 	=> __( '' ),
		'id'            => 'sidebar-2',
		'class'         => 'nav nav-pills nav-stacked',
		'before_widget' => '<aside id="%1$s" class="widget %2$s panel panel-default"><div class="panel-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer widgets area', 'nmbschild' ),
		'description' 	=> __( '' ),
		'id'            => 'sidebar-3',
		'class'         => 'nav nav-pills nav-stacked',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'nmbs_widgets_init' );

/**
 * Image sizes
 */
if ( function_exists( 'add_theme_support' ) ) {
	//add_theme_support( 'post-thumbnails' );
	update_option('thumbnail_size_w', 140);
	update_option('thumbnail_size_h', 140);
	update_option('medium_size_w', 380);
	update_option('medium_size_h', 214);
	update_option('medium_crop', '1');
// additional image sizes
// delete the next line if you do not need additional image sizes
	add_image_size( 'featured-thumb', 945, 345, true ); //(cropped)
	add_image_size( 'gallery-thumb', 390, 390, true ); //(cropped)
	add_image_size( 'category', 400, 300, true ); //(cropped)
	add_image_size( 'course-thumb', 300, 200, true ); //(cropped)
}


/**
 * all post types
 */
function all_post_types($q) {
	$vars = $q->query_vars;
	$is_category = isset($vars['category_name']) && $vars['category_name'] || isset($vars['category']) && $vars['category'];
	if($is_category)
		$q->set('post_type', 'any');
}
add_action( 'pre_get_posts', 'all_post_types');


/**
 * limit posts per page
 */
function limit_posts_per_page() {
	if ( is_category() )
		return 9;
	else
		return 9; // default: 5 posts per page
}
add_filter('pre_option_posts_per_page', 'limit_posts_per_page');

/**
 * Implement menu walker.
 */
require_once( get_template_directory() . '/inc/nav-menu-walker.php' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Shortcodes
 */
require get_template_directory() . '/inc/theme-shortcodes.php';

/**
 * Theme options
 */
require get_template_directory() . '/inc/theme-options.php';



/**
 * slider metabox
 */
require_once( get_template_directory() . '/inc/slider-metabox.php' );

/**
 * Home options (only on theme-child)
 */
require get_template_directory() . '/inc/home-options.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/theme-widgets.php';