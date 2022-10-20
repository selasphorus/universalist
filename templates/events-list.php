<?php
/*
 * Default Events List Template
 * This page displays a list of events, called during the em_content() if this is an events list page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output()
 * 
 */

echo "<!-- wpt: events-manager -> events-list -->\n"; // [atc]

$args = apply_filters('em_content_events_args', $args);

//echo "<h3>".'$args'.": <pre>".print_r( $args, true )."</pre>"; // tft

$the_date = $args['calendar_day']; // [atc]
if ( $the_date ) {
    echo "<!-- the_date: $the_date -->\n"; // [atc]
    //echo do_shortcode( '[day_title the_date="'.$the_date.'"]' );
}

if( get_option('dbem_css_evlist') ) echo "<div class='css-events-list'>";

//echo EM_Events::output( $args );
$content = EM_Events::output( $args );
$content = remove_empty_p( $content );
echo $content;

if( get_option('dbem_css_evlist') ) echo "</div>";
