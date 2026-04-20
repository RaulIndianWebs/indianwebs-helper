<div id="iw-off-canvas-menu" class="iw-hidden">
	<div class="overlay iw-offcanvas-menu-close"></div>
	<div class="menu-container">
		<div class="menu-header">
			<span class="dashicons dashicons-no-alt iw-offcanvas-menu-close"></span>
			<?php dynamic_sidebar('iw-off-canva-menu-header'); ?>
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
		    if ($secondary) {
		    	wp_nav_menu([
			        'theme_location' => 'secondary-menu',
			        'container'      => 'nav',
			        'container_class'=> 'secondary-nav',
			        'menu_class'     => 'secondary-menu',
			        'fallback_cb'    => false
			    ]);
		    }
		    if (class_exists( 'WooCommerce' ) && is_user_logged_in()) {
		    	echo '<h2>Tu cuenta</h2>';
			    woocommerce_account_navigation();
			}
		    ?>
	    </div>
		<div class="menu-footer">
			<?php if ($actions) : ?>
				<ul class="fast-actions">
					<?php if (class_exists( 'WooCommerce' )) : ?>
						<?php if (is_plugin_active("ajax-search-for-woocommerce/ajax-search-for-woocommerce.php")) ?><li><?= do_shortcode("[fibosearch]") ?></li>
						<li><a href="<?= esc_url(wc_get_page_permalink('myaccount')) ?>" class="dashicons-before dashicons-cart"></a></li>
						<li><a href="<?= esc_url(wc_get_cart_url()) ?>" class="dashicons-before dashicons-admin-users"></a></li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
			<?php dynamic_sidebar('iw-off-canva-menu-footer'); ?>
			</div>
		</div>
	</div>
</div>