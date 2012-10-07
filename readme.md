## About 

I find myself much too often creating custom post types code for WordPress and it 
was hight time I figured something out about it. Thus, here is this PHP class making 
the process of creating WordPress custom post types & taxonomies as easy as possible.

Producton Ready. I use it on multiple projects.

## Usage

First, download the class, and drag it into the root of your theme directory. 

Next, within `functions.php`, require the class.

    require 'inc/cpt-class.php';

You now have access to the class and its functions. Instantiate the class.
We'll use a Snippet post type as an example.

    $product = new Post_Type('product');

You may also pass an optional second parameter to override some of the
defaults. For example, if I only want to provide support for a title and an
excerpt, I could do:

    $product = new Post_Type('product', array(
       'supports' => array('title', 'excerpt') )
    );

If the Plural version of your Post Type is more complicated than an additional 's', then you can specify 
what it should be in the second parameter:
    
    $snippet = new Post_Type('Gallery', array(
       'supports' => array('title', 'excerpt'), 
       'plural_name' => 'Galleries' )
    );

If I want to also use the built-in category and/or tag taxonomies that WordPress provides:

    $snippet = new Post_Type('Snippet', array(
       'taxonomies' => array('category', 'post_tag') )
    );

### Custom Taxonomies

It makes sense to filter our sample Snippet post type by difficulty and language. We can implement that functionality quite easily.

    $snippet->add_taxonomy('Difficulty');
    $snippet->add_taxonomy('Language');

I may also specify the plural form of my taxonomy, and any optional overrides. 

    $snippet->add_taxonomy('Difficulty', 'Difficulties', array(
      'hierarchical' => false )
    );
    
## Requirements

* PHP 5.3. Make sure you have it running.
* Balls. Make sure you got them :)

