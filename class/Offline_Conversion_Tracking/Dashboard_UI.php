<?php
namespace Offline_Conversion_Tracking;

class Dashboard_UI {

   protected $conversion_data;

   public function set_conversion_data( Conversion_Data $conversion_data ) {
      $this->conversion_data = $conversion_data;
   }

   public function render_fields() { ?>

      <div class="form-row">
         <label for="" class="form-row-label"><?php _e( 'Omzet', 'glasbestellen' ); ?>:</label>
         <input type="text" name="conversion[revenue]" value="<?php echo $this->conversion_data->get_revenue(); ?>" placeholder="00.00">
         <p class="description"><?php _e( 'Ex. BTW.', 'glasbestellen' ); ?></p>
      </div>

      <div class="form-row">
         <label for="" class="form-row-label"><?php _e( 'Verzendkosten', 'glasbestellen' ); ?>:</label>
         <input type="text" name="conversion[shipping_price]" value="<?php echo $this->conversion_data->get_shipping_price(); ?>" placeholder="00.00">
         <p class="description"><?php _e( 'Ex. BTW.', 'glasbestellen' ); ?></p>
      </div>

      <?php
   }

   public function render_table() { ?>

      <table class="wp-list-table widefat fixed" width="100%">
         <thead>
            <tr>
               <th><?php _e( 'Product', 'glasbestellen' ); ?></th>
               <th><?php _e( 'Prijs ex. BTW.', 'glasbestellen' ); ?></th>
               <th><?php _e( 'Verwijder', 'glasbestellen' ); ?></th>
            </tr>
         </thead>
         <tbody>
            <?php
            if ( $items = $this->conversion_data->get_items() ) {
               foreach ( $items as $item ) {
                  $this->render_table_row( $item );
               }
            }
            ?>
         </tbody>
      </table>

      <?php
   }

   public function render_table_row( array $item = [] ) {

      $products = gb_get_selectable_products();
      $name  = ! empty( $item['name'] ) ? $item['name'] : '';
      $price = ! empty( $item['price'] ) ? $item['price'] : ''; ?>

      <tr class="alternate">
         <td>
            <select name="conversion[item_names][]">
               <option value="">-- <?php _e( 'Selecteer product', 'glasbestellen' ); ?> --</option>
               <?php
               if ( ! empty( $products ) ) {
                  foreach ( $products as $product ) {
                     $selected = selected( $name, $product, false );
                     echo '<option value="' . $product . '" ' . $selected . '>' . $product . '</option>';
                  }
               }
               ?>
            </select>
         </td>
         <td>
            <input type="text" name="conversion[item_prices][]" value="<?php echo $price; ?>" placeholder="00.00">
         </td>
         <td>
            <button class="button button-secondary js-delete-item-button"><?php _e( 'Verwijder', 'glasbestellen' ); ?></button>
         </td>
      </tr>

      <?php
   }

   public function render_buttons() { ?>
      <button class="button button-secondary js-add-item-button">+ <?php _e( 'Voeg product toe', 'glasbestellen' ); ?></button>
      <button class="button button-primary js-submit-button" style="float: right;"><?php _e( 'Conversie data opslaan', 'glasbestellen' ); ?></button>
      <?php
   }
}
