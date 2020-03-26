<?php
// Load wordpress
if ( empty( $_SERVER['REMOTE_ADDR'] ) || in_array( $_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'] ) ) {
   $parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
} else {
   $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
}
require_once( $parse_uri[0] . 'wp-load.php');

echo 'Started..' . PHP_EOL;

// Upload offline conversions to Google Analytics
$data_pusher = new Offline_Conversion_Tracking\Data_Pusher;
$data_pusher->upload_offline_conversions();

echo 'Done..' . PHP_EOL;
