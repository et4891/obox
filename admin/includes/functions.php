<?php if( !function_exists( 'oboxfb_update_options' ) ) {
	function oboxfb_update_options(){
		global $changes_done, $oboxfb_theme_options;

		//Clear our preset options, because we're gonna add news ones.
		wp_cache_flush();

		parse_str($_POST["data"], $data);

		$update_options = explode(",", $data["oboxfb_update"]);

		foreach($data as $key => $value) :

			wp_cache_flush();

			update_option( $key, stripslashes( $value ) );

		endforeach;

		foreach($update_options as $option) :

			if(is_array($oboxfb_theme_options[$option])):
				foreach($oboxfb_theme_options[$option] as $option) :
					if(isset($option["main_section"])) :
						foreach($option["sub_elements"] as $suboption) :
							if($suboption["input_type"] == "checkbox") :
								$key = $suboption["name"];
								if($data[$key]) :
									update_option($key, "true");
								else :
									update_option($key, "false");
								endif;
							endif;
						endforeach;
					else :
						if($option["input_type"] == "checkbox") :
							$key = $option["name"];
							if($data[$key]) :
								update_option($key, "true");
							else :
								update_option($key, "false");
							endif;
						endif;
					endif;
				endforeach;
			endif;
		endforeach;

		$changes_done = 1;

		die("");
	}
}
if( !function_exists( 'oboxfb_reset_options' ) ) {
	function oboxfb_reset_options(){
		global $changes_done;
			//Clear our preset options, because we're gonna add news ones.
		wp_cache_flush();

		parse_str($_POST["data"], $data);

		$update_options = explode(",", $data["oboxfb_update"]);

		foreach($update_options as $option) :
			oboxfb_reset_option($option);
		endforeach;
		die("");
	}
}

add_action("oboxfb_update_options", "oboxfb_update_options");

if( !function_exists( 'oboxfb_reset_option' ) ) {
	function oboxfb_reset_option( $option ){
		global $oboxfb_theme_options;

		if( isset( $oboxfb_theme_options[$option] ) &&  is_array( $oboxfb_theme_options[$option] ) ):

			foreach( $oboxfb_theme_options[$option] as $themeoption) :
				if( isset( $themeoption["main_section"] ) ) :
					foreach( $themeoption["sub_elements"] as $suboption ) :
						if( isset( $suboption["name"] ) && isset( $suboption["default"] ) ) :
							update_option( $suboption["name"] , $suboption["default"]);
						endif;
					endforeach;
				else :
					if( isset( $themeoption["name"] ) && isset( $themeoption["default"] ) ) :
						update_option( $themeoption["name"] , $themeoption["default"]);
					endif;
				endif;
			endforeach;
		endif;
	}
}

add_action("oboxfb_reset_option", "oboxfb_reset_option");