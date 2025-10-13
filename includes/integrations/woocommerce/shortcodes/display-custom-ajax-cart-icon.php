<?php
// Shortcode personalizado para mostrar el icono del carrito con contador
add_shortcode('iw-cart-link', 'shortcode_icono_carrito_con_ajax');

function shortcode_icono_carrito_con_ajax() {
    ob_start();
    ?>
    <a href="<?php echo wc_get_cart_url(); ?>" class="iw-icono-carrito-personalizado">
        <img class="fa fa-shopping-cart" src="/wp-content/uploads/2025/07/cart.png">
        <span class="iw-contador-carrito"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    </a>
    <?php
    return ob_get_clean();
}

// Fragmento AJAX para actualizar el número del carrito dinámicamente
add_filter('woocommerce_add_to_cart_fragments', 'fragmento_ajax_carrito_personalizado');

function fragmento_ajax_carrito_personalizado($fragments) {
    ob_start();
    ?>
    <span class="iw-contador-carrito"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['span.iw-contador-carrito'] = ob_get_clean();
    return $fragments;
}
