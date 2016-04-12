<?php

/**
 * Record the site being added to Obox Social Commerce Apps.
 */
if ( isset( $_GET['page'] ) && 'obox-fb.php' == $_GET['page'] && isset( $_GET['id_hash'] ) ) {

	// Store the id of the post on the Social Commerce Facebook Tab Manager.
	update_option( 'oboxfb_page_tab_id_hash', $_GET['id_hash'] );

	// Redirect
	wp_redirect( remove_query_arg( 'id_hash' ) );
	exit;
}

/**
 * Display the Tab Manager Main integration panel.
 */
function oboxfb_tab_manager_checker() {

	// Default status.
	$status = 'tab_does_not_exists';

	// Default return;
	$return = array();

	if ( $id_hash = get_option( 'oboxfb_page_tab_id_hash' ) ) {

		// Default status.
		$status = 'error';

		// Make the API call.
		$response = wp_remote_post(
			'https://socialcommerceapp.co/social-commerce-api/check-site/',
			array(
				'body' => array(
					'id_hash' => $id_hash,
				),
			)
		);

		if ( is_wp_error( $response ) ) {

			/**
			 * There's an error connecting to the API so feed that back.
			 */
			$status = 'error';
			// $error_message = $response->get_error_message();

		}
		else if ( isset( $response['body'] ) ) {

			$data = json_decode( $response['body'] );
			$return['data'] = $data;

			// echo '<pre>';
			// var_dump( $data );
			// echo '</pre>';
			// exit;

			if ( isset( $data->site ) ) {

				/**
				 * The site exists on the Social Commerce Page Tab Manager.
				 */
				$status = 'tab_exists';
			}
			else if ( isset( $data->status ) && 'tab_does_not_exist' == $data->status ) {

				/**
				 * The site doesn't exist on the Social Commerce Page Tab Manager.
				 */
				delete_option( 'oboxfb_page_tab_id_hash' );

				return oboxfb_tab_manager_checker();
			}
		}
	}

	$return['status'] = $status;

	return $return;
}


function oboxfb_tab_manager_integration_interface( $response, $checks_passed ) {

	switch ( $response['status'] ) {

		case 'error':

			?>
			<div class="oboxfb-tab-manager-integration-holder">

				<span class="oboxfb_integration_status oboxfb_integration_status_fail">
					<i class="oboxfb-icon-cancel"></i> We're having problems connecting...
				</span>

			</div>

			<div class="oboxfb_integration_notification oboxfb_integration_notification_fail">
				No connection means we can’t check if your store is live in your Facebook Page Tab. Please check back later...
			</div>
			<?php

		break;

		case 'tab_exists':

			$facebook_tab_url = $response['data']->site->facebook_tab_url;
			$delete_url = $response['data']->site->delete_url;
			$return_url = $return_url = admin_url( 'admin.php?page=obox-fb.php' );
			$delete_url = add_query_arg(
				array(
					'return_url' => urlencode( $return_url ),
				),
				$delete_url
			);
			?>
			<div class="oboxfb-tab-manager-integration-holder">

				<span class="oboxfb_integration_status oboxfb_integration_status_pass">
					<i class="oboxfb-icon-ok"></i> Your store is live on your Facebook Page Tab.
				</span>

				<div class="oboxfb_integration_actions">
					<a href="<?php echo esc_url( $facebook_tab_url ); ?>" class="oboxfb_integration_action" target="_blank">
						Preview Page Tab
					</a>
					<a href="<?php echo esc_url( $delete_url ); ?>" class="oboxfb_integration_action">
						Delete Page Tab
					</a>
				</div>
			</div>
			<?php

		break;

		default:

			// Add site_url to the $tab_manager_url - this lets the setup know this URL.
			$tab_manager_url = 'https://socialcommerceapp.co/setup/';
			$return_url = admin_url( 'admin.php?page=obox-fb.php' );

			$tab_manager_url = add_query_arg(
				array(
					'oboxfb_action' => 'create_page_tab',
					'site_url'      => urlencode( get_site_url() ),
					'return_url'    => urlencode( $return_url ),
				),
				$tab_manager_url
			);
			?>

			<?php if ( ! $checks_passed ) { ?>
				<div class="oboxfb_integration_notification oboxfb_integration_notification_fail">
					You won't be able to launch your store on Facebook until all of the above criteria are ticked off.
				</div>
			<?php } ?>

			<div class="oboxfb-tab-manager-integration-holder">

				<span class="oboxfb_integration_status oboxfb_integration_status_fail">
					<i class="oboxfb-icon-cancel"></i> Your store isn't live on your Facebook Page Tab.
				</span>

				<div class="oboxfb_integration_actions">
					<a class="button button-primary <?php echo ( ! $checks_passed ) ? 'button-primary-disabled' : '' ; ?>" href="<?php echo ( $checks_passed ) ? esc_attr( $tab_manager_url ) : "javascript:" ; ?>">
						Put your store live on Facebook +
					</a>
				</div>
			</div>

			<?php

		break;
	}
}

function oboxfb_theme_options_setup_interface() {

	$checks_passed = TRUE;

	ob_start();
	?>
	<div class="setup-help">

		<?php

		/**
		 * Do all checks.
		 */

		// Check if WooCommerce is active.
		$woocoomerce_active = class_exists( 'WooCommerce' );
		if ( ! $woocoomerce_active ) $checks_passed = FALSE;

		// Check if WooCommerce setting - woocommerce_cart_redirect_after_add.
		$woocommerce_cart_redirect_after_add = ( Boolean ) ( $woocoomerce_active && 'yes' != get_option( 'woocommerce_cart_redirect_after_add' ) );
		if ( ! $woocommerce_cart_redirect_after_add ) $checks_passed = FALSE;

		// Check if WooCommerce setting - woocommerce_enable_ajax_add_to_cart.
		$woocommerce_enable_ajax_add_to_cart = ( Boolean ) ( $woocoomerce_active && 'yes' != get_option( 'woocommerce_enable_ajax_add_to_cart' ) );
		if ( ! $woocommerce_enable_ajax_add_to_cart ) $checks_passed = FALSE;

		// Check if WooCommerce setting - woocommerce_force_ssl_checkout.
		$woocommerce_force_ssl_checkout = ( Boolean ) ( $woocoomerce_active && 'yes' == get_option( 'woocommerce_force_ssl_checkout' ) );
		if ( ! $woocommerce_force_ssl_checkout ) $checks_passed = FALSE;

		// Check if SSL is enabled.
		$ssl_active = is_ssl();
		if ( ! $ssl_active ) $checks_passed = FALSE;

		// Check if is live.
		$is_live = ( Boolean ) ( isset( $_SERVER['SERVER_NAME'] ) && 'localhost' != $_SERVER['SERVER_NAME'] && '127.0.0.1' != $_SERVER['SERVER_NAME'] );
		if ( ! $is_live ) $checks_passed = FALSE;

		// return false;

		/**
		 * API check
		 */
		$response = oboxfb_tab_manager_checker();


		/**
		 * Display Interface.
		 */
		if ( get_option( 'oboxfb_page_tab_id_hash' ) ) {

			/**
			 * Display the Page Tab Manager Integration on it's own.
			 */
			oboxfb_tab_manager_integration_interface( $response, $checks_passed );
		}
		else {

			/**
			 * Display the Page Tab Manager Integration, alnong with the all the checks.
			 */
			?>

			<div class="setup-help-item">
				<h5><strong>Step 1</strong> - Make sure WooCommerce is active and correctly configured</h5>
				<p>
					Social Commerce requires WooCommerce plugin is active and the following settings configured as follows <a href="http://kb.oboxthemes.com/themedocs/social-commerce-suggested-woocommerce-settings/" target="_blank" class="oboxfb-subtle-url-NOT">more info <i class="oboxfb-icon-export"></i></a>:
					<span class="oboxfb_checklist_status <?php echo ( $woocoomerce_active ) ? 'oboxfb_checklist_pass' : 'oboxfb_checklist_fail' ; ?>">
						WooCommerce active
					</span>
					<span class="oboxfb_checklist_status <?php echo ( $woocommerce_cart_redirect_after_add ) ? 'oboxfb_checklist_pass' : 'oboxfb_checklist_fail' ; ?>">
						<em>'Uncheck'</em> this setting '<a href="<?php echo admin_url( 'admin.php?page=wc-settings&tab=products&section=display' ); ?>" class="oboxfb-subtle-url-NOT">Redirect to the cart page after successful addition</a>'
					</span>
					<span class="oboxfb_checklist_status <?php echo ( $woocommerce_enable_ajax_add_to_cart ) ? 'oboxfb_checklist_pass' : 'oboxfb_checklist_fail' ; ?>">
						<em>'Uncheck'</em> this setting '<a href="<?php echo admin_url( 'admin.php?page=wc-settings&tab=products&section=display' ); ?>" class="oboxfb-subtle-url-NOT">Enable AJAX add to cart buttons on archives</a>'
					</span>
					<span class="oboxfb_checklist_status <?php echo ( $woocommerce_force_ssl_checkout ) ? 'oboxfb_checklist_pass' : 'oboxfb_checklist_fail' ; ?>">
						<em>'Check'</em> this setting '<a href="<?php echo admin_url( 'admin.php?page=wc-settings&tab=checkout' ); ?>" class="oboxfb-subtle-url-NOT">Force secure checkout</a>'
					</span>
				</p>
			</div>

			<?php
			/**
			 * Check if SSL is enabled.
			 */


			?>
			<div class="setup-help-item">
				<h5><strong>Step 2</strong> - Enable SSL for your store</h5>
				<p>
					For security reasons Facebook requires that your shop be running SSL before you can show it in your Facebook Page Tab. Refer to your host to inquire on SSL setup and pricing <a href="<?php echo esc_url( 'https://www.facebook.com/notes/znet-corp/facebook-require-ssl-certificate-from-oct-1-2011/1990032877406/' ); ?>" target="_blank" class="oboxfb-subtle-url-NOT">more info <i class="oboxfb-icon-export"></i></a>.
					<br>
					<?php if ( $ssl_active ) { ?>
						<!-- Pass -->
						<span class="oboxfb_checklist_status oboxfb_checklist_pass">
							Your store is SSL enabled
						</span>
					<?php } else { ?>
						<!-- Fail -->
						<span class="oboxfb_checklist_status oboxfb_checklist_fail">
							Your store is not SSL enabled
						</span>
					<?php } ?>
				</p>
			</div>

			<?php
			/**
			 * Check if SSL is enabled.
			 */
			?>
			<div class="setup-help-item">
				<h5><strong>Step 3</strong> - Make sure your shop is live and accessible</h5>
				<p>
					It’s also important that your store is live - not on a testing url like http://localhost, or on temporary test location - or it will not be accessible by Facebook <a href="http://kb.oboxthemes.com/themedocs/social-commerce-setup-your-facebook-app/" class="oboxfb-subtle-url-NOT" target="_blank">more info <i class="oboxfb-icon-export"></i></a>.
					<br>
					<?php if ( $is_live ) { ?>
						<!-- Pass -->
						<span class="oboxfb_checklist_status oboxfb_checklist_pass">
							Your store is live & accessible
						</span>
					<?php } else { ?>
						<!-- Fail -->
						<span class="oboxfb_checklist_status oboxfb_checklist_fail">
							Your store is not live & accessible
						</span>
					<?php } ?>
				</p>
			</div>

			<?php
			/**
			 * Customize your store (No Checks)
			 */

			$preview_url = add_query_arg( 'obox-fb', 1, wp_unslash( get_site_url() ) . '/' );
			?>
			<div class="setup-help-item">
				<h5><strong>Step 4</strong> - Customize your store</h5>
				<p>
					Preview your store to see what customers will see when visiting your Facebook Tab by visiting this unique url - <a href="<?php echo esc_url( $preview_url ); ?>" target="_blank"><?php echo esc_url( $preview_url ); ?> <i class="oboxfb-icon-export"></i></a>. Use the settings tabs to customize what you see <a href="http://kb.oboxthemes.com/themedocs/social-commerce-configure-plugin-settings/" class="oboxfb-subtle-url-NOT" target="_blank">more info <i class="oboxfb-icon-export"></i></a>.
				</p>
			</div>

			<?php
			/**
			 * Final Step - Put Site Live.
			 */
			?>
			<div class="setup-help-item">
				<h5><strong>Step 5 (final step)</strong> - Put your store live on your Facebook Page</h5>
				<p>
					Click the button below to authorize your site with Facebook and add your Social Commerce store to your Facebook Page.
					<br>
				</p>

				<?php
				/**
				 * Display the Tab Manager Main integration panel.
				 */
				oboxfb_tab_manager_integration_interface( $response, $checks_passed );
				?>
			</div>

			<?php
		}
		?>

	</div>
	<?php
	return ob_get_clean();
}