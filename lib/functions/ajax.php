<?php 
 

//Only allow logged in users to send an ajax request

// if logged in:
do_action( 'wp_ajax_' . $_POST['action'] );
do_action( 'wp_ajax_' . $_GET['action'] );



add_action( 'wp_ajax_myajax_fetch_register_list', 'myajax_fetch_register_list' );

function myajax_fetch_register_list() { 
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');

	$group = new Group(410);
	$idArray =$group->get_id_array();
	
	$date = date('Y-m-d H:i:s', strtotime($_POST['theDate']));
	
	register_list($idArray, $date, 'roll');
		
	// IMPORTANT: don't forget to "exit"
	die;
exit;
}

add_action( 'wp_ajax_fetch_standard_desc_confirmation', 'fetch_standard_desc_confirmation' );

function fetch_standard_desc_confirmation(){
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');	

$checkUser = sibson_check_user_can_ajax();

if ($checkUser<7){	
die;
}



// $current_user = wp_get_current_user();
// $user_id = $current_user->ID;;	
// $userdata = get_userdata( $user_id );

// if( $userdata->user_level<7) die ('Sorry there was a problem, please try again later!');	

$id = absint($_POST['id']);
$subject = $_POST['subject'];
$value = $_POST['value'];
$adjustedValueForLookup = $value+1;


$person = new Person($id);

	 $assessment = new Assessment( $id, $subject, 'individual');
	$levelArray = $assessment->get_subject_data_array();
	
echo "<p>You are about to record that ";
echo $person->returnFirstName();
echo " is working at ";
echo $levelArray[$value];
echo " of the curriuclum</p>";

 $assessment->standardStatement($person->showCurrenYearLevelforNatStandards(), $adjustedValueForLookup, $person->returnFirstName(), $person->returnPronoun('she'));

		echo '<a href="#" id="confirm_save" data-role="button" data-theme="b" data-inline="true" >Yes</a>'; 
						echo '<a href="#" id="close_confirm" data-role="button" data-theme="b" data-inline="true" >No</a>'; 

// IMPORTANT: don't forget to "exit"
	die;
exit;	
}

add_action( 'wp_ajax_ajax_search_group', 'ajax_search_group' );

function ajax_search_group() { 
if( ! wp_verify_nonce( $_GET['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
global $wpdb;
$year = date('Y');
		$s = stripslashes( $_GET['q'] );
	
		if ( false !== strpos( $s, ',' ) ) {
			$s = explode( ',', $s );
			$s = $s[count( $s ) - 1];
		}
		$s = trim( $s );
		if ( strlen( $s ) < 2 )
			die; // require 2 chars for matching
	
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT wp_groups.wp_group_id, 
					wp_groups.wp_user_id, 
					wp_groups.room, 
					wp_groups.year, 
					wp_groups.type, 
					wp_groups.group_name, 
					wp_groups.Team, 
					wp_groups.team_order, 
					wp_groups.YearGroup, 
					wp_users.display_name
				FROM wp_groups 
					 INNER JOIN wp_users ON wp_groups.wp_user_id = wp_users.ID
				 WHERE year = $year and group_name  LIKE (%s) LIMIT 20", '%' . like_escape( $s ) . '%' ) );
	
	
$idArray= array();
foreach($results as $group):
echo "<li>";
			$profile_image = wp_get_attachment_image($profile_image_id, 'thumb');
sibson_link_badge( $profile_image, '?type=Group&accessId='.$group->wp_group_id, $group->group_name." (".$group->year.")" );
echo "</li>";
endforeach;


		
	// IMPORTANT: don't forget to "exit"
	die;
exit;
}
add_action( 'wp_ajax_ajax_search_people', 'ajax_search_people' );

function ajax_search_people() { 
if( ! wp_verify_nonce( $_GET['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
global $wpdb;
		$s = stripslashes( $_GET['q'] );
	
		if ( false !== strpos( $s, ',' ) ) {
			$s = explode( ',', $s );
			$s = $s[count( $s ) - 1];
		}
		$s = trim( $s );
		if ( strlen( $s ) < 2 )
			die; // require 2 chars for matching
	
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT wp_person_id, first_name, last_name FROM wp_people WHERE wp_people.vacated = 0 and first_name LIKE (%s) LIMIT 20", '%' . like_escape( $s ) . '%' ) );
	
	
$idArray= array();
foreach($results as $personId):

echo "<li class='nameBadge'><a href='?accessId=".$personId->wp_person_id."' rel='external'>".$personId->first_name." ".$personId->last_name."</a></li>";

endforeach;

		
	// IMPORTANT: don't forget to "exit"
	die;
exit;
}

add_action( 'wp_ajax_ajax_people_by_alphabet', 'ajax_people_by_alphabet' );

function ajax_people_by_alphabet() { 
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
global $wpdb;
$letter = $_POST['letter'];
		
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM wp_people WHERE first_name LIKE %s and vacated = 0 ORDER BY first_name", $letter.'%') );
	
	
$idArray= array();
foreach($results as $personId):

$badgeArray = array(
		'id' =>$personId->wp_person_id, 
		'image'=> '', 
		'name' => $personId->first_name." ".$personId->last_name,
		'selectable'=> true,
		'theme' => ''
		);
	
			
			
		sibson_badge_from_array($badgeArray);

endforeach;

		
	// IMPORTANT: don't forget to "exit"
	die;
exit;
}

add_action( 'wp_ajax_ajax_search_selectable', 'ajax_search_selectable' );

function ajax_search_selectable() { 
if( ! wp_verify_nonce( $_GET['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
global $wpdb;
		$s = stripslashes( $_GET['q'] );
	
		if ( false !== strpos( $s, ',' ) ) {
			$s = explode( ',', $s );
			$s = $s[count( $s ) - 1];
		}
		$s = trim( $s );
		if ( strlen( $s ) < 2 )
			die; // require 2 chars for matching
	
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT wp_person_id, first_name, last_name FROM wp_people WHERE wp_people.vacated = 0 and first_name LIKE (%s) LIMIT 20", '%' . like_escape( $s ) . '%' ) );
	
	
$idArray= array();
foreach($results as $personId):

echo "<li class='nameBadge'><a href='#' class=' selectable ' data-name='".$personId->first_name." ".$personId->last_name."' data-personid='".$personId->wp_person_id."'>".$personId->first_name." ".$personId->last_name."</a></li>";

endforeach;

		
	// IMPORTANT: don't forget to "exit"
	die;
exit;
}




add_action( 'wp_ajax_ajax_fetch_auto_group', 'ajax_fetch_auto_group' );

function ajax_fetch_auto_group() { // Fetch a clickable list of people based on the parameters passed by the POST variable.
	// get the submitted parameters to call a list 
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
$id = $_POST['typeid'];
$type = $_POST['type'];
$subject = $_POST['subject'];

		$group = new AutoStudentList($id, $type, "'".$subject."'");
		
	

echo $group->showList();

	// IMPORTANT: don't forget to "exit"
	die();
exit;
}

add_action( 'wp_ajax_ajax_fetch_group_indicator', 'ajax_fetch_group_indicator' );

function ajax_fetch_group_indicator() { // Fetch a clickable list of people based on the parameters passed by the POST variable.
	// get the submitted parameters to call a list 
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
$group_id = absint($_POST['groupId']);
$indicator_id = absint($_POST['theId']);

$assessment = new Assessment($group_id, '', 'group');
$assessment->show_indicator_detail($indicator_id);
$list = $assessment->get_people_workingon_indicator($indicator_id);
	// IMPORTANT: don't forget to "exit"
	die();
exit;
}





add_action( 'wp_ajax_myajax_insert_or_edit_post', 'myajax_insert_or_edit_post' );

function myajax_insert_or_edit_post() {
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// get the submitted parameters
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$firstname = $current_user->user_firstname;
	$content = $_POST['content'];
	$profile_image = $current_user->profile_image_url;
	$type = $_POST['type'];
	if ($type=="group"|| $type=="person"){
	$type = "general";	
	}
	$postID = $_POST['thePostId'];
	$person = new Person($_POST['id']);
	$name = $person->returnFirstName();
	
		if ($person->gender == "Male"){
		$find = array("/NAME/", "/She /", "/ she /", "/Her /", "/ her /", "/ her /");
		$replace = array ($name, "He ", " he ", "His ", " his ", " him ");
		}
		else {
		$find = array("/NAME/", "/He /", "/ he /", "/His /", "/ his /", "/ him /");
		$replace = array ($name, "She ", " she ", "Her ", " her ", " her ");
		}
		

$newContent = preg_replace($find, $replace, $content);
	
if ($postID > 0){
	 $my_post = array(
	 'ID' => $postID,
     'post_title' => $name,
     'post_content' => $newContent,
     'post_status' => 'publish',
     'post_author' => $user, 
	 'post_type' => $type
  );

// Insert the post into the database
wp_update_post( $my_post );
}
	else {
	
	// Create post object
  $my_post = array(
     'post_title' => $name,
     'post_content' => $newContent,
     'post_status' => 'publish',
     'post_author' => $user, 
	 'post_type' => $type
  );

// Insert the post into the database
 $postId = wp_insert_post( $my_post );
 
//Gather the tags to tag the post correctly 
 $tags = array($_POST['id']);
 $taxonomy = 'person_id';
 //Tag the new post
wp_set_post_terms( $postId, $tags, $taxonomy );

}


$this_post = get_post($postId); 

	$post_id = $this_post->ID;
		$term_list = wp_get_post_terms($post_id, 'person_id', array("fields" => "all"));
	  		 foreach ($term_list as $p_id) {  
				$person_id =  $p_id->slug;
				$label = $p_id->name;
			}

			$the_date = date('F j, Y', strtotime($this_post->post_date)); 
			$cats = wp_get_post_categories( $post_id ); 
			$catSlug = $cats[0]['slug'];
			$catName = $cats[0]['name'];
			$the_content = $this_post->post_content;
			
			
sibson_show_post($post_id, $person_id, $label, $the_date, $catSlug, $catName, $the_content, $profile_image );

 	die();
exit;
}


add_action( 'wp_ajax_myajax_ajax_remove_post', 'myajax_ajax_remove_post' );

function myajax_ajax_remove_post() {
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// get the submitted parameters
	$postid = absint($_POST['id']);
	wp_delete_post( $postid, true );
	
die();
exit;
}

add_action( 'wp_ajax_myajax_ajax_remove_group', 'myajax_ajax_remove_group' );

function myajax_ajax_remove_group() {
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// get the submitted parameters
	$groupid = absint($_POST['id']);
	global $wpdb;
	
	$wpdb->query($wpdb->prepare(
	"
	DELETE FROM wp_groups 
	WHERE wp_group_id = %d
	", $groupid)
);
$wpdb->query($wpdb->prepare(
	"
	DELETE FROM wp_group_relationships
	WHERE wp_group_id = %d
	", $groupid)
);

	
die();
exit;
}





add_action( 'wp_ajax_myajax_add_comment', 'myajax_add_comment' );

function myajax_add_comment() {
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	
	
	 $nonce = $_POST['nonce'];
 
    // check to see if the submitted nonce matches with the
    // generated nonce we created earlier
    if ( ! wp_verify_nonce( $nonce, 'myajax-post-comment-nonce' ) )
        die ( 'Busted!');
		
		
	echo "djklhdl";
	
die();
exit;
}






add_action( 'wp_ajax_myajax_insert_or_edit_post_remote', 'myajax_insert_or_edit_post_remote' );

function myajax_insert_or_edit_post_remote() {
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// get the submitted parameters
	
	$content = $_POST['content'];
	$title = $_POST['title'];
	$name = "";
	$postID = $_POST['thePostId'];
	$urlBase = $_POST['url'];
	$fullURL = "http://".$urlBase.".fendalton.school.nz/xmlrpc.php";
	
	
	include_once(ABSPATH . WPINC . '/class-IXR.php');
	$rpc = new IXR_Client('http://esol.fendalton.school.nz/xmlrpc.php');

		$post = array(
			 'title' => $title,
			'categories' => array(),
			'mt_keywords' => '',
			'description' => $content,
			'wp_slug' => 'post-slug'
		  );
		
		$params = array(
			0,
			'Pauls',
			'197854_Ps',
			$post,
			'publish'
		);
		
		$status = $rpc->query(
			'metaWeblog.newPost',
			$params
		);
		
		if(!$status) {
			echo 'Error [' . $rpc->getErrorCode() . ']: ' . $rpc->getErrorMessage();
			exit();
		}
		else {
		
		echo '<p class="updated">'.$rpc->getResponse().'</p>';	
			
		}
	
die();
exit;
}


add_action( 'wp_ajax_ajax_get_blog_list', 'ajax_get_blog_list' );

function ajax_get_blog_list() {
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	global $current_user;
	get_currentuserinfo();
	
	$blogs = get_user_meta($current_user->ID, 'remote_blogs', true); // Get list of blogs that the user has an account for.
	$blogList = explode(",", $blogs);
	echo "<div class='spacer'>&nbsp;</div>";
	echo '<ul>';
	for ($i=0; $i<count($blogList); $i++){
		$id = $blogList[$i];
		$testImageURL = SIBSON_IMAGES."/".$id.".png";
			if (fopen($testImageURL, "r")){// test to see if the image exists on the server.
		$image ="<img src='".$testImageURL."' class='badgeImage'>";
			}
		else {
		$image ='';	
		}
		$title = $blogList[$i].' blog.';
		$detail = 'Public blog.';
		
	sibson_badge($id, $image, $title, array($detail), false, true);

		
	}
	echo '</ul>';
	echo "<div class='spacer'>&nbsp;</div>";
	echo '<input type="button" value="Save" id="savePostRemote" class="button-primary"/><input type="button" value="Cancel" id="closeForm" class="button-secondary"/><div id="feedback"></div>';
	// IMPORTANT: don't forget to "exit"
	die();
exit;
}


add_action( 'wp_ajax_ajax_get_group_list', 'ajax_get_group_list' );

function ajax_get_group_list() {
	// get the submitted parameters

if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
global $current_user;
	get_currentuserinfo();
	
	if ($_POST['query']){
	
	if($_POST['query']=="new_entrants"){
	$query = "and team = 'New Entrants'";	
	}
	else if($_POST['query']=="year_two"){
	$query = "and team = 'Year 2'";	
	}
	else if($_POST['query']=="senior"){
	$query = "and team = 'Senior'";	
	}
	
	else if($_POST['query']=="middle"){
	$query = "and team = 'Middle'";	
	}
	
	$type = '';	
	}
	else {
	$query = "";
	$type = "groups";		
	}
	
$list = new GroupList($current_user->ID, $type, $query );


echo $list->menuList('true');

	// IMPORTANT: don't forget to "exit"
	die();
exit;
}

add_action( 'wp_ajax_ajax_get_nav_group_list', 'ajax_get_nav_group_list' );

function ajax_get_nav_group_list() {
	// get the submitted parameters

if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
global $current_user;
	get_currentuserinfo();
	
	if ($_POST['query']){
	
	if($_POST['query']=="new_entrants"){
	$query = "and team = 'New Entrants'";	
	}
	else if($_POST['query']=="year_two"){
	$query = "and team = 'Year 2'";	
	}
	else if($_POST['query']=="senior"){
	$query = "and team = 'Senior'";	
	}
	
	else if($_POST['query']=="middle"){
	$query = "and team = 'Middle'";	
	}
	
	$type = '';	
	}
	else {
	$query = "";
	$type = "groups";		
	}
	
$list = new GroupList($current_user->ID, $type, $query );


echo $list->menuList('link');

	// IMPORTANT: don't forget to "exit"
	die();
exit;
}




add_action( 'wp_ajax_ajax_get_selectable_list', 'ajax_get_selectable_list' );

function ajax_get_selectable_list() {
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// get the submitted parameters

$isSelectable = $_POST['isSelectable'];
$groupid = $_POST['theId'];
	
$list = new StudentList($groupid);

if ($isSelectable== 'false'){
echo $list->menuList();	
}
else {
echo $list->selectList();
}
	// IMPORTANT: don't forget to "exit"
	die();
exit;
}

add_action( 'wp_ajax_myajax_fetch_menu_items', 'myajax_fetch_menu_items' );

function myajax_fetch_menu_items() {

if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');	// get the submitted parameters

global $current_user;
	get_currentuserinfo();
	
	if ($_GET['query']){
	
	if($_GET['query']=="new_entrants"){
	$query = "and team = 'New Entrants'";	
	}
	else if($_GET['query']=="year_two"){
	$query = "and team = 'Year 2'";	
	}
	else if($_GET['query']=="senior"){
	$query = "and team = 'Senior'";	
	}
	
	else if($_GET['query']=="middle"){
	$query = "and team = 'Middle'";	
	}
	
	$type = '';	
	}
	else {
	$query = "";
	$type = "groups";		
	}
	
$list = new GroupList($current_user->ID, $type, $query );


echo $list->jsonList();

	
	die();
exit;
}

add_action( 'wp_ajax_ajax_get_team_profile', 'ajax_get_team_profile' );

function ajax_get_team_profile() {
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	$query = $_POST['query'];
	
$list = new Group($query );


echo $list->jsonList();

	
	die();
exit;
}

add_action( 'wp_ajax_ajax_get_group_profile', 'ajax_get_group_profile' );

function ajax_get_group_profile() {
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	$GroupId =$_POST['id'];	
$group = new Group($GroupId);

echo "<h2>";
echo $group->showGroupName();
echo "</h2>";

	
	die();
exit;
}

add_action( 'wp_ajax_ajax_get_person_profile', 'ajax_get_person_profile' );

function ajax_get_person_profile() {
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	$Id =$_POST['id'];	
$person = new Person($Id);
echo $person->showImage();
echo "<h2>";
echo $person->showName();
echo "</h2>";
echo $person->showBirthday();
echo "<br />";

echo $person->showAge();

	
	die();
exit;
}

add_action( 'wp_ajax_ajax_get_group_posts', 'ajax_get_group_posts' );

function ajax_get_group_posts() {
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
$GroupId =$_POST['id'];	
$group = new Group($GroupId);

$tagArray =implode(',',$group->get_tag_array()) ;

echo '<ul>';
$the_query = new WP_Query( array( 
		'post_type' => array( 'post', 'sparkle', 'thinker', 'team_player', 'communicator', 'reading', 'writing', 'maths','dream_maker'),
		'tax_query' => array(
		array(
			'taxonomy' => 'person_id',
			'field' => 'slug',
			'terms' => $group->get_tag_array()
			)
		)
	) 
);
while ( $the_query->have_posts() ) : $the_query->the_post();
$post_id = get_the_ID();
$image = get_the_image_by_scan($post_id);

echo '<li>';
echo '<a class="open-dialog" data-dialog="post" data-id="'.get_the_ID().'" href="#">';
the_title();
echo '</a>';
echo '<span class="rss-date">';
the_date();
echo '</span>';
echo '<div class="rssSummary">';
echo "<img src='";
echo  $image['src'];
echo "' />";
 the_excerpt();
echo '</div></li>';
endwhile;

// Reset Post Data
wp_reset_postdata();
echo '</ul>';

	
	die();
exit;
}

add_action( 'wp_ajax_ajax_get_person_posts', 'ajax_get_person_posts' );

function ajax_get_person_posts() {

$Id =$_POST['id'];	
if ($_POST['subject']){
	
	$subject = $_POST['subject'];
$the_query = new WP_Query( array( 
		'post_type' => array( $subject),
		'tax_query' => array(
		array(
			'taxonomy' => 'person_id',
			'field' => 'slug',
			'terms' => $Id
			)
		)
	) 
);	
	
}
else {
	
$the_query = new WP_Query( array( 
		'post_type' => array( 'post', 'sparkle', 'thinker', 'team_player', 'communicator', 'reading', 'wirting', 'maths','dream_maker'),
		'tax_query' => array(
		array(
			'taxonomy' => 'person_id',
			'field' => 'slug',
			'terms' => $Id
			)
		)
	) 
);	
	
	
}

echo '<div id="dialog"></div>';
    echo '<div id="latestposts">';
echo '<ul class="post_list">';

while ( $the_query->have_posts() ) : $the_query->the_post();
$post_id = get_the_ID();
$image = get_the_image_by_scan($post_id);
			
			echo '<li>';		
			echo  '<span class="avatar">';
			echo '<img src="'.SIBSON_UPLOADS. get_the_author_meta('profile_image_url').'"  />';
			echo ' </span>';
			echo '<span class="post_author"><a href="#" class="open-dialog" data-id="'.$post_id.'" >';
			the_author_meta('first_name');
			echo " ";
			the_author_meta('last_name'); 
			echo '</a></span>';
			echo '<span class="post_time">';
			the_date(); 
			echo '</span>';                                                                       
			echo '<span class="icon">';
			$category = get_the_category();
			echo '<img src="'.SIBSON_IMAGES.'/'.$category[0]->slug.'.png" alt="'. $category[0]->name.'" title="'. $category[0]->name.'" />';
			echo '</span>';
			echo '<span class="content">';
			if ($image){
			echo "<img src='";
			echo $image['src'];
			echo "' />";	
			}
			the_content();
			echo '<span>';
			echo '</li>';


endwhile;

// Reset Post Data
wp_reset_postdata();
echo '</ul>';
echo '</div>';
	
	die();
exit;
}

add_action( 'wp_ajax_ajax_show_post', 'ajax_show_post' );

function ajax_show_post() {
if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	$postid =$_POST['id'];	


$post = get_post($postid); 
echo  $post->post_content;
$category = get_the_category($postid); 

$tag  = wp_get_post_terms( $post->ID, 'person_id', array("fields" => "names") ) ;

$title = $tag[0]." - ".$category[0]->cat_name;
?>
<script>	jQuery('#dialog').dialog( "option", "title", '<?php echo $title;?>' ); </script>
<?php

	
	die();
exit;
}


add_action( 'wp_ajax_ajax_get_indicator_list', 'ajax_get_indicator_list' );

function ajax_get_indicator_list() {
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	$subject = $_POST['theSubject'];
	$id= $_POST['theId'];
	$level = $_POST['theLevel'];
	$type = $_POST['theType'];
	
$assessment = new Assessment($id, $subject, 'individual');
  echo "<form data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$id."&pageType=".$subject."&formType=goal_setting' id='goal_setting' method='post' >";		
									  sibson_form_nonce('goal_setting');	
									 echo '<input type="hidden" id="personId" name="personId" value="'.$id.'" />';
									  echo '<input type="hidden" id="assessment_subject" name="assessment_subject" value="'.$subject.'" />';
									 
									 echo $assessment->get_indicatorlist($level, $type);	
									 
									   echo '<input type="submit" value="Save Changes" data-theme="b" data-inline="true" />';
									  
									   echo '</form>';

	
		die();
exit;
}

add_action( 'wp_ajax_ajax_fetch_child_detail', 'ajax_fetch_child_detail' );

function ajax_fetch_child_detail() {
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	$id= $_POST['Id'];
	
	
$person = new Person($id);

 $person->showFullPersonDetails();	
	
		die();
exit;
}





add_action( 'wp_ajax_ajax_fetch_group_show_children_by_indicator', 'ajax_fetch_group_show_children_by_indicator' );

function ajax_fetch_group_show_children_by_indicator() {
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	$id= $_POST['Id'];
	$indicatorid = $_POST['indicatorid'];

	
$group = new Group($id);

echo "<p><strong>";
show_indicator($indicatorid);
echo "</strong></p>";
echo "<p>Click on the children to set a target or set as complete.";
sibson_show_indicator_key();
echo "</p>";

echo $group->indicator_badge_list($indicatorid);	

echo "<div class='spacer'></div>";
echo '<a href="?accessId='.$id.'&type=Group&teachingId='.$indicatorid.'&pageType=teaching" data-ajax="false" data-role="button" data-theme="b" class="ui-btn ui-btn-up-b ui-corner-all"><span class="ui-btn-inner" aria-hidden="true"><span class="ui-btn-text">Click here for Teaching Ideas</span></span></a>';

	
		die();
exit;
}

add_action( 'wp_ajax_ajax_get_group_indicator_list', 'ajax_get_group_indicator_list' );

function ajax_get_group_indicator_list() {
	
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	$subject = $_POST['theSubject'];
	$id= $_POST['theId'];
	$level = $_POST['theLevel'];
	$type = $_POST['theType'];
	
$assessment = new Assessment($id, $subject, 'group');

echo "<div class='level'>";
echo "Stage ".$level;
echo "</div>";

echo $assessment->get_group_indicatorlist($level);	
	
		die();
exit;
}


add_action( 'wp_ajax_update_indicator', 'update_indicator' );

function update_indicator(){
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	
	$personId = $_POST['personId'];
	
	$Id = $_POST['Id'];
	$update = $_POST['update'];
	$Id = $_POST['Id'];
	$current_Date = date('Y-m-d H:i:s');
	$month = date('M');
	$day = date ('d');
	$cycleArray = sibson_get_current_cycle();
	$cycle =  $cycleArray[0]['currentId'];
	global $wpdb;

	$result = $wpdb->update( 'wp_assessment_data', array( 'area' => $update, 'date' => $current_Date), array('assessment_value' => $Id, 'person_id'=>$personId));
	
	
	
	 if ($result){
		 if ($update=="secure"){ 
		echo 'Saved';
	
		 }
		 else if ($update =="developing"){
				echo 'Saved';
		
			 
		 }
	 };
	 
	
	 
	 // IMPORTANT: don't forget to "exit"
	die();
exit;
	
}

add_action( 'wp_ajax_insert_indicator', 'insert_indicator' );

function insert_indicator(){
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	
	$personId = $_POST['personId'];

	$Id = $_POST['Id'];
	$update = $_POST['update'];
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');	
	$cycleArray = sibson_get_current_cycle();
	$cycle =  $cycleArray[0]['currentId'];
	global $wpdb;
$assessmentSubject = $wpdb->get_var("SELECT
	assessment_subject
FROM wp_assessment_terms
where ID = $Id");

	// $result = $wpdb->insert( 'wp_assessment_data', array( 'person_id' => $personId, 'assessment_subject' => $assessmentSubject, 'assessment_value' => $Id, 'user_id'=> $user, 'date'=> $current_Date, 'area' => $update, 'cycle' =>$cycle ));
	
$result = $wpdb->query( $wpdb->prepare( 
	"
		INSERT INTO wp_assessment_data
		( person_id, assessment_subject, assessment_value, user_id, date, area, cycle )
		VALUES ( %d, %s, %d, %d, %s, %s, %d )
	", 
        array(
		$personId, 
		$assessmentSubject, 
		$Id,
		$user,
		$current_Date,
		$update,
		$cycle
		) 
		) ); 
	
	if ($result){
	echo " Saved";
	}
	 
	 // IMPORTANT: don't forget to "exit"
	die();
exit;
	
}

add_action( 'wp_ajax_myajax_update_cycle_data', 'myajax_update_cycle_data' );


// Function to update the overall teacher judgement. This is calculated based on a formula that has been agreed by the school.

function myajax_update_cycle_data(){
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// Gather the data being sent via url query string.
	
	$personId = $_POST['personId'];
	$Subject = $_POST['Subject'];
	$update ='OTJ';
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');
	
	
	// Find out what the current assessment cycle is.
	$cycle = sibson_get_current_cycle();
	$thisCycle = $cycle[0]['currentId'];
	

	global $wpdb;

$assessment= new Assessment($personId, $Subject);
//Find out the last data saved for this person and this subject


	$currentPercent = round($assessment->get_updated_level_data(),0);
	
// Check to see if a value already exists for this person and this cycle.
	  
	 $check = $wpdb->get_row($wpdb->prepare("SELECT ID, assessment_value from wp_assessment_data where person_id = %d and cycle = $thisCycle and assessment_subject= %s and area ='OTJ'", $personId, $Subject));

// If it does then update it.
	
	
	if ($check){
		
		$existingValue = $check->assessment_value;
		$ID = $check->ID;
		if ($existingValue == $currentPercent){
			
			//Do nothing if the current assessment data is the same as the newly calculated one.
			
		}
		
// If is different then update the db with the new value.
		
		else {
			 $result = $wpdb->update( 'wp_assessment_data', array(  'assessment_value' => $currentPercent), array('ID' => $ID));
		}
		
	}
	
// If no data exists for this person and cycle then insert it.	
	else {
	// $result = $wpdb->insert( 'wp_assessment_data', array( 'person_id' => $personId, 'assessment_subject' => $Subject, 'assessment_value' => $currentPercent, 'cycle'=> $thisCycle,'user_id'=> $user, 'date'=> $current_Date, 'area' => $update ));
	$result = $wpdb->query( $wpdb->prepare( 
	"
		INSERT INTO wp_assessment_data
		( person_id, assessment_subject, assessment_value, user_id, date, area, cycle )
		VALUES ( %d, %s, %d, %d, %s, %s, %d )
	", 
        array(
		$personId, 
		$Subject, 
		$currentPercent,
		$user,
		$current_Date,
		$update,
		$thisCycle
		) 
		) ); 
	
	}
	 
	 echo $currentPercent;
	
	 // IMPORTANT: don't forget to "exit"
	die();
exit;
	
}


//Dialog loads
add_action( 'wp_ajax_ajax_fetch_dialog_content', 'ajax_fetch_dialog_content' );


// Function to update the overall teacher judgement. This is calculated based on a formula that has been agreed by the school.

function ajax_fetch_dialog_content(){
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// Gather the data being sent via url query string.
	
	$type = $_POST['theType'];
		$id = $_POST['theId'];
		$pageType = $_POST['thePageType'];
		$classType = $_POST['theClassType'];
		$post_id = $_POST['post_id'];	
	
	switch ($type){
		
	case "stuff";
		  
		echo '<div data-role="content" id="dialog_content" >';
								  
						
			
		$mail = "<img src='".SIBSON_IMAGES."/mail.png' class='badgeImage'>";
		$Calendar = "<img src='".SIBSON_IMAGES."/Calendar.png' class='badgeImage'>";
		$enrolment = "<img src='".SIBSON_IMAGES."/enrolment.png' class='badgeImage'>";
		$group = "<img src='".SIBSON_IMAGES."/groups_head.png' class='badgeImage'>";
		echo '<ul>';
			echo '<li>';
			sibson_link_badge( $mail, 'https://mail.google.com', 'Mail'); 
			echo '</li>';
			echo '<li>';
			sibson_link_badge( $Calendar, 'https://www.google.com/calendar/', 'Calendar'); 
			echo '</li>';
			echo '<li>';
			sibson_badge(34, $group, 'New Group' , array(), true, false, '','data-title="Create a new group" data-dialogtype="groupform"', 'loaddialog'); 
			echo '</li>';
			$current_user = wp_get_current_user();
	$userId = $current_user->ID;
	$userdata = get_userdata( $userId );
	$user_level =$userdata->user_level;
			if ($user_level==10){
			echo '<li>';
			sibson_badge(34, $enrolment, 'New Enrolment' , array(), true, false, '','data-title="New Enrolment Form" data-dialogtype="enrolment"', 'loaddialog'); 
			echo '</li>';
			}
			
			
			echo '</ul>';
	echo '</div>';
		break;
		
		case "people";
	
						
			echo '<div data-role="fieldcontain">';
		
		
			echo '<input type="search" id="searchBox" name="search" value="" />';
			echo '</div>';
		
			if ($classType=="Group"){
				$group = new Group($id);
				}
				else if ($classType=="Person") {
				 $person= new Person($id);	
				
				$groupid = $person->currentClass();	
				
				$group = new Group($groupid);	
				
				}
		$idArray = $group->get_id_array();
		echo "<ul id='badgeList'>";
		foreach ($idArray as $pId){
		
		$pers = new Person($pId);
		$pers->showBadge();	
		
		}
		echo '</ul>';
		
		break;
		case "groups";
		
			echo '<div data-role="fieldcontain">';
			echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
		
					echo '<a href="#" data-theme="b" class="loaddialog" data-dialogtype="mygroups" data-role="button">My Groups</a>';
					echo '<a href="#" data-theme="a" class="loaddialog" data-role="button" data-dialogtype="groups">Classes</a>';
		
		echo '</div>';
			echo '</div>';
				$list = new GroupList();
				
		echo $list->badgeList(); 
		break;
		
		case "mygroups";
			echo '<div data-role="fieldcontain">';
			echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
		
					echo '<a href="#" data-theme="a" class="loaddialog" data-dialogtype="mygroups" data-role="button">My Groups</a>';
					echo '<a href="#" data-theme="b" class="loaddialog" data-role="button" data-dialogtype="groups">Classes</a>';
		
		echo '</div>';
			echo '</div>';
			$current_user = wp_get_current_user();
$userId = $current_user->ID;
				$list = new GroupList($userId , 'groups');
				echo $list->badgeList(); 
				
		break;
			case "delete";
		
			echo "<p>Are you sure you want to delete this?</p>";
						echo "<input type='hidden' id='delete_post_id' value='$post_id' />";
						echo "<a href='#' data-role='button' class='button' data-inline='true' id='confirm_delete' data-theme='b'>Yes, delete it!</a>";
		break;
			case "deleteGroup";
		
			echo "<p>Are you sure you want to delete this Group?</p>";
						echo "<input type='hidden' id='delete_group_id' value='$post_id' />";
						echo "<a href='#' data-role='button' class='button' data-inline='true' id='confirm_delete_group' data-theme='b'>Yes, delete it!</a>";
		break;
			case "write";
			
		
			if ($pageType == "groups"){  
								  $form_type = 'new_group';
						}
						else {
								   $form_type = 'new_post';
						}
								echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$id."&pageType=".$pageType."&formType=".$form_type."' id='post_form' method='post' enctype='multipart/form-data'>";
								echo '<input type="hidden" id="existing_post_id" name="existing_post_id" value="'.$post_id.'" />';
								echo '<input type="hidden" id="post_author" name="post_author" value="'.$post->post_author.'" />';
								
								sibson_form_nonce('post_form');
								
								if ($pageType == "groups"){
									sibson_create_group_form($id);
								}
								else {
								
								sibson_form_post_type_select( $pageType);
								
								
								sibson_form_subject_select($pageType, $classType);
														
						
								sibson_text_area(	$_POST['desc'],  $id, $pageType);
								
								sibson_refer($pageType);	// add a referal page if the page type calls for it.
								
								sibson_form_upload();
							
							if($pageType=="goals"){
								sibson_form_staff_publish();
							}
							else {
								sibson_form_publish();
							}
								
								
								}
								echo "</form>"; 
		break;
			case "edit";
			
			$post = get_post($post_id);
			$cat = get_the_category( $post_id );
			
	
			
			if ($pageType == "groups"){  
								  $form_type = 'new_group';
						}
						else {
								   $form_type = 'new_post';
						}
								echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$id."&pageType=".$pageType."&formType=".$form_type."' id='post_form' method='post' enctype='multipart/form-data'>";
								echo '<input type="hidden" id="existing_post_id" name="existing_post_id" value="'.$post_id.'" />';
								echo '<input type="hidden" id="post_author" name="post_author" value="'.$post->post_author.'" />';
								echo '<input type="hidden" id="post_title" name="post_title" value="'.$post->post_title.'" />';
								echo '<input type="hidden" id="indicator_type" name="indicator_type" value="'.$_POST['indtype'].'" />';
								
								
								sibson_form_nonce('post_form');
								
								if ($pageType == "groups"){
									sibson_create_group_form($id);
								}
								else {
								
								
								sibson_form_post_type_select( $pageType, $post->post_type);
								
								
								sibson_form_subject_select($pageType, $cat[0]->category_nicename);
														 
						
								sibson_text_area($post->post_content,  $id, $pageType);
								sibson_form_upload();
							
								sibson_form_publish($post->post_date);
								}
								echo "</form>"; 
		break;
		case "document";
		$checkType = explode("type=", $_SERVER['HTTP_REFERER']);
			$check = $checkType[1];
		
								  $form_type = 'new_document';
								  $desc = $_POST['desc'];
								    $cat = $_POST['title'];
						
						if ( substr($check, 0, 5)=="Group"){
										echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$desc."&type=Group&teachingId=".$id."&pageType=teaching&formType=".$form_type."' id='post_form' method='post' enctype='multipart/form-data'>";
								echo '<input type="hidden" id="existing_post_id" name="existing_post_id" value="'.$post_id.'" />';
				echo '<input type="hidden" id="is_group" name="is_group" value="true" />';
			}
						
						else {
								echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$desc."&teachingId=".$id."&pageType=teaching&formType=".$form_type."' id='post_form' method='post' enctype='multipart/form-data'>";
						}
								echo '<input type="hidden" id="person_id" name="person_id" value="'.$desc.'" />';
								echo '<input type="hidden" id="indicator_id" name="indicator_id" value="'.$id.'" />';
								echo '<input type="hidden" id="category" name="category" value="'.$pageType.'" />';
								
						
								
							
								sibson_form_nonce('post_form');
							
								sibson_form_upload('', true);
								
								echo "</form>"; 
		break;
		
		
			case "teachingIdea";
			$checkType = explode("type=", $_SERVER['HTTP_REFERER']);
			$check = $checkType[1];
			
			$post = get_post($post_id);
			$terms = wp_get_post_terms( $post_id, 'indicator',array("fields" => "names") );
			$teachingId =sibson_fetch_indicator_by_target ( $terms[4]);
			 $desc = $_POST['desc'];
			
								  $form_type = 'new_post';
						
							
								if ( substr($check, 0, 5)=="Group"){
										echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$desc."&type=Group&teachingId=".$id."&pageType=teaching&formType=".$form_type."' id='post_form' method='post' enctype='multipart/form-data'>";
								echo '<input type="hidden" id="existing_post_id" name="existing_post_id" value="'.$post_id.'" />';
				echo '<input type="hidden" id="is_group" name="is_group" value="true" />';
			}
			else {
				echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$desc."&teachingId=".$id."&pageType=teaching&formType=".$form_type."' id='post_form' method='post' enctype='multipart/form-data'>";
								echo '<input type="hidden" id="existing_post_id" name="existing_post_id" value="'.$post_id.'" />';
				
			}
			
									echo '<input type="hidden" id="person_id" name="person_id" value="'.$desc.'" />';
								echo '<input type="hidden" id="post_author" name="post_author" value="'.$post->post_author.'" />';
								echo '<input type="hidden" id="post_title" name="post_title" value="'.$post->post_title.'" />';
								
							echo '<input type="hidden" id="indictar_id" name="indicator_id" value="'.$id.'" />';
								sibson_form_nonce('post_form');
							sibson_form_post_type_select( $pageType, $selection);
								sibson_text_area($post->post_content,  $id, $pageType);
								sibson_form_upload();
							
								sibson_form_staff_publish($post->post_date);
								
								echo "</form>"; 
		break;
			case "reuse";
		$post = get_post($post_id);
			echo "<p>Please select the children you would like to re-cycle this post for:</p>";
			echo "<form data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$id."&pageType=".$pageType."&formType=reusePost' id='post_form' method='post' enctype='multipart/form-data'>";
								echo '<input type="hidden" id="existing_post_id" name="existing_post_id" value="'.$post_id.'" />';
								echo '<input type="hidden" id="post_author" name="post_author" value="'.$post->post_author.'" />';
									echo "<div class='form_page' data-name='Select People'>";
								sibson_form_nonce('post_form');
				echo '<div data-role="fieldcontain">';
			echo '<fieldset data-role="controlgroup" data-type="horizontal">';
			
			for ($i=65; $i<=90; $i++) {
				 $x = chr($i);
				echo "<a href='#' class='loadPeopleByAlphabet' data-theme='b' data-role='button' data-inline='true' data-letter='".$x."' >";
				echo $x;
				echo "</a>";
				}
			echo '</fieldset>';	
			echo '</div>';
			echo "<div id='hiddenCheckboxes'>";
				
				echo "</div>";	
			
			echo '<ul id="selectableList">';
			
				$person= new Person($id);		
				$groupid = $person->currentClass();	
				$group = new Group($groupid);	
				$idArray = $group->get_id_array();
				foreach ($idArray as $pers){
				echo "<li>";
				$p = new Person($pers);
				$p->selectableBadge();
				echo "</li>";
				}
				echo "</ul>";
			
				echo "</div>";
				
				echo "<div class='form_page' data-name='Finish'>";
				
				echo '<p>The words <span class="ui-btn-up-e">highlighted</span> will be replaced to match the children that you have chosen.</p>';
				
				$find = array( $person->returnFirstName(), ' he ', ' she ', ' his ', ' her ', 'He ', 'She ', 'His ', 'Her ' );	
				$replace   = array( '<span class="ui-btn-up-e">'.$person->returnFirstName().'</span>', '<span class="ui-btn-up-e"> he </span>', '<span class="ui-btn-up-e"> she </span>', '<span class="ui-btn-up-e"> his </span>', '<span class="ui-btn-up-e"> her </span>', '<span class="ui-btn-up-e">He </span>', '<span class="ui-btn-up-e">She </span>', '<span class="ui-btn-up-e">His </span>', '<span class="ui-btn-up-e">Her </span>' );
				
				echo str_replace($find, $replace, $post->post_content);
				
				echo "<br />";
				echo '<a href="#" id="confirm_save" data-formid="post_form" data-role="button" data-theme="b" data-inline="true" >Ok, copy this!</a>'; 
					
				echo '</div>';
		break;
		
		case "groupform";
		
				echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$id."&formType=new_group' id='post_form' method='post' enctype='multipart/form-data'>";
								echo '<input type="hidden" id="existing_post_id" name="existing_post_id" value="'.$post_id.'" />';
								echo '<input type="hidden" id="post_author" name="post_author" value="'.$id.'" />';
								
								sibson_form_nonce('post_form');
								
							
									sibson_create_group_form($id);
								
							
								echo "</form>"; 
				
		break;
			case "editGroup";
		
				echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?formType=edit_group' id='post_form' method='post'>";
								echo '<input type="hidden" id="existing_post_id" name="existing_post_id" value="'.$post_id.'" />';
								
								
								sibson_form_nonce('post_form');
								
							
									sibson_create_group_form($id, $post_id);
								
							
								echo "</form>"; 
				
		break;
		case "emailGroup";
		echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$id."&type=Group&pageType=".$pageType."&formType=send_email' id='post_form' method='post' enctype='multipart/form-data'>";
							
								echo '<input type="hidden" id="group_id" name="group_id" value="'.$id.'" />';
								
								sibson_form_nonce('send_email');
								
						
								sibson_text_area_mail($id);
							
								
								echo "</form>"; 
		break;						
		
		case "staffgoals";
				global $wpdb;
				
				
				$goals = $wpdb->get_results($wpdb->prepare("SELECT wp_assessment_data.ID, 
	wp_assessment_data.person_id, 
	DATE_FORMAT(wp_assessment_data.date, '%M %D %Y') AS the_date, 
	wp_assessment_data.user_id, 
	wp_assessment_terms.assessment_target,
	wp_assessment_terms.assessment_subject,
	wp_assessment_terms.assessment_link, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description, 
	wp_assessment_terms.assessment_value
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.ID
WHERE wp_assessment_data.person_id = %d AND wp_assessment_terms.assessment_subject = %s AND wp_assessment_data.area = %s ", $id, $classType, $pageType));

				
				echo '<ul>';
				foreach ($goals as $goal){
					
					echo '<li>';
					echo $goal->assessment_description;
				echo '</li>';
				
	}
				echo '</ul>';
		break;
		
			case "enrolment";
			require('enrolment.php');
				sibson_enrolment_form('', 'enrol_form');
		break;
		case "enrol_edit";
			require('enrolment.php');
				sibson_enrolment_form($id, 'enrol_form');
		break;
			case "post";
			
			$post = get_post($post_id);
			
			echo '<p>';
			echo $post->post_content;
			echo '</p>';
			echo "<a href='#' class='loaddialog button'  data-role='button' data-pagetype='post' data-indicatortype='".$_POST['indtype']."'  data-theme='b' data-dialogtype='edit' data-inline='true' data-postid='".$post_id."'>Edit this...</a>";
			
		break;
		case "showgoals";
		
		$person = new Person($id);
		echo $person->showGoals($pageType);
		
		break;
		 case "duplicate_group";
		
		 $group = new Group ($id);
			
			$yearGroup = $group->returnYearGroup();
			
				switch($yearGroup){
					case 0;
					$team = "New Entrants";
					$team_order =1;
					break;
					case 1;
					$team = "New Entrants";
					$team_order =1;
					break;
					case 2;
					$team = "Year 2";
					$team_order =2;
					break;
					case 3;
					$team = "Middle";
					$team_order =3;
					break;
					
					case 4;
					$team = "Middle";
					$team_order =3;
					break;
					case 5;
					$team = "Senior";
					$team_order =4;
					break;
					
					case 6;
					$team = "Senior";
					$team_order =4;
					break;
					
				}
	
					$peopleList = $group->get_id_array();
					$current_user = wp_get_current_user();
					$userId = $current_user->ID;
					$groupDetail = array(
					'user_id'=> $userId,
					'room'=> $group->returnRoom(),
					'year'=> date('Y'),
					'type'=> '',
					'group_name'=>  $group->returnName(),
					 'team'=> $team,
					 'team_order'=> $team_order, 
					 'yearGroup'=> $yearGroup
				);
					
					
					$newGroup = sibson_create_a_group($groupDetail);
					global $wpdb;
					foreach ($peopleList as $person){
					
					$id = $person;
					
				//	$insert = $wpdb->insert( 'wp_group_relationships', array(  'wp_group_id' => $newGroup,  'wp_person_id'=>$id, 'vacated' =>0 ));	
					
						$result = $wpdb->query( $wpdb->prepare( 
	"
		INSERT INTO wp_group_relationships
		( wp_group_id, wp_person_id, vacated )
		VALUES ( %d, %d, %d )
	", 
        array(
		$newGroup, 
		$id, 
		0
		) 
		) );
					
					
					}
					if ($newGroup){
					echo "The group has been duplicated.";
					echo "<a href='".get_bloginfo('url')."?accessId=".$newGroup."&type=Group' data-theme='b' data-inline='true' rel='external' data-role='button'>Go to the new group</a>"; 
					}
		 break;
		
			case "assessment";
			global $wpdb;
			
			$assessments =$wpdb->get_results("SELECT * from wp_assessment_terms where assessment_subject = '$pageType'");
	echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$id."&formType=new_assessment' id='post_form' method='post'>";
								echo '<input type="hidden" id="subject" name="subject" value="'.$pageType.'" />';
									echo '<input type="hidden" id="person_id" name="person_id" value="'.$id.'" />';
								
								sibson_form_nonce('post_form');
								
								
			foreach ($assessments as $assessment){
				
				
			$measure = $assessment->assessment_measure;
			if ($measure == "scale-3"){		 // scale
			echo "<label><strong>".ucfirst($assessment->assessment_description)."</strong></label>";
				echo "<p>".ucfirst($assessment->assessment_target)."</p>";
				
				
		
			sibson_radio_list( 	array (
										array(
											'name'=>'radio-'.$assessment->ID,
											'id'=>'1',
											'value'=>'1',
											'existing'=> '',
											'title'=>'1'										
											),
											array(
											'name'=>'radio-'.$assessment->ID,
											'id'=>'2',
											'value'=>'2',
											'existing'=> '',
											'title'=>'2'),
											array(
											'name'=>'radio-'.$assessment->ID,
											'id'=>'3',
											'value'=>'3',
											'existing'=> '',
											'title'=>'3')),
											 'horizontal');
											 
		
	
			} // end scale
			else if ($measure == "net") {
				echo "<p><strong>".ucfirst($assessment->assessment_description)."</strong></p>";
				
			$assess = new Assessment( $id, $pageType, 'individual');
				echo '<p id="update_'.$id.'">Drag the slider to the correct score.</p>';
				  $assess->score($assessment->assessment_short, $assessment->ID);
				
			}
			else {
			break;	// break out of the loop
				
			}
			
		}
		if ($measure == "Level"){		
		
				$assess = new Assessment( $id, $pageType, 'individual');
				echo '<p id="update_'.$id.'">Drag the slider to set the level.</p>';
				  $assess->slider();
		}
			
	echo "<input type='submit' data-theme='b' data-inline='true' value='Save'/>";	
	echo '</form>';
		break;
	
		
	}
	 // IMPORTANT: don't forget to "exit"
	die();
exit;
	
}


//Dialog loads
add_action( 'wp_ajax_ajax_load_page_goals', 'ajax_load_page_goals' );

function ajax_load_page_goals(){
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// Gather the data being sent via url query string.
	
	$groupId = $_POST['groupid'];
	$pageType = $_POST['pageType'];
	$referrer = $_POST['refer'];
	
	if ($pageType=="reading" || $pageType=="writing" ||$pageType=="maths"){
		$group = new Group ($groupId);
		$group->showAssessmentSliders($pageType);
	}
	else if ($pageType=="spreadsheet"){
		$group = new Group ($groupId);
		$group->showAssessmentSpreadsheet($referrer);
	}
	else if ($pageType=="spreadsheetgoals"){
		$group = new Group ($groupId);
		$group->showAssessmentSpreadsheetGoals($referrer);
	}
	else if ($pageType=="readinggoals" || $pageType=="writinggoals" ||$pageType=="mathsgoals"){
	$assessment = new Assessment( $groupId, $pageType, 'group');
				  $assessment->get_indicatorbuttons();
				  
	}
	
	else if ($pageType=="readinggroups" || $pageType=="writinggroups" ||$pageType=="mathsgroups"){
		switch ($pageType){
		case "readinggroups";
		$subject="reading";
		break;
		case "writinggroups";
		$subject="writing";
		break;
		case "mathsgroups";
		$subject="maths";
		break;	
			
		}
		
	echo "<dl class='post_list'>";
	
	$assessment= new Assessment('', $subject);
			
			$subjectarray = $assessment->get_subject_data_array();
			$resultsArray = array();
					foreach ($subjectarray as $key => $sub){ // start loop.
						
						$resultsArray[$key+1] = array('name'=>$sub, 'results' => array()); // the plus 1 is important as it makes the array start at 1 rather than 0.
						
				
					} // end loop.
$group = new Group ($groupId);
$idArray = $group->get_id_array();
$yearGroup = $group->returnYearGroup();
$room = $group->returnRoom();
				foreach($idArray as $person_id) { // start loop.
				
						
					 $assess = new Assessment( $person_id, $subject, 'individual');
					 $value = $assess->currentDataNumber(true, false);
					 
						array_push($resultsArray[$value]['results'], $person_id);
						
						
			} // end loop.
			foreach ($resultsArray as $key =>$result){ //start loop.
			
								if (!empty($result['results'])){ //start if
								$adjustedValue = $key+1;
								echo "<dt class='post'> ";
									echo "<span class='post_author tk-head'><a href='#' >";
											   echo  trim ( $result['name'], "'" ) ;                                
									 echo "</a></span></dt>";
										echo "<dd class='post format_text tk-body'><p>" ;
										echo "The children listed below are working at ".trim ( $result['name'], "'" ).".";
										$assessment->shortStandardStatement( $yearGroup, $adjustedValue, 'they', 'they', true);
										echo "</p>";
										
											foreach ($result['results'] as $id){ //start subloop.
												$person = new Person($id);
												$person ->showBadge();
												$peoplestring .= $id."-";
										
											}	// end subloop.	
									 echo "<a href='#dialog' data-rel='dialog' data-role='button' class='createGroup' data-yeargroup='".$yearGroup."' data-room='".$room."' data-pagetype='".$pageType."' data-inline='true' data-subject='".$pageType."' data-peoplestring='".$peoplestring."' data-theme='b'  >Make this a group</a>";									
							echo "<div class='spacer'></div>";								    
					  echo "</dd>"; 	
															
					$peoplestring ='';
				}// end if.
			

			} //end loop.
echo "</dl>";
				  
	}
	
	 // IMPORTANT: don't forget to "exit"
	die();
exit;
}

add_action( 'wp_ajax_ajax_create_auto_group', 'ajax_create_auto_group' );

function ajax_create_auto_group(){
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// Gather the data being sent via url query string.
	
	$yearGroup = $_POST['year'];
	$pageType = $_POST['pageType'];
	$people = $_POST['people'];
	
	switch($yearGroup){
		case 0;
		$team = "New Entrants";
		$team_order =1;
	 	break;
		case 1;
		$team = "New Entrants";
		$team_order =1;
	 	break;
		case 2;
		$team = "Year 2";
		$team_order =2;
	 	break;
		case 3;
		$team = "Middle";
		$team_order =3;
	 	break;
		
		case 4;
		$team = "Middle";
		$team_order =3;
	 	break;
		case 5;
		$team = "Senior";
		$team_order =4;
	 	break;
		
		case 6;
		$team = "Senior";
		$team_order =4;
	 	break;
		
	}
	
	$peopleList = explode('-',$people);
	$current_user = wp_get_current_user();
	$userId = $current_user->ID;
	$groupDetail = array(
	'user_id'=> $userId,
	'room'=> $_POST['room'],
	'year'=> date('Y'),
	'type'=> $_POST['pageType'],
	'group_name'=> $_POST['room']."-".$pageType,
	 'team'=> $team,
	 'team_order'=> $team_order, 
	 'yearGroup'=> $yearGroup
);
	
	
	$newGroup = sibson_create_a_group($groupDetail);
	global $wpdb;
	for ($i=0; $i<count($peopleList); $i++){
	$id = $peopleList[$i];
	
//	$insert = $wpdb->insert( 'wp_group_relationships', array(  'wp_group_id' => $newGroup,  'wp_person_id'=>$id, 'vacated' =>0 ));	
	
	$insert = $wpdb->query( $wpdb->prepare( 
	"
		INSERT INTO wp_group_relationships
		( wp_group_id, wp_person_id, vacated )
		VALUES ( %d, %d, %d )
	", 
        array(
		$newGroup, 
		$id, 
		0
		) 
		) );
	
	}
	
	echo "A new group has been created.";
	echo "<a href='".get_bloginfo('url')."?accessId=".$newGroup."&type=Group' data-theme='b' data-inline='true' rel='external' data-role='button'>Go to the new group</a>"; 
	
	
	
	
	 // IMPORTANT: don't forget to "exit"
	die();
exit;
}

add_action( 'wp_ajax_ajax_load_assessments', 'ajax_load_assessments' );

function ajax_load_assessments(){
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// Gather the data being sent via url query string.
	
	$subject = $_POST['pageType'];
	
	
	$id =  $_POST['groupid'];
	
	$group = new Group($id);
		 
	if ($subject == "Spelling" ||$subject == "writing" ||$subject == "reading" ||$subject == "maths" ){	 
		echo $subject;
		$group->showAssessmentSliders($subject);
	}
								
	else {
		$group->showAssessmentData($subject);
	}
	
	 // IMPORTANT: don't forget to "exit"
	die();
exit;
}

add_action( 'wp_ajax_ajax_send_mail', 'ajax_send_mai' );

function ajax_send_mai(){
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// Gather the data being sent via url query string.
	
	$checkUser = sibson_check_user_can_ajax();

if ($checkUser<7){	
die;
}
	

								
	
	 // IMPORTANT: don't forget to "exit"
	die();
exit;
}

add_action( 'wp_ajax_ajax_load_targets', 'ajax_load_targets' );

function ajax_load_targets(){
	
	if( ! wp_verify_nonce( $_POST['Nonce'],'sibson_nonce')) die ('Sorry there was a problem, please try again later!');
	// Gather the data being sent via url query string.
	
	
	$groupid = $_POST['groupid'];
	$subject = $_POST['pageType'];
	
	$group = new Group($groupid);
	
	$group->targetPage($subject);	
	

								
	
	 // IMPORTANT: don't forget to "exit"
	die();
exit;
}




?>