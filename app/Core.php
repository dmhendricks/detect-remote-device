<?php
namespace CloudVerve\Detect_Mobile_Device;

final class Core extends Plugin {

  private static $class;

  public static function init() {

    if ( !isset( self::$class ) && !( self::$class instanceof Core ) ) {

      self::$class = new Core();

      // Add device body classes
      if( !( defined( 'DMD_BODY_CLASS_PREFIX' ) && DMD_BODY_CLASS_PREFIX === false ) )
        add_filter( 'body_class', array( self::$class, 'device_body_classes' ) );

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

    // Add device body class tag(s)
    $device = new \Mobile_Detect;
    if( $device->isMobile() ) $classes[] = $class_prefix . '-mobile';
    if( $device->isTablet() ) $classes[] = $class_prefix . '-tablet';
    if( $device->isMobile() && !$device->isTablet() ) $classes[] = $class_prefix . '-phone';
    if( !$device->isMobile() ) $classes[] = $class_prefix . '-desktop';

    return is_admin() ? implode( ' ', $classes ) : $classes;

  }


}