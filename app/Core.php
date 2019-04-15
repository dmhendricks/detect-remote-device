<?php
namespace CloudVerve\Detect_Remote_Device;
use DeviceDetector\DeviceDetector;
use Jenssegers\Agent\Agent;

final class Core extends Plugin {

  private static $class;

  public static function init() {

    if ( !isset( self::$class ) && !( self::$class instanceof Core ) ) {

      self::$class = new Core;

      // Add device body classes
      add_filter( 'body_class', array( self::$class, 'device_body_classes' ) );

      // Modify wp_is_mobile() to return false for tablets
      if( defined( 'DMD_MODIFY_WP_IS_MOBILE' ) && DMD_MODIFY_WP_IS_MOBILE ) {

        $agent = new Agent;
        add_filter( 'wp_is_mobile', $agent->isPhone() ? '__return_true' : '__return_false' );

      }

      // Filter to detect if device is mobile
      add_filter( 'device_is_mobile', array( 'CloudVerve\Detect_Remote_Device\Helpers', 'device_is_mobile' ) );

      // Filter to detect if device is a phone
      add_filter( 'device_is_phone', array( 'CloudVerve\Detect_Remote_Device\Helpers', 'device_is_phone' ) );

      // Filter to detect if device is a tablet
      add_filter( 'device_is_tablet', array( 'CloudVerve\Detect_Remote_Device\Helpers', 'device_is_tablet' ) );

      // Filter to detect if device is destop
      add_filter( 'device_is_desktop', array( 'CloudVerve\Detect_Remote_Device\Helpers', 'device_is_desktop' ) );

      // Filter to fetch user agent information
      add_filter( 'get_user_agent', array( 'CloudVerve\Detect_Remote_Device\Helpers', 'get_user_agent' ) );

      // Filter to fetch the device type
      add_filter( 'get_device_type', array( 'CloudVerve\Detect_Remote_Device\Helpers', 'get_device_type' ) );

    }

    return self::$class;

  }

  /**
   * Add device type classes to page <body>
   *
   * @param array $classes An array of current body classes
   * @since 1.0.0
   */
  public function device_body_classes( $classes ) {

    // Support adding body classes via admin_body_class filter
    if( is_admin() ) $classes = explode( ' ', $classes );

    // Set the body class prefix. Default: device
    $class_prefix = defined( 'DMD_BODY_CLASS_PREFIX' ) && is_string( DMD_BODY_CLASS_PREFIX ) && !empty( DMD_BODY_CLASS_PREFIX ) ? DMD_BODY_CLASS_PREFIX : 'device';

    // Add device body class tags
    if( !( defined( 'DMD_ADD_DEVICE_TYPE_BODY_CLASSES' ) && !DMD_ADD_DEVICE_TYPE_BODY_CLASSES ) ) {
      $agent = new Agent;
      if( $agent->isMobile() ) $classes[] = $class_prefix . '-mobile';
      if( $agent->isTablet() ) $classes[] = $class_prefix . '-tablet';
      if( $agent->isPhone() ) $classes[] = $class_prefix . '-phone';
      if( $agent->isDesktop() ) $classes[] = $class_prefix . '-desktop';  
    }

    // Add operating system tag
    if( defined( 'DMD_ADD_PLATFORM_BODY_CLASSES' ) && DMD_ADD_PLATFORM_BODY_CLASSES ) {
      $classes[] = $class_prefix . '-' . sanitize_title( $agent->device() );
      $device = new DeviceDetector( $_SERVER['HTTP_USER_AGENT'] );
      $device->discardBotInformation();
      $device->parse();
      if( isset( $device->getOs()['name'] ) ) $classes[] = $class_prefix . '-' . sanitize_title( $device->getOs()['name'] );
    }

    return is_admin() ? implode( ' ', $classes ) : $classes;

  }

}
