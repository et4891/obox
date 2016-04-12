<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'One Comment on &ldquo;%2$s&rdquo;', '%1$s Comment on &ldquo;%2$s&rdquo;', get_comments_number(), 'ocmx' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="commentlist">

            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>">
                    <div class="comment-author vcard">
                        <?php echo get_avatar($comment, $size = '60'); ?>
                    </div>
                    
                    <div class="comment-meta commentmetadata">
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em><?php _e('Your comment is awaiting moderation.', 'ocmx'); ?></em>
                            <br />
                        <?php endif; ?>
                        <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
                        <a class="date" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf(__('%1$s at %2$s', 'ocmx'), get_comment_date(),  get_comment_time()); ?></a>
                        <?php edit_comment_link(__('(Edit)', 'ocmx'),'  ',''); ?>
                        <?php comment_text(); ?>
                    </div>
        
                    <div class="reply">
                        <?php comment_reply_link(); ?>
                    </div>
                </div>
            </li>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'ocmx' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'ocmx' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ocmx' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'ocmx' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>

</div><!-- #comments .comments-area -->