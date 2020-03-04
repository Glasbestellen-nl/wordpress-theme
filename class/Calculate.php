<?php
class Calculate {

   static public function to_square_meters( $width = 0, $height = 0 ) {
      return ( $width * $height ) / 1000000;
   }

   static public function to_circumference( $width = 0, $height = 0 ) {
      return ( ( $width * 2 ) + ( $height * 2 ) ) / 1000;
   }

}
