<?php
/**
 * The template for the sidebar containing the main widget area
 *
 */
?>

<?php
// Get custom post-specific sidebar content
$post_id = get_the_ID();
$post_widget = ""; // tft
/*$post_widget = get_post_sidebar_widget($post_id);
if ( $post_widget ) {
    $widget_position = get_post_meta( $post_id, 'post_sidebar_widget_position', true ); // wip
}*/
// Get category description widget, if available
//$category_widget = get_category_widget($post_id);
?>

<!-- wpt: sidebar -->
<?php if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar('welcome') ) : ?>
<?php //if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<aside id="secondary" class="sidebar widget-area" role="complementary">
		
        <?php //echo do_shortcode('[troubleshooting]'); ?>
        
        <?php 
        if ( is_dev_site() ) {
            
            // Get the post_widgets repeater field values (ACF)
            $widget_rows = get_field('post_widgets', get_the_ID() );
            if ( empty($widget_rows) ) { $widget_rows = array(); }
            echo "<!-- ".count($widget_rows)." post_widgets rows -->"; // tft
            
            if ( count($widget_rows) > 0 ) {
                
                foreach ( $widget_rows as $row ) {                    
                    
                    //echo "<!-- ".print_r($row, true)." -->";
                    if ( isset($row['widget_title']) && $row['widget_title'] != "" ) { 
                        $widget_title = $row['widget_title'];
                    } else {
                        $widget_title = null;
                    }

                    if ( isset($row['widget_content']) && $row['widget_content'] != "" ) {
                        $widget_content = $row['widget_content'];
                    } else {
                        $widget_content = null;
                    }

                    if ( !empty($widget_title) || !empty($widget_content) ) {
                        echo '<section class="widget">'; //id="media_image-16" class="widget widget_media_image"                    
                        if ( !empty($widget_title) ) { echo '<h2 class="widget-title">'.$widget_title.'</h2>'; }
                        echo '<div class="textwidget custom-html-widget">';
                        if ( !empty($widget_content) ) { echo $widget_content; }
                        echo '</div>';
                        echo '</section>';
                    }

                }
                
            }
            
        }
        ?>
        
        <?php if ( $post_widget && $widget_position == "top" ) { echo $post_widget; } ?>
        
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
        
        <?php if ( $post_widget && $widget_position != "top" ) { echo $post_widget; } // for widget_position == "bottom" or not set/null ?>
        
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>
