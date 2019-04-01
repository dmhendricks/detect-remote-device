<?php
namespace CloudVerve\Detect_Mobile_Device;

final class Helpers extends Plugin {

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

  /**
   * Return the device type
   *
   * @return string Device type
   * @since 1.0.0
   */
  public static function get_remote_device_type() {

    $device = new \Mobile_Detect;

    switch( true ) {
      case $device->isTablet():
        return 'tablet';
      case $device->isMobile() && !$device->isTablet():
        return 'phone';
      default:
        return 'desktop';
    }

  }

}