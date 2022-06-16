<?php
if ( class_exists( 'WC_Product' ) ) {

    class WC_Product_Extended extends WC_Product {

        public function __construct( $product ) {
            parent::__construct( $product );
        }

        public function get_faq_page_id() {
            return get_field( 'faq_post_id', $this->id );
        }

        public function get_faq_page_url() {
            $page_id = $this->get_faq_page_id();
            if ( ! $page_id ) return;
            return get_permalink( $this->get_faq_page_id() );
        }

        public function get_explanation_page_id() {
            return get_field( 'explanation_page_id', $this->id );
        }

        public function get_explanation_page_url() {
            $page_id = $this->get_explanation_page_id();
            if ( ! $page_id ) return;
            return get_permalink( $this->get_explanation_page_id() );
        }

        public function get_info_file_url( string $info ) {
            switch ( $info ) {
                case 'corrections' :
                    return get_field( 'corrections_instruction', $this->id );
                    break;
                case 'measurement' :
                    return get_field( 'measure_instruction', $this->id );
                    break;
                case 'fittings' :
                    return get_field( 'fittings_info', $this->id );
                    break;                    
                default :
                    return get_field( 'assembly_instruction', $this->id );
            }
        }

        public function get_reference() {
            return get_post_meta( $this->id, 'configurator_reference', true );
        }

    }

}