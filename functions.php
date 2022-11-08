<?php
// Universalist theme functions

/**
 * Define Constants
 *
 */
define( 'TEMPLATE_URL', get_stylesheet_directory_uri() ); // get_stylesheet_directory_uri()
//define("API_KEY", "75528e65e3a94933804f53798029c93f");

/**
 * Enqueues scripts and styles.
 *
 */

add_action( 'wp_enqueue_scripts', 'site_scripts_and_styles' );
function site_scripts_and_styles() {
    
	//wp_enqueue_style( 'parent-style', get_parent_theme_file_path() . '/style.css' );
    wp_enqueue_style( 'parent-theme-style', get_template_directory_uri() . '/style.css' ); // Make sure the parent theme styles are properly inherited
    wp_dequeue_style( 'twentysixteen-style' );
    
    $post_id = get_the_ID();
    
    // This is not really 'twentysixteen-style' but rather child-style, but because of setup for twentysixteen_scripts and the stylesheet dependencies, it is necessary
    // wp_enqueue_style( $handle, $src, $deps, $ver, $media );
    $ver = filemtime( get_stylesheet_directory() . '/style.css');
    wp_enqueue_style( 'twentysixteen-style', get_stylesheet_uri(), NULL, $ver );
	
    // Events Manager (EM) style overrides and additions
    //$ver = filemtime( get_stylesheet_directory() . '/css/allsouls-em.css');
    $ver = "1.0";
    wp_enqueue_style( 'atc-em-style', get_stylesheet_directory_uri() . '/css/allsouls-em.css', NULL, $ver );
    
	if ( is_admin() ) {		
		//wp_register_script('adminjs', TEMPLATE_URL . '/js/adminjs.js', array( 'jquery' ) );
		//wp_enqueue_script('adminjs');		
	}
		
	// Google Fonts
	// Open Sans -- default font
	wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800', false );
	
    // Garamond -- for new concerts page &c.
	//wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800', false );
	//<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital@0;1&display=swap" rel="stylesheet">
	
    // Enqueue the Dashicons script
	wp_enqueue_style( 'dashicons' );
	
}

// Enqueue admin styles
add_action( 'admin_enqueue_scripts', 'theme_enqueue_admin_scripts_and_styles' );
function theme_enqueue_admin_scripts_and_styles() {
    
    $filepath = get_stylesheet_directory() . '/admin.css';
    //$stat = stat($filepath); //$ver = $stat['ctime'];
    if ( !$ver = filemtime( $filepath ) ) { // version tag based on file modification time -- for cache-busting
        $ver = ""; // TODO: find a better alternative to nothing...
    }
    wp_enqueue_style( 'universalist-admin',  get_stylesheet_directory_uri() . '/admin.css', NULL, $ver );
    
}

//
add_action( 'after_setup_theme', 'allsouls_universalist_theme_setup', 11 ); //add_action( 'after_setup_theme', 'bweb_remove_post_formats', 11 );
function allsouls_universalist_theme_setup() {
    
    // Remove support for some post formats by specifying list to support
    add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'audio' ) ); // link, quote, video, status, chat
    
    add_editor_style( 'css/editor-style-universalist.css' );
	//add_editor_style( get_stylesheet_directory_uri() . '/css/editor-style-atchq.css' );
    
}

// Register theme menus
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
  register_nav_menus(
    array(
      	'secondary-header-nav' => __( 'Secondary Header Menu' ),
		'header-tabs' => __( 'Header Tabs Menu' ),
		//'secondary-header-nav-mobile' => __( 'Secondary Header Menu - Mobile' ),
      	'footer-nav' => __( 'Footer Menu' )
    )
  );
}

// Add custom query vars
// TODO: move this to plugins/allsouls?
add_filter( 'query_vars', 'universalist_query_vars' );
function universalist_query_vars( $qvars ) {
	$qvars[] = 'devmode'; // TODO: consider changing this to 'devmode'?
	$qvars[] = 'sermon_topic';
	$qvars[] = 'sermon_author';
	$qvars[] = 'bbook';
	$qvars[] = 'sermon_date';
	$qvars[] = 'y'; // = year -- for date_calculations (and - ?)
    return $qvars;
}

// In case the allsouls plugin hasn't loaded properly, avoid a fatal error when other plugins call the logging fcn
/*if ( !function_exists( 'birdhive_log' ) ) {
    function birdhive_log($log_msg) {
    
        // Create directory for storage of log files, if it doesn't exist already
        $log_filename = $_SERVER['DOCUMENT_ROOT']."/_allsouls-devlog";
        if (!file_exists($log_filename)) {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }

        $timestamp = current_time('mysql'); // use WordPress function instead of straight PHP so that timezone is correct -- see https://codex.wordpress.org/Function_Reference/current_time
        $datestamp = current_time('Ymd'); // date('d-M-Y')

        //birdhive_log("loop_item_divider");
        if ($log_msg == "divline1") {
            $log_msg = "\n=================================================================================\n";
        } else if ($log_msg == "divline2") {
            $log_msg = "-----------";
        } else {
            $log_msg = "[birdhive_log ".$timestamp."] ".$log_msg;
            //$log_msg = "[birdhive_log ".$timestamp."] ".$log_msg."\n";
        }

        // Generate a new log file name based on the date
        // (If filename does not exist, the file is created. Otherwise, the existing file is overwritten, unless the FILE_APPEND flag is set.)
        $log_file = $log_filename.'/' . $datestamp . '-allsouls_dev.log';
        // Syntax: file_put_contents(filename, data, mode, context)
        file_put_contents($log_file, $log_msg . "\n", FILE_APPEND);
    }
}*/

// Function to test if admin user is currently logged in -- this must be here instead of allsouls.php because it's needed for determining body classes (see below: atc_body_class)
function user_is_administrator() {
	
	if ( is_user_logged_in() ) {
        $current_user = wp_get_current_user();
		$roles = ( array ) $current_user->roles;
		
		if ( in_array('administrator', $roles) ) { 
			return true;
		}
	}
	
	return false;
}

/**
 * [[Register default sidebar]]; unregister content bottom sidebars from twentysixteen parent theme.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 */
add_action( 'widgets_init', 'universalist_widgets_init', 11 );
function universalist_widgets_init() {
	
	$sql = "";
	$troubleshooting_div = "\n".'<div class="troubleshooting">{'.$sql.'}</div>';
	
	register_sidebar(
		array(
			'name'          => __( 'Default Sidebar', 'universalist' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'universalist' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => __( 'Homepage Features', 'universalist' ),
			'id'            => 'homepage-features',
			'description'   => __( 'Add widgets here to appear at the bottom of the homepage.', 'universalist' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
    register_sidebar(
        array(
            'name'          => __( 'Bottom Widgets', 'universalist' ),
            'id'            => 'bottom-widgets',
            'description'   => __( 'Bottom widgets.', 'universalist' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
    
    unregister_sidebar( 'sidebar-2' ); // 'Content Bottom 1' (Twentysixteen)
    unregister_sidebar( 'sidebar-3' ); // 'Content Bottom 2' (Twentysixteen)
    //unregister_sidebar( 'sidebar-4' ); // ?
	
}

add_filter( 'body_class', 'atc_body_class' );
function atc_body_class( $classes ) {
	
	if ( 
	is_singular( 'project' ) 
	OR is_post_type_archive('project')
	) {
		$classes[] = 'no-sidebar-full-width';
		$classes[] = 'no-sidebar';
	}
	
    // Determine whether to show admin-specific & troublshooting infos
	$current_user = wp_get_current_user();
    //if ( user_is_administrator() === true ) { 
    if ( current_user_can('edit_roles') || current_user_can('publish_events') ) {
    //if ( in_array( 'allsouls_administrator', $current_user->roles ) ) {
        $classes[] = 'admin';
        $classes[] = 'admin-view';
    }
    $devmode = get_query_var( 'devmode' ) ? get_query_var( 'devmode' ) : false;
    
    // Show troubleshooting info only for user allsoulsdev in devmode
    $username = $current_user->user_login;
    if ( $username == 'allsoulsdev' && $devmode ) { 
        $classes[] = 'dev-view';
    }
	
	if ( is_dev_site() ) { $classes[] = 'devsite'; }
	
	return $classes;
}

function atc_get_type_for_template() {
	
	if ( is_singular('person') ) {
		$post_type = 'person'; 
	} else if ( is_singular('repertoire') OR is_tax( 'repertoire_category') OR is_post_type_archive('repertoire') ) {
		$post_type = 'repertoire';
	} else if ( is_singular('edition') OR is_post_type_archive('edition') ) {
		$post_type = 'edition';
	} else if ( is_singular('sermon') OR is_post_type_archive('sermon') ) {
		$post_type = 'sermon';
	} else if ( is_singular('event') OR is_post_type_archive('event') ) {
		$post_type = 'event';
    } else if ( is_singular('sermon_series') OR is_singular('event_series') ) {
        $post_type = 'series';
	} else if ( is_single() ) {
		$post_type = 'single';
	} else if ( is_search() || is_archive() ) {
		$post_type = 'excerpt';
	} else {
		$post_type = get_post_format();
	}
	return $post_type;
	
}

/* Modify post thumbnail size to crop 'large' instead of merely scaling -- helps things line up better, e.g. "Related Events" */
// Large Size Thumbnail
if (false === get_option("medium_crop") ) {
	add_option("medium_crop", "1"); 
} else {
	update_option("medium_crop", "1");
}

if (false === get_option("large_crop") ) {
	add_option("large_crop", "1"); 
} else {
	update_option("large_crop", "1");
}

function allsouls_post_thumbnail( $post_id = null, $imgsize = "thumbnail", $use_custom_thumb = false, $echo = true ) {
    
    $info = ""; // init
    
    if ( $post_id === null ) {
        $post_id = get_the_ID();
    }
    $thumbnail_id = null; // init
    
    if ( is_singular($post_id) || is_page($post_id) ) {
        $imgsize = "full";
    }
    
    $troubleshooting_info = "";
    $troubleshooting_info .= "post_id: $post_id<br />";
    $troubleshooting_info .= "imgsize: $imgsize<br />";
    
    // Are we using the custom image, if any is set?
    if ( $use_custom_thumb == true ) {    
        // First, check to see if the post has a Custom Thumbnail
        $custom_thumb_id = get_post_meta( $post_id, 'custom_thumb', true );
        
        if ( $custom_thumb_id ) {
            $thumbnail_id = $custom_thumb_id;
        }
    }

    // If we're not using the custom thumb, or if none was found, then proceed to look for other image options for the post
    if ( !$thumbnail_id ) {
        
        // Check to see if the given post has a featured image
        if ( has_post_thumbnail( $post_id ) ) {

            $thumbnail_id = get_post_thumbnail_id( $post_id );
            $troubleshooting_info .= "post has a featured image.<br />";

        } else {

            $troubleshooting_info .= "post has NO featured image.<br />";

            // If there's no featured image, see if there are any other images that we can use instead
            $image_info = get_first_image_from_post_content( $post_id );
            if ( $image_info ) {
                $thumbnail_id = $image_info['id'];
            } else {
                $thumbnail_id = "test"; // tft
            }

            if ( empty($thumbnail_id) ) {

                // The following approach would be a good default except that images only seem to count as 'attached' if they were directly UPLOADED to the post
                // Also, images uploaded to a post remain "attached" according to the Media Library even after they're deleted from the post.
                $images = get_attached_media( 'image', $post_id );
                //$images = get_children( "post_parent=".$post_id."&post_type=attachment&post_mime_type=image&numberposts=1" );
                if ($images) {
                    //$thumbnail_id = $images[0];
                    foreach ($images as $attachment_id => $attachment) {
                        $thumbnail_id = $attachment_id;
                    }
                }

            }

            // If there's STILL no image, use a placeholder
            // TODO: make it possible to designate placeholder image(s) for archives via CMS (instead of hard-coding it here)
            // TODO: designate placeholders *per category*?? via category/taxonomy ui?
            if ( empty($thumbnail_id) ) {
                if ( is_dev_site() ) { $thumbnail_id = 121560; } else { $thumbnail_id = 121560; } // Fifth Avenue Entrance
            }
        }
    }
    
    // Make sure this is a proper context for display of the featured image
    
    if ( post_password_required($post_id) || is_attachment($post_id) ) {
        
        return;
        
    } else if ( has_term( 'video-webcasts', 'event-categories' ) && is_singular('event') ) {
        
        // featured images for events are handled via Events > Settings > Formatting AND via allsouls-calendar.php (#_EVENTIMAGE)
        return;
        
    } else if ( has_term( 'video-webcasts', 'category' ) ) {
        
        $player_status = get_media_player( $post_id, true ); // get_media_player ( $post_id = null, $status_only = false, $url = null )
        if ( $player_status == "ready" ) {
            return;
        }
        
    } else if ( is_page_template('page-centered.php') ) {
        
		return;
        
	} else if ( is_singular() && in_array( get_field('featured_image_display'), array( "background", "thumbnail", "banner" ) ) ) {
        
        //return; // wip
        
    }

    $troubleshooting_info .= "Ok to display the image!<br />";
    
    // Ok to display the image! Set up classes for styling
    $classes = "post-thumbnail allsouls";
    
    // Retrieve the caption (if any) and return it for display
    if ( get_post( $thumbnail_id  ) ) {
        $caption = get_post( $thumbnail_id  )->post_excerpt;
        if ( !empty($caption) ) {
            $classes .= " has_caption";
        }
    }
    
    if ( is_singular($post_id) || is_page($post_id) ) {
        
        if ( has_post_thumbnail($post_id) ) {
            
            if ( is_singular('person') ) {
                $imgsize = "medium"; // portrait
                $classes .= " float-left";
            }
            
            $classes .= " is_singular";
            
            $info .= '<div class="'.$classes.'">';
            $info .= get_the_post_thumbnail( $imgsize ); //the_post_thumbnail( $imgsize );
            $info .= '</div><!-- .post-thumbnail -->';
            
        }
        
    } else { 
        
        // NOT singular -- aka archives, search results, &c.
        
        $classes .= " float-left";
        //$classes .= " NOT_is_singular"; // tft
        
        $info .= '<a class="'.$classes.'" href="'.get_the_permalink($post_id).'" aria-hidden="true">';
        if ( $thumbnail_id ) {
            
            // display attachment via thumbnail_id
            $info .= wp_get_attachment_image( $thumbnail_id, $imgsize, false, array( "class" => "featured_attachment" ) );
            
            $troubleshooting_info .= 'post_id: '.$post_id.'; thumbnail_id: '.$thumbnail_id;
            if ( isset($images)) { $troubleshooting_info .= '<pre>'.print_r($images,true).'</pre>'; }
            
        } /*else if ( has_post_thumbnail() ) {
            
            the_post_thumbnail( $imgsize, array( 'alt' => the_title_attribute( 'echo=0' ) ) );
            
        } */else {
            
            $troubleshooting_info .= 'Use placeholder img';
            
            if ( function_exists( 'get_placeholder_img' ) ) { 
                $info .= get_placeholder_img();
            }
        }
        $info .= '</a>';
        
    } // End if is_singular()
    
    $info .= '<div class="troubleshooting">'.$troubleshooting_info.'</div>';
    if ( $echo === true ) {
        echo $info;
        return true;
    } else {
        return $info;
    }    

}


/**
* Removes or edits the 'Protected:' part from posts titles
*/
add_filter( 'protected_title_format', 'remove_protected_text' );
function remove_protected_text() {
    return __('%s');
}

/*
 * Function to add Copyright info to the footer
 */
add_action( 'atc_footer_copyright', 'atc_footer_copyright', 10 );
//function to show the footer info, copyright information
if ( ! function_exists( 'atc_footer_copyright' ) ) :
function atc_footer_copyright() {
	
	$site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
	$atc_link =  '<a href="'.esc_url( 'https://birdhive.com' ).'" target="_blank" title="'.esc_attr__( 'Birdhive Development & Design', 'atc' ).'" rel="designer"><span>'.__( 'Birdhive Development & Design', 'atc') .'</span></a>';

	$default_footer_value = sprintf( __( 'Copyright &copy; %1$s %2$s', 'atc' ), date( 'Y' ), $site_link ).' &mdash; '.sprintf( __( 'Website by %1$s', 'atc' ), $atc_link );

	$atc_footer_copyright = $default_footer_value;
	echo $atc_footer_copyright;
}
endif;

/* Limit excerpt length */
/*add_filter( 'excerpt_length', function($length) {
    return 15;
} );*/


// Replaces the excerpt "Read More" text by a link
add_filter('excerpt_more', 'atc_excerpt_more');
function atc_excerpt_more() { //function atc_excerpt_more($more) {
    global $post;
    return '&nbsp;<a class="moretag" href="'. get_permalink($post->ID) . '"><em>Read more...</em></a>'; // <p></p>
}

add_filter( 'get_the_excerpt', 'excerpt_more_for_manual_excerpts' );
function excerpt_more_for_manual_excerpts( $excerpt ) {

    if ( has_excerpt() ) {
        $excerpt .= atc_excerpt_more();
    } else {
    	$excerpt .= "*"; // tft
    }

    return $excerpt;
}

// Replace trim_excerpt function -- temp disabled for troubleshooting
//remove_filter('get_the_excerpt', 'wp_trim_excerpt');
//add_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt'); 

add_action( 'after_setup_theme', 'child_theme_setup' );
function child_theme_setup() {
	// override parent theme's 'more' text for excerpts
	remove_filter( 'excerpt_more', 'twentysixteen_excerpt_more' ); 
	remove_filter( 'excerpt_more', 'twentysixteen_auto_excerpt_more' ); 
	remove_filter( 'get_the_excerpt', 'twentysixteen_custom_excerpt_more' );
}

add_post_type_support( 'page', 'excerpt' );

/**
 * Prints HTML with meta information for the categories, tags.
 *
 * This function overrides the function by the same name in the parent theme (twentysixteen/template-tags.php).
 *
 */
function twentysixteen_entry_meta() {
	
    $format = get_post_format();
    if ( current_theme_supports( 'post-formats', $format ) ) {
        printf(
            '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
            sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'twentysixteen' ) ),
            esc_url( get_post_format_link( $format ) ),
            get_post_format_string( $format )
        );
    }

    if ( 'post' === get_post_type() ) {
        twentysixteen_entry_taxonomies();
    }

}

/**
	 * Displays the excerpt -- custom or otherwise
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * This function overrides the function by the same name in the parent theme (twentysixteen/template-tags.php).
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function twentysixteen_excerpt( $class = 'entry-summary' ) {
        
		$class = esc_attr( $class );

		if ( !is_singular('post') 
			&& ( 
				has_excerpt() // for custom excerpts only
				|| is_search() 
				|| is_page('news') 
				|| is_page('webcasts') 
				|| is_archive() 
				|| is_category() 
				|| is_post_type_archive()
			) )  {
			?>
			<div class="excerpt <?php echo $class; ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo $class; ?> -->
			<?php
            
        }
        
	}

/**
	 * Prints HTML with date information for current post.
	 *
	 * This function overrides the function by the same name in the parent theme (twentysixteen/template-tags.php).
	 *
	 */
	function twentysixteen_entry_date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf(
			//'<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			'<span class="posted-on"><span class="screen-reader-text">%1$s </span>%3$s</span>',
            _x( 'Posted on', 'Used before publish date.', 'twentysixteen' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}

/*** EVENTS MANAGER ***/
// TODO: move to allsouls plugin?

add_filter('em_cpt_event', 'em_enable_event_revisions', 10, 1);
add_filter('em_cpt_event_recurring', 'em_enable_event_revisions', 10, 1);
function em_enable_event_revisions( $args ) {
	if( !in_array( 'revisions', $args['supports'] ) ) {
		$args['supports'][] = 'revisions';
	}
	return $args;
}


/* Temporary function for forcing update to try to get converted events to show up properly on front end (single event pages) */
//add_action('init','tmp_em_events_post_import_processing');
function tmp_em_events_post_import_processing(){

    $posts = get_posts( array('post_type' => 'event', 'numberposts' => 3 ) );

    foreach ( $posts as $post ):
        //$post['post_content'] = 'This is the updated content.';
        wp_update_post( $post );
        /*if (is_wp_error($post_id)) {
            $errors = $post_id->get_error_messages();
            foreach ($errors as $error) {
                echo $error;
            }
        }*/
    endforeach;
    
}

/*** TEMPORARY PATCH PENDING RELEASE OF WP 5.6.2 ***/
/*
 * WordPress 5.6.1: Window Unload Error Final Fix
 */
//add_action('admin_print_footer_scripts', 'wp_561_window_unload_error_final_fix');
function wp_561_window_unload_error_final_fix(){
    ?>
    <script>
        jQuery(document).ready(function($){

            // Check screen
            if(typeof window.wp.autosave === 'undefined')
                return;

            // Data Hack
            var initialCompareData = {
                post_title: $( '#title' ).val() || '',
                content: $( '#content' ).val() || '',
                excerpt: $( '#excerpt' ).val() || ''
            };

            var initialCompareString = window.wp.autosave.getCompareString(initialCompareData);

            // Fixed postChanged()
            window.wp.autosave.server.postChanged = function(){

                var changed = false;

                // If there are TinyMCE instances, loop through them.
                if ( window.tinymce ) {
                    window.tinymce.each( [ 'content', 'excerpt' ], function( field ) {
                        var editor = window.tinymce.get( field );

                        if ( ( editor && editor.isDirty() ) || ( $( '#' + field ).val() || '' ) !== initialCompareData[ field ] ) {
                            changed = true;
                            return false;
                        }

                    } );

                    if ( ( $( '#title' ).val() || '' ) !== initialCompareData.post_title ) {
                        changed = true;
                    }

                    return changed;
                }

                return window.wp.autosave.getCompareString() !== initialCompareString;

            }
        });
    </script>
    <?php
}

?>