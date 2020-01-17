<?php
use TheIconic\Tracking\GoogleAnalytics\Analytics;

namespace Offline_Conversion_Tracking;

class Data_Pusher {

   public function __construct() {
      add_action( 'wp', array( $this, 'schedule_tasks' ) );
      add_action( 'upload_offline_conversions', array( $this, 'upload_offline_conversions' ) );
   }

   public function schedule_tasks() {
      $timestamp = wp_next_scheduled( 'upload_hourly_offline_conversions' );
   	if ( $timestamp == false ) {
   		wp_schedule_event( time(), 'hourly', 'upload_hourly_offline_conversions' );
   	}
   }

   public function upload_offline_conversions() {

      if ( ! $this->get_conversions() ) return;

      $analytics = new Analytics();

      foreach ( $this->get_conversions() as $conversion ) {

         $analytics->setProtocolVersion('1')
            ->setTrackingId( get_option( 'ga_tracking_id' ) )
            ->setClientId( $conversion['client_id'] );

         $analytics->setTransactionId( $conversion['transaction_id'] )
            ->setAffiliation( 'form' )
            ->setRevenue( $conversion['revenue'] )
            ->setShipping( $conversion['shipping_price'] )
            ->setTax( \Money::vat( $conversion['revenue'] ) )
            ->sendTransaction();

         if ( ! empty( $conversion['items'] ) ) {
            foreach ( $conversion['items'] as $item ) {
               $analytics->setTransactionId( $conversion['transaction_id'] )
                  ->setItemName( $item['name'] )
                  ->setItemPrice( $item['price'] )
                  ->setItemQuantity( 1 )
                  ->sendItem();
            }
         }
      }

   }

   public function get_conversions() {

      $leads = CRM::get_leads_by_status( 'order' );

      if ( empty( $leads ) ) return;

      $conversions = [];

      foreach ( $leads as $lead ) {
         $conversion_data = CRM::get_lead_meta( $lead->lead_id, 'conversion_data', true );
         $client_id = CRM::get_lead_meta( $lead->lead_id, 'gclid', 'true' );

         $conversion = [
            'transaction_id' => $lead->lead_id,
            'revenue' => $conversion_data['revenue'],
            'shipping_price' => $conversion_data['shipping_price'],
            'items' => $conversion_data['items'],
            'client_id' => $client_id
         ];

         $conversions[] = $conversion;
      }

      return $conversions;

   }

}
