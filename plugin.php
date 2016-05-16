<?php
/*
	Plugin Name: Cranleigh Policies
	Plugin URI: http://www.cranleigh.org
	Description: Custom Post Type for all Cranleigh Policy downloads. 
	Author: Fred Bradley
	Version: 1
	Author URI: http://fred.im
*/

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

class Cranleigh_Policies {
	public $post_type_key = "policies";
	
	/**
	 * __construct function. Contains all the actions and filters for the class.
	 * 
	 * @access public
	 * @return void
	 */
	function __construct() {
		register_activation_hook(__FILE__, array($this, 'activate'));
		
		add_action( 'init', array($this, 'CPT_Cranleigh_Policies'));
		
		add_filter( 'rwmb_meta_boxes', array($this, 'meta_boxes'));

		add_action( 'tgmpa_register', array($this, 'required_plugins') );

		
	}
	
	/**
	 * activate function. Called only once upon activation of the plugin on any site.
	 * 
	 * @access public
	 * @return void
	 */
	 
	function activate() {

	}
	
	
	
	/**
	 * title_text_input function.
	 * 
	 * @access public
	 * @param mixed $title
	 * @return void
	 */
	function title_text_input($title) {
		if (get_post_type()==$this->post_type_key):
			return $title = '(first name) (surname)';
		endif;
		return $title;
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
		$prefix = "_policy_";
		$meta_boxes[] = array(
			"id" => "staff_meta_side",
			"title" => "Staff Info",
			"post_types" => array($this->post_type_key),
			"context" => "side",
			"priority" => "high",
			"autosave" => true,
			"fields" => array(
				array(
					"name" => __("Lead Job Title", "cranleigh"),
					"id" => "{$prefix}leadjobtitle",
					"type" => "text",
					"desc" => "The job title that will show on on your cards, and contacts"
				)
			
			),
			'validation' => array(
				'rules'    => array(
					"{$prefix}position" => array(
						'required'  => true,
						'minlength' => 3,
					),
					"{$prefix}leadjobtitle" => array(
						"required" => true,
						"minlength" => 3
					)
				),
				// optional override of default jquery.validate messages
				'messages' => array(
					"{$prefix}position" => array(
						'required'  => __( 'Position is required', 'text_domain' ),
						'minlength' => __( 'Position must be at least 3 characters', 'text_domain' ),
					),
					"{$prefix}leadjobtitle" => array(
						"required" => __("You must enter a lead job title", "cranleigh"),
						"minlength" => __("Job Title must be at least 3 characters", "cranleigh")
					)
				),
			),
		);
		
/*		$meta_boxes[] = array(
			"id" => "staff_meta_normal",
			"title" => "Staff Meta",
			"post_types" => array($this->post_type_key),
			"context" => "normal",
			"autosave" => true,
			"fields" => array(
				array(
					"name" => __("Excerpt")
				)
			)
		)*/
		return $meta_boxes;
	}
	
	// Register Custom Post Type
	function CPT_Cranleigh_Policies() {
		
		$labels = array(
			'name'                  => _x( 'Cranleigh Policies', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Policy', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Policies', 'text_domain' ),
			'name_admin_bar'        => __( 'Policies', 'text_domain' ),
			'archives'              => __( 'Cranleigh Policies', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
			'all_items'             => __( 'All Cranleigh Policies', 'text_domain' ),
			'add_new_item'          => __( 'Add New Policy', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			
		);
		$args = array(
			'label'                 => __( 'Person', 'text_domain' ),
			'description'           => __( 'A List of People that are mentioned on the website', 'text_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail','excerpt' ),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-media-text',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( $this->post_type_key, $args );
	
	}
	
	
	function required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			array(
				'name'      => 'Meta Box',
				'slug'      => 'meta-box',
				'required'  => true,
			),
	
		);
	
			$config = array(
			'id'           => 'cranleigh',				// Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',						// Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins',	// Menu slug.
			'parent_slug'  => 'plugins.php',            // Parent menu slug.
			'capability'   => 'manage_options',			// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,						// Show admin notices or not.
			'dismissable'  => true,						// If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',						// If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,					// Automatically activate plugins after installation or not.
			'message'      => '',						// Message to output right before the plugins table.
	
		);
	
		tgmpa( $plugins, $config );
	}


}

$Cranleigh_Policis = new Cranleigh_Policies();

