<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wisdmlabs.com
 * @since      1.0.0
 *
 * @package    Ld_Content_Cloner
 * @subpackage Ld_Content_Cloner/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ld_Content_Cloner
 * @subpackage Ld_Content_Cloner/admin
 * @author     WisdmLabs <info@wisdmlabs.com>
 */
class Ld_Content_Cloner_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ld_Content_Cloner_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ld_Content_Cloner_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		global $current_screen;
		
		if( isset( $current_screen ) && in_array( $current_screen->post_type, array( 'sfwd-courses', 'sfwd-lessons', 'sfwd-quiz' ) ) ){
			

			wp_enqueue_style( 
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'css/ld-content-cloner-admin.css',
				array(),
				$this->version,
				'all'
			);

			wp_enqueue_style(
				$this->plugin_name . 'jquery-ui',
				plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css',
				array(),
				$this->version,
				'all'
			);

			wp_enqueue_style(
				$this->plugin_name . 'jquery-ui-structure',
				plugin_dir_url( __FILE__ ) . 'css/jquery-ui.structure.min.css',
				array(),
				$this->version,
				'all'
			);

			wp_enqueue_style( 
				$this->plugin_name . 'jquery-ui-theme',
				plugin_dir_url( __FILE__ ) . 'css/jquery-ui.theme.min.css',
				array(),
				$this->version,
				'all'
			);

		}

		if( isset( $current_screen ) && $current_screen->id === 'admin_page_learndash-course-bulk-rename' ){

			wp_enqueue_style( 
				'ldbr-admin-css',
				plugin_dir_url( __FILE__ ) . 'css/ldbr-admin.css',
				array(),
				$this->version,
				'all'
			);
		
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ld_Content_Cloner_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ld_Content_Cloner_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $current_screen;

		if( isset( $current_screen ) && in_array( $current_screen->post_type, array( 'sfwd-courses', 'sfwd-lessons', 'sfwd-quiz' ) ) ){

			wp_enqueue_script( 
							$this->plugin_name,
							plugin_dir_url( __FILE__ ) . 'js/ld-content-cloner-admin.js',
							array( 'jquery' ),
							$this->version,
							false
						);

			wp_enqueue_script( 'jquery-ui-core' );

			wp_enqueue_script( 'jquery-ui-dialog' );

			wp_localize_script( 
							$this->plugin_name,
							'ldcc_js_data',
							array(
								'adm_ajax_url' => admin_url( 'admin-ajax.php' ),
								'adm_post_url' => admin_url( 'post.php' ),
								'adm_ldbr_url' => admin_url( 'admin.php?page=learndash-course-bulk-rename' ),
								'image_base_url' => plugin_dir_url( __FILE__ ) . 'images/',
							)
						);

		}

		if( isset( $current_screen ) && $current_screen->id === 'admin_page_learndash-course-bulk-rename' ){

			wp_enqueue_script( 
							'ldbr-admin-js',
							plugin_dir_url( __FILE__ ) . 'js/ldbr-admin.js',
							array( 'jquery' ),
							$this->version,
							false
						);

			wp_localize_script( 
							'ldbr-admin-js',
							'ldbr_js_data',
							array(
								'adm_ajax_url' => admin_url( 'admin-ajax.php' ),
								'image_base_url' => plugin_dir_url( __FILE__ ) . 'images/',
							)
						);

		}

	}

}
