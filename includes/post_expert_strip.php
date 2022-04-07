<?php
/*************************************************/
/*** expert posts
/**************************************************/
add_action( 'init', 'icee_expert_strip_payments' );  
function icee_expert_strip_payments() {
	
	$labels = array(
		'name' 				=> _x('Strip payments ', 'post type general name'),
		'add_new' 			=> 'Add Strip payments',
		'add_new_item' 		=> 'Add Strip payments',
		'edit_item' 		=> __('Edit Strip payments'),
		'new_item' 			=> __('New Strip payments'),
		'all_items' 		=> __('All Strip payments'),
		'view_item' 		=> __('View Strip payments'),
		'search_items' 		=> __('Search Strip payments'),
		'not_found' 		=>  __('Empty'),
		'not_found_in_trash'=> __('Empty Strip payments'), 
		'parent_item_colon' => '',
		'menu_name' 		=> __('Strip payments')
	);

	$args = array(
		'labels' 			=> $labels,
		'public' 			=> true,
		'publicly_queryable'=> false,
		'exclude_from_search'=> true,
		'show_ui' 			=> true, 
		'show_in_menu' 		=> true, 
		'query_var' 		=> true,
		'rewrite'			=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> true, 
		'hierarchical'		=> false,
		'menu_position' 	=> NULL,
		//'show_in_rest'     => true,
		'supports' 			=> array( 'title', 'editor'),
        //'taxonomies'          => array( 'category' ),
		
		
	);
	
	register_post_type("expertstrippayments",$args);
	//register_taxonomy("expertcat", array("expert_posts"), array("hierarchical" => true, "label" => "Categories", "singular_label" => "Categories", "rewrite" => true));
	//register_taxonomy("experttags", array("expert_posts"), array("false" => true, "label" => "Tags", "singular_label" => "Tags", "rewrite" => true));
	
	//register_taxonomy("governmentindustry", array("governmentprojects"), array("hierarchical" => true, "label" => "Government Industry", "singular_label" => "Government Industry", "rewrite" => true));
	
	//register_post_type("counselingprojects",$args);
	
	//register_taxonomy("referencecicategory", array("referenceci"), array("hierarchical" => true, "label" => "Reference Cloud Infrastructure Category", "singular_label" => "Reference Cloud Infrastructure Category", "rewrite" => true));
	
	//register_taxonomy("freecourseuniversity", array("freecourses"), array("hierarchical" => true, "label" => "Free University", "singular_label" => "Free University", "rewrite" => true));
}


?>