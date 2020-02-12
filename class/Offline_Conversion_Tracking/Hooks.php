<?php
namespace Offline_Conversion_Tracking;

class Hooks {

   public function __construct() {
      add_action( 'wp_ajax_get_dashboard_item_row_html', array( $this, 'ajax_get_dashboard_item_row_html' ) );
      add_action( 'wp_ajax_save_dasboard_conversion', array( $this, 'ajax_save_dasboard_conversion' ) );
   }

   public function ajax_get_dashboard_item_row_html() {
      $dashboard_ui = new Dashboard_UI;
      $dashboard_ui->render_table_row();
      wp_die();
   }

   public function ajax_save_dasboard_conversion() {

      $conversion_data = new Conversion_Data;

      if ( empty( $_POST['lead_id'] ) ) wp_die();

      if ( empty( $_POST['conversion']['revenue'] ) ) wp_die();

      $input = $_POST['conversion'];

      $conversion_data->set_revenue( $input['revenue'] );
      $conversion_data->set_shipping_price( $input['shipping_price'] );

      if ( ! empty( $input['item_names'] ) ) {
         foreach ( $input['item_names'] as $index => $item_name ) {

            if ( ! empty( $input['item_prices'][$index] ) )
            $conversion_data->add_item( $item_name, $input['item_prices'][$index], $input['item_quantities'][$index] );
         }
      }

      \CRM::update_lead_meta( $_POST['lead_id'], 'conversion_data', $conversion_data->get_data() );

      wp_die();
   }

}
