<?php

if ( !class_exists( 'Wdm_Get_Plugin_Data' ) ) {

        class Wdm_Get_Plugin_Data {

                public static function get_data_from_db($plugin_data) {

                        $author_name = $plugin_data['author_name'];
                        $plugin_name = $plugin_data['plugin_name'];
                        $plugin_short_name = $plugin_data['plugin_short_name'];
                        $plugin_slug = $plugin_data['plugin_slug'];
                        $plugin_version = $plugin_data['plugin_version'];
                        $store_url = $plugin_data['store_url'];

                        $get_trans = get_transient( 'wdm_' . $plugin_slug . '_license_trans' );

                        if ( !$get_trans ) {

                                $license_key = trim( get_option( 'edd_' . $plugin_slug . '_license_key' ) );
                                if ( $license_key ) {
                                        $api_params = array(
                                            'edd_action' => 'check_license',
                                            'license' => $license_key,
                                            'item_name' => urlencode( $plugin_name )
                                        );

                                        $response = wp_remote_get( add_query_arg( $api_params, $store_url ), array(
                                            'timeout' => 15, 'sslverify' => false ) );

                                        if ( is_wp_error( $response ) )
                                                        return false;

                                        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

                                        update_option( 'edd_' . $plugin_slug . '_license_status', $license_data->license );
                                        $license_status = $license_data->license;
                                        if ( $license_status == 'valid' ) {
                                                set_transient( 'wdm_' . $plugin_slug . '_license_trans', $license_data->license, 60 * 60 * 24 * 7 );
                                                return 'available';
                                        } else
                                                        set_transient( 'wdm_' . $plugin_slug . '_license_trans', $license_data->license, 60 * 60 * 5 );
                                        return 'unavailable';
                                }
                        }
                        else {

                                $license_status = get_option( 'edd_' . $plugin_slug . '_license_status' );
                                if ( $license_status == 'valid' ) {
                                        return 'available';
                                } else {
                                        return 'unavailable';
                                }
                        }

                }

        }

}
