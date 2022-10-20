<?php
/* @var $args array */
?>
<?php
// To do -- figure out why a version of this code is needed in both this file AND events-list-grouped.
if ( isset($_REQUEST['scope']) && (isset($_REQUEST['scope-source']) && $_REQUEST['scope-source'] == 'widget') ) { 
    
    if ( isset($_REQUEST['scope']) ) {
		//$troubleshooting .= "REQUEST scope: ".print_r($_REQUEST['scope'], true)."<br />";
		if ( isset($_REQUEST['scope'][0]) ) {
			$start_date = $_REQUEST['scope'][0]; // start date of scope
			//$troubleshooting .= ">> date_selected via _REQUEST['scope'][0]<br />";
			//$month_selected = substr($_REQUEST['scope'][0],5,2);
			//$year_selected = substr($_REQUEST['scope'][0],0,4);
			//$troubleshooting .= ">> month via _REQUEST['scope'][0]<br />";
			//$troubleshooting .= ">> year via _REQUEST['scope'][0]<br />";
		}
	} else {
	
		// If no year was specified, use the current year
		if (isset($_REQUEST['scope_year'])) { $year = $_REQUEST['scope_year']; } else { $year = date('Y'); }
	
		// If no month was specified, use the current month
		if (isset($_REQUEST['scope_month'])) { $month = $_REQUEST['scope_month']; } else { $month = date('n'); }
	
		// Create start date as first day of selected month/year
		$start_date = $year."-".$month."-01";
    
	}  
    
    $args['scope'][0] = $start_date;
    add_query_arg( 'scope', $args['scope']);
    
}

//echo "<pre>".print_r($args,true)."</pre>"; // tft 
?>

<!-- START Date Search -->
<div class="em-search-scope em-search-field em-datepicker em-datepicker-range input" data-separator="<?php echo esc_attr($args['scope_seperator']); ?>"  data-format="<?php echo esc_attr($args['scope_format']); ?>">
	<label for="em-search-scope-<?php echo absint($args['id']) ?>" class="screen-reader-text"><?php echo esc_html($args['scope_label']); ?></label>
	<input id="em-search-scope-<?php echo absint($args['id']) ?>" type="hidden" class="em-date-input em-search-scope" aria-hidden="true" placeholder="<?php echo esc_html($args['scope_label']); ?>">
	<div class="em-datepicker-data">
		<input type="date" name="scope[0]" value="<?php echo esc_attr($args['scope'][0]); ?>" aria-label="<?php echo esc_html($args['scope_label']); ?>">
		<span class="separator"><?php echo esc_html($args['scope_seperator']); ?></span>
		<input type="date" name="scope[1]" value="<?php echo esc_attr($args['scope'][1]); ?>" aria-label="<?php echo esc_html($args['scope_seperator']); ?>">
	</div>
	<!-- old version:
	<input type="text" class="em-date-input-loc em-date-start" placeholder="click to select start date" />
			<input type="hidden" class="em-date-input" name="scope[0]" value="<?php if ( isset($args['scope'][0]) )  { echo esc_attr($args['scope'][0]); } ?>" />
			
		<span class="separator"><?php echo esc_html($args['scope_seperator']); ?></span>
		
			<input type="text" class="em-date-input-loc em-date-end" placeholder="click to select end date (optional)" style="min-width: 16rem;" />
			<input type="hidden" class="em-date-input" name="scope[1]" value="<?php if ( isset($args['scope'][1]) ) { echo esc_attr($args['scope'][1]); } ?>" />
	-->
</div>
<?php /* Example alternatives
<div class="em-search-scope em-search-field em-datepicker em-datepicker-until" data-separator="<?php echo esc_attr($args['scope_seperator']); ?>">
	<label for="em-search-scope-start-<?php echo absint($args['id']) ?>" class="screen-reader-text"><?php echo esc_html($args['scope_label']); ?></label>
	<input type="hidden" class="em-date-input em-date-input-start" id="em-search-scope-start-<?php echo absint($args['id']) ?>" aria-hidden="true">
    <input id="em-search-scope-<?php echo absint($args['id']) ?>" type="hidden" class="em-date-input em-search-scope" aria-hidden="true" placeholder="<?php echo esc_html($args['scope_label']); ?>">
    <label for="em-search-scope-end-<?php echo absint($args['id']) ?>"><?php echo esc_html($args['scope_seperator']); ?></label>
	<input type="hidden" class="em-date-input em-date-input-end" id="em-search-scope-end-<?php echo absint($args['id']) ?>" aria-hidden="true" placeholder="<?php echo esc_html($args['scope_seperator']); ?>">
	<div class="em-datepicker-data">
		<input type="date" name="scope[0]" value="<?php echo esc_attr($args['scope'][0]); ?>" aria-label="<?php echo esc_html($args['scope_label']); ?>">
		<span class="separator"><?php echo esc_html($args['scope_seperator']); ?></span>
		<input type="date" name="scope[1]" value="<?php echo esc_attr($args['scope'][1]); ?>" aria-label="<?php echo esc_html($args['scope_seperator']); ?>">
	</div>
</div>
<div class="em-search-scope em-search-field em-datepicker" data-separator="<?php echo esc_attr($args['scope_seperator']); ?>">
	<label>Date</label>
	<input type="hidden" class="em-date-input em-date-input-start" aria-hidden="true">
	<div class="em-datepicker-data">
		<input type="date" name="scope[0]" value="2022-05-10">
	</div>
</div>
*/ ?>
<!-- END Date Search -->