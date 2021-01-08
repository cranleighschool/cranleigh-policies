<?php

	namespace CranleighSchool\Policies;

	/**
	 * Class CustomPostType
	 *
	 * @package CranleighSchool\Policies
	 */
	class CustomPostType
	{
		/**
		 * @var string
		 */
		public $post_type_key;

		/**
		 * CustomPostType constructor.
		 *
		 * @param string $post_type_key
		 */
		public function __construct(string $post_type_key)
		{
			$this->post_type_key = $post_type_key;
			add_action('init', array($this, 'cpt_policies'), 0);
			add_action('pre_get_posts', array($this, 'getAllPosts'), 99999); // We can force this because there's a post type check in the method
		}

		/**
		 *
		 */
		public function cpt_policies()
		{

			$labels = array(
				'name'                  => _x('Policies', 'Policy General Name', 'cranleigh-2016'),
				'singular_name'         => _x('Policy', 'Policy Singular Name', 'cranleigh-2016'),
				'menu_name'             => __('Policies', 'cranleigh-2016'),
				'name_admin_bar'        => __('Policy', 'cranleigh-2016'),
				'archives'              => __('Item Archives', 'cranleigh-2016'),
				'parent_item_colon'     => __('Parent Item:', 'cranleigh-2016'),
				'all_items'             => __('All Policies', 'cranleigh-2016'),
				'add_new_item'          => __('Add New Policy', 'cranleigh-2016'),
				'add_new'               => __('Add New Policy', 'cranleigh-2016'),
				'new_item'              => __('New Policy', 'cranleigh-2016'),
				'edit_item'             => __('Edit Policy', 'cranleigh-2016'),
				'update_item'           => __('Update Policy', 'cranleigh-2016'),
				'view_item'             => __('View Policy', 'cranleigh-2016'),
				'search_items'          => __('Search Policy', 'cranleigh-2016'),
				'not_found'             => __('Not found', 'cranleigh-2016'),
				'not_found_in_trash'    => __('Not found in Trash', 'cranleigh-2016'),
				'featured_image'        => __('Featured Image', 'cranleigh-2016'),
				'set_featured_image'    => __('Set featured image', 'cranleigh-2016'),
				'remove_featured_image' => __('Remove featured image', 'cranleigh-2016'),
				'use_featured_image'    => __('Use as featured image', 'cranleigh-2016'),
				'insert_into_item'      => __('Insert into item', 'cranleigh-2016'),
				'uploaded_to_this_item' => __('Uploaded to this item', 'cranleigh-2016'),
				'items_list'            => __('Policies list', 'cranleigh-2016'),
				'items_list_navigation' => __('Policies list navigation', 'cranleigh-2016'),
				'filter_items_list'     => __('Filter policy list', 'cranleigh-2016'),
			);

			$args = array(
				'label'               => __('Policy', 'cranleigh-2016'),
				'description'         => __('The policies and information on these pages are subject to change due to annual reviews and changes in statutory guidance. If you have any questions, please contact the school. A copy of the policies on this page can also be obtained by contacting the <a href="mailto:reception@cranleigh.org">School Office</a>.', 'cranleigh-2016'),
				'labels'              => $labels,
				'supports'            => array('title'),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 27,
				'menu_icon'           => 'dashicons-carrot',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);

			register_post_type($this->post_type_key, $args);

		}

		/**
		 * @param \WP_Query $query
		 *
		 * @return \WP_Query
		 */
		public function getAllPosts(\WP_Query $query): \WP_Query
		{
			if ($this->isArchiveAndMainQuery($query) && $query->is_admin === false) {
				$query->set('posts_per_page', -1);
				$query->set('orderby', 'title');
				$query->set('order', 'ASC');
			}

			return $query;
		}

		private function isArchiveAndMainQuery(\WP_Query $query): bool
		{
			if (is_post_type_archive($this->post_type_key) && $query->is_main_query()) {
				return true;
			}

			return false;
		}
	}
