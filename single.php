<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Universalist
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<!-- wpt: single -->
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) :
			the_post();

		// Determine the post type and include the appropriate post content template.
		$post_type = atc_get_type_for_template();
        $post_id = get_the_ID();
		//echo '<p>post_type: '.$post_type.'</p>';
		echo '<!-- wpt_post_type: '.$post_type.' -->';
		get_template_part( 'template-parts/content', $post_type );

			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation(
					array(
						'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen' ),
					)
				);
			} elseif ( is_singular( 'post' ) && $post_id != 232540 ) {
				// Previous/next post navigation.
				the_post_navigation(
					array(
						'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post&nbsp;&rarr;', 'twentysixteen' ) . '</span> ' .
							'<span class="screen-reader-text">' . __( 'Next post:', 'twentysixteen' ) . '</span> ' .
							'<span class="post-title">%title</span>',
						'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '&larr;&nbsp;Previous Post', 'twentysixteen' ) . '</span> ' .
							'<span class="screen-reader-text">' . __( 'Previous post:', 'twentysixteen' ) . '</span> ' .
							'<span class="post-title">%title</span>',
					)
				);
			}

			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
