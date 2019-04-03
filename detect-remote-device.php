<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Detect Remote Device
 * Plugin URI:        https://github.com/dmhendricks/detect-remote-device
 * Description:       Adds additional functions and shortcodes to modify output by device type - mobile, tablet or desktop.
 * Version:           0.1.0
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
      $device = new \Jenssegers\Agent\Agent;
      return $device->isMobile();
    }

  }

  // Add device_is_phone() function
  if( !function_exists( 'device_is_phone' ) ) {

    function device_is_phone() {
      $device = new \Jenssegers\Agent\Agent;
      return $device->isMobile() && !$device->isTablet();
    }

  }

  // Add device_is_tablet() function
  if( !function_exists( 'device_is_tablet' ) ) {

    function device_is_tablet() {
      $device = new \Jenssegers\Agent\Agent;
      return $device->isTablet();
    }

  }

  // Add device_is_desktop() function
  if( !function_exists( 'device_is_desktop' ) ) {

    function device_is_desktop() {
      $device = new \Jenssegers\Agent\Agent;
      return !$device->isMobile();
    }

  }

  // Add get_the_device_type() function
  if( !function_exists( 'get_the_device_type' ) ) {

    function get_the_device_type() {

      switch( true ) {
        case device_is_tablet():
          return 'tablet';
        case device_is_phone():
          return 'phone';
        default:
          return 'desktop';
      }

    }

  }

  // Add get_user_agent() function
  if( !function_exists( 'get_user_agent' ) ) {

    function get_user_agent( $key = null ) {

      $agent = new \Jenssegers\Agent\Agent;

      switch( $key ) {
        case 'type':
          return get_the_device_type();
        case 'device':
          return $agent->device();
        default:
          return $_SERVER['HTTP_USER_AGENT'];
      }

    }

  }

}
