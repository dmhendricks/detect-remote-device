<?php
namespace CloudVerve\Detect_Remote_Device\Shortcodes;
use CloudVerve\Detect_Remote_Device\Plugin;

final class Shortcode_Loader extends Plugin {

  /**
   * Shortcode loader
   * 
   * @since 1.0.0
   */

    private static $class;
    private static $shortcodes;

    public static function init() {

        if ( !isset( self::$class ) && !( self::$class instanceof Shortcode_Loader ) ) {

            self::$class = new Shortcode_Loader();

            self::$shortcodes = [
                Device_Type_Shortcodes::class,
                Device_Matches_Shortcode::class
            ];

            foreach( self::$shortcodes as $shortcodeClass ) {
                if( class_exists( $shortcodeClass ) ) $shortcodeClass::load();
            }
            
        }

        return self::$class;

    }

}