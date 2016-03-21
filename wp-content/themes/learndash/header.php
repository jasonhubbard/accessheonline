<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package nmbs
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php if(get_option('nmbs_favicon')) : ?>
<link rel="icon" type="image/png" href="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php echo get_option('nmbs_favicon'); ?>&h=16&w=16">
<?php endif; ?>
<?php if(get_option('nmbs_meta_description')) : ?>
<meta name="description" content="<?php echo get_option('nmbs_meta_description'); ?>">
<?php endif; ?>
<?php if(get_option('nmbs_meta_keywords')) : ?>
<meta name="keywords" content="<?php echo get_option('nmbs_meta_keywords'); ?>">
<?php endif; ?>
<?php wp_head(); ?>

<?php if(get_option('nmbs_analytics')) : ?>
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo get_option("nmbs_analytics"); ?>']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
<?php endif; ?>

<style type="text/css">
	.jumbotron.page-header{
		background-color: <?php echo get_option('nmbs_header_background'); ?>;
	}
	.jumbotron.page-header h1,
	.jumbotron.page-header p{
		color: <?php echo get_option('nmbs_header_color'); ?>;
		<?php if(get_option('nmbs_header_img')) : ?>
		text-shadow: 0 2px 3px rgba(0,0,0,0.5);
		<?php endif; ?>
	}
	<?php if(get_option('nmbs_header_img')) : ?>
	.jumbotron.page-header .btn{		
		box-shadow: 0 2px 3px rgba(0,0,0,0.5);
		-moz-box-shadow: 0 2px 3px rgba(0,0,0,0.5);
		-webkit-box-shadow: 0 2px 3px rgba(0,0,0,0.5);
	}
	<?php endif; ?>
	#colophon{
		background-color: <?php echo get_option('nmbs_footer_background'); ?>;
	}
	#colophon *{
		color: <?php echo get_option('nmbs_footer_color'); ?>;
	}
	.navbar-inverse {
		background-color: <?php echo get_option('nmbs_navigation_background'); ?>;
		border-color: rgba(0,0,0,0.2);
	}
	.navbar-inverse .navbar-nav>li>a,
	.navbar-inverse .navbar-nav>li>a:hover,
	.navbar-inverse .navbar-nav>li>a:focus {
		color: <?php echo get_option('nmbs_navigation_colors'); ?>;
	}
	.navbar-inverse .navbar-nav>.active>a,
	.navbar-inverse .navbar-nav>.active>a:hover, 
	.navbar-inverse .navbar-nav>.active>a:focus {
		color: <?php echo get_option('nmbs_selected_menu_text'); ?>;
		background-color: <?php echo get_option('nmbs_selected_menu_background'); ?>;;
	}
	.dropdown-menu {
		color: <?php echo get_option('nmbs_submenu_text'); ?>;
		background-color: <?php echo get_option('nmbs_submenu_background'); ?>;;
	}
	.dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus {
		color: <?php echo get_option('nmbs_submenu_text_hover'); ?>;
		background-color: <?php echo get_option('nmbs_submenu_background_hover'); ?>;;
	}
	.btn-primary {
		color: <?php echo get_option('nmbs_button_text_color'); ?>;
		background-color: <?php echo get_option('nmbs_button_color'); ?>;
		border-color: rgba(0,0,0,0.2);
	}
	.btn-primary:hover, 
	.btn-primary:focus,
	.btn-primary:active,
	.btn-primary.active,
	.open .dropdown-toggle.btn-primary {
		color: <?php echo get_option('nmbs_button_text_color'); ?>;
		background-color: <?php echo get_option('nmbs_button_hover_color'); ?>;
		border-color: rgba(0,0,0,0.2);
	}
	<?php if(get_option('nmbs_lessonstopics')) : ?>
	#learndash_lessons .learndash_topic_dots{		
		display:none!important;
	}
	<?php endif; ?>

	#main-slider .carousel-caption h3,
	#main-slider .carousel-caption p{
		color: <?php echo get_option('nmbs_slider_text_color'); ?>;
	}

</style>

</head>

<body <?php body_class(); ?>>

	<?php do_action( 'before' ); ?>

<header id="masthead" class="site-header" role="banner">

	<div class="container">
		<nav class="navbar navbar-inverse <?php echo get_option('nmbs_logo_size'); ?>" role="navigation">
			<div class="container">
				<div class="navbar-header">
				    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main">
				      <span class="sr-only">Toggle navigation</span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				    </button>

				    <?php if(get_option('nmbs_logo')) : ?>
				    <h1 class="navbar-brand image">
					    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					    	<img src="<?php bloginfo( 'template_directory' ); ?>/timthumb.php?src=<?php echo get_option('nmbs_logo'); ?>&h=200"/>
					    </a>
					</h1>
					<?php else : ?>
				    <h1 class="navbar-brand image">
				    	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					    	<img src="<?php bloginfo('template_directory');?>/img/LearnDash-logo.png"/>
					    </a>
					</h1>
					<?php endif; ?>
					<h2 class="site-description hidden"><?php bloginfo( 'description' ); ?></h2>
		  		</div>
		  		<div class="navbar-collapse collapse navbar-main">
		  			<?php if(get_option('nmbs_login')) : ?>
		  			<ul class="nav navbar-nav navbar-right navbar-nav-login">
		  				<?php if(is_user_logged_in()): ?>
	  					<li><a href="<?php echo wp_logout_url() ?>"><span aria-hidden="true" class="icon icon-user i-16"></span> <?php _e('Log Out', 'learndash-theme') ?></a></li>
	  					<?php else: ?>
						<li><a href="<?php echo wp_login_url(get_permalink()) ?>"><span aria-hidden="true" class="icon icon-user i-16"></span> <?php _e('Login', 'learndash-theme') ?></a></li>
						<?php endif; ?>
					</ul>
					<?php endif; ?>
		  			<?php if(get_option('nmbs_search')) : ?>
		  			<form class="navbar-form navbar-right" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div class="form-group">
							<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'nmbs' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'nmbs' ); ?>">
						</div>
						<button type="submit" class="search-submit btn btn-primary" title="<?php echo esc_attr_x( 'Search', 'submit button', 'nmbs' ); ?>"><span aria-hidden="true" class="icon icon-search i-16"></span></button>
					</form>
					<?php endif; ?>
					<?php wp_nav_menu( array(
						'container'			=>	'',
						'container_class'	=>	'',
						'theme_location'	=>	'primary',
						'menu_class'		=>	'nav navbar-nav navbar-left',
						'depth'				=>	3,
						'fallback_cb'		=>	false,
						'walker'			=>	new Nmbs_Nav_Walker,
					) );?>
				</div>
			</div>
		</nav>
	</div>
</header><!-- #masthead -->

<?php if (is_page_template('page-templates/front-page.php')): ?>
	<?php get_template_part( 'slider' ); ?>
<?php endif; ?>