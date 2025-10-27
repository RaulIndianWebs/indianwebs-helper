<div id="iw-off-canvas-menu" class="iw-hidden">
    <div class="overlay iw-offcanvas-menu-close"></div>
    <div class="menu-container">
        <div class="menu-header">
            <span class="dashicons dashicons-no-alt iw-offcanvas-menu-close"></span>
        </div>
        <div class="menu-content">
            <?php
                wp_nav_menu([
                    'theme_location' => 'off-canva',
                    'container'      => 'nav',
                    'container_class'=> 'off-canvas-nav',
                    'menu_class'     => 'off-canvas-menu',
                    'fallback_cb'    => false
                ]);
                if ($options["secondary-menu"]) {
                    wp_nav_menu([
                        'theme_location' => 'secondary-menu',
                        'container'      => 'nav',
                        'container_class'=> 'secondary-nav',
                        'menu_class'     => 'secondary-menu',
                        'fallback_cb'    => false
                    ]);
                }
            ?>
        </div>
        <div class="menu-footer">
            <?php if ($options["fast-actions"]) : ?>
                <ul class="fast-actions">
                    <?php if (class_exists( 'WooCommerce' )) : ?>
                        <li><a href="/my-account/" class="dashicons-before dashicons-admin-users"></a></li>
                        <li><?php echo do_shortcode('[iw-cart-link]') ?></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>