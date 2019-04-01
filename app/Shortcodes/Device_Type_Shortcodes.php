<?php
namespace CloudVerve\Detect_Mobile_Device\Shortcodes;
use CloudVerve\Detect_Mobile_Device\Plugin;

final class Device_Type_Shortcodes extends Plugin {

  private static $class;

  public static function load() {

    if ( !isset( self::$class ) && !( self::$class instanceof Device_Type_Shortcodes ) ) {

      self::$class = new Device_Type_Shortcodes();

      // [device_is_mobile]
      if ( !shortcode_exists( 'device_is_mobile' ) ) {
        add_shortcode( 'device_is_mobile', array( self::$class, 'device_is_type_shortcode' ) );
      }

      // [device_is_phone]
      if ( !shortcode_exists( 'device_is_phone' ) ) {
        add_shortcode( 'device_is_phone', array( self::$class, 'device_is_type_shortcode' ) );
      }

      // [device_is_mobile]
      if ( !shortcode_exists( 'device_is_tablet' ) ) {
        add_shortcode( 'device_is_tablet', array( self::$class, 'device_is_type_shortcode' ) );
      }
      
      // [device_is_desktop]
      if ( !shortcode_exists( 'device_is_desktop' ) ) {
        add_shortcode( 'device_is_desktop', array( self::$class, 'device_is_type_shortcode' ) );
      }

    }

    return self::$class;

  }

  /**
   * Shortcodes: [device_is_{type}]
   *
   * @since 1.0.0
   */
  public static function device_is_type_shortcode( $atts = [], $content = '', $shortcode_name ) {

    if( empty( $content ) ) return $content;

    $device = new \Mobile_Detect;
    $device_match = false;

    switch( true ) {
      case $shortcode_name == 'device_is_mobile' && $device->isMobile():
        $device_match = true;
        break;
      case $shortcode_name == 'device_is_phone' && $device->isMobile() && !$device->isTablet():
        $device_match = true;
        break;
      case $shortcode_name == 'device_is_tablet' && $device->isTablet():
        $device_match = true;
        break;
      case $shortcode_name == 'device_is_desktop' && !$device->isMobile():
        $device_match = true;
        break;
    }

    return $device_match ? do_shortcode( $content ) : '';

  }

}