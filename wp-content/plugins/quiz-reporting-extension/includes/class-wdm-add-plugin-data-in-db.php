<?php

if ( !class_exists( 'Wdm_Add_Plugin_Data_In_DB' ) ) {

        class Wdm_Add_Plugin_Data_In_DB {

                /**
                 *
                 * @var string Short Name for plugin.
                 */
                var $plugin_short_name = "";

                /**
                 *
                 * @var string Slug to be used in url and functions name
                 */
                var $plugin_slug = '';

                /**
                 *
                 * @var string stores the current plugin version
                 */
                var $plugin_version = '';

                /**
                 *
                 * @var string Handles the plugin name
                 */
                var $plugin_name = '';

                /**
                 *
                 * @var string  Stores the URL of store. Retrieves updates from
                 *              this store
                 */
                var $store_url = '';

                /**
                 *
                 * @var string  Name of the Author
                 */
                var $author_name = '';

                public function __construct( $plugin_data ) {

                        $this->author_name = $plugin_data['author_name'];
                        $this->plugin_name = $plugin_data['plugin_name'];
                        $this->plugin_short_name = $plugin_data['plugin_short_name'];
                        $this->plugin_slug = $plugin_data['plugin_slug'];
                        $this->plugin_version = $plugin_data['plugin_version'];
                        $this->store_url = $plugin_data['store_url'];


                        add_action( 'admin_menu', array( $this, 'l_menu' ) );

                }

                function l_menu() {

                        $this->add_data();

                        add_plugins_page( "{$this->plugin_short_name} License", "{$this->plugin_short_name} License", 'manage_options', $this->plugin_slug . '-license', array(
                            $this, 'l_page' ) );

                }

                function l_page() {

                        include_once trailingslashit( dirname( dirname( __FILE__ ) ) ) . 'templates/l_page_display.php';

                }


                function add_data() {
                        if ( isset( $_POST['edd_' . $this->plugin_slug . '_license_activate'] ) ) {

                                if ( !check_admin_referer( 'edd_' . $this->plugin_slug . '_nonce', 'edd_' . $this->plugin_slug . '_nonce' ) )
                                                return;

                                $license_key = trim( $_POST['edd_' . $this->plugin_slug . '_license_key'] );

                                if ( $license_key ) {
                                        $api_params = array(
                                            'edd_action' => 'activate_license',
                                            'license' => $license_key,
                                            'item_name' => urlencode( $this->plugin_name )
                                        );

                                        $response = wp_remote_get( add_query_arg( $api_params, $this->store_url ), array(
                                            'timeout' => 15, 'sslverify' => false ) );
                                        if ( is_wp_error( $response ) ) {
                                                return false;
                                        }

                                        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

                                        if($license_data->license == 'failed') {
                                                
                                             update_option( 'edd_' . $this->plugin_slug . '_license_status', 'deactivated' );   
                                        } else {
                                                
                                        update_option( 'edd_' . $this->plugin_slug . '_license_status', $license_data->license );
                                        }
                                        update_option( 'edd_' . $this->plugin_slug . '_license_key', $license_key );

                                        $trans_var = get_transient( 'wdm_' . $this->plugin_slug . '_license_trans' );
                                        if ( isset( $trans_var ) ) {
                                                delete_transient( 'wdm_' . $this->plugin_slug . '_license_trans' );
                                        }
                                }
                        }

                        if ( isset( $_POST['edd_' . $this->plugin_slug . '_license_deactivate'] ) ) {


                                if ( !check_admin_referer( 'edd_' . $this->plugin_slug . '_nonce', 'edd_' . $this->plugin_slug . '_nonce' ) )
                                                return;

                                $wpep_license_key = trim( get_option( 'edd_' . $this->plugin_slug . '_license_key' ) );

                                if ( $wpep_license_key ) {
                                        $api_params = array(
                                            'edd_action' => 'deactivate_license',
                                            'license' => $wpep_license_key,
                                            'item_name' => urlencode( $this->plugin_name )
                                        );

                                        $response = wp_remote_get( add_query_arg( $api_params, $this->store_url ), array(
                                            'timeout' => 15, 'sslverify' => false ) );
                                        

                                        if ( is_wp_error( $response ) )
                                                        return false;

                                        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

                                        if ( $license_data->license == 'deactivated' || $license_data->license == 'failed' ) {

                                                update_option( 'edd_' . $this->plugin_slug . '_license_status', 'deactivated' );
                                        }
                                        delete_transient( 'wdm_' . $this->plugin_slug . '_license_trans' );
                                        set_transient( 'wdm_' . $this->plugin_slug . '_license_trans', $license_data->license, 0 );
                                }
                        }

                }

        }

}
