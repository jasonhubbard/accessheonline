<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists('Mega_Menu_Custom_Icon') ) :

/**
 *
 */
class Mega_Menu_Custom_Icon {


	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

		add_filter( 'megamenu_icon_tabs', array( $this, 'custom_icon_tab'), 100, 5 );
		add_filter( 'megamenu_scss_variables', array( $this, 'add_custom_icons_var_to_scss'), 10, 4 );
		add_filter( 'megamenu_load_scss_file_contents', array( $this, 'append_scss'), 10 );

	}


	/**
	 * Append the custom icon SCSS to the main SCSS file
	 *
	 * @since 1.0
	 * @param string $scss
	 * @param string
	 */
	public function append_scss( $scss ) {

		$path = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'scss/custom-icon.scss';

		$contents = file_get_contents( $path );

 		return $scss . $contents;

	}


	/**
	 * Create a new variable containing the IDs and icons of menu items to be used by the SCSS file
	 *
	 * @param array $vars
	 * @param string $location
	 * @param string $theme
	 * @param int $menu_id
	 * @return array - all custom SCSS vars
	 * @since 1.0
	 */
	public function add_custom_icons_var_to_scss( $vars, $location, $theme, $menu_id ) {

		$menu_items = wp_get_nav_menu_items( $menu_id );

		$custom_vars = array();

		if ( is_array( $menu_items ) ) {

			foreach ( $menu_items as $menu_order => $item ) {

				if ( $settings = get_post_meta($item->ID, "_megamenu", true ) ) {

					if ( isset( $settings['icon'] ) && $settings['icon'] == 'custom' && isset( $settings['custom_icon']['id'] ) && intval( $settings['custom_icon']['id'] ) > 0 ) {

						$id = $settings['custom_icon']['id'];
						$width = $settings['custom_icon']['width'];
						$height = $settings['custom_icon']['height'];
						$vertical_align = $settings['custom_icon']['vertical_align'];

						$styles = array(
							'id' => $item->ID,
							'custom_icon_url' => "'" . apply_filters("megamenu_custom_icon_url", $this->get_resized_image_url( $id, $width, $height ) ) . "'",
							'custom_icon_width' => $width . 'px',
							'custom_icon_height' => $height . 'px',
							'custom_icon_2x_url' => "'" . apply_filters("megamenu_custom_icon_url", $this->get_resized_image_url( $id, $width * 2, $height * 2 ) ) . "'",
							'custom_icon_2x_width' => $width * 2 . 'px',
							'custom_icon_2x_height' => $height * 2 . 'px',
							'custom_icon_vertical_align' => $vertical_align
						);

						$custom_vars[ $item->ID ] = $styles;

					}

				}

			}

		}

		//$custom_icons:(
		// (123, red, 150px),
	    // (456, green, null),
		// (789, blue, 90%),());

		if ( count( $custom_vars ) ) {

			$list = "(";

			foreach ( $custom_vars as $id => $vals ) {

				$list .= "(" . implode( ",", $vals ) . "),";
			}

			// Always add an empty list item to meke sure there are always at least 2 items in the list
			// Lists with a single item are not treated the same way by SASS
			$list .= "());";

			$vars['custom_icons'] = $list;

		}

		return $vars;

	}


	/**
	 * Add the "Custom Icon" tab to the "Menu Icons" tab
	 *
	 * @param array $tabs
	 * @param int $menu_item_id
	 * @param int $menu_id
	 * @param int $menu_item_depth
	 * @param array $menu_item_meta
	 * @return array
	 * @since 1.0
	 */
	public function custom_icon_tab( $tabs, $menu_item_id, $menu_id, $menu_item_depth, $menu_item_meta ) {

		$icon_id = isset( $menu_item_meta['custom_icon']['id'] ) ? $menu_item_meta['custom_icon']['id'] : false;
		$icon_align = isset( $menu_item_meta['custom_icon']['vertical_align'] ) ? $menu_item_meta['custom_icon']['vertical_align'] : 'middle';
		$icon_width = isset( $menu_item_meta['custom_icon']['width'] ) ? $menu_item_meta['custom_icon']['width'] : apply_filters("megamenu_custom_icon_default_width", 20);
		$icon_height = isset( $menu_item_meta['custom_icon']['height'] ) ? $menu_item_meta['custom_icon']['height'] : apply_filters("megamenu_custom_icon_default_height", 20);

		if ( $icon_id ) {

			$icon = wp_get_attachment_image_src( $icon_id, 'thumbnail' );
			$icon_url = $icon[0];

		}

		$html  = "    <input type='hidden' id='custom_icon_id' name='settings[custom_icon][id]' value='{$icon_id}' />";
		$html .= "    <input type='hidden' name='settings[icon]' value='custom' />";
		$html .= "    <input type='hidden' name='clear_cache' value='true' />";
		$html .= "    <table>";
		$html .= "        <tr>";
		$html .= "            <td class='mega-name'>" . __("Media File", "megamenupro") . "</td>";
		$html .= "            <td class='mega-value'>";

		if ( $icon_id > 0 ) {
			$html .= "<img style='display: block;' id='mm_icon' src='{$icon_url}' />";

			$change_style = 'display: block;';
			$remove_style = 'display: block;';
			$choose_style = 'display: none;';
		} else {
			$html .= "<img style='display: none;' id='mm_icon' />";

			$change_style = 'display: none;';
			$remove_style = 'display: none;';
			$choose_style = 'display: block;';
		}

		$html .= "                <a id='mm_choose_icon' style='{$choose_style}' data-menu-item-id='" . esc_attr( $menu_item_id ) . "' data-button-text='" . __("Select Icon", "megamenupro") . "'>" . __("Select Icon", "megamenupro") . "</a>";
		$html .= "                <a id='mm_remove_icon' style='{$remove_style}' data-menu-item-id='" . esc_attr( $menu_item_id ) . "'>" . __("Remove Icon", "megamenupro") . "</a>";
		$html .= "                <a id='mm_change_icon' style='{$change_style}' data-menu-item-id='" . esc_attr( $menu_item_id ) . "' data-button-text='" . __("Change Icon", "megamenupro") . "'>" . __("Change Icon", "megamenupro") . "</a>";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr>";
		$html .= "            <td class='mega-name'>" . __("Icon Width", "megamenupro") . "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <input type='number' name='settings[custom_icon][width]' class='mm_icon_width' value='{$icon_width}' />px";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr>";
		$html .= "            <td class='mega-name'>" . __("Icon Height", "megamenupro") . "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <input type='number' name='settings[custom_icon][height]' class='mm_icon_height' value='{$icon_height}' />px";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "        <tr>";
		$html .= "            <td class='mega-name'>" . __("Icon Vertical Align", "megamenupro") . "</td>";
		$html .= "            <td class='mega-value'>";
		$html .= "                <select name='settings[custom_icon][vertical_align]'>";
		$html .= "                    <option value='middle' " . selected( $icon_align, 'middle', false) . ">" . __("Middle (Default)", "megamenupro") . "</option>";
		$html .= "                    <option value='top' " . selected( $icon_align, 'top', false) . ">" . __("Top", "megamenupro") . "</option>";
		$html .= "                    <option value='bottom' " . selected( $icon_align, 'bottom', false) . ">" . __("Bottom", "megamenupro") . "</option>";
		$html .= "                    <option value='text-top' " . selected( $icon_align, 'text-top', false) . ">" . __("Text-Top", "megamenupro") . "</option>";
		$html .= "                    <option value='text-bottom' " . selected( $icon_align, 'text-bottom', false) . ">" . __("Text-Bottom", "megamenupro") . "</option>";
		$html .= "                    <option value='super' " . selected( $icon_align, 'super', false) . ">" . __("Super", "megamenupro") . "</option>";
		$html .= "                    <option value='sub' " . selected( $icon_align, 'sub', false) . ">" . __("Sub", "megamenupro") . "</option>";
		$html .= "                    <option value='initial' " . selected( $icon_align, 'initial', false) . ">" . __("Initial", "megamenupro") . "</option>";
		$html .= "                    <option value='inherit' " . selected( $icon_align, 'inherit', false) . ">" . __("Inherit", "megamenupro") . "</option>";
		$html .= "                <select>";
		$html .= "            </td>";
		$html .= "        </tr>";
		$html .= "    </table>";
		$html .= get_submit_button( __("Save custom icon", "megamenupro") );

		// add the tab
		$tabs['custom'] = array(
			'title' => __("Custom Icon", "megamenupro"),
			'active' => isset( $menu_item_meta['icon'] ) && $menu_item_meta['icon'] === "custom",
			'content' => $html
		);

		return $tabs;
	}


    /**
     * Return the image URL, crop the image to the correct dimensions if required
     *
     * @param int $attachment_id
     * @param int $dest_width
     * @param int $dest_height
     * @since 1.0
     * @return string resized image URL
     */
    public function get_resized_image_url( $attachment_id, $dest_width, $dest_height ) {
 
        $meta = wp_get_attachment_metadata( $attachment_id );

        $upload_dir = wp_upload_dir();

        $full_url = $upload_dir['baseurl'] . "/" . get_post_meta( $attachment_id, '_wp_attached_file', true );

        if ( ! isset( $meta['width'], $meta['height'] ) ) {
            return $full_url; // image is not valid
        }

        // if the full size is the same as the required size, return the full URL
        if ( $meta['width'] == $dest_width && $meta['height'] == $dest_height ) {
            return $full_url;
        }

        $path = get_attached_file( $attachment_id );
        $info = pathinfo( $path );
        $dir = $info['dirname'];
        $ext = $info['extension'];
        $name = wp_basename( $path, ".$ext" );
        $dest_file_name = "{$dir}/{$name}-{$dest_width}x{$dest_height}.{$ext}";

        if ( file_exists( $dest_file_name ) ) {
            // good. no need for resize, just return the URL
            return str_replace( basename( $full_url ), basename( $dest_file_name ), $full_url );
        }


        $image = wp_get_image_editor( $path );

        // editor will return an error if the path is invalid
        if ( is_wp_error( $image ) ) {
            return $full_url;
        }

		$image->resize( $dest_width, $dest_height, true );

        $saved = $image->save( $dest_file_name );

        if ( is_wp_error( $saved ) ) {
            return;
        }

        // Record the new size so that the file is correctly removed when the media file is deleted.
        $backup_sizes = get_post_meta( $attachment_id, '_wp_attachment_backup_sizes', true );

        if ( ! is_array( $backup_sizes ) ) {
            $backup_sizes = array();
        }

        $backup_sizes["resized-{$dest_width}x{$dest_height}"] = $saved;
        update_post_meta( $attachment_id, '_wp_attachment_backup_sizes', $backup_sizes );

        $url = str_replace( basename( $full_url ), basename( $saved['path'] ), $full_url );

        return $url;
    }

}

endif;