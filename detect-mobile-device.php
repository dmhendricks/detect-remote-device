<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Detect Mobile Device
 * Plugin URI:        https://github.com/dmhendricks/detect-mobile-device
 * Description:       Adds additional functions and shortcodes to modify output by device type - mobile, tablet or desktop.
 * Version:           0.1.0
 * Author:            Daniel M. Hendricks
 * Author URI:        https://daniel.hn
 * License:           GPL-2.0
 * License URI:       https://opensource.org/licenses/GPL-2.0
 * Text Domain:       detect-mobile-device
 * Domain Path:       languages
 * GitHub Plugin URI: dmhendricks/detect-mobile-device
 */
ABSPATH || die();

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
  require( __DIR__ . '/vendor/autoload.php' );
}

// Initialize plugin
\CloudVerve\Detect_Mobile_Device\Plugin::instance( __FILE__, dirname( __FILE__ ), plugin_dir_url( __FILE__ ) );
