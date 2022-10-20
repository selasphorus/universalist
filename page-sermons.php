<?php
/**
* Template Name: Sermons Archive Page
*
* @package WordPress
* @subpackage Universalist
*/


get_header(); ?>
<!-- wpt: page-sermons -->
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) :
			the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// End of the loop.
		endwhile;
		
		$info = ""; // init -- var in this case used for debugging only

        // Get current page and append to custom query parameters array (for pagination)
		$current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$info .= "<!-- current_page: $current_page -->";
        
		// WIP -- filtering
        
		// Get query vars for filtering
		$year = get_query_var( 'sermon_date' ) ? get_query_var( 'sermon_date' ) : null; // NB: sermon_date stored in query_var as Y only
        $sermon_author = get_query_var( 'sermon_author' ) ? get_query_var( 'sermon_author' ) : 'any';
		//$sermon_author = get_query_var( 'sermon_author' ) ? get_query_var( 'sermon_author' ) : null;		
		$bbook = get_query_var( 'bbook' ) ? get_query_var( 'bbook' ) : null;
		if ($bbook === 'any' ) { $bbook = null; }
		$topic = get_query_var( 'sermon_topic' ) ? get_query_var( 'sermon_topic' ) : null;
        
        // Find sermons matching the selected filters
        $sermons_info = find_matching_sermons( $year, $sermon_author, $bbook, $topic );
		echo $sermons_info['msg'];
		$args = $sermons_info['args'];
		$sermons = $sermons_info['posts'];
        
        $args['paged'] = $current_page;
        echo '<div class="troubleshooting">args: <pre>'.print_r($args, true).'</pre></div>';
        
        //$sermons_query = new WP_Query( $args );
		
		if ( $sermons->have_posts() ) {
			while ( $sermons->have_posts() ) {
				?>
				<div class="archive">
				<?php
				$sermons->the_post();
				$post_id = get_the_ID();
				$info .= "<!-- post_id: $post_id -->";
				get_template_part( 'template-parts/content', 'sermon' );
				?>
				</div><!-- /archive -->
				<?php
			}
            
            // Reset postdata
			wp_reset_postdata();
			
            /*
			// Temporarily swap queries for pagination to function on secondary loop            
            $temp_query = $wp_query;
            $wp_query   = NULL;
            $wp_query   = $sermons_query;
            
			//echo "max_num_pages: $sermons_query->max_num_pages<br />"; // tft
			//echo "Last SQL-Query: {$sermons_query->request}";
		
			// Custom query loop pagination
			?>
			<div class="nav-previous alignleft"><?php previous_posts_link( '<span>&laquo;</span> Newer Sermons' ); ?></div>
			<div class="nav-next alignright"><?php next_posts_link( 'Older Sermons <span>&raquo;</span>', $sermons_query->max_num_pages ); ?></div>
            <br clear="all" />
			<?php
				
            // Reset main query object
            $wp_query = NULL;
            $wp_query = $temp_query;
            */
            /*echo "<!-- Pagination -->";
            // Previous/next page navigation.
			the_posts_pagination(
				array(
					'prev_text'          => __( 'Previous page', 'twentysixteen' ),
					'next_text'          => __( 'Next page', 'twentysixteen' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
				)
			);
            echo "<!-- /Pagination -->";
            */
            
		} else {
			echo "No matching sermons found.<br />";
			echo '<div class="troubleshooting">sermons: <pre>'.print_r($sermons, true).'</pre></div>';
		}
        
        wp_reset_postdata(); // obsolete?

		if ( is_dev_site() ) { 
            echo "<hr />".$info; // tft
        }
		
		?>

	</main><!-- .site-main -->

	<?php //get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
