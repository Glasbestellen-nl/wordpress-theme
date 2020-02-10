<?php
$parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
require_once( $parse_uri[0] . 'wp-load.php');

$json = file_get_contents( get_template_directory() . '/import-data/leads.json' );
$leads = json_decode( $json, true );

if ( empty( $leads ) ) return;

foreach ( $leads as $lead ) {

   // Insert lead
   $lead_id = CRM::insert_lead( $lead['lead_data'] );
   echo 'Inserted new lead' . PHP_EOL;

   // Update lead meta
   if ( ! empty( $lead['lead_meta'] ) ) {
      foreach ( $lead['lead_meta'] as $meta_key => $meta_value ) {

         if ( 'status' == $meta_key ) {
            switch ( $meta_value ) {
               case 'afgekeurd':
                  $meta_value = 'answered';
                  break;
               case 'afwachten':
                  $meta_value = 'wait';
                  break;
               case 'beantwoord':
                  $meta_value = 'answered';
                  break;
               case 'offerte':
                  $meta_value = 'quote';
                  break;
               case 'online-besteld':
                  $meta_value = 'answered';
                  break;
            }
            CRM::update_lead_status( $lead_id, $meta_value );
         } else {
            CRM::update_lead_meta( $lead_id, $meta_key, $meta_value );
         }
         echo 'Updated lead meta ' . $meta_key . PHP_EOL;
      }
   }

   // Update lead owner
   if ( ! empty( $lead['owner'] ) ) {
      if ( $user = get_user_by( 'email', $lead['owner']['user_email'] ) ) {
         $owner_id = $user->ID;
      } else {
         unset( $lead['owner']['ID'] );
         $owner_id = wp_insert_user( $lead['owner'] );
      }
      CRM::update_lead_meta( $lead_id, 'lead_owner', $owner_id );
      echo 'Updated lead owner' . PHP_EOL;
   }

   // Update lead conversion data
   if ( ! empty( $lead['conversion_data'] ) ) {
      CRM::update_lead_meta( $lead_id, 'conversion_data', $lead['conversion_data'] );
      echo 'Updated lead conversion data' . PHP_EOL;
   }

   // Upload lead attachments
   if ( ! empty( $lead['attachments'] ) ) {
      foreach ( $lead['attachments'] as $attachment_url ) {

         $filename = basename( $attachment_url );

         $path = gb_get_lead_attachments_dir() . '/' . $lead_id;
         if ( ! is_dir( $path ) ) {
            mkdir( $path );
         }
         $destination = $path . '/' . $filename;

         if ( ! file_exists( $destination ) ) {
            copy( $attachment_url, $destination );
            echo 'Uploaded attachment: ' . $destination . PHP_EOL;
         }
      }
   }

}
