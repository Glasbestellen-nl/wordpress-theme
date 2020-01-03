<?php
class Rectangle {

   protected $dimensions = [];

   public function __construct( float $width = 0, float $length = 0 ) {
      $this->dimensions['width']  = $width;
      $this->dimensions['length'] = $length;
   }

   public function deduct( $direction = 'width', float $value = 0 ) {
      $this->dimensions[$direction] -= $value;
   }

   public function deduct_width( float $value ) {
      $this->deduct( 'width', $value );
   }

   public function deduct_length( float $value ) {
      $this->deduct( 'length', $value );
   }

   public function display_dimensions() {
      return $this->dimensions['width'] . 'mm x ' . $this->dimensions['length'] . 'mm';
   }

}
