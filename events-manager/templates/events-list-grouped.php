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

echo "<!-- wpt: events-manager -> events-list-grouped -->";

//add_query_arg( 'test', 'charpentier');
//echo "<h3>".'$_REQUEST'.": <pre>".print_r( $_REQUEST, true )."</pre>";

$args = apply_filters('em_content_events_args', $args);

// If the $_REQUEST array contains scope vars passed from the sidebar widget, then include those in the $args array for the event filters
// Old version: scope value from datepicker
if ( isset($_REQUEST['scope']) && (isset($_REQUEST['scope-source']) && $_REQUEST['scope-source'] == 'widget') ) { 
    $args['scope'] = $_REQUEST['scope'].",";
    add_query_arg( 'scope', $args['scope']);
    if ( isset($_REQUEST['action']) ) {
        $args['action'] = $_REQUEST['action'];
    }
}

// New version: scope month and year which must be combined to form proper scope var
if ( ( isset($_REQUEST['scope_month']) || isset($_REQUEST['scope_year']) ) && (isset($_REQUEST['scope-source']) && $_REQUEST['scope-source'] == 'widget') ) {
//if ( ( $_REQUEST['scope_month'] || $_REQUEST['scope_year'] ) && $_REQUEST['scope-source'] == 'widget' ) { 
    
    // If no year was specified, use this year
    if (isset($_REQUEST['scope_year'])) { $year = $_REQUEST['scope_year']; } else { $year = date('Y'); }
    
    // If no month was specified, use this month
    if (isset($_REQUEST['scope_month'])) { $month = $_REQUEST['scope_month']; } else { $month = date('n'); }
    
    // Create start date as first day of selected month/year
    $start_date = $year."-".$month."-01"; 
    
    $args['scope'] = $start_date.",";
    //$args['scope'][0] = $start_date;
    add_query_arg( 'scope', $args['scope']);
    
    $scope = $args['scope'];
    
    if ( isset($_REQUEST['action']) ) {
        $args['action'] = $_REQUEST['action'];
    }
    
    //echo "widget scope: $scope<br />"; // tft
    
} else if ( isset($_GET["scope"]) ) {
    
    $scope = $_GET["scope"];
    if ( $scope != "" ) {
        $args['scope'] = $scope;
    }
    
    //echo "scope: $scope<br />"; // tft
    
}

if ( isset($_GET["category"]) ) {
    $category = $_GET["category"];
    if ( $category != "" ) {
        $args['category'] = $category;
    }
}

/*if ( isset($args["header_format"]) & ! is_page( 'events' ) ) {
    $header_format = $args["header_format"];
    if ( $header_format != "" ) {
        $args['header_format'] = do_shortcode($header_format);
    }
    $args['header_format'] .= "TEST";
}*/

//echo "<pre>".print_r( $args, true )."</pre>"; // tft

if ( get_option('dbem_css_evlist') ) { echo "<div class='css-events-list'>"; }

echo EM_Events::output_grouped($args); //note we're grabbing the content, not em_get_events_list_grouped function
    
if ( get_option('dbem_css_evlist') ) { echo "</div>"; }