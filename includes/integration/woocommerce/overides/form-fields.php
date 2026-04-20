<?php
add_filter( 'woocommerce_checkout_fields', function( $fields ) {

    foreach ( $fields as $section_key => $section_fields ) {
        foreach ( $section_fields as $field_key => $field ) {

            // Clase al wrapper del campo
            $fields[ $section_key ][ $field_key ]['class'][] = 'iw-woocommerce-field-container';

            // Clase al input / select / textarea
            $fields[ $section_key ][ $field_key ]['input_class'][] = 'iw-woocommerce-field';
        }
    }

    return $fields;
});


add_filter( 'woocommerce_shipping_rate_label', function( $label, $method ) {
    return '<span class="iw-woocommerce-field">' . $label . '</span>';
}, 10, 2 );

add_filter( 'woocommerce_gateway_icon', function( $icon, $gateway_id ) {
    return '<span class="iw-woocommerce-field">' . $icon . '</span>';
}, 10, 2 );

