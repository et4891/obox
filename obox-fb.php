<?php
/*
	Plugin Name: Social Commerce
	Plugin URI: http://www.oboxthemes.com/plugins/social-commerce/
	Description: A plugin which brings your WooCommerce store into Facebook
	Version: 1.5.0
	Author: Obox Themes
	Author URI: http://www.oboxthemes.com
*/

/***************************/
/* Set Directories and Files*/
define( 'OBOXFBID' , '1540');
define( 'OBOXFB_VER' , '1.5.0' );
define( 'OBOXFBDIR' , plugin_dir_path( __FILE__ ) );
define( 'OBOXFBURL' , plugin_dir_url( __FILE__ ) );
define( 'OBOXFBFILE' , __FILE__ );


/***********************/
/* Include admin files */
function oboxfb_includes(){

	$folders = array(
		'functions' => 'functions/',
		'interface' => 'admin/interface/',
		'includes' 	=> 'admin/includes/',
		'setup' 	=> 'admin/setup/'
	);

	foreach( $folders as $key => $folder ){

		$abs_folder = OBOXFBDIR . $folder;

		if ( $handler = opendir( $abs_folder ) ) :
			while (false !== ( $file = readdir( $handler ) ) ) :
				if ($file !== "." && $file !== ".." && strpos($file, ".php")) :
					include_once ( $abs_folder . $file );
				endif;
			endwhile;
			closedir($handler);
		endif;
	}

}
add_action("plugins_loaded", "oboxfb_includes", 0);

/****************************************/
/* Begin OCMX Mobile Checks & Implement */
function begin_oboxfb(){
	global $ocmx_oboxfb_class;
	$ocmx_oboxfb_class = new OBOXFB();
	$ocmx_oboxfb_class->initiate();
}
add_action( 'plugins_loaded', 'begin_oboxfb', 0 );

/***********************/
/* Add OCMX Menu Items */
function oboxfb_add_admin() {
	add_object_page(
			__( '荟Facebook', 'ocmx' ),
			__( '荟Facebook', 'ocmx' ),
			'manage_options',
			basename(__FILE__),
			'oboxfb_general_options',
			'dashicons-facebook'
		);
}
add_action('admin_menu', 'oboxfb_add_admin');

/****************************/
/* Add Localization Support */
load_plugin_textdomain( 'ocmx', false, dirname( plugin_basename( __FILE__ ) ) . '/admin/lang/' );

/***********************************/
/* Run when we activate the plugin */
function oboxfb_setup(){

	include( OBOXFBDIR . 'admin/setup/plugin-options.php' );
	include( OBOXFBDIR . 'admin/includes/functions.php' );

	do_action( 'obox_fb_plugin_options' );

	global $oboxfb_theme_options;

	foreach( $oboxfb_theme_options as $theme_option => $value)
		{
			if( function_exists( 'oboxfb_reset_option' ) ) :
				oboxfb_reset_option( $theme_option );
			endif;
		}
}
register_activation_hook( __FILE__, 'oboxfb_setup' );