<?php
class Money {

   public static function display( $value = 0, $including_vat = true ) {
      $symbol = '&euro;';

      $value = ( $including_vat ) ? self::including_vat( $value ) : $value;
      return $symbol . self::format( $value );
   }

   public static function format( $value = 0 ) {
      return number_format( $value, 2, ',', '.' );
   }

   public static function including_vat( $value = 0 ) {
      return $value * 1.21;
   }

   public static function vat( $value = 0 ) {
      return $value * 0.21;
   }

}
