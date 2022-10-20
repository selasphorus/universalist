<?php
/**
 * The template part for displaying series
 *
 */
?>

<?php 
$post_id = get_the_ID();

// Determine the series type
if ( is_singular('event_series') ) {
    $series_type = 'event_series';
    $post_type = 'event';
    $related_field = 'related_events';
} else if ( is_singular('sermon_series') ) {
    $series_type = 'sermon_series';
    $post_type = 'sermon';
    $related_field = 'related_sermons';
}

//echo "<!-- series_type: ".$series_type."; post_type: ".$post_type."; related_field: ".$related_field." -->"; // tft

// Get the series posts
$series_post_ids = get_field($related_field, $post_id, false);
//echo "<!-- series_post_ids: <pre>".print_r($series_post_ids, true)."</pre> -->"; // tft -- Beware! this breaks if post content contains comments

// Initialize a new array for building a multi-dimensional array for sorting by the appropriate post meta value
$series_posts = array();

foreach ( $series_post_ids as $series_post_id ) {
	if ( $post_type == "event" ) {
		$event_date = get_post_meta( $series_post_id, '_event_start_date', true );
		$series_posts[$event_date] = $series_post_id;
		//$series_posts[] = array( 'ID' => $series_post_id, 'sorter' => $event_date );
	} else if ( $post_type == "sermon" ) {
		$sort_num = get_field('sermon_series_num', $series_post_id, false);
		$series_posts[$sort_num] = $series_post_id;
		//$series_posts[] = array( 'ID' => $series_post_id, 'sorter' => $sort_num );
	}
}

// Sort array of series_posts according to series type
if ( $series_posts ) {
	ksort($series_posts);
    if ( $post_type == "event" ) {
        // Sort Events by start date
        //usort($series_posts, atc_array_sorter('_event_start_date', 'meta_key'));
    } else if ( $post_type == "sermon" ) {
        // Sort sermons by sermon_series_num
        // TODO: expand array_sorter fcn to allow for multiple sort keys, e.g. sermon_series_num, then sermon_date
        //usort($series_posts, atc_array_sorter('sermon_series_num', 'meta_key'));
    }
    //echo "<!-- series_posts, sorted: <pre>".print_r($series_posts, true)."</pre> -->"; 
}
?>

<!-- wpt: template-parts/content-series -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
	<header class="entry-header">
		<h1 class="inline"><!-- <?php echo ucfirst( $post_type ); ?> Series: --><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        
        allsouls_post_thumbnail();

        /* translators: %s: Name of current post */
        the_content(
            sprintf(
                __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
                get_the_title()
            )
        );

        ?>
        
        <?php if ( !empty($series_posts) ) { ?>
            <div class="archive allsouls_em_events">
            <?php
            foreach ( $series_posts as $sorter => $series_post_id ) {
                $post = get_post( $series_post_id );
                echo "<!-- series_post_id: ".$series_post_id." -->"; // tft
                get_template_part( 'template-parts/content', $post_type );
            }
            wp_reset_postdata();
            ?>
            </div>
        <?php } ?>
        
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
