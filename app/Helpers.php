<?php
namespace CloudVerve\Detect_Remote_Device;
use DeviceDetector\DeviceDetector;
use Jenssegers\Agent\Agent;

final class Helpers extends Plugin {

  /**
   * Filter to detect if device is mobile
   *    Usage: if( apply_filters( 'device_is_mobile' ) ) { ... };
   *
   * @return bool
   * @since 1.0.0
   */
  public function device_is_mobile() {

    $agent = new Agent;
    switch( true ) {
      case isset( $_GET['_device_type'] ):
        return in_array( strtolower( $_GET['_device_type'] ), [ 'tablet', 'phone' ] );
      case isset( $_GET['_device_is_mobile'] ):
        return filter_var( $_GET['_device_is_mobile'], FILTER_VALIDATE_BOOLEAN );
      default:
        return $agent->isMobile();
    }

  }

  /**
   * Filter to detect if device is a phone
   *    Usage: if( apply_filters( 'device_is_phone' ) ) { ... };
   *
   * @return bool
   * @since 1.0.0
   */
  public function device_is_phone() {

    $agent = new Agent;
    switch( true ) {
      case isset( $_GET['_device_type'] ):
        return strtolower( $_GET['_device_type'] ) == 'phone';
      case isset( $_GET['_device_is_phone'] ):
        return filter_var( $_GET['_device_is_phone'], FILTER_VALIDATE_BOOLEAN );
      default:
        return $agent->isPhone();
    }

  }

  /**
   * Filter to detect if device is a tablet
   *    Usage: if( apply_filters( 'device_is_tablet' ) ) { ... };
   *
   * @return bool
   * @since 1.0.0
   */
  public function device_is_tablet() {

    $agent = new Agent;
    switch( true ) {
      case isset( $_GET['_device_type'] ):
        return strtolower( $_GET['_device_type'] ) == 'tablet';
      case isset( $_GET['_device_is_tablet'] ):
        return filter_var( $_GET['_device_is_tablet'], FILTER_VALIDATE_BOOLEAN );
      default:
        return $agent->isTablet();
    }

  }

  /**
   * Filter to detect if device is a tablet
   *    Usage: if( apply_filters( 'device_is_desktop' ) ) { ... };
   *
   * @return bool
   * @since 1.0.0
   */
  public function device_is_desktop() {

    $agent = new Agent;
    switch( true ) {
      case isset( $_GET['_device_type'] ):
        return strtolower( $_GET['_device_type'] ) == 'desktop';
      case isset( $_GET['_device_is_desktop'] ):
        return filter_var( $_GET['_device_is_desktop'], FILTER_VALIDATE_BOOLEAN );
      default:
        return $agent->isDesktop();
    }

  }

  /**
   * Filter to detect if device is a tablet
   *    Usage: if( apply_filters( 'get_device_type' ) ) { ... };
   *
   * @return bool
   * @since 1.0.0
   */
  public function get_device_type( $args = [ 'header' => null ] ) {

    // Get the device type from specified header
    if( !empty( $args['header'] ) && is_string( $args['header'] ) ) {
      $args['header'] = trim( $args['header'] );
      $args['header'] = ( stripos( $args['header'], 'HTTP_' ) == fasle ? 'HTTP_' : '' ) . strtoupper( str_replace( '-', '_', $args['header'] ) );

      if( !empty( $_SERVER[ $args['header'] ] ) ) {
        $device_type = strtolower( $_SERVER[ $args['header'] ] );
        return $args['header'] != 'HTTP_CF_DEVICE_TYPE' ? $device_type : str_replace( 'mobile', 'phone', $device_type );
      }
    }

    // Otherwise, use Agent
    $agent = new Agent;
    switch( true ) {
      case !empty( $_GET['_device_type'] ):
        return strtolower( $_GET['_device_type'] );
      case $agent->isTablet():
        return 'tablet';
      case $agent->isPhone():
        return 'phone';
      case $agent->isDesktop():
        return 'desktop';
    }

    return 'desktop';

  }

  /**
   * Fetch information about the remote user agent
   *    Usage: echo apply_filters( 'get_user_agent' ) );
   *           echo apply_filters( 'get_user_agent', 'name' ) );
   *
   * @return bool
   * @since 1.0.0
   */
  public function get_user_agent( $key = null ) {

    $agent = new Agent;
    $device = new DeviceDetector( $_SERVER['HTTP_USER_AGENT'] );
    $device->parse();

    switch( $key ) {
      case 'type':
        return self::get_device_type();
      case 'name':
        return $agent->device();
      case 'os':
        $os = $device->getOs();
        return isset( $os['name'] ) ? $os['name'] : null;
      case 'bot':
        return $device->isBot() ? $device->getBot() : false;
      default:
        return $_SERVER['HTTP_USER_AGENT'];
    }

  }

  /**
   * Get the path of a file relative to plugin directory
   * @return string Absolute file path of script
   * @since 1.0.0
   */
  public static function get_script_dir( $filepath ) {

    return self::$plugin_dir . DIRECTORY_SEPARATOR . $filepath;

  }

  /**
   * Get the URL of a file relative to plugin URL
   * @return string Full URI of script
   * @since 1.0.0
   */
  public static function get_script_url( $filepath ) {

    return self::$plugin_url . '/' . $filepath;

  }

  /**
   * Read JSON data from file
   * 
   * @param string $filepath Absolute path to JSON file
   * @param bool $assoc If false, returns object. If true, returns associave array.
   * @return object Object containing JSON values
   * @since 1.0.0
   */ 
  public static function get_json_contents( $filepath, $assoc = true ) {

    if( !file_exists( $filepath ) ) return $assoc ? [] : (object) [];
    return @json_decode( file_get_contents( $filepath ), $assoc );

  }

}