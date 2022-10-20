<?php /* @var $args array */ ?>

<?php
$troubleshooting = ""; // init

if ( isset($_GET["category"]) ) { $category = $_GET["category"]; } else { $category = ""; }

if ( $category != "" ) {
    // If we're working with a category slug instead of the cat_id, get the id
    if ( is_numeric ($category) ) {
        $cat_id = $category;
        //echo "<!-- qp category is_numeric: $cat_id -->";
    } else {
        //echo "<!-- qp category NOT is_numeric: $category -->"; // tft
        $cat_obj = get_term_by('slug', $category, 'event-categories');
        $cat_id = $cat_obj->term_id;
        //echo "<!-- cat_id: $cat_id -->";
        //echo "<!-- ".print_r($cat_obj,true)."-->";
    }
    
    $troubleshooting .= "category: ".$category."<br />";
    $troubleshooting .= "cat_id: ".$cat_id."<br />";
    
    $args['category'] = $cat_id;
}

if ( $troubleshooting != "" && devmode_active() ) {
    echo '<div class="troubleshooting">'.$troubleshooting.'</div>';
}
?>

<!-- START Category Search -->
<div class="em-search-category em-search-field">
	<label for="em-search-category-<?php echo absint($args['id']) ?>" class="screen-reader-text"><?php echo esc_html($args['category_label']); ?></label>

	<select name="category[]" class="em-search-category em-selectize always-open checkboxes" id="em-search-category-<?php echo absint($args['id']) ?>" multiple size="10" placeholder="<?php echo esc_attr($args['categories_placeholder']); ?>">
		<?php
		$categories = EM_Categories::get(array('orderby'=>'name','hide_empty'=>0));
		$selected = array();
		if( !empty($args['category']) ){
			if( !is_array($args['category']) ){
				$selected = explode(',', $args['category']);
			} else {
				$selected = $args['category'];
			}
		}
		$walker = new EM_Walker_CategoryMultiselect();
		$args_em = array(
		    'hide_empty' => 0,
		    'orderby' =>'name',
		    'name' => 'category',
		    'hierarchical' => true,
		    'taxonomy' => EM_TAXONOMY_CATEGORY,
		    'selected' => $selected,
		    'show_option_none' => $args['categories_label'],
		    'option_none_value'=> 0,
			'walker'=> $walker
		);
		echo walk_category_dropdown_tree($categories, 0, $args_em);
		?>
	</select>
</div>
<!-- END Category Search -->