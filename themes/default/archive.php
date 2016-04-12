<?php get_header(); ?>

<div id="col2">
	<ul class="posts">
		<?php if (have_posts()) :
	        global $post;
	        while (have_posts()) : the_post(); setup_postdata($post);
	            get_template_part("/functions/fetch-list");
	        endwhile;

	    else :
	        oboxfb_no_posts();
	    endif; wp_reset_query(); ?>
    </ul>
    <?php
		global $wp_query;

		$big = 999999999; // need an unlikely integer
		$translated = __( 'Page', 'mytextdomain' ); // Supply translatable string

		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages,
				'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>'
		) );
	?>
</div>

<?php get_footer(); ?>