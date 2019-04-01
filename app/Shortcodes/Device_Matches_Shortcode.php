<?php
namespace CloudVerve\Detect_Mobile_Device\Shortcodes;
use CloudVerve\Detect_Mobile_Device\Plugin;
use CloudVerve\Detect_Mobile_Device\Helpers;

final class Device_Matches_Shortcode extends Plugin {

  private static $class;

  public static function load() {

    if ( !isset( self::$class ) && !( self::$class instanceof Device_Matches_Shortcode ) ) {

      self::$class = new Device_Matches_Shortcode();

      // [device_is]
      if ( !shortcode_exists( 'device_is' ) ) {
        add_shortcode( 'device_is', array( self::$class, 'device_match_shortcode' ) );
      }

      // [device_is_not]
      if ( !shortcode_exists( 'device_is_not' ) ) {
        add_shortcode( 'device_is_not', array( self::$class, 'device_match_shortcode' ) );
      }

    }

    return self::$class;

  }

  /**
   * Shortcodes: [device_is], [device_is_not]
   *
   * @since 1.0.0
   */
  public static function device_match_shortcode( $atts = [], $content = '', $shortcode_name ) {

    // Set default attributes
    $atts = shortcode_atts( array(
      'type' => null
    ), $atts, $shortcode_name );

    // Validate attributes
    if( empty( $content ) || !$atts['type'] ) return $content;
    $atts['type'] = explode( ',', $atts['type'] );

    $device = new \Mobile_Detect;
    $display_content = false;

    if( $shortcode_name == 'device_is' ) {
      // [device_is] match
      if( in_array( Helpers::get_remote_device_type(), $atts['type'] ) ) $display_content = true;
    } else {
      // [device_is_not] match
      if( !in_array( Helpers::get_remote_device_type(), $atts['type'] ) ) $display_content = true;
    }

    return $display_content ? do_shortcode( $content ) : '';

  }

}