<?php
class Cart {

   protected $items;

   protected $current_index;

   protected $item;

   protected $total;

   public function __construct( array $items = [] ) {
      $this->items = $items;
      $this->current_index = 0;
      $this->item = false;
      $this->total = 0;
   }

   public function get_item_id() {
      return key( $this->items );
   }

   public function get_item_thumbnail() {
      $this->item_exists();
      return get_the_post_thumbnail_url( $this->item['post_id'] );
   }

   public function get_item_title() {
      $this->item_exists();
      return get_the_title( $this->item['post_id'] );
   }

   public function get_item_summary() {
      $this->item_exists();
      return $this->item['summary'];
   }

   public function get_item_quantity() {
      $this->item_exists();
      return $this->item['quantity'];
   }

   public function get_item_price() {
      $this->item_exists();
      return $this->item['price'] * $this->item['quantity'];
   }

   public function item_exists() {
      if ( ! $this->item ) return;
   }

   public function the_item() {
      $id = $this->get_item_id();
      $this->item = $this->items[$id];
      next( $this->items );
      $this->current_index ++;
   }

   public function have_items() {
      return $this->current_index < count( $this->items );
   }

   public function get_items() {
      return ! empty( $this->items ) ? $this->items : false;
   }

   public function get_total_price() {

      $total = 0;

      if ( empty( $this->items ) )
         return $total;

      $total = array_reduce( $this->items, function( $carry, $item ) {
         $carry += $item['price'] * $item['quantity'];
         return $carry;
      });

      return $total;
   }

   public function add_item( int $post_id = null, float $price = 0, int $quantity = 1, array $summary, array $configuration ) {

      if ( empty( $post_id ) )
         return;

      $item = [
         'post_id' => $post_id,
         'price' => $price,
         'quantity' => $quantity,
         'summary' => $summary,
         'configuration' => $configuration
      ];
      $id = time();
      $this->items[$id] = $item;
      return $id;
   }

   public function remove_item( int $id = 0 ) {
      unset( $this->items[$id] );
      return true;
   }

   public function update_item_quantity( int $id = 0, int $quantity = 0 ) {

      if ( empty( $this->items[$id] ) ) return;

      if ( $quantity > 0 ) {
         $this->items[$id]['quantity'] = $quantity;
      } else {
         $this->remove_item( $id );
      }

      return true;
   }



   // Edit (configured) cart item

   // Configure another one

}
