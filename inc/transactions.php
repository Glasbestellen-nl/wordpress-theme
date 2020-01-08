<?php
function gb_add_transaction_meta_boxes() {
   add_meta_box( 'transaction_billing_meta_box', __( 'Factuur gegevens', 'glasbestellen' ), 'gb_transaction_billing_meta_box', 'transactie' );
   add_meta_box( 'transaction_delivery_meta_box', __( 'Afleveradres', 'glasbestellen' ), 'gb_transaction_delivery_meta_box', 'transactie' );
   add_meta_box( 'transaction_items_meta_box', __( 'Bestelde producten', 'glasbestellen' ), 'gb_transaction_items_meta_box', 'transactie' );
   add_meta_box( 'transaction_order_meta_box', __( 'Order gegevens', 'glasbestellen' ), 'gb_transaction_order_meta_box', 'transactie', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'gb_add_transaction_meta_boxes' );

function gb_transaction_billing_meta_box( $post ) {
   $data = get_post_meta( $post->ID, 'transaction_billing_details', true );
}

function gb_transaction_delivery_meta_box( $post ) {
   $data = get_post_meta( $post->ID, 'transaction_delivery_details', true );
}

function gb_transaction_items_meta_box( $post ) {
   $items = get_post_meta( $post->ID, 'transaction_items', true );
}

function gb_transaction_order_meta_box( $post ) {
   $data = get_post_meta( $post->ID, 'transaction_order_details', true );
}
