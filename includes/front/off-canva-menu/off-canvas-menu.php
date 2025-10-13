<?php
// Get menu options
$options = getHelperOptions("helper-config")["features-options"]["off-canva-options"];


if ($options["active"]) {
	// Register new menu location
	register_nav_menu( 'off-canva', 'Off Canva Menu');

	IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/features/off-canva-menu.css');
	IW_Scripts_Cache::cache_js_files(get_plugin_directory() . 'assets/js/features/off-canva-menu.js');

	// Print off-canva-menu container in footer
	add_action("wp_footer", function() use ($options) {
		echo '<div id="iw-off-canvas-menu" class="iw-hidden">';
			echo '<div class="overlay iw-offcanvas-menu-close"></div>';
			echo '<div class="menu-container">';
				echo '<div class="menu-header">';
					echo '<span class="dashicons dashicons-no-alt iw-offcanvas-menu-close"></span>';
				echo '</div>';
				echo '<div class="menu-content">';
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
			    echo '</div>';
				echo '<div class="menu-footer">';
					if ($options["fast-actions"]) {
						echo '<ul class="fast-actions">';
							if (class_exists( 'WooCommerce' )) {
								echo '<li><a href="/my-account/" class="dashicons-before dashicons-admin-users"></a></li>';
								echo '<li>'.do_shortcode('[iw-cart-link]').'</li>';
							}
						echo '</ul>';
					}
				echo '</div>';
			echo '</div>';
		echo '</div>';
	});
}