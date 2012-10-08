## About 

I find myself much too often creating custom post types code for WordPress and it 
was high time I figured something out about it. Thus, here is this PHP class making 
the process of creating WordPress custom post types and taxonomies as easy as possible.

This class is Producton Ready; I use it on multiple projects.

## Usage

First, download the class, and drag it into the root of your theme directory. 

Next, within `functions.php`, require the class.

    require TEMPLATEPATH . '/inc/cpt-class.php';

You now have access to the class and its functions. Instantiate the class.
We'll use a Snippet post type as an example.

    $snippet = new Post_Type('snippet');

You may also pass an optional second parameter to override some of the
defaults. For example, if I only want to provide support for a title and an
excerpt, I could do:

    $snippet = new Post_Type('snippet', array(
		'supports' => array('title', 'excerpt'),
		'menu_icon' => get_stylesheet_directory_uri() . '/img/custom-icon.png',
	));

If the Plural version of your Post Type is more complicated than an additional 's', then you can specify 
what it should be in the second parameter:
    
    $gallery = new Post_Type('Gallery', array(
		'plural_name' => 'Galleries',
	));

If I want to also use the built-in category and/or tag taxonomies that WordPress provides:

    $snippet = new Post_Type('Snippet', array(
		'taxonomies' => array('category', 'post_tag'),
	));

### Custom Taxonomies

It makes sense to filter our sample Snippet post type by difficulty and language. We can implement that functionality quite easily.

    $snippet->add_taxonomy('Language');
    $snippet->add_taxonomy('Difficulty');

You may also specify the plural form of your taxonomy, and any optional overrides. 

    $snippet->add_taxonomy('Difficulty', array(
       'plural_name' => 'Difficulties',
       'hierarchical' => false,
    ));
    
## Requirements

* PHP 5.3. Make sure you have it running.
* Balls. Make sure you got them :)

