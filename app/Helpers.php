<?php
namespace CloudVerve\Detect_Mobile_Device;

final class Helpers extends Plugin {

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