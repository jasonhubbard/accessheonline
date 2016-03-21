<?php

//Get License key
$license_key = get_option( 'edd_' . $this->plugin_slug .'_license_key' );

//Get License Status
$status = get_option( 'edd_' . $this->plugin_slug . '_license_status' );

?>
<div class="wrap">
        <?php

        $license_key = trim( get_option( 'edd_' . $this->plugin_slug .'_license_key' ) );
        
        //Handle Submission of inputs on license page
        if ( isset($_POST['edd_' . $this->plugin_slug .'_license_key']) && empty($_POST['edd_' . $this->plugin_slug .'_license_key']) ) {
                //If empty, show error message
                add_settings_error(
                        'wdm_' . $this->plugin_slug .'_errors', esc_attr( 'settings_updated' ), __( 'Please enter license key.', $this->plugin_slug . '_text_domain' ), 'error'
                );
        } else if ( $status !== false && $status == 'valid' ) { //Valid license key
                add_settings_error(
                        'wdm_' . $this->plugin_slug .'_errors', esc_attr( 'settings_updated' ), __( 'Your license key is activated.', $this->plugin_slug . '_text_domain' ), 'updated'
                );
        } else if ( $status == 'invalid' ) { //Invalid license key
                add_settings_error(
                        'wdm_' . $this->plugin_slug .'_errors', esc_attr( 'settings_updated' ), __( 'Please enter valid license key.', $this->plugin_slug . '_text_domain' ), 'error'
                );
        } else if ( $status == 'site_inactive' ) { //Site is inactive
                add_settings_error(
                        'wdm_' . $this->plugin_slug .'_errors', esc_attr( 'settings_updated' ), __( 'Site inactive(Press Activate license to activate plugin)', $this->plugin_slug . '_text_domain' ), 'error'
                );
        } else if ( $status == 'deactivated' ) { //Site is inactive
                add_settings_error(
                        'wdm_' . $this->plugin_slug .'_errors', esc_attr( 'settings_updated' ), __( 'License Key is deactivated', $this->plugin_slug . '_text_domain' ), 'updated'
                );
        }

        settings_errors( 'wdm_' . $this->plugin_slug .'_errors' );

        ?>
        <h2><?php _e( $this->plugin_name .' License Options', $this->plugin_slug . '_text_domain' ); ?></h2>
        <form method="post" action="">
                <table class="form-table">
                        <tbody>
                                <tr valign="top">	
                                        <th scope="row" valign="top">
<?php _e( 'License Key', $this->plugin_slug . '_text_domain' ); ?>
                                        </th>
                                        <td>
                                                <input id="<?php echo 'edd_' . $this->plugin_slug .'_license_key'?>" name="<?php echo 'edd_' . $this->plugin_slug .'_license_key'?>" type="text" class="regular-text" value="<?php esc_attr_e( $license_key ); ?>" />
                                                <label class="description" for="<?php echo 'edd_' . $this->plugin_slug .'_license_key'?>"></label>
                                        </td>
                                </tr>

                                <tr>
                                        <th scope="row" valign="top">
                                                <?php _e( 'License Status' ); ?>
                                        </th>
                                        <td>
                                                <?php if ( $status !== false && $status == 'valid' ) { ?>
                                                        <span style="color:green;"><?php _e( 'Active', $this->plugin_slug . '_text_domain' ); ?></span>
                                                <?php } else if ( get_option( 'edd_' . $this->plugin_slug .'_license_status' ) == 'site_inactive' ) {

                                                        ?>
                                                        <span style="color:red;"><?php _e( 'Not Active', $this->plugin_slug . '_text_domain' ) ?></span>
                                                <?php } elseif ( get_option( 'edd_' . $this->plugin_slug .'_license_status' ) == 'invalid' ) { ?>
                                                        <span style="color:red;"><?php _e( 'Not Active', $this->plugin_slug . '_text_domain' ); ?></span>
                                                        <?php

                                                } else {

                                                        ?>
                                                        <span style="color:red;"><?php _e( 'Not Active', $this->plugin_slug . '_text_domain' ); ?></span>
                                                <?php }

                                                ?>
                                        </td>
                                </tr>
                                <tr valign="top">	
                                        <th scope="row" valign="top">
                                                <?php _e( 'Activate License', $this->plugin_slug . '_text_domain' ); ?>
                                        </th>
                                        <td>
                                                <?php if ( $status !== false && $status == 'valid' ) { ?>

                                                        <?php wp_nonce_field( 'edd_' . $this->plugin_slug .'_nonce', 'edd_' . $this->plugin_slug .'_nonce' ); ?>
                                                        <input type="submit" class="button-primary" name="<?php echo 'edd_' . $this->plugin_slug .'_license_deactivate'; ?>" value="<?php _e( 'Deactivate License', $this->plugin_slug . '_text_domain' ); ?>"/>
        <?php

} else {
        wp_nonce_field( 'edd_' . $this->plugin_slug .'_nonce', 'edd_' . $this->plugin_slug .'_nonce' );

        ?>
                                                        <input type="submit" class="button-primary" name="<?php echo 'edd_' . $this->plugin_slug .'_license_activate'; ?>" value="<?php _e( 'Activate License', $this->plugin_slug . '_text_domain' ); ?>"/>
<?php } ?>
                                        </td>
                                </tr>
                        </tbody>
                </table>
        </form>
</div>
