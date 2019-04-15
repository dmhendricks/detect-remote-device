<?php
namespace CloudVerve\Detect_Remote_Device\Shortcodes;
use CloudVerve\Detect_Remote_Device\Plugin;
use Jenssegers\Agent\Agent;

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

    $agent = new Agent;
    $device_match = false;

    switch( true ) {
      case $shortcode_name == 'device_is_mobile' && $agent->isMobile():
        $device_match = true;
        break;
      case $shortcode_name == 'device_is_phone' && $agent->isPhone():
        $device_match = true;
        break;
      case $shortcode_name == 'device_is_tablet' && $agent->isTablet():
        $device_match = true;
        break;
      case $shortcode_name == 'device_is_desktop' && $agent->isDesktop():
        $device_match = true;
        break;
    }

    return $device_match ? do_shortcode( $content ) : '';

  }

}