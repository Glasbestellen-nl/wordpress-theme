<?php
class Lead {

   protected $data;

   protected $metadata;

   public function __construct( $data, $metadata ) {
      $this->data = $data;
      $this->metadata = $metadata;
   }

   public function get_id() {
      return $this->data->lead_id;
   }

   public function get_content() {
      return $this->data->lead_content;
   }

   public function get_date( $format = 'd F Y h:m' ) {
      return date_format( date_create( $this->data->lead_date ), $format );
   }

   public function get_relation() {
      return new Relation( $this->data->lead_relation );
   }

   public function get_status() {
      return $this->get_meta( 'lead_status' );
   }

   public function get_owner() {
      return $this->get_meta( 'lead_owner' );
   }

   public function get_note() {
      return $this->get_meta( 'lead_note' );
   }

   public function get_attachments() {

      $id = $this->data->lead_id;
      $base_path = gb_get_lead_attachments_dir() . '/' . $id;
      $base_url  = gb_get_lead_attachments_uri();

      if ( $files = glob( $base_path . '/*' ) ) {
         $attachments = [];
         foreach ( $files as $index => $path ) {
            $filename = basename( $path );
            $url = $base_url . '/' . $id . '/' . $filename;
            $attachments[$index]['filename'] = $filename;
            $attachments[$index]['url'] = $url;
         }
         return $attachments;
      }
      return false;
   }

   public function get_meta( $meta_key ) {

      if ( empty( $meta_key ) )
         return;

      if ( ! empty( $this->metadata ) ) {
         foreach ( $this->metadata as $obj ) {
            if ( $obj->meta_key == $meta_key )
               return $obj->meta_value;
         }
      }
      return false;
   }

}
