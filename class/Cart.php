<?php
class Cart {

   // Cart items array
   protected $items;

   // Current index in cart items array
   protected $current_index;

   // Current id in cart items array
   protected $current_id;

   // Current cart item
   protected $item;

   public function __construct( array $items = [] ) {
      $this->items = $items;
      $this->current_index = 0;
      $this->current_id = 0;
      $this->item = [];
   }

   /**
    * Returns current cart item id
    */
   public function get_item_id() {
      return $this->current_id;
   }

   /**
    * Checks whether there are cart items
    */
   public function have_items() {
      return $this->current_index < count( $this->items );
   }

   /**
    * Sets the current cart item and sets index to the next
    */
   public function the_item() {
      $this->set_current_item();
      $this->current_index ++;
   }

   /**
    * Sets current cart item id
    */
   public function set_current_id() {
      if ( ! $this->have_items() ) return;
      $ids = array_keys( $this->items );
      $this->current_id = $ids[$this->current_index];
   }

   /**
    * Sets current cart item
    */
   public function set_current_item() {
      $this->set_current_id();
      $this->item = $this->items[$this->current_id];
   }

   /**
    * Returns all the cart items
    */
   public function get_items() {
      return $this->items;
   }

   /**
    * Returns a cart item by id
    */
   public function get_item( int $id ) {
      return ! empty( $this->items[$id] ) ? $this->items[$id] : false;
   }

   /**
    * Returns cart item thumbnail
    */
   public function get_item_thumbnail() {
      return get_the_post_thumbnail_url( $this->item['post_id'] );
   }

   /**
    * Returns cart item title
    */
   public function get_item_title() {
      return get_the_title( $this->item['post_id'] );
   }

   /**
    * Returns cart item summary
    */
   public function get_item_summary() {
      return $this->item['summary'];
   }

   /**
    * Returns cart item quantity
    */
   public function get_item_quantity() {
      return $this->item['quantity'];
   }

   /**
    * Returns cart item price
    */
   public function get_item_price() {
      return $this->item['price'] * $this->item['quantity'];
   }

   public function get_item_category( $taxonomy = 'startopstelling', $output = 'name' ) {
      return get_first_term_by_id( $this->item['post_id'], $taxonomy, $output );
   }

   /**
    * Checks whether current item isset
    */
   public function item_exists() {
      if ( empty( $this->item ) ) return;
   }

   /**
    * Returns total cart price
    */
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

   /**
    * Returns total cart quantity
    */
   public function get_total_quantity() {

      $quantity = 0;

      if ( empty( $this->items ) )
         return $quantity;

      $quantity = array_sum( array_column( $this->items, 'quantity' ) );

      return $quantity;

   }

   /**
    * Adds cart item
    */
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

   /**
    * Deleted cart item
    */
   public function delete_item( int $id = 0 ) {
      unset( $this->items[$id] );
      return true;
   }

   /**
    * Updates cart item quantity
    */
   public function update_item_quantity( int $id = 0, int $quantity = 0 ) {

      if ( empty( $this->items[$id] ) ) return;

      if ( $quantity > 0 ) {
         $this->items[$id]['quantity'] = $quantity;
      } else {
         $this->delete_item( $id );
      }
      return true;
   }


}
