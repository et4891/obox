<?php
function oboxfb_sidebars_menus(){

	// Register Menus
	register_nav_menus(
		array(
			'oboxfb' => __('Social Commerce', 'ocmx')
		)
	);

	// Register Sidebars
	register_sidebar(
		array(
			"name" => "Social Commerce Sidebar",
			"id" => "social_sidebar" ,
			"description" => "You may add up to 3 widgets here, shown on all pages. Recommended: WooCommerce Recently Viewed, WooCommerce Cart, WooCommerce Filtered Nav. WooCommerce Price Filter will not work on Facebook!",
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="content">',
			'after_widget' => '</div></aside>'
		)
	);

}
add_action( 'wp_loaded', 'oboxfb_sidebars_menus' );