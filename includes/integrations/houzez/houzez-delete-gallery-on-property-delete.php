<?php
/**
 * Elimina imagen destacada y galería de propiedades al borrar un post type "property"
 */

add_action('before_delete_post', function ($post_id) {
    if (get_post_type($post_id) !== 'property') {
        return;
    }

    $thumbnail_id = get_post_thumbnail_id($post_id);
    if ($thumbnail_id) {
        wp_delete_attachment($thumbnail_id, true);
    }

    $gallery_ids = get_post_meta($post_id, 'fave_property_images');

    if (!empty($gallery_ids)) {
        foreach ($gallery_ids as $attachment_id) {
            $attachment_id = intval($attachment_id);
            if ($attachment_id > 0) {
                wp_delete_attachment($attachment_id, true);
            }
        }
    }
}
);

