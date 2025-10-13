<h2>General</h2>
<?php
$general = new IW_Helper_Favorite_Plugins(Array(
    'WooCommerce'               => 'woocommerce',
    'Facturas PDF'              => 'woocommerce-pdf-invoices-packing-slips',
    'AJAX Add to Cart'          => 'woocommerce-menu-bar-cart',
    'Modal AJAX Add to Cart'    => 'woo-ajax-add-to-cart',
    'Fibo Search'               => 'ajax-search-for-woocommerce',
));
$general->render();
?>
<br>
<h2>Pasarelas de pago</h2>
<?php
$pasarelas = new IW_Helper_Favorite_Plugins(Array(
    'RedSys'    => 'woo-redsys-gateway-light',
    'PayPal'    => 'woocommerce-paypal-payments',
    'Stripe'    => 'woocommerce-gateway-stripe',
));
$pasarelas->render();
?>
<br>
<h2>Donativos</h2>
<?php
$donativos = new IW_Helper_Favorite_Plugins(Array(
    'Donation Platform for WooCommerce' => 'wc-donation-platform',
    'GiveWP'                            => 'give',
));
$donativos->render();
?>
<br>