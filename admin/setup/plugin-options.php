<?php if( !function_exists( 'obox_fb_plugin_options' ) ) {
	function obox_fb_plugin_options(){
	global $oboxfb_theme_options;

	$oboxfb_theme_options = array();

	$oboxfb_theme_options["facebook_tab_setup_options"] = array(
		array(
			'label' => 'Facebook Page Tab Setup',
			// 'description' => 'Follow these steps to put your store live in your Facebook Page Tab.',
			'description' => '',
			'name' => 'setup_video',
			'default' => '',
			'id' => 'setup_video_2',
			'input_type' => 'html',
				'html' => ( function_exists( 'oboxfb_theme_options_setup_interface' ) ? oboxfb_theme_options_setup_interface() : '' ),
		),
	);

	$oboxfb_theme_options["general_site_options"] =
		array(
			array(
				"main_section" => "Featured Slider",
				"main_description" => "These settings control the content that will be displayed in the feature slider. You can upload slider images and content.",
				"sub_elements" =>
					array(
						array("label" => "Enable", "description" => "", "name" => "oboxfb_slider", "default" => "no", "id" => "oboxfb_slider", "input_type" => "select", "options" => array("Yes" => "yes", "No" => "no")),
						array("label" => "Post Count", "description" => "", "name" => "oboxfb_slider_count", "default" => "5", "id" => "", "input_type" => "select", "options" => array("3" => "3", "6" => "6", "9" => "9")),
						array("label" => "Slider Duration", "description" => "", "name" => "oboxfb_slider_duration", "default" => "5", "id" => "oboxfb_slider_duration", "input_type" => "input"),
						array("label" => "Image Dimensions", "description" => "", "name" => "oboxfb_slider_dimensions", "default" => "620x300", "id" => "oboxfb_slider_dimensions", "input_type" => "select", "options" => array( "620 x 300 pixels" => "620x300" , "620 x 465 pixels" => "620x465" ) )
					)
				),
			array("label" => "Breadcrumbs", "description" => "Select whether or not you would like to display breadcrumbs on shop and list pages", "name" => "oboxfb_breadcrumbs", "default" => "no", "id" => "oboxfb_breadcrumbs", "input_type" => "select", "options" => array("Yes" => "yes", "No" => "no")),
			array(
				"main_section" => "Shop Introduction",
				"main_description" => "These settings control the introduction text on the home page of your store. You can add a title and some text.",
				"sub_elements" =>
					array(
						array("label" => "Enable", "description" => "", "name" => "oboxfb_intro", "default" => "no", "id" => "oboxfb_intro", "input_type" => "select", "options" => array("Yes" => "yes", "No" => "no")),
						array("label" => "Title", "description" => "Leave blank to have no title", "name" => "oboxfb_intro_title", "default" => "", "id" => "oboxfb_intro_title", "input_type" => "input"),
						array("label" => "Intro Text", "description" => "", "name" => "oboxfb_intro_text", "default" => "", "id" => "oboxfb_intro_text", "input_type" => "memo")

				)
			),
			array(
				"main_section" => "Product Display",
				"main_description" => "These settings control what type of product list you want on the home page. You can choose between listing featured products or specific product categories.",
				"sub_elements" =>
					array(
						array("label" => "Enable", "description" => "", "name" => "oboxfb_products", "default" => "yes", "id" => "oboxfb_products", "input_type" => "select", "options" => array("Yes" => "yes", "No" => "no")),
						array("label" => "Title", "description" => "Leave blank to have no title", "name" => "oboxfb_products_title", "default" => "Products", "id" => "oboxfb_products_title", "input_type" => "input"),
						array("label" => "Display", "description" => "*Featured products are set by clicking the star in the Product's row in your Products admin", "name" => "oboxfb_products_category", "default" => "recent_products", "id" => "oboxfb_products_category", "input_type" => "select", "options" => array("Most Recent Products" => "recent_products", "Featured Products" => "feature_products", "Product Categories" => "product_categories")),
						array("label" => "Post Count", "description" => "Only if Posts selected above", "name" => "oboxfb_products_count", "default" => "4", "id" => "", "input_type" => "select", "options" => array("4" => "4", "8" => "8", "12" => "12"))
				)
			)
		);

	$oboxfb_theme_options["customization_options"] = array(
				array("label" => "Upload Your Logo", "description" => "<strong>Recommended size 162px x 50px</strong><br />Upload your company logo here. You can either upload it from your PC or you can enter in a URL.", "name" => "oboxfb_custom_logo", "default" => "", "id" => "upload_button_logo", "input_type" => "file", "sub_title" => "mobile-logo"),
				array("label" => "Show Add To Cart Buttons?", "description" => "Choose whether to show or hide the Add to Cart buttons on your home, shop and category pages.", "name" => "show_cart_buttons", "default" => "yes", "id" => "show_cart_buttons", "input_type" => "select", 'options' => array('Show Add To Cart Buttons' => 'yes', 'Hide Add to Cart Buttons' => 'no')),
				array("label" => "Reviews", "description" => "Choose whether to enable Facebook comments in products (RECOMMENDED).", "name" => "fb_reviews", "default" => "yes", "id" => "fb_reviews", "input_type" => "select", 'options' => array('Show Facebook Reviews' => 'yes', 'Hide Comments' => 'no')),
				array("label" => "Comments", "description" => "Choose whether to enable Facebook comments in normal posts.", "name" => "fb_comments", "default" => "true", "id" => "fb_comments", "input_type" => "select", 'options' => array('Use Facebook Comments' => 'true', 'Use Standard WordPress Comments' => 'false')),
					array("label" => "Custom Sidebar Text", "description" => "Use this text area to enter in any copyrights or links to your main site. You can use HTML in this area.", "name" => "oboxfb_custom_footer", "default" => "<a href=\"http://codecanyon.net/item/social-commerce-woocommerce-facebook-plugin/4131041?utm_source=facebook&utm_medium=link&utm_campaign=Social%20Commerce%20Footer%20Text\">Social Commerce</a> created by Obox", "id" => "oboxfb_custom_footer", "input_type" => "memo"),
				array("label" => "Custom CSS", "description" => "Social Commerce is designed to fit into the overall Facebook interface and experience, which builds visitor trust which results in higher conversions. If you wish to customize any aspect of the display, such as colors, hiding elements or fixing extension contrnt, you may do so with CSS overrides here.", "name" => "oboxfb_custom_css", "default" => "", "id" => "oboxfb_custom_css", "input_type" => "memo")

		);

	$oboxfb_theme_options["sharing_options"] = array(
			array(
					"main_section" => "Facebook Sharing Options",
					"main_description" => "Set a default image URL to appear on Facebook shares if no featured image is found. Recommended size 200x200.",
					"sub_elements" =>
						array(
							array("label" => "Disable OpenGraph?", "description" => "Select Yes only if you have a separate plugin enabled which outputs Facebook data into the header.", "name" => "ocmx_open_graph", "default" => "no", "id" => "ocmx_open_graph", "input_type" => 'select', 'options' => array('Yes' => 'yes', 'No' => 'no')
							),

							array("label" => "Image URL", "description" => "", "name" => "ocmx_site_thumbnail", "sub_title" => "Open Graph image", "default" => "", "id" => "upload_button_ocmx_site_thumbnail", "input_type" => "file", "args" => array("width" => 80, "height" => 80)
							)
						)
				),
			array("label" => "Social Sharing", "description" => "Display Like and Recommend Buttons on products?", "name" => "oboxfb_social_meta", "default" => "yes", "id" => "oboxfb_social_meta", "input_type" => 'select', 'options' => array('Yes' => 'yes', 'No' => 'no'))
		);

	$appid = get_option("fb_appid");
	$url = get_site_url();
	$oboxfb_theme_options["setup_options"] = array(
			array(
			'label' => 'Step by Step Setup',
			'description' => 'Click <a href="http://www.thunderpenny.com/app/website" target="_blank">here</a> to view instructions on using the free Thunderpenny Website App for Facebook, and add your secure Social Commerce URL, which is <b>https://</b>www.yoursite.com<b>/?obox-fb=1</b>.<a href="http://kb.oboxthemes.com/documentation/social-commerce-docs/" target="_blank" class="button">View Detailed Setup Documentation</a>',
			'name' => 'setup_video',
			'default' => '',
			'id' => 'setup_video',
			'input_type' => 'html',
			'html' => '
			<div class="setup-help">
			<h4>Dependencies</h4>

					<br>

				<h5>WooCommerce</h5>
					<p>Social Commerce is designed specifically for use with the<a href="http://www.woothemes.com/woocommerce-docs/user-guide/getting-started/woocommerce-installation/" target="_blank"> WooCommerce</a> plugin, which must be Active and configured prior to setup of Social Commerce. For information on installing, configuring or using WooCommerce, visit their <a href="http://www.woothemes.com/woocommerce-docs/category/user-guide/getting-started/" target="_blank">documentation page.</a> If you are using an Obox theme that supports WooCommerce, theme-specific setup and configuration info is available in your <a href="http://kb.oboxthemes.com/theme-documentation/" target="_blank">Theme Documentation</a>. We also offer a short checklist of settings required by Facebook in the next article.</p>

					<br>

				<h5>SSL Certificate</h5>
					<p>You will need a <strong>domain validated (professionally signed)</strong> SSL certificate setup for your domain. This is a <a href="https://www.facebook.com/notes/znet-corp/facebook-require-ssl-certificate-from-oct-1-2011/1990032877406" target="_blank">Facebook requirement and cannot be skipped!</a></p>
					<p>Additionally, all content you intend to be displayed in the Facebook page must be hosted on the domain your SSL certificate is setup for. If you have cloud-hosted images, for example, your host must assist you in domain masking them and ensuring they are protected by your site SSL.</p>
					<p>For more information, check with your host or <a href="http://support.hostgator.com/articles/ssl-certificates/ssl-setup-use/how-to-make-your-facebook-app-ssl-secure" target="_blank">get a certificate at Host Gator</a></p>

					<br>

				<h5>Facebook Page Tab/ App Setup</h5>
				<p>You will need to create a Page Tab to display the Social Commerce shop on your Facebook page.  You can do this via a 3rd Party app provider such as Thunderpenny, or you can create your own. We provide detailed instructions for both in the <a href="http://kb.oboxthemes.com/themedocs/social-commerce-setup-your-facebook-app/" target="_blank">Setup Your Page Tab article.</a></p>

					<br>

			<div class="important-info">
				<p><b>Important Info!</b></p>
				<p>Social Commerce is not able to display special page templates, shortcodes or other functionality your main theme may provide. Some 3rd party plugins or widgets may also not be compatible with Facebook and may not display correctly, or may load scripts and stylesheets that cause conflicts in your Social Commerce pages. If you encounter problems with the look or functionality of the shop, products or landing page, see these <a href="http://kb.oboxthemes.com/articles/social-commerce-troubleshooting-common-issues/" target="_blank">Troubleshooting Steps.</a></p>
			</div>
		</div>
			',
		),
	);
}
}add_action( 'init', 'obox_fb_plugin_options', 0 );
add_action( 'obox_fb_plugin_options', 'obox_fb_plugin_options' );