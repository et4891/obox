<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?> xmlns:fb="http://ogp.me/ns/fb#">
<head prefix="og: http://ogp.me/ns# object: http://ogp.me/ns/object#">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--Set Viewport for Mobile Devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<div id="fb-root"></div>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<script>
	FB.init({
	appId  : '<?php echo get_option("fb_appid"); ?>',
	status : true, //check login status
	cookie : true, //enable cookies to allow the server to access the session
	xfbml  : true  //parse XFBML
	 });
	FB.Canvas.setAutoGrow(7);
</script>


<div id="wrapper">
	<div id="container">

		<div id="col1">

			<div class="logo">
				<h1>
					<a href="<?php echo site_url(); ?>">
						<?php if(get_option("oboxfb_custom_logo")) : ?>
							<img src="<?php echo get_option("oboxfb_custom_logo"); ?>" alt="<?php bloginfo('name'); ?>" />
						<?php else : ?>
							<?php bloginfo('name'); ?>
						<?php endif; ?>
					</a>
				</h1>
			</div>

			<div class="content">
				<form role="search" method="get" id="searchform" action="<?php echo home_url(); ?>">
						<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="<?php _e('Search for products', 'ocmx'); ?>" />
						<input type="submit" id="searchsubmit" value="<?php _e('Search', 'ocmx'); ?>" />
						<input type="hidden" name="obox-fb" value="1" />
						<input type="hidden" name="post_type" value="product" />
				</form>
			</div>

			<div class="content navigation">
				<?php if (function_exists("wp_nav_menu")) :
					wp_nav_menu(array(
							'menu' => 'Social Commerce Nav',
							'menu_id' => 'nav',
							'menu_class' => 'clearfix',
							'sort_column' 	=> 'menu_order',
							'theme_location' => 'oboxfb',
							'container' => 'ul',
							'fallback_cb' => 'oboxfb_menu_fallback')
					);
				endif; ?>
			</div>

			<?php dynamic_sidebar('social_sidebar'); ?>
			<?php if(get_option("oboxfb_custom_footer") !="") :
				echo get_option('oboxfb_custom_footer');
			endif; ?>
		</div>