<?php
/*
	Plugin Name: Cranleigh Policies
	Plugin URI: http://www.cranleigh.org/policies
	Description: One plugin adds the Policies Custom Policy
	Author: Fred Bradley
	Version: 1.0.1
	Author URI: http://fred.im
*/
class CS_CPT_policies {
	public $post_type_key = "policies";

	function __construct() {
		add_action( 'init', array($this,'cpt_policies'), 0 );
		add_filter( 'rwmb_meta_boxes', array($this, 'meta_boxes') );
		add_action( 'pre_get_posts', array($this, 'policies_order') );
		add_filter( 'get_the_archive_title', array($this,'filter_title'), 4 );
		add_action( 'init', array($this, 'custom_tax'), 0 );
	}

	function filter_title($title) {
		if (is_post_type_archive( $this->post_type_key )):
		    return str_replace("Archives:", "", $title); //'The ' . $title . ' was filtered';
		endif;

		return $title;
	}
	function policies_order($query) {
		if (is_post_type_archive( $this->post_type_key )){
			if ($query->is_main_query()) {
				$query->set("posts_per_page", -1);
				$query->set("orderby", "title");
				$query->set("order", "ASC");
			}
		}
	}
	/**
	 * meta_boxes function.
	 * Uses the 'rwmb_meta_boxes' filter to add custom meta boxes to our custom post type.
	 * Requires the plugin "meta-box"
	 *
	 * @access public
	 * @param array $meta_boxes
	 * @return void
	 */
	function meta_boxes($meta_boxes) {
		$prefix = "policy_";
		$meta_boxes[] = array(
			"id" => "policy_meta",
			"title" => "Policy Data",
			"post_types" => array($this->post_type_key),
			"context" => "normal",
			"priority" => "high",
			"autosave" => true,
			"fields" => array(
				array(
					"name" => __("PDF", "cranleigh"),
					"id" => "{$prefix}pdf",
					"type" => "file_advanced",
					"desc" => "Upload the policy PDF file",
					"max_file_uploads" => 1
				)

			),
			/*'validation' => array(
				'rules'    => array(
					"{$prefix}pdf" => array(
						'required'  => true,
					),
				),
				// optional override of default jquery.validate messages
				'messages' => array(
					"{$prefix}pdf" => array(
							'required'  => __( 'There\'s not PDF uploaded? Are you wanting to add this policy or not?', 'cranleigh' ),
					),
				),
			),*/
		);

		return $meta_boxes;
	}

	// Register Custom Policy
	function cpt_policies() {

		$labels = array(
			'name'                  => _x( 'Policies', 'Policy General Name', 'cranleigh' ),
			'singular_name'         => _x( 'Policy', 'Policy Singular Name', 'cranleigh' ),
			'menu_name'             => __( 'Policies', 'cranleigh' ),
			'name_admin_bar'        => __( 'Policy', 'cranleigh' ),
			'archives'              => __( 'Item Archives', 'cranleigh' ),
			'parent_item_colon'     => __( 'Parent Item:', 'cranleigh' ),
			'all_items'             => __( 'All Policies', 'cranleigh' ),
			'add_new_item'          => __( 'Add New Policy', 'cranleigh' ),
			'add_new'               => __( 'Add New Policy', 'cranleigh' ),
			'new_item'              => __( 'New Policy', 'cranleigh' ),
			'edit_item'             => __( 'Edit Policy', 'cranleigh' ),
			'update_item'           => __( 'Update Policy', 'cranleigh' ),
			'view_item'             => __( 'View Policy', 'cranleigh' ),
			'search_items'          => __( 'Search Policy', 'cranleigh' ),
			'not_found'             => __( 'Not found', 'cranleigh' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'cranleigh' ),
			'featured_image'        => __( 'Featured Image', 'cranleigh' ),
			'set_featured_image'    => __( 'Set featured image', 'cranleigh' ),
			'remove_featured_image' => __( 'Remove featured image', 'cranleigh' ),
			'use_featured_image'    => __( 'Use as featured image', 'cranleigh' ),
			'insert_into_item'      => __( 'Insert into item', 'cranleigh' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'cranleigh' ),
			'items_list'            => __( 'Policies list', 'cranleigh' ),
			'items_list_navigation' => __( 'Policies list navigation', 'cranleigh' ),
			'filter_items_list'     => __( 'Filter policy list', 'cranleigh' ),
		);

		$args = array(
			'label'                 => __( 'Policy', 'cranleigh' ),
			'description'           => __( 'The policies and information on these pages are subject to change due to annual reviews and changes in statutory guidance. If you have any questions, please contact the school. A copy of the policies on this page can also be obtained by contacting the School Office.', 'cranleigh' ),
			'labels'                => $labels,
			'supports'              => array( 'title' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 27,
			'menu_icon'             => 'dashicons-carrot',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);

		register_post_type( $this->post_type_key, $args );

	}

	// Register Custom Taxonomy
	function custom_tax() {

		$labels = array(
			'name'                       => _x( 'Policy Types', 'Taxonomy General Name', 'cranleigh-2016' ),
			'singular_name'              => _x( 'Policy type', 'Taxonomy Singular Name', 'cranleigh-2016' ),
			'menu_name'                  => __( 'Policy Types', 'cranleigh-2016' ),
			'all_items'                  => __( 'All Items', 'cranleigh-2016' ),
			'parent_item'                => __( 'Parent Item', 'cranleigh-2016' ),
			'parent_item_colon'          => __( 'Parent Item:', 'cranleigh-2016' ),
			'new_item_name'              => __( 'New Item Name', 'cranleigh-2016' ),
			'add_new_item'               => __( 'Add New Item', 'cranleigh-2016' ),
			'edit_item'                  => __( 'Edit Item', 'cranleigh-2016' ),
			'update_item'                => __( 'Update Item', 'cranleigh-2016' ),
			'view_item'                  => __( 'View Item', 'cranleigh-2016' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'cranleigh-2016' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'cranleigh-2016' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'cranleigh-2016' ),
			'popular_items'              => __( 'Popular Items', 'cranleigh-2016' ),
			'search_items'               => __( 'Search Items', 'cranleigh-2016' ),
			'not_found'                  => __( 'Not Found', 'cranleigh-2016' ),
			'no_terms'                   => __( 'No items', 'cranleigh-2016' ),
			'items_list'                 => __( 'Items list', 'cranleigh-2016' ),
			'items_list_navigation'      => __( 'Items list navigation', 'cranleigh-2016' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'policy_type', array( 'policies' ), $args );

	}

}
new CS_CPT_policies();
