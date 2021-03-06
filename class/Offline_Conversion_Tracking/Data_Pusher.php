<?php
namespace Offline_Conversion_Tracking;

use TheIconic\Tracking\GoogleAnalytics\Analytics;

class Data_Pusher {

   public function upload_offline_conversions() {

      if ( ! $this->get_conversions() ) return;

      $analytics = new Analytics();

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

         if ( ! \CRM::get_lead_meta( $lead->lead_id, 'conversion_data_pushed', true ) ) {

            $conversion_data = \CRM::get_lead_meta( $lead->lead_id, 'conversion_data', true );
            $client_id = \CRM::get_lead_meta( $lead->lead_id, 'gclid', 'true' );

            if ( $conversion_data && $client_id ) {

               $conversion = [
                  'lead_id' => $lead->lead_id,
                  'revenue' => $conversion_data['revenue'],
                  'shipping_price' => ! empty( $conversion_data['shipping_price'] ) ? $conversion_data['shipping_price'] : 0,
                  'items' => ! empty( $conversion_data['items'] ) ? $conversion_data['items'] : [],
                  'client_id' => $client_id
               ];

               $conversions[] = $conversion;

            }

         }
      }

      return $conversions;

   }

}
