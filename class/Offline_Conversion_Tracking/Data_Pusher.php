<?php
namespace Offline_Conversion_Tracking;
use \CRM;

class Data_Pusher {

   public function upload_offline_conversions() {

      $conversions = $this->get_conversions();
      if (!$conversions) return;

      $url = get_option('offline_conversion_webhook_url');
      if (!$url) return;

      foreach ($conversions as $conversion) {

         // Send data to Google Analytics 4 when client id is available
         if (!empty($data['client_id'])) {
            $this->send_offline_conversion_to_ga4($conversion);
         }

         // Make webhook call
         $data = [
            'lead_id' => $conversion['lead_id'],
            'revenue' => $conversion['revenue'],
            'shipping_price' => $conversion['shipping_price'],
            'items' => $conversion['items'],
            'client_id' => $conversion['client_id'],
            'gclid' => $conversion['gclid'],
            'timestamp' => $conversion['timestamp']
         ];
         $this->make_webhook_post_request($url, $data);

         CRM::update_lead_meta( $conversion['lead_id'],  'conversion_data_pushed', 1 );
      }
      return $conversions;
   }

   public function make_webhook_post_request($url, $data) {
      
      $headers = [
         'Content-Type' => 'application/json',
         'Accept' => 'application/json'
      ];

      $response = wp_remote_post( $url, [
         'headers' => $headers,
         'body' => json_encode( $data )
      ] );

      if ( is_wp_error( $response ) ) {
         return false;
      }

      $response_code = wp_remote_retrieve_response_code( $response );

      if ( $response_code !== 200 ) {
         return false;
      }
      return true;
   }

   public function send_offline_conversion_to_ga4($conversion) {

      $measurement_id = 'G-XXXXXXXXXX';
      $api_secret = '<secret_value>'; 
      $request_url = "https://www.google-analytics.com/mp/collect?measurement_id={$measurement_id}&api_secret={$api_secret}";
  
      $client = new \GuzzleHttp\Client();
  
      $items = [];
      if (!empty($conversion['items'])) {
         foreach ($conversion['items'] as $item) {
            $items[] = [
               'item_name' => $item['name'],
               'currency'  => 'EUR',
               'quantity'  => 'quantity',
               'shipping'  => $conversion['shipping_price']
            ];
         }
      }
  
      $body = [
          'client_id' => $conversion['client_id'],
          'events' => [
              [
                  'name' => 'offline_purchase',
                  'params' => [
                     'transaction_id' => 'L_' . $conversion['lead_id'],
                     'value' => $conversion['revenue'],
                     'currency' => 'EUR',
                     'items' => $items,
                  ],
              ],
          ],
      ];
  
      try {
          $response = $client->post($request_url, [
              'json' => $body,
          ]);
  
          if ($response->getStatusCode() !== 200) {
              // Handle non-successful response
              return false;
          }
  
          return true;
      } catch (\Exception $e) {
          // Handle exception
          return false;
      }
   }  

   public function get_conversions() {

      $leads = CRM::get_leads_by_status( 'order' );

      if ( empty( $leads ) ) return;

      $conversions = [];

      foreach ( $leads as $lead ) {

         if (!CRM::get_lead_meta( $lead->lead_id, 'conversion_data_pushed', true)) {

            $conversion_data = CRM::get_lead_meta( $lead->lead_id, 'conversion_data', true );
            $client_id = CRM::get_lead_meta( $lead->lead_id, 'gclid', 'true' );
            $gclid = CRM::get_lead_meta( $lead->lead_id, 'ads_gclid', 'true' );

            if ($conversion_data && ($client_id || $gclid)) {

               $conversion = [
                  'lead_id' => $lead->lead_id,
                  'revenue' => $conversion_data['revenue'],
                  'shipping_price' => ! empty( $conversion_data['shipping_price'] ) ? $conversion_data['shipping_price'] : 0,
                  'items' => ! empty( $conversion_data['items'] ) ? $conversion_data['items'] : [],
                  'client_id' => $client_id,
                  'gclid' => $gclid,
                  'timestamp' => time()
               ];
               $conversions[] = $conversion;
            }
         }
      }
      return $conversions;
   }

}
