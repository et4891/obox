<?php global $product; ?>
<div id="col2">
	<ul class="blog-main-post-container clearfix">
		<li>
			<?php
				// Shopt Page Title
				$shop_page_id = get_option('woocommerce_shop_page_id');
				$shop_page = get_post( $shop_page_id );
				$shop_page_title = $shop_page_id ? $shop_page->post_title : get_option('woocommerce_shop_page_title');
			?>

			<?php if( !is_home() ) { oboxfb_breadcrumbs( 'crumbs' ); } ?>

			<?php if (is_search()) : ?>
				<h2 class="post-title"><?php _e('Search Results:', 'ocmx'); ?> &ldquo;<?php the_search_query(); ?>&rdquo; <?php if (get_query_var('paged')) echo ' &mdash; Page '.get_query_var('paged'); ?></h2>
			<?php else : ?>
				<h2 class="post-title"><?php echo apply_filters('the_title', $shop_page_title); ?></h2>
			<?php endif; ?>

			<?php if (have_posts()) : ?>
            	<?php  do_action('woocommerce_before_shop_loop'); ?>
				<?php woocommerce_product_loop_start(); ?>
				<?php woocommerce_product_subcategories(); ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; // end of the loop. 
			else :
				get_template_part("/functions/post-empty"); ?>	
			<?php endif; ?>
            <?php  do_action('woocommerce_after_shop_loop'); ?>
            <?php woocommerce_product_loop_end(); ?>
		</li>
	</ul>

</div>