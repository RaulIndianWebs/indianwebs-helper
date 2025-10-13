<?php
global $custom_config;


if ($custom_config["image-meta"] == true) {
    add_filter( 'wp_get_attachment_image_attributes', function( $attr, $attachment, $size ) {
        if ( is_numeric( $attachment ) ) {
            $attachment_obj = get_post( $attachment );
        } elseif ( $attachment instanceof WP_Post ) {
            $attachment_obj = $attachment;
        } else {
            return $attr;
        }

        $site_tagline = get_bloginfo( 'description' );
        $alt_meta     = get_post_meta( $attachment_obj->ID, '_wp_attachment_image_alt', true );
        $img_title    = $attachment_obj->post_title;

        $alt   = $alt_meta  ? $alt_meta  : '';
        $title = $img_title ? $img_title : '';

        if ( empty( $alt ) && empty( $title ) ) {
            $alt = $title = $site_tagline;
        } elseif ( empty( $alt ) ) {
            $alt = $title;
        } elseif ( empty( $title ) ) {
            $title = $alt;
        }

        $attr['alt']   = $alt;
        $attr['title'] = $title;

        return $attr;
    }, 10, 3 );

    add_filter( 'get_image_tag', function( $html, $id, $alt, $title, $align, $size, $context ) {
        $attrs = apply_filters( 'wp_get_attachment_image_attributes', [
            'alt'   => $alt,
            'title' => $title,
        ], $id, $size );

        $html = preg_replace( '/alt="[^"]*"/',   'alt="' . esc_attr( $attrs['alt'] ) . '"',   $html );
        $html = preg_replace( '/title="[^"]*"/', 'title="' . esc_attr( $attrs['title'] ) . '"', $html );

        return $html;
    }, 10, 7 );

    add_filter( 'shortcode_atts_et_pb_image', function( $out_atts, $pairs, $atts, $shortcode ) {
        $tagline = get_bloginfo( 'description' );
        $alt     = ! empty( $out_atts['alt'] )   ? $out_atts['alt']   : '';
        $title   = ! empty( $out_atts['title'] ) ? $out_atts['title'] : '';

        if ( empty( $alt ) && empty( $title ) ) {
            $alt = $title = $tagline;
        } elseif ( empty( $alt ) ) {
            $alt = $title;
        } elseif ( empty( $title ) ) {
            $title = $alt;
        }

        $out_atts['alt']   = $alt;
        $out_atts['title'] = $title;

        return $out_atts;
    }, 10, 4 );

    add_filter( 'shortcode_atts_et_pb_gallery', function( $out_atts, $pairs, $atts, $shortcode ) {
        $tagline = get_bloginfo( 'description' );

        if ( ! empty( $out_atts['images'] ) && is_array( $out_atts['images'] ) ) {
            foreach ( $out_atts['images'] as $index => $img_id ) {
                $alt_meta  = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
                $img_title = get_post( $img_id )->post_title;
                $alt       = $alt_meta  ? $alt_meta  : '';
                $title     = $img_title ? $img_title : '';

                if ( empty( $alt ) && empty( $title ) ) {
                    $alt = $title = $tagline;
                } elseif ( empty( $alt ) ) {
                    $alt = $title;
                } elseif ( empty( $title ) ) {
                    $title = $alt;
                }

                $out_atts['images_attrs'][ $index ] = [
                    'alt'   => $alt,
                    'title' => $title,
                ];
            }
        }

        return $out_atts;
    }, 10, 4 );

    add_filter( 'et_pb_module_shortcode_attributes', function( $props, $slug ) {
        $modules = [ 'et_pb_image', 'et_pb_gallery', 'et_pb_slider' ];
        if ( in_array( $slug, $modules, true ) ) {
            $tagline = get_bloginfo( 'description' );
            $alt     = ! empty( $props['alt'] )   ? $props['alt']   : '';
            $title   = ! empty( $props['title'] ) ? $props['title'] : '';

            if ( empty( $alt ) && empty( $title ) ) {
                $alt = $title = $tagline;
            } elseif ( empty( $alt ) ) {
                $alt = $title;
            } elseif ( empty( $title ) ) {
                $title = $alt;
            }

            $props['alt']   = $alt;
            $props['title'] = $title;
        }
        return $props;
    }, 10, 2 );
}