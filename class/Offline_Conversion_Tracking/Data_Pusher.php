<?php
namespace Offline_Conversion_Tracking;

use TheIconic\Tracking\GoogleAnalytics\Analytics;

class Data_Pusher {

   public function __construct() {
      add_action( 'wp', array( $this, 'schedule_tasks' ) );
      add_action( 'upload_offline_conversions', array( $this, 'upload_offline_conversions' ) );
      $this->upload_offline_conversions();
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

      print_r( $this->get_conversions() );

      foreach ( $this->get_conversions() as $conversion ) {

         $analytics->setProtocolVersion('1')
            ->setTrackingId( get_option( 'ga_tracking_id' ) )
            ->setClientId( $conversion['client_id'] );

         $analytics->setTransactionId( $conversion['lead_id'] )
            ->setAffiliation( 'form' )
            ->setRevenue( $conversion['revenue'] )
            ->setShipping( $conversion['shipping_price'] )
            ->setTax( \Money::vat( $conversion['revenue'] ) )
            ->sendTransaction();

         if ( ! empty( $conversion['items'] ) ) {
            foreach ( $conversion['items'] as $item ) {
               $analytics->setTransactionId( $conversion['lead_id'] )
                  ->setItemName( $item['name'] )
                  ->setItemPrice( $item['price'] )
                  ->setItemQuantity( $item['quantity'] )
                  ->sendItem();
            }
         }

         \CRM::update_lead_meta( $conversion['lead_id'], 'conversion_data_pushed', 1 );

      }

   }

   public function get_conversions() {

      $leads = \CRM::get_leads_by_status( 'order' );

      if ( empty( $leads ) ) return;

      $conversions = [];

      foreach ( $leads as $lead ) {

         if ( ! \CRM::get_lead_meta( $lead->get_id(), 'conversion_data_pushed', true ) ) {

            $conversion_data = \CRM::get_lead_meta( $lead->get_id(), 'conversion_data', true );
            $client_id = \CRM::get_lead_meta( $lead->get_id(), 'gclid', 'true' );

            $conversion = [
               'lead_id' => $lead->get_id(),
               'revenue' => $conversion_data['revenue'],
               'shipping_price' => $conversion_data['shipping_price'],
               'items' => $conversion_data['items'],
               'client_id' => $client_id
            ];

            $conversions[] = $conversion;

         }
      }

      return $conversions;

   }

}
