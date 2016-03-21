<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('Mega_Menu_Vertical') ) :

/**
 *
 */
class Mega_Menu_Vertical {

	/**
	 * Constructor
	 *
	 * @since 1.1
	 */
	public function __construct() {

        add_action( 'megamenu_settings_table', array( $this, 'add_orientation_setting'), 10, 2);
		add_filter( 'megamenu_load_scss_file_contents', array( $this, 'append_scss'), 10 );
		add_filter( 'megamenu_nav_menu_args', array( $this, 'apply_vertical_class'), 10, 3 );

	}


	/**
	 * Change the orientation class to 'mega-menu-vertical'
	 *
	 * @since 1.1
	 * @param array $args
	 * @param int $menu_id
	 * @param string $location
	 */
	public function apply_vertical_class( $args, $menu_id, $location ) {

		$settings = get_option('megamenu_settings');

		if ( isset( $settings[$location]['orientation'] ) ) {
			$args['menu_class'] = str_replace( 'horizontal', $settings[$location]['orientation'], $args['menu_class'] );
		}

		return $args;

	}


	/**
	 * Add Orientation setting to menu options
	 *
	 * @since 1.1
	 * @param string $location
	 * @param array $settings
	 */
	public function add_orientation_setting( $location, $settings ) {
		?>

            <tr>
                <td><?php _e("Orientation", "megamenupro"); ?></td>
                <td>

                    <select name='megamenu_meta[<?php echo $location ?>][orientation]'>
                        <option value='horizontal'>Horizontal</option>
                        <option value='vertical' <?php selected( isset($settings[$location]['orientation']) && $settings[$location]['orientation'] == 'vertical' ) ?>><?php _e("Vertical", "megamenupro"); ?></option>
                    </select>
                </td>
            </tr>

		<?php

	}

	/**
	 * Append the vertical menu SCSS to the main SCSS file
	 *
	 * @since 1.1
	 * @param string $scss
	 * @param string
	 */
	public function append_scss( $scss ) {

		$path = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'scss/vertical.scss';

		$contents = file_get_contents( $path );

 		return $scss . $contents;

	}

}

endif;