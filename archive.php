<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen > Universalist
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>
<!-- wpt: archive -->

	<div id="primary" class="content-area"><!-- fullwidth -->
		<main id="main" class="site-main" role="main">

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
            
            // init
            $archive_type = null; // maybe don't need this var at all?
            $featured_posts = null;
            
            // Determine type of archive -- category? tag? other taxonomy? -- and query accordingly for featured posts
            
            $term = get_queried_object();
            $term_id = $term->term_id;
            $term_slug = $term->slug;
            $taxonomy = $term->taxonomy;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            echo "<!-- term: ".print_r($term_id, true)." -->";
            echo "<!-- term_id: ".$term_id." -->";
            echo "<!-- term_slug: ".$term_slug." -->";
            echo "<!-- taxonomy: ".$taxonomy." -->";
            echo "<!-- paged: ".$paged." -->";
            
            if ( is_category() ) {
                
                //$archive_type = "category";
                
                // Check for "cat" query var
                $cat = get_category( get_query_var( 'cat' ) );
                $cat_id = $cat->term_id;
                $cat_slug = $cat->slug;
                
                //echo "<!-- cat: ".print_r($cat, true)." -->";
                echo "<!-- cat_id: ".$cat_id." -->";
                echo "<!-- cat_slug: ".$cat_slug." -->";
                $args = array( 'category' => $cat_id, );
                $posts_info = allsouls_get_posts( $args );
                $featured_posts = $posts_info['arr_posts'];
                //echo $posts_info['info']; // tft
                
            } else if ( is_tax() ) {
                
                //$archive_type = "custom_taxonomy";
                
                if ( $taxonomy == "program_label" ) {
                    $related_events = get_related_events ( $taxonomy, $term_id );
                    echo "related_events['info']: <br />".$related_events['info']."<br />";
                    //echo "event_posts: <pre>".print_r($related_events['event_posts'], true)."</pre>";
                }
                
            } else if ( is_tag() ) {
                
                //$archive_type = "tag";
                
            }
            
            // Loop through and display the featured posts, if any
            if ( !empty( $featured_posts) && $featured_posts->have_posts() && $paged == 1 ) {
                ?>
                <div class="featured-posts">
                <?php
                while ( $featured_posts->have_posts() ) {

                    $featured_posts->the_post();
                    $post_id = get_the_ID();
                    echo "<!-- post_id: ".$post_id." -->";
                    $post_type_for_template = atc_get_type_for_template();
                    //echo "<!-- post_type_for_template: ".$post_type_for_template." -->";
                    get_template_part( 'template-parts/content', $post_type_for_template );
                }
                ?>
                </div>
            <?php
                wp_reset_postdata();
            }
            
            // If this is a category archive, modify the main query to exclude Archived articles
            if ( is_category() ) {
                
                if ( is_dev_site() ) {
                    $archives_cat_id = '2183'; // dev
                } else {
                    $archives_cat_id = '2971'; // live
                }
                
                global $wp_query;
                $args = array_merge( $wp_query->query_vars, array( 'cat' => $archives_cat_id ) );
                query_posts( $args );
                
            } else if ( is_tax() ) {
                
                // TODO: get related posts accordingly to taxonomy -- e.g. all programs containing specified program_label
                
                
            }

			//
            if ( have_posts() ) {
            
                if ( is_category() && $paged == 1 ) { 
                    echo "<h2>Archived Articles</h2>";
                }
            
                // Loop through the posts 
                while ( have_posts() ) {
                    the_post();

                    $post_type_for_template = atc_get_type_for_template();
                    //echo "<!-- post_type_for_template: ".$post_type_for_template." -->";
                    get_template_part( 'template-parts/content', $post_type_for_template );

                } // endwhile;

                // Previous/next page navigation.
                the_posts_pagination(
                    array(
                        'prev_text'          => __( 'Previous page', 'twentysixteen' ),
                        'next_text'          => __( 'Next page', 'twentysixteen' ),
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
                    )
                );

			// If no content, include the "No posts found" template.
            } else {
			//get_template_part( 'template-parts/content', 'none' );
            }
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
