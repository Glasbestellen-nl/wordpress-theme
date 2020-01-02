<?php
class Relation {

   protected $id;

   protected $data;

   public function __construct( $id ) {
      $this->id = $id;
      $this->data = get_userdata( $id );
   }

   public function get_name() {
      return isset( $this->data->display_name ) ? $this->data->display_name : '';
   }

   public function get_email() {
      return isset( $this->data->user_email ) ? $this->data->user_email : '';
   }

   public function get_phone() {
      return $this->get_meta( 'user_phone' );
   }

   public function get_residence() {
      return $this->get_meta( 'user_residence' );
   }

   public function get_meta( $meta_key ) {
      return get_user_meta( $this->id, $meta_key, true );
   }

}
