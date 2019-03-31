<?php
namespace CloudVerve\Detect_Mobile_Device;

final class Core extends Plugin {

  private static $class;

  public static function init() {

    if ( !isset( self::$class ) && !( self::$class instanceof Core ) ) {

      self::$class = new Core();

      // TODO

    }

    return self::$class;

  }

}