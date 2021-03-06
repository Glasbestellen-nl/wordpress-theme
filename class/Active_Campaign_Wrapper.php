<?php
class Active_Campaign_Wrapper {

   const ACTIVECAMPAIGN_URL = 'https://glasbestellennl.api-us1.com';
   const ACTIVECAMPAIGN_API_KEY = '35c85095c4acfb71776cd45505c42635da04dd733ca6b991e659aa2bfa3781590db33407';
   const ACTIVECAMPAIGN_ACTID = '253986739';
   const ACTIVECAMPAIGN_EVENT_KEY = 'cb8e76e52d285ee41de8bd94291effd76f389842';

   protected static $instance;

   protected static $activecampaign;

   protected function __construct() {
      try {
         $activecampaign = new ActiveCampaign( self::ACTIVECAMPAIGN_URL, self::ACTIVECAMPAIGN_API_KEY );
         if ( ! (int) $activecampaign->credentials_test() ) {
            error_log( 'Access denied: Invalid credentials (URL and/or API key).' );
            exit();
         }
         self::$activecampaign = $activecampaign;
      } catch ( Exception $e ) {
         error_log( $e->getMessage() );
      }
   }

   public static function get_instance() {
      if ( is_null( self::$instance ) ) {
         self::$instance = new self();
      }
      return self::$instance;
   }

   public static function update_contact( string $email, array $contact_data = [] ) {
      try {
         $post_data = [...$contact_data, 'email' => $email];
         $response = self::$activecampaign->api( 'contact/sync', $post_data );
         if ( ! (int) $response->success ) {
            error_log( 'Syncing contact failed. Error returned: ' . $response->error );
            exit();
         }
         return $response;
      } catch ( Exception $e ) {
         error_log( $e->getMessage() );
      }
   }

   public static function log_event( string $email, string $event, string $event_data = '' ) {
      try {
         $success = self::update_contact( $email );
         if ( ! $success ) return;
         self::$activecampaign->track_actid = self::ACTIVECAMPAIGN_ACTID;
         self::$activecampaign->track_key   = self::ACTIVECAMPAIGN_EVENT_KEY;
         self::$activecampaign->track_email = $email;
         $post_data = [
            'event' => $event,
            'eventdata' => $event_data
         ];
         $response = self::$activecampaign->api( 'tracking/log', $post_data );
         if ( ! (int) $response->success ) {
            error_log( 'Tracking event failed' );
            exit();
         }
         return $response;
      } catch ( Exception $e ) {
         error_log( $e->getMessage() );
      }
   }

}
