<?php
/* ATC override of EM template */
/*
 * By modifying this in your theme folder within plugins/events-manager/templates/events-search.php, you can change the way the search form will look.
 * To ensure compatability, it is recommended you maintain class, id and form name attributes, unless you now what you're doing.
 * You also have an $args array available to you with search options passed on by your EM settings or shortcode
 */
/* @var $args array */
if( empty($args['id']) ) $args['id'] = rand(); // prevent warnings
$id =  esc_attr($args['id']); // id of form for unique selections
//em_template_classes('search', 'modal,search-advanced');

$args['advanced_mode'] = 'inline'; // Force this mode since it doesn't seem to work via EM settings
$args['search_advanced_text'] = 'Advanced Search'; // Stupid default is "Show Advanced Search" which shows up as the modal header

$args['css_classes'] = array ('has-search-main', 'has-views', 'has-advanced', 'advanced-mode-inline', 'advanced-visible', 'em-events-search');
/* default based on buggy settings:
[css_classes] => Array
	(
		[0] => has-search-main
		[1] => has-views --- what does this do?
		[2] => has-advanced
		[3] => advanced-mode-modal
		[4] => advanced-visible
		[5] => em-events-search
	)
*/

// Unset location-related args, since we're not using them
// This isn't functionally necessary, but it reduces clutter when displaying the args array for troubleshooting
unset($args['geo']);
unset($args['near']);
//unset($args['search_geo_main']);
//unset($args['search_geo']);
unset($args['geo_label']);
//unset($args['search_geo_units']);
unset($args['geo_units_label']);
unset($args['near_unit']);
unset($args['near_distance']);
unset($args['geo_distance_values']);
unset($args['search_eventful_locations_label']);
unset($args['search_eventful_locations_tooltip']);
unset($args['search_countries']);
unset($args['country']);
unset($args['country_label']);
unset($args['countries_label']);
unset($args['region']);
unset($args['search_regions']);
unset($args['region_label']);
unset($args['state']);
unset($args['search_states']);
unset($args['state_label']);
unset($args['town']);
unset($args['search_towns']);
unset($args['town_label']);

$args['views'] = array ('list-grouped');

echo '<div class="troubleshooting">args: <pre>'.print_r($args, true).'</pre></div>';

?>
<div class="<?php em_template_classes('search'); ?> <?php echo esc_attr(implode(' ', $args['css_classes'])); ?>" id="em-search-<?php echo $id; ?>" data-view="<?php echo esc_attr($args['view']); ?>">
	<form action="<?php echo !empty($args['search_url']) ? esc_url($args['search_url']) : EM_URI; ?>" method="post" class="em-search-form" id="em-search-form-<?php echo $id; ?>">
		<input type="hidden" name="action" value="<?php echo esc_attr($args['search_action']); ?>" />
		<input type="hidden" name="view_id" value="<?php echo esc_attr($args['id']); ?>" />
		<?php if( $args['show_main'] ): //show the 'main' search form ?>
			<div class="em-search-main em-search-main-bar">
				<?php do_action('em_template_events_search_form_header'); // hook in here to add extra fields, text etc. ?>
				<?php
				//search text - tweak ID so it is unique when repeated in advanced further down
				$args['id'] = '-main-' . $args['id'];
				if( !empty($args['search_term_main']) ) em_locate_template('templates/search/search.php',true,array('args'=>$args));
				//if( !empty($args['search_geo_main']) ) em_locate_template('templates/search/geo.php',true,array('args'=>$args));
				if( !empty($args['search_scope_main']) ) em_locate_template('templates/search/scope.php',true,array('args'=>$args));
				$args['id'] = $id;
				?>
				<?php /*if( !empty($args['advanced_hidden']) && !empty($args['show_advanced']) ): //show the advanced search toggle if advanced fields are collapsed ?>
					<div class="em-search-advanced-trigger">
						<button type="button" class="em-search-advanced-trigger em-clickable em-tooltip" data-search-advanced-id="em-search-advanced-<?php echo $id; ?>" id="em-search-advanced-trigger-<?php echo $id; ?>" aria-label="<?php echo esc_html($args['search_text_show']); ?>"></button>
					</div>
				<?php endif;*/ ?>
				<?php /*if( !empty($args['views']) && count($args['views']) > 1 ): //show the advanced search toggle if advanced fields are collapsed ?>
					<div class="em-search-views" aria-label="<?php esc_attr_e('View Types', 'events-manager'); ?>">
						<?php $search_views = em_get_search_views(); ?>
						<div class="em-search-views-trigger" data-template="em-search-views-options-<?php echo $id; ?>">
							<button type="button" class="em-search-view-option em-clickable em-search-view-type-<?php echo $args['view']; ?>" data-view="<?php echo esc_attr($args['view']); ?>"><?php echo esc_html($search_views[$args['view']]['name']); ?></button>
						</div>
						<div class="em-search-views-options input" id="em-search-views-options-<?php echo $id; ?>">
							<select name="view" multiple="multiple" class="em-search-views-options-list" id="em-search-views-options-select-<?php echo $id; ?>" size="<?php echo count($args['views']); ?>">
								<?php foreach( $args['views'] as $view ): $view_name = $search_views[$view]['name']; ?>
									<option class="em-search-view-option em-search-view-type-<?php echo esc_attr($view); ?>" value="<?php echo esc_attr($view); ?>" data-view="<?php echo esc_attr($view); ?>"  <?php if( $view === $args['view'] ) echo 'selected'; ?>><?php echo esc_html($view_name); ?></option>
								<?php endforeach; ?>
							</select>
							<label for id="em-search-views-options-select-<?php echo $id; ?>" class="screen-reader-text"><?php esc_html_e('Search Results View Type','events-manager'); ?></label>
						</div>
					</div>
				<?php else: ?>
					<input name="view" type="hidden" value="<?php echo $args['view']; ?>">
				<?php endif;*/ ?>
				<input name="view" type="hidden" value="<?php echo $args['view']; ?>">
				<div class="em-search-submit input">
					<button type="submit" class="em-search-submit button-primary" data-button-text="<?php echo esc_html($args['search_button']); ?>"><?php echo esc_html($args['search_button']); ?></button>
				</div>
			</div>
		<?php endif; ?>
		<?php /*if( (empty($args['show_advanced']) || empty($args['search_countries'])) && !empty($args['country']) ): //show country in hidden field for geo searching ?>
			<input type="hidden" name="country" value="<?php echo esc_attr($args['country']) ?>" />
		<?php endif; ?>
		<?php if( empty($args['search_geo_units']) ): //show country in hidden field for geo searching ?>
			<?php if( !empty($args['near_distance']) ) : ?><input name="near_distance" type="hidden" value="<?php echo esc_attr($args['near_distance']); ?>" /><?php endif; ?>
			<?php if( !empty($args['near_unit']) ) : ?><input name="near_unit" type="hidden" value="<?php echo esc_attr($args['near_unit']); ?>" /><?php endif; ?>
		<?php endif;*/ ?>
		
		<?php if( !empty($args['show_advanced']) && $args['advanced_mode'] == 'inline' ): //show inline if requested ?>
			<div class="<?php em_template_classes('search-advanced', 'input'); //'search',  ?> <?php echo esc_attr(implode(' ', $args['css_classes_advanced'])); ?>" id="em-search-advanced-<?php echo $id; ?>" data-parent="em-search-form-<?php echo $id; ?>" data-view="<?php echo esc_attr($args['view']); ?>">
			<!--div class="em-search-advanced input" <?php if( !empty($args['advanced_hidden']) ) echo 'style="display:none"'; ?>-->
				<?php
				/*
				//date range (scope)
				//if( !empty($args['search_scope']) ) em_locate_template('templates/search/scope.php',true,array('args'=>$args));
				//categories
				if( get_option('dbem_categories_enabled') && !empty($args['search_categories']) ) em_locate_template('templates/search/categories.php',true,array('args'=>$args));
				// Location data
				//em_locate_template('templates/search/location.php',true, array('args'=>$args));
				//if( !empty($args['search_geo_units']) ) em_locate_template('templates/search/geo-units.php',true, array('args'=>$args));
				*/
				?>
				<div class="em-modal-content em-search-sections input">
					<section class="em-search-main">
						<?php
						// main three searches on top
						if( !empty($args['search_term']) ) em_locate_template('templates/search/search.php',true,array('args'=>$args));
						if( !empty($args['search_scope']) ) em_locate_template('templates/search/scope.php',true,array('args'=>$args));
						if( !empty($args['search_geo']) ) em_locate_template('templates/search/geo.php',true,array('args'=>$args));
						?>
					</section>
					<section class="em-search-advanced-sections">
						<?php if( get_option('dbem_categories_enabled') && !empty($args['search_categories']) ): ?>
							<section class="em-search-section-categories em-search-advanced-section">
								<!--header><?php echo esc_html($args['category_label']); ?></header-->
								<div class="em-search-section-content">
									<?php em_locate_template('templates/search/categories.php',true,array('args'=>$args)); ?>
								</div>
							</section>
						<?php endif; ?>
						<?php if( get_option('dbem_tags_enabled') && !empty($args['search_tags']) ): ?>
							<section  class="em-search-section-tags em-search-advanced-section">
								<!--header><?php echo esc_html($args['tag_label']); ?></header-->
								<div class="em-search-section-content">
									<?php em_locate_template('templates/search/tags.php',true,array('args'=>$args)); ?>
								</div>
							</section>
						<?php endif; ?>
					</section>
				</div><!-- content -->
				
				<?php do_action('em_template_events_search_form_footer'); //hook in here to add extra fields, text etc. ?>
				
				<?php /*<button type="reset" class="button button-secondary"><?php esc_html_e('Clear All', 'events-manager'); ?></button> */ ?>
				
				<?php if( !$args['show_main'] ): //show button if it wasn't shown further up ?>
					<button type="submit" class="em-search-submit button-primary" data-button-text="<?php echo esc_html($args['search_button']); ?>">
						<?php echo esc_html($args['search_button']); ?>
					</button>
				<?php endif; ?>
			</div>
		<?php else: // Search Form Pop-Up Shown as separate form ?>
			<div class="em-modal <?php em_template_classes('search', 'search-advanced'); ?> <?php echo esc_attr(implode(' ', $args['css_classes_advanced'])); ?>" id="em-search-advanced-<?php echo $id; ?>" data-parent="em-search-form-<?php echo $id; ?>" data-view="<?php echo esc_attr($args['view']); ?>">
				<div class="em-modal-popup">
					<header>
						<a class="em-close-modal" href="#"></a><!-- close modal -->
						<div class="em-modal-title">
							<?php echo esc_html($args['search_text_show']); ?>
						</div>
					</header>
					<div class="em-modal-content em-search-sections input">
						<section class="em-search-main">
							<?php
							// main three searches on top
							if( !empty($args['search_term']) ) em_locate_template('templates/search/search.php',true,array('args'=>$args));
							if( !empty($args['search_scope']) ) em_locate_template('templates/search/scope.php',true,array('args'=>$args));
							if( !empty($args['search_geo']) ) em_locate_template('templates/search/geo.php',true,array('args'=>$args));
							?>
						</section>
						<section class="em-search-advanced-sections">
							<!--section class="em-search-section-location em-search-advanced-section">
								<header>Location Options</header>
								<div class="em-search-section-content">
									<?php
									em_locate_template('templates/search/location.php', true, array('args'=>$args));
									if( !empty($args['search_geo_units']) ) em_locate_template('templates/search/geo-units.php',true, array('args'=>$args));
									if( !empty($args['search_eventful']) ) em_locate_template('templates/search/eventful-locations.php',true,array('args'=>$args));
									?>
								</div>
							</section-->
							<?php if( get_option('dbem_categories_enabled') && !empty($args['search_categories']) ): ?>
								<section class="em-search-section-categories em-search-advanced-section">
									<header><?php echo esc_html($args['category_label']); ?></header>
									<div class="em-search-section-content">
										<?php em_locate_template('templates/search/categories.php',true,array('args'=>$args)); ?>
									</div>
								</section>
							<?php endif; ?>
							<?php if( get_option('dbem_tags_enabled') && !empty($args['search_tags']) ): ?>
								<section  class="em-search-section-tags em-search-advanced-section">
									<header><?php echo esc_html($args['tag_label']); ?></header>
									<div class="em-search-section-content">
										<?php em_locate_template('templates/search/tags.php',true,array('args'=>$args)); ?>
									</div>
								</section>
							<?php endif; ?>
						</section>
					</div><!-- content -->
					<footer class="em-submit-section input">
						<div>
							<button type="reset" class="button button-secondary"><?php esc_html_e('Clear All', 'events-manager'); ?></button>
						</div>
						<div>
							<button type="submit" class="button button-primary" data-button-text="<?php echo esc_html($args['search_button']); ?>"><?php echo esc_html($args['search_button']); ?></button>
						</div>
					</footer>
				</div><!-- modal -->
			</div>
		<?php endif; ?>
	</form>
</div>

<?php if( empty($args['has_view']) ): // if called by another shortcode e.g. events_list, then that shortcode should generate the search form and wrap itself in the below ?>
	<div class='<?php em_template_classes('view-container'); ?> <?php echo esc_attr(implode(' ', $args['css_classes'])); ?>' id="em-view-<?php echo $id; ?>" data-view="<?php echo esc_attr($args['view']); ?>"></div>
<?php endif; ?>
