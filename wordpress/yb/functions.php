<?php
/*
Author: Shelby Smith
URL: htp://yellowberri.com

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images, 
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

// yb.php is a bastardization of the original bones.php file from the Bones Theme, developed by Eddie Machado
require_once('library/yb.php'); // if you remove this, yb will break
require_once('library/admin.php'); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'yb-thumb-600', 600, 150, true );
add_image_size( 'yb-thumb-300', 300, 100, true );
/* 
to add more sizes, simply copy a line from above 
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image, 
we would use the function:
<?php the_post_thumbnail( 'yb-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'yb-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function yb_register_sidebars() {
    register_sidebar(array(
    	'id' => 'main-sidebar',
    	'name' => 'Main Sidebar',
    	'description' => 'The main (primary) sidebar.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
    /* 
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call 
    your new sidebar just use the following code:
    
    Just change the name to whatever your new
    sidebar's id is, for example:
    
    register_sidebar(array(
    	'id' => 'sidebar2',
    	'name' => 'Sidebar 2',
    	'description' => 'The second (secondary) sidebar.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
    To call the sidebar in your template, you can just copy
    the sidebar.php file and rename it to your sidebar's name.
    So using the above example, it would be:
    sidebar-sidebar2.php
    
    */
} // don't remove this bracket!


/************* CUSTOM FUNCTIONS ********************/

function remove_menus () {
global $menu;
	$restricted = array(__('Posts', 'yb'), __('Links', 'yb'), __('Media', 'yb'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
//add_action('admin_menu', 'remove_menus');

function custom_menu_order($menu_ord) {  
    if (!$menu_ord) return true;  
      
    return array(  
        'index.php', // Dashboard  
        'separator1', // First separator  
        'edit.php?post_type=page', // Pages  
        'edit.php', // Posts  
        'edit.php?post_type=events',
        'edit.php?post_type=staff',
        'edit.php?post_type=gg_galleries',
        'edit.php?post_type=soliloquy',
        'upload.php', // Media  
        'link-manager.php', // Links  
        'edit-comments.php', // Comments  
        'separator2', // Second separator  
        'themes.php', // Appearance  
        'plugins.php', // Plugins  
        'users.php', // Users  
        'tools.php', // Tools  
        'options-general.php', // Settings  
        'separator-last', // Last separator  
    );  
}  
//add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order  
//add_filter('menu_order', 'custom_menu_order');  

function edit_admin_menus() {  
    global $menu;  
    //var_dump($menu);
    $menu[5][0] = __('Recipes', 'yb'); // Change Posts to Recipes  
}  
//add_action( 'admin_menu', 'edit_admin_menus' ); 


?>