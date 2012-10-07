<?php

/**
 * Post Types
 * @author Baki Goxhaj
 * @link http://wplancer.com
 * @credit Based upon Jeffrey Way's work.
 */
class Post_Type
{

	/**
	 * The name of the post type.
	 * @var string
	 */
	public $post_type_name;

	/**
	 * A list of user-specific options for the post type.
	 * @var array
	 */
	public $post_type_args;

	/**
	 * The singular name of the post type
	 * @var string
	*/
	public $singular;

	/**
	 * The plural name of the post type
	 * @var string
	*/
	public $plural;


	/**
	 * Sets default values, registers the passed post type, and
	 * listens for when the post is saved.
	 *
	 * @param string $name The name of the desired post type.
	 * @param array @post_type_args Override the options.
	 */
	function __construct($name, $post_type_args = array())
	{		
		$this->post_type_name = strtolower($name);
		$this->post_type_args = (array)$post_type_args;

		// Handle Plurals & Singulars for labels throughout the admin area.
		$this->createLabels();

		// First step, register that new post type
		$this->init(array(&$this, "register_post_type"));
	}

	/**
	 * Helper method, that attaches a passed function to the 'init' WP action
	 * @param function $cb Passed callback function.
	 */
	function init($cb)
	{
		add_action("init", $cb);
	}

	/**
	 * Helper method, that attaches a passed function to the 'admin_init' WP action
	 * @param function $cb Passed callback function.
	 */
	function admin_init($cb)
	{
		add_action("admin_init", $cb);

	}

	/**
	*
	* Create correct labels based on whether or not the user has provided
	* Plural or Singular variations of the post type name
	*
	*/
	protected function createLabels(){
		
		$singular = $this->post_type_args['singular_name'];
		$plural   = $this->post_type_args['plural_name'];

		// Singular name explicitly set.
		if (!is_null($singular)){
		  $this->singular = ucwords($singular);
		  $this->plural   = ucwords($this->post_type_name);
		}

		// Plural name explicitly set.
		if (!is_null($plural)){
		  $this->plural   = ucwords($plural);
		  $this->singular = ucwords($this->post_type_name);
		}
		
		// Nothing explicitly set
		if (is_null($plural) or is_null($singular)){
			$this->singular = ucwords($this->post_type_name);
			$this->plural   = ucwords($this->post_type_name) . 's';
		}
	}


	/**
	 * Registers a new post type in the WP db.
	 */
	public function register_post_type()
	{
		$labels = array(
		  'name'				=> $this->plural,
		  'singular_name'		=> $this->singular,
		  'add_new'			 	=> 'Add New',
		  'add_new_item'		=> 'Add New ' . $this->singular,
		  'edit_item'		  	=> 'Edit '. $this->singular,
		  'new_item'			=> 'New ' . $this->singular ,
		  'all_items'		   	=> 'All ' . $this->plural,
		  'view_item'		   	=> 'View ' . $this->singular,
		  'search_items'		=> 'Search ' . $this->plural,
		  'not_found'		   	=> 'No ' . $this->plural . ' found',
		  'not_found_in_trash'  => 'No ' . $this->plural . ' found in Trash',
		  'parent_item_colon'   => '',
		  'menu_name' 			=> $this->plural
		);

		$args = array(
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"query_var" => true,
			#"menu_icon" => get_stylesheet_directory_uri() . "/article16.png",
			"rewrite" => true,
			"capability_type" => "post",
			"hierarchical" => false,
			"menu_position" => 5, // I know default is null, but I use '5' all the time, thus ...
			"supports" => array("title", "editor", "thumbnail"),
			'has_archive' => true
		);

		// Take user provided options, and override the defaults.
		$args = array_merge($args, $this->post_type_args);

		register_post_type($this->post_type_name, $args);
	}


	/**
	 * Registers a new taxonomy, associated with the instantiated post type.
	 *
	 * @param string $taxonomy_name The name of the desired taxonomy
	 * @param string $plural The plural form of the taxonomy name. (Optional)
	 * @param array $options A list of overrides
	 */
	function add_taxonomy($taxonomy_name, $plural = '', $options = array())
	{
		// Create local reference so we can pass it to the init cb.
		$post_type_name = $this->post_type_name;

		// If no plural form of the taxonomy was provided, do a crappy fix. :)

		if (empty($plural)) {
			$plural = $taxonomy_name . 's';
		}

		// Taxonomies need to be lowercase, but displaying them will look better this way...
		$taxonomy_name = ucwords($taxonomy_name);

		// At WordPress' init, register the taxonomy
		$this->init(
			function() use($taxonomy_name, $plural, $post_type_name, $options)
			{
				// Override defaults with user provided options

				$options = array_merge(
					array(
						 "hierarchical" => true,
						 "label" => $taxonomy_name,
						 "singular_label" => $plural,
						 "show_ui" => true,
						 "query_var" => true,
						 "rewrite" => array("slug" => strtolower($taxonomy_name))
					),
					$options
				);

				// name of taxonomy, associated post type, options
				register_taxonomy(strtolower($taxonomy_name), $post_type_name, $options);
			});
	}
}
