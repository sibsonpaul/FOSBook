<?php 

/** The code in this script controls the custom look and feel of the admin section of the theme. 
	1. SECURITY.
	2. GLOBAL VARIABLES.
	3. REMOVE DEFAULTS.
	4. CUSTOM STYLING.
	5. CUSTOM SCRIPTING.
	6. CUSTOM MENUS.
	7. DASHBOARD.
	8. POSTS (EDIT AMD ADD)
	9. FUNCTIONS>

**/

// SECURITY.

//Check if user has access to the backend and then redirect them if they try to access it.

add_action( 'admin_init', 'restrict_admin', 1 );
function restrict_admin(){
	global $current_user;
	get_currentuserinfo();

	//if not admin, redirect to their profile page.
	if ( $current_user->user_level <  7 ) { // If user level is lower than 7.
		wp_redirect( home_url() ); exit; 
	}
	
}

// GLOBAL VARIABLES

global $current_user;
get_currentuserinfo();
$userid= $current_user->ID;

if ($_GET['person_id'] || $_GET['group_id']){ // Check to see if a variable has been passed to set a groupid or personid.
		if ($_GET['person_id'] && is_numeric($_GET['person_id'])){ // See if the id variable is a person or not.
			$Id =$_GET['person_id']; // Set the id to this person id.
			if ($_GET['post_type']){ // see if a post type has been set for the page.
				$subject = $_GET['post_type']; // Set subject to that post type.
				if ($subject =="home"){
					$subject = 'person';
				}
				}
				else {
				$subject = 'person';// Or else set the subject to 'person'.
				}
				$type="person";// Set the type to person.
			$person = new Person($Id); // Instantiate the person class based on the person_id.
			}
		if ($_GET['group_id'] &&is_numeric($_GET['group_id'])){ // Check to see if the id is a group id.
			$Id = $_GET['group_id']; // Set the id to this groups id
			if ($_GET['post_type']){ // Check to see if a post type has been set.
				$subject = $_GET['post_type']; // Set the subject to this post type.
				}
				else {
				$subject = 'group'; // Or else set the subject to group.
				}
		$type = 'group'; // Set the type to group.
		$group = new Group($Id);
		
		}
} // end if.

else  {// If no variable passed, use the users own personid

			$Id = get_user_meta($userid, 'person_id', true); // Get the person is for this user.
			$type="person";	// Set the tyep to person (this will be used by the PageMeta class to display the correct widgets).
			$subject ='person'; // Set the subject to person (this will be used by the PageMeta class to display the correct widgets).
			$person = new Person($Id); // Instantiate the person class based on the person_id.

}

		

// REMOVE DEFAULTS.

// Remove all the standard wordpress menus so that they can be replaced with custom ones.
function remove_menus () {
global $menu;
	$restricted = array( __('Posts'), __('Media'), __('Links'), __('Pages'), __('Appearance'), __('Tools'),  __('Users'), __('Comments'), __('Plugins'), __('Goal'), __('Reviews'), __('Profile'), __('Sparkle'), __('Maths'), __('Literacy'), __('Team'), __('Assessments'), __('Communicator'), __('Thinker'), __('Support'), __('Dream'), __('Plugins'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}


 
function remove_post_custom_fields() {
	remove_meta_box( 'tagsdiv-post_tag' , 'post' , 'normal' ); 
}


// Remove all the submenus.



function remove_submenus() {
  global $submenu;
  //Dashboard menu
  unset($submenu['index.php'][10]); // Removes Updates
  //Posts menu
  unset($submenu['edit.php'][5]); // Leads to listing of available posts to edit
  unset($submenu['edit.php'][10]); // Add new post
  unset($submenu['edit.php'][15]); // Remove categories
  unset($submenu['edit.php'][16]); // Removes Post Tags
  //Media Menu
  unset($submenu['upload.php'][5]); // View the Media library
  unset($submenu['upload.php'][10]); // Add to Media library
  //Links Menu
  unset($submenu['link-manager.php'][5]); // Link manager
  unset($submenu['link-manager.php'][10]); // Add new link
  unset($submenu['link-manager.php'][15]); // Link Categories
  //Pages Menu
  unset($submenu['edit.php?post_type=page'][5]); // The Pages listing
  unset($submenu['edit.php?post_type=page'][10]); // Add New page
  //Appearance Menu
  unset($submenu['themes.php'][5]); // Removes 'Themes'
  unset($submenu['themes.php'][7]); // Widgets
  unset($submenu['themes.php'][15]); // Removes Theme Installer tab
  //Plugins Menu
  unset($submenu['plugins.php'][5]); // Plugin Manager
  unset($submenu['plugins.php'][10]); // Add New Plugins
  unset($submenu['plugins.php'][15]); // Plugin Editor
  //Users Menu
  unset($submenu['users.php'][5]); // Users list
  unset($submenu['users.php'][10]); // Add new user
  unset($submenu['users.php'][15]); // Edit your profile
  //Tools Menu
  unset($submenu['tools.php'][5]); // Tools area
  unset($submenu['tools.php'][10]); // Import
  unset($submenu['tools.php'][15]); // Export
  unset($submenu['tools.php'][20]); // Upgrade plugins and core files
  //Settings Menu
  unset($submenu['options-post.php'][10]); // General Options
  unset($submenu['options-post.php'][15]); // Writing
  unset($submenu['options-post.php'][20]); // Reading
  unset($submenu['options-post.php'][25]); // Discussion
  unset($submenu['options-post.php'][30]); // Media
  unset($submenu['options-post.php'][35]); // Privacy
  unset($submenu['options-post.php'][40]); // Permalinks
  unset($submenu['options-post.php'][45]); // Misc
  

}



// disable default dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');
function disable_default_dashboard_widgets() {

	remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}

	
// CUSTOM STYLING.

	
	add_action('admin_init', 'add_admin_stylesheet');
	/*Styling the WP Login Screen */
		function add_admin_stylesheet() {
		wp_enqueue_style('custom-admin.php', SIBSON_STYLE. '/olive/colours.css');
		wp_enqueue_style('custom-admin', SIBSON_STYLE. '/custom-admin.css');
	
	}



// CUSTOM SCRIPTING.

		add_action('admin_init', 'add_admin_scripts');

		function add_admin_scripts() {
	
		 wp_enqueue_script (  'admin-ajax.js' ,       // handle
                         SIBSON_SCRIPTS.'/admin-ajax.js');
		  wp_enqueue_script ( 'highcharts.js',  SIBSON_SCRIPTS.'/highcharts.js');
	
		
		
		}
	
	


// DASHBOARD
	
// Rename the dashboard	

add_action( 'admin_menu', 'change_dashboard_menu_label' );
function change_dashboard_menu_label() {
    global $menu;
    global $submenu;
    $menu[2][0] = 'Home';
 
 
    echo '';
}

 
	
// Add new dashboard widgets
	
add_action('wp_dashboard_setup', 'sibson_custom_dashboard_widgets');

 
function sibson_custom_dashboard_widgets() {
global $wp_meta_boxes;
global $subject;
global $type;
	$postHeading = "Quick ".ucFirst($subject)." Post";

wp_add_dashboard_widget( 'custom_quick_profile_widget', 'Profile', 'custom_dashboard_profile'); // Profile box.
add_meta_box( 'custom_navigation_widget', 'Navigation', 'custom_dashboard_navigation', 'dashboard', 'side', 'high' ); // Show buttons to navigate through.
wp_add_dashboard_widget( 'custom_quick_post_widget', $postHeading, 'custom_dashboard_quick_post'); // Profile box.

if ($subject=="person"){
	global $person;
	$groupTitle = $person->returnFirstName()."'s groups";

wp_add_dashboard_widget( 'custom_latest_updates_widget', 'All Posts', 'custom_latest_updates');


add_meta_box( 'custom_group_history_widget', $groupTitle, 'custom_dashboard_group_history', 'dashboard', 'side', 'high' );
add_meta_box( 'custom_comments_widget', 'Comment Counts', 'custom_dashboard_comment_counts', 'dashboard', 'side', 'high' );
	
}

else if ($subject=="group"){

wp_add_dashboard_widget( 'custom_latest_updates_widget', 'All Posts', 'custom_latest_updates');	
add_meta_box( 'custom_ethnicity_widget', 'Ethnicity', 'custom_dashboard_ethnicty', 'dashboard', 'side', 'high' );
}
else if ($subject=="maths"){
add_meta_box( 'custom_maths_widget', 'Maths', 'custom_dashboard_maths', 'dashboard', 'side', 'high' );
wp_add_dashboard_widget( 'custom_maths_stage_1_knowledge_widget', 'Knowledge', 'custom_stage_1_knowledge');
wp_add_dashboard_widget( 'custom_maths_stage_1_strategy_widget', 'Strategy', 'custom_stage_1_strategy');
wp_add_dashboard_widget( 'custom_maths_stage_2_knowledge_widget', 'Knowledge', 'custom_stage_2_knowledge');
wp_add_dashboard_widget( 'custom_maths_stage_2_strategy_widget', 'Strategy', 'custom_stage_2_strategy');

add_meta_box( 'custom_maths_select_widget', 'Select Stage', 'custom_dashboard_maths_select', 'dashboard', 'side', 'high' );

}
else if ($subject=="reading"){
add_meta_box( 'custom_reading_widget', 'Reading', 'custom_dashboard_reading', 'dashboard', 'side', 'high' );
wp_add_dashboard_widget( 'custom_latest_updates_widget', 'All Posts', 'custom_all_posts');

wp_add_dashboard_widget( 'custom_reading_level_widget', 'Goals', 'custom_level');
wp_add_dashboard_widget( 'custom_reading_level_1_widget', 'Goals', 'custom_level_1');


add_meta_box( 'custom_reading_select_widget', 'Select Level', 'custom_dashboard_reading_select', 'dashboard', 'side', 'high' );
}
else if ($subject=="writing"){
add_meta_box( 'custom_writing_widget', 'Writing', 'custom_dashboard_writing', 'dashboard', 'side', 'high' );
wp_add_dashboard_widget( 'custom_latest_updates_widget', 'All Posts', 'custom_all_posts');

wp_add_dashboard_widget( 'custom_writing_level_widget', 'Goals', 'custom_level');
wp_add_dashboard_widget( 'custom_writing_level_1_widget', 'Goals', 'custom_level_1');


add_meta_box( 'custom_reading_select_widget', 'Select Level', 'custom_dashboard_reading_select', 'dashboard', 'side', 'high' );
}
else if ($subject=="home"){
	if ($type == "person"){
	global $person;
			$groupTitle = $person->returnFirstName()."'s groups";
			wp_add_dashboard_widget( 'custom_latest_updates_widget', 'All Posts', 'custom_latest_updates');
			add_meta_box( 'custom_group_history_widget', $groupTitle, 'custom_dashboard_group_history', 'dashboard', 'side', 'high' );
			add_meta_box( 'custom_comments_widget', 'Comment Counts', 'custom_dashboard_comment_counts', 'dashboard', 'side', 'high' );
	}
	else if($type=="group"){
	
wp_add_dashboard_widget( 'custom_latest_updates_widget', 'All Posts', 'custom_latest_updates');	
add_meta_box( 'custom_ethnicity_widget', 'Ethnicity', 'custom_dashboard_ethnicty', 'dashboard', 'side', 'high' );	
	}
	
}
else {
	$heading = ucFirst($subject)." Posts";
	$descriptionHeading = ucFirst($subject);
wp_add_dashboard_widget( 'custom_latest_updates_widget', $heading, 'custom_all_posts');	

add_meta_box( 'custom_post_type_description_widget', $descriptionHeading, 'custom_post_type_description', 'dashboard', 'side', 'high' );
}

}



// POSTS (EDIT AMD ADD)

// Add the meta boxes to create all the navigation and hidden form elements.
add_action ('add_meta_boxes', 'custom_dashboard_navigation');
add_action ('add_meta_boxes', 'sibson_hidden_form_elements');

function sibson_hidden_form_elements(){ // These hidden widgets make sure that posts are asigned to the correct person.
	
	 add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'post' 
    );
	add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'sparkle' 
    );
	add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'thinker' 
    );
	add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'communicator' 
    );
	add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'dream_maker' 
    );
	add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'team_player' 
    );
	add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'reading' 
    );
	add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'writing' 
    );
	add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'maths' 
    );
	add_meta_box( 
        'sibson_sectionid',
        __( 'Hidden Form elements', 'sibson_textdomain' ),
        'sibson_inner_hidden_form_elements',
        'support' 
    );
	add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'general' 
    );
	 add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'sparkle' 
    );
	 add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'thinker' 
    );
	 add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'communicator' 
    );
	 add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'dream_maker' 
    );
	 add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'team_player' 
    );
	 add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'reading' 
    );
	 add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'writing' 
    );
	 add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'maths' 
    );
	 add_meta_box( 
        'sibson_profileid',
        __( 'Profile', 'sibson_textdomain' ),
        'sibson_profile',
        'support' 
    );
	
	
	
}

function sibson_inner_hidden_form_elements( $post ) { // When the post is saved the correct person id taxonomy is added. 

$term_list = wp_get_post_terms($post->ID, 'person_id', array("fields" => "all"));
	  		 foreach ($term_list as $p_id) {  
				$person_id =  $p_id->slug;
			 }

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'sibson_noncename' );

  // The actual fields for data entry
  echo '<label for="sibson_person_field">';
       _e("Hidden Person Id", 'sibson_textdomain' );
  echo '</label> ';
  echo '<input type="hidden" id="sibson_person_field" name="sibson_person_field" value="'.$person_id.'"/>';
}

function sibson_profile( $post ){
	
	echo "<div id='profile'>";

		global $type;
		global $subject;
			
	$term_list = wp_get_post_terms($post->ID, 'person_id', array("fields" => "all"));
	  		 foreach ($term_list as $p_id) {  
				$person_id =  $p_id->slug;
			 }
		
		if ($type== "person"){
		
		$person = new Person($person_id);
		
		echo "<div class='head'>";
		echo $person->showImage();
		echo "<h2>";
		echo $person->showName();
		echo "</h2>";
		echo $person->showBirthday();
		echo "<br />";
		
		echo $person->showAge();
		echo "</div>";
		echo '<ul id="profileMenu">';
		
		echo $person->showAdminLinks($subject);
		echo '</ul>';
		}
		else if ($type== "group"){
		
		$group = new Group($Id);
		echo "<div class='head'>";
		echo $group->showImage();
		echo "<h2>";
		echo $group->showGroupName();
		echo "</h2>";
		echo $group->showCount();
		echo "<br />";
		echo "</div>";
		echo '<ul id="profileMenu">';
		echo $group->showAdminLinks($subject);
		echo '</ul>';
		}
		
		
		echo "</div>";
	
	
	
}

/* Do something with the data entered */
add_action( 'save_post', 'sibson_save_postdata' );

function sibson_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['sibson_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions

    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  // OK, we're authenticated: we need to find and save the data

  $mydata = $_POST['sibson_person_field'];
	
	wp_set_post_terms( $post_id, $mydata, 'person_id', false ) ;


}
add_action( 'trash_post', 'sibson_redirect_on_trash' );

function sibson_redirect_on_trash(){

$location = 'post.php';
	
	wp_redirect( $location); exit ;
	

}




?>
