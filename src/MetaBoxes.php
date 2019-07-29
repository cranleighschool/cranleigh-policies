<?php


	namespace CranleighSchool\Policies;


	/**
	 * Class MetaBoxes
	 *
	 * @package CranleighSchool\Policies
	 */
	class MetaBoxes
	{
		/**
		 * @var string
		 */
		private $prefix = "policy_";

		/**
		 * MetaBoxes constructor.
		 */
		public function __construct()
		{
			add_filter('rwmb_meta_boxes', array($this, 'meta_boxes'));
		}

		/**
		 * meta_boxes function.
		 * Uses the 'rwmb_meta_boxes' filter to add custom meta boxes to our custom post type.
		 * Requires the plugin "meta-box"
		 *
		 * @access public
		 *
		 * @param array $meta_boxes
		 *
		 * @return array $meta_boxes
		 */
		function meta_boxes(array $meta_boxes)
		{

			$meta_boxes[] = array(
				'id'         => 'policy_meta',
				'title'      => 'Policy Data',
				'post_types' => array('policies'),
				'context'    => 'normal',
				'priority'   => 'high',
				'autosave'   => true,
				'fields'     => array(
					array(
						'name'             => __('PDF', 'cranleigh-2016'),
						'id'               => "{$this->prefix}pdf",
						'type'             => 'file_advanced',
						'desc'             => 'Upload the policy PDF file',
						'max_file_uploads' => 1,
					),

				),

			);

			return $meta_boxes;
		}
	}
