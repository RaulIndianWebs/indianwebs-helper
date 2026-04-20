<div class="iw-product-list-container iw-slider">
    <?php if ($query->have_posts()) : $iterator = $limit; ?>
        <?php while ($query->have_posts()) : $query->the_post(); $iterator--; ?>
            <?php
                $product = wc_get_product(get_the_ID());
                $product_id = $product->get_id();
                $thumb = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : wc_placeholder_img_src();
            ?>
            <article class="iw-product">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <div class="iw-image-container">
                        <ul class="product-flags">
                            <?php if ($product->is_on_sale()) : ?>
                                <li class="product-flag sale">Oferta</li>
                            <?php endif; ?>
                            <?php if ((time() - strtotime(get_the_date('Y-m-d', $product_id))) < ( 60 * 60 * 24 * 30)) : ?>
                                <li class="product-flag new">Nuevo</li>
                            <?php endif; ?>
                        </ul>
                        <img src="<?php echo esc_url($thumb); ?>" class="iw-main-image">
                    </div>
                    <div class="iw-product-content">
                        <h3 class="iw-product-title"><?php echo esc_html(get_the_title()); ?></h3>
                    </div>
                    <div class="iw-product-footer">
                        <p class="iw-product-price"><?= $product->get_price_html() ?></p>
                    </div>
                </a>
            </article>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</div>

