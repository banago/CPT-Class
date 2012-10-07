## Usage

Firstly, this class *requires* PHP 5.3. Make sure you have it running.

Secondly, this is still quite new, so it needs
a lot of debugging and work. :) In other words, it's Beta. 

First, download the class, and drag it into the root of your theme directory. 

Next, within `functions.php`, require the class.

    require 'cpt-class.php';

You now have access to the class and its functions. Instantiate the class.
We'll use a Snippet post type as an example.

    $snippet = new Post_Type('Snippet');

You may also pass an optional second parameter to override some of the
defaults. For example, if I only want to provide support for a title and an
excerpt, I could do:

    $snippet = new Post_Type('Snippet', array(
       'supports' => array('title', 'excerpt') )
    );

If the Plural version of your Post Type is more complicated than an additional 's', then you can specify 
what it should be in the second parameter:
    
    $snippet = new Post_Type('Gallery', array(
       'supports' => array('title', 'excerpt'), 
       'plural_name' => 'Galleries' )
    );

If I want to also use the built-in category and/or tag taxonomies that WordPress provides...

    $snippet = new Post_Type('Snippet', array(
       'taxonomies' => array('category', 'post_tag') )
    );

### Custom Taxonomies

It makes sense to filter our sample Snippet post type by difficulty and language. We can implement that functionality quite easily.

    $snippet->add_taxonomy('Difficulty');
    $snippet->add_taxonomy('Language');

I may also specify the plural form of my taxonomy, and any optional overrides. 

    $snippet->add_taxonomy('Difficulty', 'Difficulties', array(
      'show_ui' => false )
    );
