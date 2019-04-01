<?php
namespace CloudVerve\Detect_Mobile_Device;

class Plugin {

  private static $instance;
  protected static $plugin_dir;
  protected static $plugin_url;
  protected static $version;
  protected static $config;
  protected static $textdomain;

  public static function instance( $plugin_file, $plugin_dir, $plugin_url ) {

    if ( !isset( self::$instance ) && !( self::$instance instanceof Plugin ) ) {

      self::$instance = new Plugin;
      self::$plugin_dir = $plugin_dir;
      self::$plugin_url = $plugin_url;

      // Load plugin configuration
      self::$config = (array) Helpers::get_json_contents( Helpers::get_script_dir( 'plugin.json' ) );

      // Get plugin meta data
      self::$config['plugin'] = self::get_plugin_meta( $plugin_file );
      self::$version = self::$config['plugin']['version'];

      // Define plugin version
      if ( !defined( __CLASS__ . '\VERSION' ) ) define( __CLASS__ . '\VERSION', self::$version );

      // Set and load text domain
      self::$textdomain = self::$config['plugin']['textdomain'];
      add_action( 'init', array( self::$instance, 'plugin_load_textdomain' ) );
      
      // Activation hook
      register_activation_hook( self::$config['plugin']['identifier'], array( self::$instance, 'activate' ) );

      // Load dependecies and load plugin logic
      add_action( 'init', array( self::$instance, 'load_plugin' ) );

    }

    return self::$instance;

  }
    
  /**
   * Load plugin core logic
   * @since 1.0.0
   */
  public function load_plugin() {

    if( !self::check_dependencies() ) {
      return;
    }

    // Load core plugin logic
    Core::init();

    // Load shortcodes
    Shortcodes\Shortcode_Loader::init();

  }

  /**
   * Load translations
   * @since 1.0.0
   */
  public function plugin_load_textdomain() {

    load_plugin_textdomain( self::$textdomain, false, trailingslashit( self::$config['plugin'][ 'slug' ] ) . self::$config['plugin'][ 'languages' ] );

  }

  /**
   * Plugin activation callback
   * @since 1.0.0
   */
  public function activate() {

    self::check_dependencies( true );

  }

  /**
   * Function to check dependencies.
   *
   * @param bool $die If true, plugin execution is halted with die(), useful for
   *    outputting error(s) in during activate()
   * @return bool
   * @since 1.0.0
   */
  private function check_dependencies( $die = false ) {

    $requirements = new \underDEV_Requirements( __( 'Detect Mobile Device', self::$textdomain ), [
      'php'             => self::$config['dependencies']['php'],
      'wp'              => self::$config['dependencies']['wp']
    ]);

    // Display admin notice if requirements not met
    if( !$requirements->satisfied() ) {
      if ( $die ) {
        die( $requirements->notice() );
      } else {
        $requirements->notice();
      }
    }

    return $requirements->satisfied();

  }

  /**
   * Append a field prefix as defined in $config
   *
   * @param string|null $field_name The string/field to prefix
   * @param string $before String to add before the prefix
   * @param string $after String to add after the prefix
   * @return string Prefixed string/field value
   * @since 1.0.0
   */
  public function prefix( $field_name = null, $before = '', $after = '_' ) {

    $prefix = $before . self::$config['prefix'] . $after;
    return $field_name !== null ? $prefix . $field_name : $prefix;

  }

  /**
   * Get meta fields from plugin header
   * @return array
   * @since 1.0.0
   */
  public function get_plugin_meta( $plugin_file ) {

    // Get plugin meta data
    $plugin_data = get_file_data( $plugin_file, [
      'name' => 'Plugin Name',
      'version' => 'Version',
      'textdomain' => 'Text Domain',
      'domainpath' => 'Domain Path'
    ], 'plugin');

    // Get WordPress plugin file identifier and directory slug
    $plugin_file = explode( DIRECTORY_SEPARATOR, $plugin_file );
    $identifier = implode( '/', array_slice( $plugin_file, -2, 2, true ) );
    $plugin_slug = @current( array_slice( $plugin_file, -2, 1, true ) ) ?: sanitize_title( $plugin_data[ 'name' ] );

    // Add additional string translations
    $plugin_data['translated_strings'] = [
      __( 'Detect Mobile Device', self::$textdomain ),
      __( 'Adds additional functions and shortcodes to modify output by device type - mobile, tablet or desktop.', self::$textdomain )
    ];

    // Return plugin meta data
    return array_merge( $plugin_data, [
      'identifier' => $identifier,
      'slug' => $plugin_slug
    ]);

  }

}