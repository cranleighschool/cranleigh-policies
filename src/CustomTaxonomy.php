<?php


	namespace CranleighSchool\Policies;


	/**
	 * Class CustomTaxonomy
	 *
	 * @package CranleighSchool\Policies
	 */
	class CustomTaxonomy
	{
		/**
		 * @var string
		 */
		public $taxonomy_name;

		/**
		 * @var string
		 */
		public $post_type_key;

		/**
		 * CustomTaxonomy constructor.
		 *
		 * @param string $post_type_key
		 * @param string $taxonomy_name
		 */
		public function __construct(string $post_type_key, string $taxonomy_name)
		{
			$this->post_type_key = $post_type_key;
			$this->taxonomy_name = $taxonomy_name;
			add_action('init', array($this, 'custom_tax'), 0);

		}


		/**
		 *
		 */
		public function custom_tax()
		{

			$labels = array(
				'name'                       => _x('Policy Types', 'Taxonomy General Name', 'cranleigh-2016'),
				'singular_name'              => _x('Policy type', 'Taxonomy Singular Name', 'cranleigh-2016'),
				'menu_name'                  => __('Policy Types', 'cranleigh-2016'),
				'all_items'                  => __('All Items', 'cranleigh-2016'),
				'parent_item'                => __('Parent Item', 'cranleigh-2016'),
				'parent_item_colon'          => __('Parent Item:', 'cranleigh-2016'),
				'new_item_name'              => __('New Item Name', 'cranleigh-2016'),
				'add_new_item'               => __('Add New Item', 'cranleigh-2016'),
				'edit_item'                  => __('Edit Item', 'cranleigh-2016'),
				'update_item'                => __('Update Item', 'cranleigh-2016'),
				'view_item'                  => __('View Item', 'cranleigh-2016'),
				'separate_items_with_commas' => __('Separate items with commas', 'cranleigh-2016'),
				'add_or_remove_items'        => __('Add or remove items', 'cranleigh-2016'),
				'choose_from_most_used'      => __('Choose from the most used', 'cranleigh-2016'),
				'popular_items'              => __('Popular Items', 'cranleigh-2016'),
				'search_items'               => __('Search Items', 'cranleigh-2016'),
				'not_found'                  => __('Not Found', 'cranleigh-2016'),
				'no_terms'                   => __('No items', 'cranleigh-2016'),
				'items_list'                 => __('Items list', 'cranleigh-2016'),
				'items_list_navigation'      => __('Items list navigation', 'cranleigh-2016'),
			);
			$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => true,
			);
			register_taxonomy($this->taxonomy_name, array($this->post_type_key), $args);

		}
	}
