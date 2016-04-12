<?php 
global $post;    // Declare global $more (before the loop).
$link = get_permalink($post->ID);
$image = get_oboxfb_image(620, '380', '', 'div', 'post-image'); ?>
<li class="post">		
    <h2 class="post-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h2>
	<div class="post-image">
    	<?php echo $image ?>
    </div>
	<div class="post-meta clearfix">
		<p><?php echo the_time(get_option('date_format'));  _e(", By ","ocmx"); the_author_posts_link(); _e(" in ",'ocmx'); the_category(", ",'ocmx'); ?></p>
	</div>
    <div class="copy clearfix">
        <?php the_excerpt(); ?>
        <p><a href="<?php echo $link; ?>" class="action-link"><?php _e("Continue Reading &rarr;", "ocmx"); ?></a></p>
    </div>    
</li>                        
