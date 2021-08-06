<?php
namespace Configurator;

class Archive {

   protected $_product_id;

   protected $_filters;

   protected $_query_args;

   public function __construct( int $product_id = 0, array $filters = [] ) {
      $this->_product_id = $product_id;
      $this->set_filters( $filters );
      $this->set_items_query_args();
   }

   protected function set_items_query_args() {

      $term_id = get_post_meta( $this->_product_id, 'configurator', true );

      if ( ! $term_id ) return;

      $this->_query_args = [
         'post_type' => 'configurator',
         'posts_per_page' => -1,
         'orderby' => 'menu_order',
         'order' => 'desc',
         'tax_query' => [
            [
               'taxonomy' => 'startopstelling',
               'terms' => $term_id
            ]
         ]
      ];

      if ( ! empty( $this->_filters ) ) {
         foreach ( $this->_filters as $parent_filter => $child_filter ) {
            if ( term_exists( $child_filter, 'filter' ) ) {
               $this->_query_args['tax_query'][] = [
                  'taxonomy' => 'filter',
                  'terms' => $child_filter,
                  'field' => 'slug'
               ];
            }
         }
      }
   }

   public function get_items_query_object() {
      return new \WP_Query( $this->_query_args );
   }

   public function get_items() {
      return get_posts( $this->_query_args );
   }

   public function set_filters( array $filters = [] ) {
      $this->_filters = $filters;
   }

   public function get_filters() {

      if ( $items = $this->get_items() ) {
         $filters = [];
         foreach ( $items as $item ) {
            if ( $terms = get_the_terms( $item->ID, 'filter' ) ) {
               foreach ( $terms as $term ) {
                  if ( $term->parent == 0 ) {
                     $filters[$term->term_id]['title'] = $term->name;
                     $filters[$term->term_id]['value'] = $term->slug;
                  } else {
                     $filters[$term->parent]['options'][$term->term_id] = [
                        'title' => $term->name,
                        'value' => $term->slug
                     ];
                  }
               }
            }
         }
         return $filters;
      }
   }

}
