<?php
function oboxfb_add_scripts()
	{
		global $themeid, $ocmx_oboxfb_class;

		//Add support for 2.9 and 3.0 functions and setup jQuery for theme
		if( is_admin() ) :

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-tabs' );

			wp_enqueue_script( 'oboxdfb-ajaxupload', OBOXFBURL.'admin/scripts/ajaxupload.js', array( 'jquery' ) );

			// Enqueue Admin Page Scripts.
			if ( isset( $_GET['page'] ) && 'obox-fb.php' == $_GET['page'] ) {

				// Main Admin style.css
				wp_enqueue_style( 'oboxfb-admin-style', OBOXFBURL . '/admin/style.css', array(), OBOXFB_VER );

				// Icon Font
				wp_enqueue_style( 'oboxfb-icon-font', OBOXFBURL . '/admin/fonts/css/oboxfb-icon-font.css', array(), OBOXFB_VER );
			}

			if(strpos( $_SERVER['REQUEST_URI'], 'obox-fb' ) !== false) :
				wp_enqueue_script( "oboxfb-jquery", OBOXFBURL."admin/scripts/ocmx_jquery.js", array( "jquery" ), OBOXFB_VER );
				wp_localize_script( "oboxfb-jquery", "oboxfb", array( "ajaxurl" => admin_url( "admin-ajax.php" ), "appid" => get_option("fb_appid"), "url" => get_site_url() ) );
			endif;

		else :

			if($ocmx_oboxfb_class->allow_oboxfb() === true) :
				wp_enqueue_script( "oboxfb-jquery", OBOXFBURL."themes/default.js", array( "jquery" ), OBOXFB_VER );
				wp_enqueue_script( "oboxfb-resize-end", OBOXFBURL."themes/".$ocmx_oboxfb_class->oboxfb_stylesheet()."/scripts/jquery.resize.end.js", array( "jquery" ), OBOXFB_VER );
				wp_enqueue_script( "oboxfb-theme-jquery", OBOXFBURL."themes/".$ocmx_oboxfb_class->oboxfb_stylesheet()."/scripts/theme-jquery.js", array( "jquery" ), OBOXFB_VER );

				wp_localize_script( "oboxfb-jquery", "oboxfb", array( "ajaxurl" => admin_url( "admin-ajax.php" ), "path" => get_bloginfo("url") ) );
				wp_enqueue_script( "oboxfb-superfish", get_bloginfo("template_directory")."/scripts/superfish.js", array( "jquery" ) );
				wp_enqueue_script( "oboxfb-uniform", OBOXFBURL."admin/scripts/jquery.uniform.js", array( "jquery" ), OBOXFB_VER );
			endif;
		endif;

		add_action( 'wp_ajax_oboxfb_save-options', 'oboxfb_update_options' );
		add_action( 'wp_ajax_oboxfb_reset-options', 'oboxfb_reset_options');
		add_action( 'wp_ajax_oboxfb_ajax-upload', 'oboxfb_ajax_upload' );
		add_action( 'wp_ajax_oboxfb_remove-image', 'oboxfb_ajax_remove_image' );
	}
add_action("init", "oboxfb_add_scripts");