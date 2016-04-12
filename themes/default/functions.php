<?php

/**********************/
/* Include OCMX files */
include_once ('load-scripts.php');


add_action( 'wp_head', 'oboxfb_meta' );
function oboxfb_meta(){
	if(get_option("ocmx_open_graph") !="yes") {
		$default_thumb = get_option('ocmx_site_thumbnail');
		$fb_image = oboxfb_get_fbimage();
		if(is_home()) :
	?>
		<meta property="og:title" content="<?php bloginfo('name'); ?>"/>
		<meta property="og:description" content="<?php bloginfo('description'); ?>"/>
		<meta property="og:url" content="<?php echo home_url(); ?>"/>
		<meta property="og:image" content="<?php if(isset($default_thumb) && $default_thumb !==""){echo $default_thumb; } else {echo $fb_image;}?>"/>
		<meta property="og:type" content="<?php echo "website";?>"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>

	<?php else : ?>
		<meta property="og:title" content="<?php the_title(); ?>"/>
		<meta property="og:description" content="<?php echo strip_tags($post->post_excerpt); ?>"/>
		<meta property="og:url" content="<?php the_permalink(); ?>"/>
		<meta property="og:image" content="<?php if($fb_image ==""){echo $default_thumb;} else {echo $fb_image;} ?>"/>
		<meta property="og:type" content="<?php echo "article"; ?>"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
	<?php endif;
	}
}

global $wp_version;
if ( version_compare( $wp_version, '3.4', '>=' ) ) {
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
}

if ( ! isset( $content_width ) ) $content_width = 800;

add_image_size( 'slider-main', 599, 300, true);

/*********************/
/* Load Localization */
load_theme_textdomain('ocmx', get_template_directory() . '/lang');

/************************************************/
/* Fallback Function for WordPress Custom Menus */

function oboxfb_menu_fallback() {
	echo '<ul id="nav" class="clearfix">';
		wp_list_pages('title_li=&');
	echo '</ul>';
}


/******************************************************************************/
/* Each theme has their own "No Posts" styling, so it's kept in functions.php */

function oboxfb_no_posts(){
	_e("The page you are looking for does not exist","ocmx");
};
// disable the admin bar
show_admin_bar(false);

// Disable WooCommerce stylesheet for all themes
if ( defined( 'WOOCOMMERCE_VERSION' ) && version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}
else {
	define( 'WOOCOMMERCE_USE_CSS', false );
}

function oboxfb_add_query_vars($query_vars) {
	$query_vars[] = 'stylesheet';
	return $query_vars;
}
add_filter( 'query_vars', 'oboxfb_add_query_vars' );

function oboxfb_takeover_css() {
	$style = get_query_var('stylesheet');

	if($style == "custom") {
		include_once(get_template_directory(). '/style.php');
		exit;
	}
}
add_action( 'template_redirect', 'oboxfb_takeover_css');

/**************************/
/* Facebook Support      */
function oboxfb_get_fbimage() {
	global $post;
	if ( !is_single() ){
		return '';
	}
	$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', '' );
	$fbimage = null;

	if ( has_post_thumbnail($post->ID) ) {
		$fbimage = $src[0];
	} else {
		global $post, $posts;
		$fbimage = '';
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',
		$post->post_content, $matches);
		if(!empty($matches[1]))
			$fbimage = $matches [1] [0];
	}
	if(empty($fbimage)) {
		$fbimage = get_the_post_thumbnail($post->ID);
	}
	return $fbimage;
}
/**************************************************/
/* Redefine woocommerce_output_related_products() */

// Displays up to 3 related products on product posts (determined by common category/tag)
function woocommerce_output_related_products() {
	woocommerce_related_products(array( 'posts_per_page' => 4 ),1); // Display 4 products in a single row
}
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 8;' ), 8 );
/**************************************************/
/* Redefine woocommerce_product_reviews_tab() */

// Displays Facebook comments instead of WordPress comments to encourage social discussion and sharing
add_filter( 'woocommerce_product_tabs', 'oboxfb_remove_product_tabs', 98 );

function oboxfb_remove_product_tabs( $tabs ) {

	if( isset( $tabs['reviews'] ) ) unset( $tabs['reviews'] ); 			// Remove the reviews tab

	return $tabs;

}
add_filter( 'woocommerce_product_tabs', 'oboxfb_new_product_tab' );

function oboxfb_new_product_tab( $tabs ) {

	// Adds the new tab

	$tabs['social-reviews'] = array(
		'title' 	=> __( 'Reviews', 'woocommerce'),
		'priority' 	=> 50,
		'callback' 	=> 'oboxfb_new_product_tab_content',
	);

	return $tabs;

}
function oboxfb_new_product_tab_content() {
	global $product, $post;

	$permalink = get_permalink($post->ID);

	if ( get_option('fb_reviews') == 'yes' ) {

		echo '<div id="reviews">';
			echo '<div id="comments">';
				echo '<h2>'. __( 'Reviews', 'ocmx' ).'</h2>';
				echo '<div class="fb-like fb-reviews" data-href="'.$permalink.'" data-layout="button" data-action="recommend" data-show-faces="true" data-share="false"></div>';
				echo '<div class="fb-comments" data-href="'.$permalink.'?obox=fb=1" data-width="600" data-numposts="5" data-colorscheme="light"></div>';
			echo '</div>';
		echo '</div>';

	}
}
function oboxfb_reorder_tabs( $tabs ) {

	if( isset( $tabs['social-reviews'] ) ) $tabs['social-reviews']['priority'] = 5; // Reviews first
	if( isset( $tabs['description'] ) ) $tabs['description']['priority'] = 10; // Description second

	return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'oboxfb_reorder_tabs', 98 );

function oboxfb_remove_add_to_cart_buttons() {
	global $ocmx_oboxfb_class;
	if ( 'no' == get_option( 'show_cart_buttons' ) && TRUE == $ocmx_oboxfb_class->allow_oboxfb() ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}
}
add_action( 'woocommerce_init', 'oboxfb_remove_add_to_cart_buttons' );

function oboxfb_remove_same_options_header(){
	remove_action( 'template_redirect', 'wc_send_frame_options_header' );
 }
add_action( 'init', 'oboxfb_remove_same_options_header', 50 );