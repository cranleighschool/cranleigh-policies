<?php


	namespace CranleighSchool\Policies;


	/**
	 * Class Plugin
	 *
	 * @package CranleighSchool\Policies
	 */
	class Plugin
	{
		/**
		 * @var string
		 */
		public $post_type_key = 'policies';

		/**
		 * Plugin constructor.
		 */
		function __construct()
		{
			add_action('pre_get_posts', array($this, 'policies_order'));
			add_filter('get_the_archive_title', array($this, 'filter_title'), 4);
			new CustomPostType("policies");
			new CustomTaxonomy("policies", "policy_type");
		}

		/**
		 * @param $title
		 *
		 * @return mixed
		 */
		public function filter_title($title)
		{
			if (is_post_type_archive($this->post_type_key)) :
				return str_replace('Archives:', '', $title); // 'The ' . $title . ' was filtered';
			endif;

			return $title;
		}

		/**
		 * @param $query
		 */
		public function policies_order($query)
		{
			if (is_post_type_archive($this->post_type_key)) {
				if ($query->is_main_query()) {
					$query->set('posts_per_page', -1);
					$query->set('orderby', 'title');
					$query->set('order', 'ASC');
				}
			}
		}




	}
