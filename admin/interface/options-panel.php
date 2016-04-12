<?php function oboxfb_options_panel($section_header, $tabs = 0, $submit_text = "Save Changes", $note = "") {
			global $oboxfb_theme_options, $selected_tab, $changes_done, $ocmx_version;
			 if( isset( $_GET["current_tab"] ) ) :
				$selected_tab = $_GET["current_tab"];
			else :
				$selected_tab = 1;
			endif; ?>
			<form action="<?php echo esc_html( $_SERVER['REQUEST_URI'] ) ?>" name="oboxfb-options" id="oboxfb-options" method="post" enctype="multipart/form-data">
				<div class="ocmx-container">
					<div class="wrap">
						<h2>
							Social Commerce
							<div class="heading-sub-line">
								Show your WooCommerce Shop on your facebook page tab. <strong>Version <?php echo OBOXFB_VER; ?></strong>
							</div>
						</h2>

						<?php if(isset($_GET["changes_done"]) || $changes_done) : ?>
							<div class="updated below-h2" id="ocmx-note"><p><?php _e("Your changes were successful.","ocmx") ?></p></div>
						<?php elseif(isset($_GET["options_reset"])) : ?>
							<div class="updated below-h2" id="ocmx-note"><p><?php _e("These Options Have Been Reset.","ocmx") ?></p></div>
						<?php endif; ?>

						<!-- OCMX Tabs -->
						<?php if(count($tabs) > 1) : ?>
							<?php $tab_i = 1; ?>
							<div id="info-content-block">
								<ul id="tabs" class="tabs clearfix">
									<?php foreach($tabs as $tab) : ?>
										<li <?php if($selected_tab == $tab_i) : ?>class="selected" <?php endif; ?>>
											<a href="#" rel="#tab-<?php echo $tab_i; ?>"><?php echo $tab["option_header"]; ?></a>
										</li>
										<?php $tab_i++; ?>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>

						<!-- OCMX Form Content -->
						<?php $tab_i = 1; ?>
						<div id="content-block">

							<?php if($note != "") : ?>
								<p class="admin-note"><?php echo $note; ?></p>
							<?php endif; ?>

							<?php foreach($tabs as $tab => $taboption) : ?>
								<ul class="<?php echo $taboption["ul_class"]; ?>" <?php if($selected_tab != $tab_i):?>style="display: none;"<?php endif; ?> id="tab-<?php echo $tab_i; ?>">
									<?php $use_options = $taboption["function_args"];
									if(isset($oboxfb_theme_options[$use_options])) :
										foreach($oboxfb_theme_options[$use_options] as $use_theme_options => $which_array) :
											do_action($taboption["use_function"], $which_array);
										endforeach;
									else :
										do_action($taboption["use_function"], isset($which_array));
									endif;?>
								</ul>
								<?php $tab_i++; ?>
							<?php endforeach; ?>

							<!-- Second row of form buttons go here -->
							<div class="base-controls clearfix">
								<?php if( '' != $submit_text ) : ?>
									<input type="submit" class="button-primary" value="<?php echo $submit_text; ?>" />
								<?php endif; ?>
								<?php if( count( $tabs ) >= 1) :

									$tab_i = 1;

									foreach( $tabs as $tab => $taboption) :
										if( isset($taboption["base_button"]["href"] ) ) : ?>
											<div <?php if( $selected_tab != $tab_i ) echo 'style="display: none;"'; ?> id="tab-<?php echo $tab_i; ?>-href-1">
												<a href="<?php echo $taboption["base_button"]["href"]; ?>" id="<?php echo $taboption["base_button"]["id"]; ?>" rel="<?php echo $taboption["base_button"]["rel"]; ?>" class="button-primary"><?php _e($taboption["base_button"]["html"]); ?></a>
											</div>
									<?php endif;
										$tab_i++;
									endforeach;
								endif; ?>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="oboxfb_update" value="<?php foreach($tabs as $tab) : echo $tab['function_args'].","; endforeach; ?>1" />
			</form>
<?php }

function obox_fb_option_li( $input = FALSE ) {
	global $counter, $label_class;

	// Bail if no input.
	if ( ! $input ) return; ?>

	<li class="admin-block-item">
		<div class="admin-description">
			<?php if(isset($input["main_section"])) : ?>
				<h4><?php _e($input["main_section"],"ocmx");?></h4>
				<?php if($input["main_description"] !== "") : ?>
					<p><?php _e($input["main_description"],"ocmx");?></p>
				<?php endif; ?>
			<?php else : ?>
				<h4><?php _e($input["label"],"ocmx");?></h4>
				<?php if($input['description'] !== "") : ?>
					<p><?php _e($input["description"]);?></p>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="admin-content">
			<?php if(isset($input["main_section"])) : ?>
				<?php if(isset($input["note"])) : ?>
					<p><em><?php _e($input["note"],"ocmx");?></em></p>
				<?php endif; ?>
				<ul class="form-options contained-forms">
					<?php foreach($input["sub_elements"] as $sub_input) :
						if(isset($sub_input["linked"])) :
							$option = $sub_input["linked"];
							if(get_option($option) == "false" || get_option($option) == "no" || get_option($option) == "off")
								{$hideme=1;}
							else
								{unset($hideme);}
							$showif = "rel=\"".$sub_input["linked"]."\"";
						endif;?>
						<li <?php if(isset($hideme)) : ?>class="no_display"<?php endif; ?> <?php if(isset($showif)) : echo $showif; endif; ?>>
							<label class="parent-label"><?php echo $sub_input["label"]; ?></label>
							<div class="form-wrap">
								<?php create_oboxfb_form($sub_input, count($input), "child-form"); ?>
							</div>
							<?php if($sub_input["description"] !== "") : ?>
								<span class="tooltip"><?php echo $sub_input["description"]; ?></span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else :
				create_oboxfb_form($input, count($input), $label_class);
			endif; ?>
		</div>
	</li>
	<?php
}
add_action("obox_fb_option_li", "obox_fb_option_li");