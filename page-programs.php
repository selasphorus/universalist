<?php
/**
* Template Name: Event Programs DEV Page
*
* @package WordPress
* @subpackage Universalist
*/


get_header(); ?>
<!-- wpt: page-programs -->
<div id="primary" class="fullwidth content-area">
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
		
		// TO DO: move query construction to plugin?
		
        $posts_per_page = 10;
        
		// Set up query args -- Get all posts w/ personnel placeholder rows
        $args = array(
            'posts_per_page' => $posts_per_page,
            'post_type'   => 'event',
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'personnel',
                    'compare' => 'EXISTS'
                ),
                array(
                    'key'     => 'personnel',
                    'compare' => '!=',
                    'value'   => 0,
                ),
                array(
                    'key'     => 'personnel',
                    'compare' => '!=',
                    'value'   => '',
                )
            ),
            'orderby'   => 'ID meta_key',
            'order'     => 'ASC',
            'tax_query' => array(
                //'relation' => 'AND', //tft
                array(
                    'taxonomy' => 'admin_tag',
                    'field'    => 'slug',
                    'terms'    => array( 'program-personnel-placeholders' ),
                    //'terms'    => array( 'program-placeholders' ),
                    //'terms'    => array( $admin_tag_slug ),
                    //'operator' => 'NOT IN',
                ),
                /*
                array(
                    'taxonomy' => 'event-categories',
                    'field'    => 'slug',
                    'terms'    => 'choral-services',//'terms'    => 'worship-services',

                )*/
            ),
        );

        // Get current page and append to custom query parameters array (for pagination)
		$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

		//$info .= "<!-- args: <pre>".print_r($args, true)."</pre> -->"; // tft
        $info .= "args: <pre>".print_r($args, true)."</pre>"; // tft
        
        $personnel_query = new WP_Query( $args );
        //$posts = $personnel_query->posts;
        
		$info .= "<p>Last SQL-Query (personnel_query): {$personnel_query->request}</p>";
        //$info .= "<!-- Last SQL-Query (query): {$personnel_query->request} -->";

        if ( $personnel_query->have_posts() ) :
			?>
			<table>
                <tr>
                    <th>post_id</th>
                    <th>role</th>
                    <th>role_txt</th>
                    <th>person</th>
                    <th>ensemble</th>
                    <th>person_txt</th>
                    <th>MATCH(ES)</th>
                    <th>Actions</th>
                </tr>
			<?php
            while ( $personnel_query->have_posts() ) :
				
                $personnel_query->the_post();
                $post_id = get_the_ID();
                //echo "post_id: $post_id<br />";
                
                // Get the program personnel repeater field values (ACF)
                $personnel = get_field('personnel', $post_id);
                if ( empty($personnel) ) { $personnel = array(); }
                $info .= "<!-- ".count($personnel)." personnel rows -->\n"; // tft
    
                if ( count($personnel) > 0 && current_user_can('administrator') ) {

                    foreach ($personnel as $row) {
                        
                        // TODO: figure out how to streamline this -- duplicate code
                        
                        // Get the person role
                        if ( isset($row['role']) ) { 

                            if ( isset($row['role'][0]) ) { 
                                $person_role = get_the_title($row['role'][0]);
                            } else if ( !empty($row['role']) ) { 
                                $term = get_term( $row['role'] );
                                if ($term) { $person_role = $term->name; }
                            }

                        }
                        
                        // Get the person name
                        if ( isset($row['person'][0]) ) { 
                            $person_name = get_the_title($row['person'][0]);
                        }
                        
                        // Get the ensemble name
                        if ( isset($row['ensemble'][0]) ) { 
                            $ensemble_obj = $row['ensemble'][0];
                            if ($ensemble_obj) { 
                                $ensemble_name = $ensemble_obj->post_title;
                            }
                        }
                        
                        //https://developer.wordpress.org/reference/functions/get_post_meta/
                        //get_post_meta( int $post_id, string $key = '', bool $single = false )
                        //https://developer.wordpress.org/reference/functions/update_post_meta/
                        //update_post_meta( int $post_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' )
                        //https://developer.wordpress.org/reference/functions/delete_post_meta/
                        //delete_post_meta( int $post_id, string $meta_key, mixed $meta_value = '' )
                        
                        /*
                        dev site
                        e.g. post_id 75020
                        _personnel_0_person -- field_5ca37c2297392
                        _personnel_0_person_txt -- field_5db4a1cffec0d
                        personnel_0_person_txt -- The Reverend Dr. David Bartlett Lantz Professor of Preaching, Yale Divinity School
                        e.g. post_id 64251
                        personnel_0_person -- a:1:{i:0;s:5:"18618";} -- new/current version
                        e.g. post_id 155795
                        personnel_0_person -- 124072 -- old style
                        */
                        
                        ?>
                        <tr>
                            <td><?php echo $post_id; //postmeta edit link/button -- offer also option to simply "clear"/delete meta value? ?></td>
                            <td><?php echo $person_role; //edit_link ?></td>
                            <td><?php echo $row['role_txt']; //edit_link ?></td>
                            <td><?php echo $person_name; //edit_link ?></td>
                            <td><?php echo $ensemble_name; //edit_link ?></td>
                            <td><?php echo $row['person_txt']; //edit_link ?></td>
                            <td><?php // matches -- form w/ radio buttons? ?></td>
                            <td><?php // echo actions tools -- delete placeholders; &c.? ?></td>
                        </tr>
                        <?php                        
                    }
                }
                
				//get_template_part( 'template-parts/content', 'sermon' );

            endwhile;
			?>
			</table>
			<?php
			// Reset postdata
			wp_reset_postdata();
			
			// Temporarily swap queries for pagination to function on secondary loop
            $temp_query = $wp_query;
            $wp_query   = NULL;
            $wp_query   = $personnel_query;
		
			//echo "max_num_pages: $personnel_query->max_num_pages<br />"; // tft
			//echo "Last SQL-Query: {$personnel_query->request}";
		
			// Custom query loop pagination
			?>
			<div class="nav-previous alignleft"><?php previous_posts_link( '<span>&laquo;</span> Newer Records' ); ?></div>
			<div class="nav-next alignright"><?php next_posts_link( 'Older Records <span>&raquo;</span>', $personnel_query->max_num_pages ); ?></div>
            <br clear="all" />
			<?php
				
            // Reset main query object
            $wp_query = NULL;
            $wp_query = $temp_query;

		else:
		
			echo "No records found matching those filter criteria.";
		
        endif;
        
		if ( is_dev_site() ) { 
            echo '<div class="clear"><hr />'.$info.'</div>'; // tft
        }
		
		?>

	</main><!-- .site-main -->

	<?php //get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
