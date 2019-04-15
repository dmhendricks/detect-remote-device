<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Detect Remote Device
 * Plugin URI:        https://github.com/dmhendricks/detect-remote-device
 * Description:       Adds additional functions and shortcodes to modify output by device type - mobile, tablet or desktop.
 * Version:           0.2.0
 * Stable tag:        1.0.0
 * Requires at least: 4.7
 * Requires PHP:      5.6
 * Tested up to:      5.1.1
 * Author:            Daniel M. Hendricks
 * Author URI:        https://daniel.hn
 * License:           GPL-2.0
 * License URI:       https://opensource.org/licenses/GPL-2.0
 * Text Domain:       detect-remote-device
 * Domain Path:       /languages
 * GitHub Plugin URI: dmhendricks/detect-remote-device
 */
use \CloudVerve\Detect_Remote_Device\Helpers;
ABSPATH || die();

/* Copyright 2019	  Daniel M. Hendricks (https://daniel.hn/)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Load dependencies
 */
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
  require( __DIR__ . '/vendor/autoload.php' );
} else {
  return;
}

/**
 * Initialize plugin
 */
\CloudVerve\Detect_Remote_Device\Plugin::instance( __FILE__, dirname( __FILE__ ), plugin_dir_url( __FILE__ ) );

/**
 * Global Functions
 */

if( !( defined( 'DMD_DISABLE_GLOBAL_FUNCTIONS' ) && DMD_DISABLE_GLOBAL_FUNCTIONS ) ) {

  // Add device_is_mobile() function; similar to wp_is_mobile(), but uses jenssegers/agent library
  if( !function_exists( 'device_is_mobile' ) ) {

    function device_is_mobile() {
      return Helpers::device_is_mobile();
    }

  }

  // Add device_is_phone() function
  if( !function_exists( 'device_is_phone' ) ) {

    function device_is_phone() {
      return Helpers::device_is_phone();
    }

  }

  // Add device_is_tablet() function
  if( !function_exists( 'device_is_tablet' ) ) {

    function device_is_tablet() {
      return Helpers::device_is_tablet();
    }

  }

  // Add device_is_desktop() function
  if( !function_exists( 'device_is_desktop' ) ) {

    function device_is_desktop() {
      return Helpers::device_is_desktop();
    }

  }

  // Add get_the_device_type() function
  if( !function_exists( 'get_the_device_type' ) ) {

    function get_the_device_type( $args = [ 'header' => null ] ) {
      return Helpers::get_device_type( $args );
    }

  }

  // Add get_user_agent() function
  if( !function_exists( 'get_user_agent' ) ) {

    function get_user_agent( $key = null ) {
      return Helpers::get_user_agent( $key );
    }

  }

}
