<?php
/**
 * The template for displaying search results pages
 *
 * Adapted from @subpackage Twenty_Sixteen
 */

get_header(); ?>

<!-- wpt: search -->
<?php 
$results_type = null; // tft while lines below are disabled
//$query_post_type = get_query_var( 'type');
//if (!empty($query_post_type)) { $results_type = get_post_type_str( $query_post_type ); } else { $results_type = null; }
/*echo '<pre>';
var_dump($wp_query->query); // tft -- ok
var_dump($wp_query->query_vars['orderby']); // tft -- ok
echo '</pre>';*/

//echo "query_post_type: $query_post_type<br />";
//echo "results_type: $results_type<br />";
//global $wp_query;
//print_r($wp_query);
/*echo '<pre>';
//var_dump($wp_query->query_vars); // tax_query, meta_query, date_query...
//var_dump($wp_query);
echo '</pre>';*/
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentysixteen' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
				<?php 
				if ( $results_type ) {
					echo 'Filtered to show only results of type "'.$results_type.'"<br />';
                } ?>
				<?php echo '<em>('.$wp_query->found_posts.' results found)</em>'; ?>
			</header><!-- .page-header -->

			<?php			
			// Start the loop.
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

				// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination(
				array(
					'prev_text'          => __( 'Previous page', 'twentysixteen' ),
					'next_text'          => __( 'Next page', 'twentysixteen' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
				)
			);

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
