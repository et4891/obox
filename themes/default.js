jQuery(document).ready(function($)
	{
		setTimeout(function(){

			jQuery("a").each(function(){

				$a = jQuery(this);

				if ( typeof( $a.attr("href") ) == 'undefined' ){
					// Do Nothing
				}
				else {

					var href = $a.attr("href").toString();

					if ( href.indexOf(oboxfb.path) > -1 && href.indexOf( 'obox-fb' ) == -1 ) {
						
						// Make sure there's `obox-fb=1` at the end of every href.
						if ( href.indexOf("?") > -1 ){
							var sep = "&";
						} else {
							var sep = "?";
						}
						var href = href + sep + "obox-fb=1";
						$a.attr( 'href', href );
					}

					if (href.indexOf('wp-login') > -1 || href.indexOf('wp-admin') > -1){
						$a.attr("target", "_blank");
					}

					if (href.indexOf('jpeg') > -1 || href.indexOf('jpg') > -1 || href.indexOf('png') > -1 || href.indexOf('gif') > -1){
						$a.click(function(){return false;})
					}
				}

			});
		}, 500);

		jQuery("form").each(function(){

			$form = jQuery(this);

			if ($form.attr("action")){
				var action = $form.attr("action").toString();

				if (action.indexOf(oboxfb.path) > -1) {
					if (action.indexOf("?") > -1){
						var sep = "&";
					} else {
						var sep = "?";
					}
					var action = action+sep+"obox-fb=1";

					$form.attr("action", action);
				}
			}
		});

	});