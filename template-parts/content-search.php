<?php
/**
 * The template part for displaying results in search pages
 *
 */
?>

<!-- wpt: template-parts/content-search -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ).get_post_type_str().': ', '</a></h2>' ); // syntax: the_title( $before, $after, $echo ); ?>
		
		<?php if ( in_array( get_post_type(), array( 'post', 'page' ) ) ) { ?>
			<span class="pub_date">Published on <?php echo twentysixteen_entry_date(); ?></span>
		<?php } ?>
		
	</header><!-- .entry-header -->

	<?php twentysixteen_excerpt(); ?>
    <span class="smaller"><?php echo "Search relevance score: $post->relevance_score"; ?></span>

		<footer class="entry-footer">
			<?php twentysixteen_entry_meta(); ?>
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	
</article><!-- #post-<?php the_ID(); ?> -->

