<?php
class Price_Matrix {

   protected $_lines = [];

   public function __construct( $csv_file = '' ) {
      $this->convert_csv_to_array( $csv_file );
   }

   public function get_price( $x_value = 0, $y_value = 0 ) {

      if ( empty( $this->_lines ) ) return;

      foreach ( $this->_lines as $index => $line ) {
         $y_values[] = $line[0];
      }

      $x_index = $this->find_closest( $x_value, $this->_lines[0] );
      $y_index = $this->find_closest( $y_value, $y_values );

      $price = $this->_lines[$y_index][$x_index];
      return ! empty( $price ) ? str_replace( ',', '.', $price ) : 0;
   }

   protected function find_closest( $target_value, array $values = [] ) {

      $closest_index = 0;
      $closest = 0;

      foreach ( $values as $index => $value ) {
         if ( ! empty( $value ) ) {
            if ( $target_value <= $value && ( abs( $target_value - $closest ) > abs( $value - $target_value ) ) ) {
               $closest = $value;
               $closest_index = $index;
            }
         }
      }
      return $closest_index;
   }

   protected function convert_csv_to_array( $csv_file = '' ) {

      if ( empty( $csv_file ) ) return;

      $handle = fopen( $csv_file, 'r' );
      while ( ( $line = fgetcsv( $handle, 1000, "," ) ) !== FALSE ) {
         $this->_lines[] = $line;
      }
      fclose( $handle );
   }


}
