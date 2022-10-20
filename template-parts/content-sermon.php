<?php
/**
 * The template part for displaying sermons
 *
 */
?>

<?php 
$post_id = get_the_ID();
$date = get_post_meta( $post_id, 'sermon_date', true );
$sermon_date = date_create($date);
$formatted_date = date_format($sermon_date,"l, F d, Y \@ h:i a");
$subtitle = get_post_meta( $post_id, 'subtitle', true );
?>

<!-- wpt: template-parts/content-sermon -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_singular('sermon') ) { ?>
        
            <h1 class="inline">Sermon Archive</h1>
			<h2 class="sermon-title<?php if ( $subtitle ) { echo " has-subtitle"; } ?>"><?php the_title(); ?></h2>
            <?php if ( $subtitle ) { ?><h3 class="subtitle"><?php echo $subtitle; ?></h3><?php } ?>
        
		<?php } else { // sermons archive ?>
        
			<h2 class="em_events"><?php echo $formatted_date; ?></h2>
            <?php //echo get_day_title( array ('the_date' => $date ) ); ?>
            <h3 class="entry-title"><?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); // syntax: the_title( $before, $after, $echo ); ?></h3>
            <?php if ( $subtitle ) { ?><h4 class="subtitle"><?php echo $subtitle; ?></h4><?php } ?>
        
		<?php } ?>
	</header><!-- .entry-header -->

    <div class="entry-content">
        <?php 
        if ( is_singular('sermon') ) {
            
            echo get_cpt_sermon_meta();
            allsouls_post_thumbnail();
            echo atc_custom_post_content(); // Specialized content per Custom Post Type (CPT)
            
            /* translators: %s: Name of current post */
            the_content(
                sprintf(
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
                    get_the_title()
                )
            );

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
            
        } else {
            
            echo get_cpt_sermon_meta();
            twentysixteen_excerpt();
        }
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
