<?php
/**
 * Plugin Name: Must use plugins
 * Plugin URI: https://github.com/knife-media/knife-wpmu
 * Description: Fix WordPress options caching problem
 * Author: Anton Lukin
 * Version: 1.0
 * License: MIT
 */


/**
 * Fix a race condition in alloptions caching
 *
 * @link https://core.trac.wordpress.org/ticket/31245
 * @link https://github.com/Automattic/vip-go-mu-plugins-built/blob/master/misc.php#L66-L83
 */
function _wpcom_vip_maybe_clear_alloptions_cache( $option ) {
	if ( ! wp_installing() ) {
		$alloptions = wp_load_alloptions(); //alloptions should be cached at this point
		if ( isset( $alloptions[ $option ] ) ) { //only if option is among alloptions
			wp_cache_delete( 'alloptions', 'options' );
		}
	}
}

add_action( 'added_option',   '_wpcom_vip_maybe_clear_alloptions_cache' );
add_action( 'updated_option', '_wpcom_vip_maybe_clear_alloptions_cache' );
add_action( 'deleted_option', '_wpcom_vip_maybe_clear_alloptions_cache' );
