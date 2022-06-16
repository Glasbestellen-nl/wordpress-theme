<?php
if ( class_exists( 'WC_Product_Extended' ) ) {

    class WC_Product_Configurable extends WC_Product_Extended {

        public $price;

        public function __construct( $product ) {
            parent::__construct( $product );
            $this->product_type = 'configurable';
        }

        public function get_type(){
            return 'configurable';
        }

        public function get_configurator_id() {
            $configurator_id = get_post_meta( $this->id, 'configurator', true );
            return $configurator_id;
        }

        public function get_configurator() {
            return gb_get_configurator( $this->get_configurator_id() );
        }

    }

}
