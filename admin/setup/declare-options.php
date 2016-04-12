<?php function oboxfb_general_options (){

	/**
	 * LOAD OPTIONS PANEL.
	 */
	$tabs = array(
		array(
			"option_header" => "Facebook Page Tab Setup",
			"use_function"  => "obox_fb_option_li",
			"function_args" => "facebook_tab_setup_options",
			"ul_class"      => "admin-block-list clearfix",
		),
		array(
			"option_header" => "Home Page",
			"use_function" => "obox_fb_option_li",
			"function_args" => "general_site_options",
			"ul_class"      => "admin-block-list clearfix",
		),
		array(
			"option_header" => "Customization",
			"use_function" => "obox_fb_option_li",
			"function_args" => "customization_options",
			"ul_class"      => "admin-block-list clearfix",
		),
		array(
			"option_header" => "Social &amp; Sharing",
			"use_function" => "obox_fb_option_li",
			"function_args" => "sharing_options",
			"ul_class" => "admin-block-list clearfix",
		)
	);

	oboxfb_options_panel("General Options", $tabs, "Save Changes");
}