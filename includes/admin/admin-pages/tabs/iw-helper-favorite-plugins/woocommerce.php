<h2>General</h2>
<?php
IW_Helper\Utilities\Features\Admin\render_fav_plugins(Array(
    'WooCommerce'               => 'woocommerce',
    'Facturas PDF'              => 'woocommerce-pdf-invoices-packing-slips',
    'AJAX Add to Cart'          => 'woocommerce-menu-bar-cart',
    'Modal AJAX Add to Cart'    => 'woo-ajax-add-to-cart',
    'Fibo Search'               => 'ajax-search-for-woocommerce',
));
?>
<br>
<h2>Pasarelas de pago</h2>
<?php
IW_Helper\Utilities\Features\Admin\render_fav_plugins(Array(
    'RedSys'    => 'woo-redsys-gateway-light',
    'PayPal'    => 'woocommerce-paypal-payments',
    'Stripe'    => 'woocommerce-gateway-stripe',
));
?>
<br>
<h2>Donativos</h2>
<?php
IW_Helper\Utilities\Features\Admin\render_fav_plugins(Array(
    'Donation Platform for WooCommerce' => 'wc-donation-platform',
    'GiveWP'                            => 'give',
));
?>
<br>