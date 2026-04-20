<div class="iw-product-list-container iw-archive <?= $container_classes ?>">
    <?php if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php
                $product = wc_get_product(get_the_ID());
                if (!$product) continue;
                $product_id = $product->get_id();
                $thumb = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : wc_placeholder_img_src();
            ?>
            <article class="iw-product">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <div class="iw-image-container">
                        <?php if(shortcode_exists("yith_wcwl_add_to_wishlist")) echo do_shortcode("[yith_wcwl_add_to_wishlist]"); ?>
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
                        <?php
                        if(isset($add_to_cart) && $add_to_cart) {
                            woocommerce_template_loop_add_to_cart();
                        }
                        ?>
                        <p class="iw-product-price"><?= $product->get_price_html() ?></p>
                    </div>
                </a>
            </article>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p style="width: 100%;">No se han encontrado productos</p>
    <?php endif; ?>

    <?php
    if (
        !empty($paginate) &&
        $paginate &&
        $query instanceof WP_Query &&
        $query->max_num_pages > 1
    ) :

        $current_page = max(1, get_query_var('paged') ?: get_query_var('page'));

        $pagination_links = paginate_links(array(
            'total'        => $query->max_num_pages,
            'current'      => $current_page,
            'mid_size'     => 2,
            'prev_text'    => '«',
            'next_text'    => '»',
            'type'         => 'list'
        ));

        if ($pagination_links) : ?>
            <nav class="iw-pagination">
                <?php echo $pagination_links; ?>
            </nav>
        <?php endif;

    endif;
    ?>
</div>

