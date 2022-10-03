<?php
class Utilities { 
    
    public static function convert_mm_string_to_cm( $value = '', $size_unit = 'mm' ) {
        $value = ( $size_unit == 'cm' && is_numeric( $value ) ) ? $value / 10 : $value;
        $value = preg_replace_callback( '/\d+(?:[,.]\d+)?(?=\s*(?:mm))/', function( $matches ) {
           return ( $matches[0] / 10 );
        }, $value );
        $value = str_replace( 'mm', 'cm', $value );
        return $value;  
    }
}