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
$args = apply_filters('em_content_events_args', $args);
if( empty($args['id']) ) $args['id'] = rand(); // prevent warnings
$id = esc_attr($args['id']);

/*** Start STC/ATC ***/
echo "<!-- wpt: events-manager -> events-list-grouped -->"; // tft
$troubleshooting = ""; // init

//add_query_arg( 'test', 'charpentier'); // tft
$troubleshooting .= '$_GET'.": <pre>".print_r( $_GET, true )."</pre>"; // tft
$troubleshooting .= '$_REQUEST'.": <pre>".print_r( $_REQUEST, true )."</pre>"; // tft

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
    
    // If no year was specified, use this year
    if (isset($_REQUEST['scope_year'])) { $year = $_REQUEST['scope_year']; } else { $year = date('Y'); }
    
    // If no month was specified, use this month
    if (isset($_REQUEST['scope_month'])) { $month = $_REQUEST['scope_month']; } else { $month = date('n'); }
    
    // Create start date as first day of selected month/year
    $start_date = $year."-".$month."-01"; 
    
    $args['scope'] = $start_date.","; //$args['scope'][0] = $start_date;
    
    $scope = $args['scope'];
    
    if ( isset($_REQUEST['action']) ) {
        $args['action'] = $_REQUEST['action'];
    }
    
    $troubleshooting .= "widget scope: $scope<br />"; // tft
    
} /*else if ( isset($_REQUEST["scope"]) ) {
    
    $scope = $_REQUEST["scope"];
    if ( $scope != "" ) {
        $args['scope'] = $scope;
    }
    
} */else if ( isset($_GET["scope"]) ) {
    
    $scope = $_GET["scope"];
    if ( $scope != "" ) {
        $args['scope'] = $scope;
    }
    
}

// WIP 220913
if ( isset($scope) ) {
    //add_query_arg( 'scope', $scope);
    $troubleshooting .= "WIP add_query_arg scope: $scope<br />"; // tft
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


$troubleshooting .= "args: <pre>".print_r($args, true)."</pre>"; // tft

if ( $troubleshooting != "" && function_exists('devmode_active') && devmode_active() ) {
    echo '<div class="troubleshooting">'.$troubleshooting.'</div>';
}

/*** End STC/ATC ***/
?>
<div class="<?php em_template_classes('view-container'); ?>" id="em-view-<?php echo $id; ?>" data-view="list-grouped">
	<div class="<?php em_template_classes('events-list', 'events-list-grouped'); ?>" id="em-events-list-grouped-<?php echo $id; ?>">
	<?php
	echo EM_Events::output_grouped($args); //note we're grabbing the content, not em_get_events_list_grouped function
	?>
	</div>
</div>