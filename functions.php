<?php 
date_default_timezone_set('Pacific/Auckland');

// 1. Define locations of scripts, classe, includes.

define('SIBSON_LIB', TEMPLATEPATH . '/lib');
define('SIBSON_STYLE', get_bloginfo('template_directory') . '/style');
define('SIBSON_FUNCTIONS', SIBSON_LIB . '/functions');
define('SIBSON_INCLUDES', SIBSON_LIB . '/includes');
define('SIBSON_CLASSES', SIBSON_LIB . '/classes');
define('SIBSON_SCRIPTS',  get_bloginfo('template_directory'). '/lib/scripts' );
define('SIBSON_IMAGES', SIBSON_STYLE. '/images' );

$upload_dir = wp_upload_dir();  
$uploads =  $upload_dir['baseurl'];
define('SIBSON_UPLOADS', $uploads);

//Load classes.
require(SIBSON_CLASSES . '/lockandkey.php');
require(SIBSON_CLASSES . '/person.php');
require(SIBSON_CLASSES . '/group.php');
require(SIBSON_CLASSES . '/lists.php');
require(SIBSON_CLASSES . '/assessment.php');
require(SIBSON_CLASSES . '/print.php');
require(SIBSON_CLASSES . '/log.php');
require(SIBSON_CLASSES . '/admin.php');


// Allow pages documents to be uploaded.

add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {
// add pages extension to the array
$existing_mimes['pages'] = 'application/x-iwork-pages-sffpages';

return $existing_mimes;
}

// ensure that only administrators can access the admin pages but that ajax will still function.

function my_admin_init(){
    if( !defined('DOING_AJAX') && !current_user_can('administrator') ){
        wp_redirect( home_url() );
        exit();
    }
}
add_action('admin_init','my_admin_init');


//Load scripts for student and parents pages.

if($_GET['fullscreen']){
	
add_action('wp_head', 'add_fullscreen_stylesheets'); 	
add_action('wp_enqueue_scripts', 'add_main_scripts');
}
else {
add_action('wp_head', 'add_main_stylesheets'); 
add_action('wp_enqueue_scripts', 'add_main_scripts');
}
function add_main_stylesheets() {
	
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_directory').'/style.css" />';
	
		
}
function add_fullscreen_stylesheets() {
	
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_directory').'/fullscreen.css" />';
		echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_directory').'/style.css" />';
	
		
}


function add_limited_scripts(){
	wp_deregister_script( 'jquery' );
	
    wp_register_script( 'jquery',  SIBSON_SCRIPTS.'/jquery.js');
    wp_enqueue_script( 'jquery' );
	// embed the javascript file that makes the AJAX request
wp_enqueue_script( 'sibson', SIBSON_SCRIPTS. '/sibson.js');
	
		 wp_enqueue_script (  'jQueryMobile' ,       // handle
                         SIBSON_SCRIPTS.'/jquery.mobile-1.0.min.js');
		  wp_enqueue_script ( 'googleapi.js',  'https://www.google.com/jsapi');
		 
		  
	

wp_enqueue_script (  'typekit' ,       // handle
                         'http://use.typekit.com/vxe4kfy.js');


	
}

function add_main_scripts() {
		
		 wp_deregister_script( 'jquery' );
	
    wp_register_script( 'jquery',  'http://code.jquery.com/jquery-1.6.4.js');
    wp_enqueue_script( 'jquery' );
	// embed the javascript file that makes the AJAX request

	
		 wp_enqueue_script (  'jQueryMobile' ,       // handle
                         'http://ajax.aspnetcdn.com/ajax/jquery.mobile/1.0/jquery.mobile-1.0.min.js');
		wp_enqueue_script( 'sibson', SIBSON_SCRIPTS. '/fulljavascript.js');				 
		  wp_enqueue_script ( 'googleapi.js',  'https://www.google.com/jsapi');
		 
		  
	

wp_enqueue_script (  'typekit' ,       // handle
                         'http://use.typekit.com/vxe4kfy.js');



// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
wp_localize_script( 'sibson', 'MyAjax', array( 'imageUrl'=>SIBSON_STYLE ,'ajaxurl' => admin_url( 'admin-ajax.php' ), 'sibson_nonce_for_ajax' => wp_create_nonce( 'sibson_nonce' ) ) );
		
}


 

add_theme_support('post-thumbnails');


// Load functions.

require(SIBSON_FUNCTIONS. '/custom_post_types.php');
require(SIBSON_FUNCTIONS. '/ajax.php');
require(SIBSON_FUNCTIONS. '/sibson_funcs.php');
require(SIBSON_FUNCTIONS. '/admin_funcs.php');


//2. Modifications to wordpress defaults. 

// hide the admin bar.

add_filter( 'show_admin_bar', '__return_false' );

/*Styling the WP Login Screen */

function add_log_in_stylesheet() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/style/custom-login.css" />';

	

}


add_action('login_head', 'add_log_in_stylesheet'); 


//Hide the uncategorised option.

function the_category_filter($thelist,$separator=' ') {  
    if(!defined('WP_ADMIN')) {  
        //Category Names to exclude  
        $exclude = array('Uncategorized', 'Private');  
  
        $cats = explode($separator,$thelist);  
        $newlist = array();  
        foreach($cats as $cat) {  
            $catname = trim(strip_tags($cat));  
            if(!in_array($catname,$exclude))  
                $newlist[] = $cat;  
        }  
        return implode($separator,$newlist);  
    } else {  
        return $thelist;  
    }  
}  
add_filter('the_category','the_category_filter', 10, 2);  


// 3. Security and user redirection.

//Add an action that will automatically redirect user to log in page if they are not logged in.

add_action('get_header', 'sibson_private');	

function sibson_private() {
  if (!is_user_logged_in()) {
    auth_redirect();
  }
}



// disblae rss feeds so that information about students cannot be accessed by mistake.
function fb_disable_feed() {
wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}

function remove_footer_admin () {
echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Designed by <a href="#" target="_blank">Paul Sibson</a></p>';
}


 
add_filter('admin_footer_text', 'remove_footer_admin');

 
add_action('do_feed', 'fb_disable_feed', 1);
add_action('do_feed_rdf', 'fb_disable_feed', 1);
add_action('do_feed_rss', 'fb_disable_feed', 1);
add_action('do_feed_rss2', 'fb_disable_feed', 1);
add_action('do_feed_atom', 'fb_disable_feed', 1);	





?>
