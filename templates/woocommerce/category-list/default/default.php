<div class="iw-category-list-container iw-archive">
    <?php if (!empty($query) && !is_wp_error($query)) : ?>
        <?php foreach ($query as $cat) : ?>
            <?php
                $cat_link = get_term_link($cat);
                
                $thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                $thumb = $thumb_id ? wp_get_attachment_url($thumb_id) : wc_placeholder_img_src();
            ?>
            <article class="iw-category">
                <a href="<?php echo esc_url($cat_link); ?>">
                    <div class="iw-image-container">
                        <img src="<?php echo esc_url($thumb); ?>" class="iw-main-image">
                    </div>
                    <div class="iw-category-content">
                        <h3 class="iw-category-title"><?php echo esc_html($cat->name); ?></h3>
                    </div>
                </a>
            </article>
        <?php endforeach; ?>
    <?php else : ?>
        <p style="width: 100%;">No se han encontrado categorías</p>
    <?php endif; ?>
</div>
