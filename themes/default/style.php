<?php 
$custom_css = get_option('oboxfb_custom_css');
header( 'Content-type: text/css' );
if ( isset( $custom_css ) && $custom_css != '' ) {
	echo $custom_css;
} // if custom_css


