<?php
defined( 'ABSPATH' ) || exit;
$is_order_received = is_checkout() && ! empty( is_wc_endpoint_url( 'order-received' ) );
?>

<ol class="step-indicator step-indicator--done-<?php echo ( $is_order_received ) ? '4' : '2'; ?>">
    <li class="step-indicator__step step-indicator__step--done">
        <div class="step-indicator__step-number">1</div>
        <span class="step-indicator__step-text"><?php _e( 'Winkelwagen', 'glasbestellen' ); ?></span>
    </li>
    <li class="step-indicator__step step-indicator__step--done">
        <div class="step-indicator__step-number">2</div>
        <span class="step-indicator__step-text"><?php _e( 'Gegevens', 'glasbestellen' ); ?></span>
    </li>
    <li class="step-indicator__step <?php echo ( $is_order_received ) ? 'step-indicator__step--done' : ''; ?>">
        <div class="step-indicator__step-number">3</div>
        <span class="step-indicator__step-text"><?php _e( 'Betalen', 'glasbestellen' ); ?></span>
    </li>
    <li class="step-indicator__step <?php echo ( $is_order_received ) ? 'step-indicator__step--done' : ''; ?>">
        <div class="step-indicator__step-number">4</div>
        <span class="step-indicator__step-text"><?php _e( 'Afronden', 'glasbestellen' ); ?></span>
    </li>
</ol>
