<?php
/**
 * The template part for displaying content excerpts
 *
 * @package WordPress
 * @subpackage Universalist
 */
?>

<!-- wpt: template-parts/content-excerpt -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php
    //if ( is_dev_site() ) { 
        echo "<!-- allsouls_post_thumbnail -->"; // tft
        allsouls_post_thumbnail( 'medium', true);
    //}
    ?>
    
	<header class="entry-header">
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<span class="sticky-post"><?php _e( 'Featured', 'twentysixteen' ); ?></span>
		<?php endif; ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		
		<?php if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) { twentysixteen_entry_date(); } ?>
		
	</header><!-- .entry-header -->

	<div class="entry-content">
        
        <?php
        //allsouls_post_thumbnail('medium');
        
        the_excerpt();
        //twentysixteen_excerpt();
        
        wp_link_pages(
            array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
                'separator'   => '<span class="screen-reader-text">, </span>',
            )
        );
        ?>
	</div><!-- .entry-content -->

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
