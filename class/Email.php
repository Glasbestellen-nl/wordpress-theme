<?php
class Email {

   protected $subject;

   protected $html;

   protected $receiver_emails;

   public function __construct( string $subject = '' ) {
      $this->subject = $subject;
      $this->receiver_emails = [];
      $this->html = '';
   }

   public function add_receiver_email( $receiver_email = '' ) {
      $this->receiver_emails[] = $receiver_email;
   }

   public function set_template( $html = '' ) {
      $this->html = $html;
   }

   public function send() {
      if ( empty( $this->receiver_emails ) ) return;
      foreach ( $this->receiver_emails as $receiver_email ) {
         wp_mail( $receiver_email, $this->subject, $this->html, ['Content-Type: text/html; charset=UTF-8'] );
      }
      return true;
   }

}
