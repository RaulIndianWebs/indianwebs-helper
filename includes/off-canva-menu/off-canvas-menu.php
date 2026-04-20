<?php
// Get menu options
$options = getPluginOptions("helper-config")["features-options"]["off-canva-options"];


if ($options["active"]) {
	add_action('widgets_init', function () {
	    register_sidebar(array(
	        'name'          => 'Off Canva Menu Header',
	        'id'            => 'iw-off-canva-menu-header',
	        'description'   => 'Header del menú off canva principal.',
	        'before_widget' => '<div class="iw-off-canva-menu-header-widgets-container">',
	        'after_widget'  => '</div>',
	        'before_title'  => '',
	        'after_title'   => '',
	    ));
	});
	register_nav_menu( 'off-canva', 'Off Canva Menu');
	add_action('widgets_init', function () {
	    register_sidebar(array(
	        'name'          => 'Off Canva Menu footer',
	        'id'            => 'iw-off-canva-menu-footer',
	        'description'   => 'Footer del menú off canva principal.',
	        'before_widget' => '<div class="iw-off-canva-menu-footer-widgets-container">',
	        'after_widget'  => '</div>',
	        'before_title'  => '',
	        'after_title'   => '',
	    ));
	});

	// Print off-canva-menu container in footer
	add_action("wp_footer", function() use ($options) {
		echo iw_load_template("off-canva-menu", array(
			"secondary" => $options["secondary-menu"],
			"actions" => $options["fast-actions"],
		));
	});
}