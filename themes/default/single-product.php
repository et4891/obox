<?php get_header();
global $product;
$link = get_permalink($post->ID);
?>

	<div id="col2">

		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); global $post, $product; ?>

			<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<?php if( !is_home() ) { oboxfb_breadcrumbs( 'crumbs' ); } ?>  
				<?php do_action( 'woocommerce_before_single_product', $product ); ?>
                
                <div class="product-header-meta">
					<h2 class="post-title"><?php the_title(); ?></h2>
                 	<?php if( get_option('oboxfb_social_meta') != 'no') { ?>
                       <div class="fb-like product-share" data-href="<?php echo $link; ?>" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
                    <?php } ?>
				</div>
				
                <div class="product-left">
					<?php do_action( 'woocommerce_before_single_product_summary', $product ); ?>
				</div>

				<div class="product-content">
					<div class="product-price">
						<?php do_action( 'woocommerce_single_product_summary', $product ); ?>
					</div>     
                </div> 
                <div class="clearfix"></div>


					<div class="woocommerce_tabs clearfix">
						<?php do_action( 'woocommerce_after_single_product_summary', $post, isset($product) ); ?>
					</div>

				
			</div>

		<?php endwhile; ?>

	</div>

<?php get_footer(); ?>