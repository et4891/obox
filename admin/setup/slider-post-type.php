


<?php
function oboxfb_slider_post_type()
{
	$labels = array(
		// 'name' => _x('Social Slider', 'post type general name','ocmx'),
		'name' => _x('荟Facebook幻灯片', 'post type general name','ocmx'),
		'singular_name' => _x('幻灯片', 'post type singular name','ocmx'),
		'add_new' => _x('Add 幻灯片', 'social-slider','ocmx'),
		'add_new_item' => __('Add New 幻灯片','ocmx'),
		'edit_item' => __('Edit ','ocmx'),
		'new_item' => __('New 幻灯片','ocmx'),
		'view_item' => __('View 幻灯片','ocmx'),
		'search_items' => __('Search 幻灯片','ocmx'),
		'not_found' =>  __('No 幻灯片 found','ocmx'),
		'not_found_in_trash' => __('No 幻灯片 found in Trash','ocmx'),
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'menu_icon' => 'dashicons-facebook',
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','author','thumbnail', 'page-attributes')
	);
	register_post_type('social-slider',$args);

}

add_action( 'init' , 'oboxfb_slider_post_type');
add_action( 'add_meta_boxes', 'obox_add_custom_box' );
add_action( 'save_post', 'obox_save_postdata' );

function obox_add_custom_box() {
		add_meta_box(
				'obox_options',
				'Slider Options',
				'obox_inner_custom_box',
				'social-slider'
		);
}

function obox_inner_custom_box( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'obox_noncename' );

	$mydata = get_post_meta($post->ID, 'obox_slider', TRUE);
	if( '' != $mydata ){
		$link = $mydata['obox_imageurl'];
	} else {
		$link = '';
	}
	// The actual fields for data entry
	echo '<label for="obox_imageurl">';
	echo "Your Slide's link: (Only internal links):";
	echo '</label> ';
	echo '<input type="text" id="obox_imageurl" name="obox_imageurl" value="'. $link .'" size="25" />';
}

function obox_save_postdata( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

	if ( !isset( $_POST['obox_noncename'] ) || ( isset( $_POST['obox_noncename'] ) && !wp_verify_nonce( $_POST['obox_noncename'], plugin_basename( __FILE__ ) ) ) )
			return;

	if ( !current_user_can( 'edit_post', $post_id ) )
				return;

	$mydata = array();
	foreach($_POST as $key => $data) {
		if($key == 'obox_noncename')
			continue;
		if(preg_match('/^obox/i', $key)) {
			$mydata[$key] = $data;
		}
	}

	update_post_meta($post_id, 'obox_slider', $mydata);
	return $mydata;
}