<?php function oboxfb_add_theme_scripts() {
	global $woocommerce;

	if( !is_admin() ) :

		wp_enqueue_style( 'social-commerce', get_template_directory_uri().'/style.css');
		wp_enqueue_style('social-commerce-custom', get_home_url().'/?obox-fb=1&stylesheet=custom');

		wp_enqueue_script( "jquery" );

		if( isset( $woocommerce ) ) :
			wc_enqueue_js('

			var payment_methods = jQuery( ".payment_methods" ).offset();

			jQuery(document).ajaxSuccess(function(event,request,settings){
				var legalJSON = request.responseText;

				// Get the valid JSON only from the returned string
				if ( legalJSON.indexOf("<!--WC_START-->") >= 0 )
					legalJSON = legalJSON.split("<!--WC_START-->")[1]; // Strip off before after WC_START

				if ( legalJSON.indexOf("<!--WC_END-->") >= 0 )
					legalJSON = legalJSON.split("<!--WC_END-->")[0]; // Strip off anything after WC_END

				data = jQuery.parseJSON( legalJSON );

				if( data.result == "success" && data.redirect ) {

					window.stop();

					jQuery.blockUI({
						message: "'. __( '<h3>Checkout</h3> <p>Checkout will be completed on the main ' . get_bloginfo( 'name' ) . ' website.', 'social-commerce' ) . '</p><p><a class=\"button\" href=\"" + data.redirect + "\" target=\"_blank\">' . __( 'Click Here to Complete Checkout', 'ocmx' ) .'</a></p>" ,
						overlayCSS:
						{
							background: "#000",
							opacity: 0.6
						},
						css: {
							top:            ( payment_methods.top / 2 ) + "px",
							padding:        20,
							textAlign:      "center",
							color:          "#555",
							border:         "10px solid #3b5998",
							backgroundColor:"#fff",
							cursor:         "pointer",
							lineHeight:		"32px",
							left: "20%",
							width: "60%"
						}
					});
				}

			});');
		endif;

	endif;
};
add_action('init', 'oboxfb_add_theme_scripts');

function oboxfb_deregister_scripts(){
	global $ocmx_oboxfb_class;
	if( 'oboxfb' == $ocmx_oboxfb_class->site_style() ) :
		// Remove Woo Lightbox scripts
		wp_dequeue_script('fancybox');
		wp_dequeue_style('woocommerce_fancybox_styles');
	endif;
};
add_action('wp_enqueue_scripts', 'oboxfb_deregister_scripts', 25);
