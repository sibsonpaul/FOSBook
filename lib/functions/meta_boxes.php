<?php

/**




**/



// Profile box.
function custom_dashboard_profile() {
echo "<div id='profile'>";

global $Id;
global $type;
global $subject;



if ($type== "person"){

global $person;

echo "<div class='head'>";
echo $person->showImage();
echo "<h2>";
echo $person->showName();
echo "</h2>";
echo $person->showBirthday();
echo "<br />";

echo $person->showAge();
echo "<br />Current MOE level is Year ";
echo $person->showCurrentMOEYearLevel();
echo "</div>";
echo '<ul id="profileMenu">';

echo $person->showAdminLinks($subject);
echo '</ul>';
}
else if ($type== "group"){

global $group;
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

function custom_dashboard_quick_post(){
	
	global $Id;
	global $type;
	global $subject;

	
	
echo '<div id="postdivrich" class="postarea">';

echo '<form data-initialForm="" id="quickPostForm" name="quickPostForm" >';
echo '<input type="text" id="quickTitle" name="quickContent" />';
echo '<textarea id="quickContent" name="quickContent"></textarea>';
echo '<input type="hidden" id="quickPostType" name="quickPostType" value="'.$subject.'" />';
echo '<input type="hidden" id="quickPostID" name="quickPostID" value="'.$Id.'" />';
echo '</div>';
		echo "<div class='spacer'>&nbsp;</div>";
echo '<span id="publishing-action">';

if ($type == "group"){
	sibson_open_selectable_list_button($Id, 'Select children for this post');
	
}
else if ($type =="person"){
		global $person;
		$name = $person->returnFirstName();
	sibson_open_select_dialog_button('post', "Post just for $name");
	sibson_open_select_dialog_button('get_group_list', 'Select other children for this post', '','secondary');	
}
else {
	sibson_open_select_dialog_button('get_blog_list', 'Post to a blog', '');
	sibson_open_select_dialog_button('get_group_list', 'Select children for this post');	
	
}

               
echo '</span>';
			echo "<div class='spacer'>&nbsp;</div>";	
echo '<div id="form_dialog" style="display:none">';

echo '</div>';
	echo '</form>';
	
	echo '<form action="options-general.php?page=copy_posts.php" method="post">';
	echo '<input type="submit" value="Copy Posts and Data"/>';
	 echo  '<input type="hidden" name="info_update" id="info_update" value="true" />';
	 echo '<input type="hidden" name="UPN" value="'.$Id.'"/>';
  
	echo '</form>';
	
	echo '<form action="options-general.php?page=copy_data.php" method="post">';
	echo '<input type="submit" value="Copy Data only"/>';
	 echo  '<input type="hidden" name="info_update" id="info_update" value="true" />';
	 echo '<input type="hidden" name="UPN" value="'.$Id.'"/>';
  
	echo '</form>';
}

function custom_dashboard_comment_counts(){
	
global $person;
		
		echo $person->get_person_commentlist();
		


	
}


function custom_all_posts(){
	global $subject;
	 global $Id;
	 global $type;
	 
	 $tax ='person_id';
			
				if ($type== "group"){
					
						global $group;
						
						$tagArray =implode(',',$group->get_tag_array()) ;
						
							
					$the_query = new WP_Query( array( 
						'post_type' => $subject,
						'tax_query' => array(
						array(
							'taxonomy' => $tax,
							'field' => 'slug',
							'terms' => $group->get_tag_array()
							)
						)
					) 
				);	
					
						
				}
				else if ($type=="person"){
						
					$the_query = new WP_Query( array( 
						'post_type' => $subject,
						'tax_query' => array(
						array(
							'taxonomy' => $tax,
							'field' => 'slug',
							'terms' => $Id
							)
						)
					) 
				);	
				
					
				}
				
				
	
    echo '<div id="latestposts">';
	echo '<ul class="post_list">';		
			while ( $the_query->have_posts() ) : $the_query->the_post();
	
		$post_id = get_the_ID();
		$term_list = wp_get_post_terms($post_id, 'person_id', array("fields" => "all"));
	  		 foreach ($term_list as $p_id) {  
				$person_id =  $p_id->slug;
				$label = $p_id->name;
			}
			
	if($type=="person"){
			$label = get_the_author_meta('first_name')." ".get_the_author_meta('last_name');
	}
			$the_date = get_the_date(); 
			$category = get_the_category();
			$catSlug = $category[0]->slug;
			$catName =$category[0]->name;
			$the_content = get_the_content();
			$profile_image_url = get_the_author_meta('profile_image_url');
				
			sibson_show_post($post_id, $person_id, $label, $the_date, $catSlug, $catName, $the_content, $profile_image_url);

	endwhile;

// Reset Post Data
wp_reset_postdata();
echo '</ul>';
echo '</div>';
	
	
}
function custom_latest_updates(){
	echo '<div id="dialog"></div>';
    echo '<div id="latestposts">';
	echo '<ul class="post_list">';
     global $userid;
	 global $Id;
	global $type;
	
	if ($type == "group" || $type=="person"){
	
				if ($type== "group"){
					
						global $group;
						
						$tagArray =implode(',',$group->get_tag_array()) ;
						
						
						$the_query = new WP_Query( array( 
								'post_type' => array( 'general', 'sparkle', 'thinker', 'team_player', 'communicator', 'reading', 'wirting', 'maths','dream_maker', 'support'),
								'tax_query' => array(
								array(
									'taxonomy' => 'person_id',
									'field' => 'slug',
									'terms' => $group->get_tag_array()
									)
								)
							) 
						);
						
				}
				else if ($type=="person"){
					
							$the_query = new WP_Query( array( 
						'post_type' => array( 'general', 'sparkle', 'thinker', 'team_player', 'communicator', 'reading', 'writing', 'maths','dream_maker', 'support'),
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
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$post_id = get_the_ID();
		
		$term_list = wp_get_post_terms($post_id, 'person_id', array("fields" => "all"));
	  		 foreach ($term_list as $p_id) {  
				$person_id =  $p_id->slug;
				$label = $p_id->name;
			}
			
	if($type=="person"){
			$label = get_the_author_meta('first_name')." ".get_the_author_meta('last_name');
	}
			$the_date = get_the_date(); 
			$category = get_the_category();
			$catSlug = $category[0]->slug;
			$catName =$category[0]->name;
			$the_content = get_the_content();
			$profile_image_url = get_the_author_meta('profile_image_url');
				
			sibson_show_post($post_id, $person_id, $label, $the_date, $catSlug, $catName, $the_content, $profile_image_url);

	endwhile;

// Reset Post Data
wp_reset_postdata();
echo '</ul>';
	}
else {
	
	 $blog = get_user_meta($userid, 'team_blog', true); 
       wp_widget_rss_output(array(
            'url' => $blog,  //put your feed URL here
            'title' => 'Latest News from Team Blog', // Your feed title
            'items' => 2, //how many posts to show
            'show_summary' => 1, // 0 = false and 1 = true 
            'show_author' => 0,
            'show_date' => 1
       ));
       
      
}
 echo "</div>";
}

function custom_post_type_description(){
	
	global $subject;
	global $person;
	
	if ($person){
	sibson_subject_blurb($subject, $person);
	}
}

function custom_dashboard_navigation() {
global $Id;
global $type;
global $current_user;

echo "<div id='custom-nav-sidebar'></div>";

echo '<div class="jqueryslidemenu"  id="custom-nav-header">';
echo '<ul>';

echo '<li><a href="index.php?group_id=" class="load-team" data-action="ajax_get_nav_group_list" data-query="" >My Groups</a>';
sibson_drop_down_menu('my_groups');
echo '<li><a href="index.php?group_id="  class="load-team" data-action="ajax_get_nav_group_list" data-query="new_entrants" >New Entrants</a>';
sibson_drop_down_menu('New Entrants');
echo '</li><li><a href="index.php?group_id=" class="load-team" data-action="ajax_get_nav_group_list" data-query="year_two" >Year Two</a>';
sibson_drop_down_menu('Year 2');
echo '</li><li><a href="index.php?group_id="  class="load-team" data-action="ajax_get_nav_group_list" data-query="middle" >Middle Team</a>';
sibson_drop_down_menu('Middle');
echo '</li><li><a href="index.php?group_id="  class="load-team" data-action="ajax_get_nav_group_list" data-query="senior" >Senior Team</a>';
sibson_drop_down_menu('Senior');
echo '</li>';
if ( $current_user->user_level >  7 ) { // If user level is lower than 7.
		echo '<li><a href="index.php?group_id=" class="load-team" data-action="ajax_get_nav_group_list" data-query="senior" >Admin</a>';
		echo '<ul>';
		echo '<li><a href="/wp-admin/options-general.php?page=copy_posts.php">Copy Posts</a></li>';
		echo '<li><a href="/wp-admin/options-general.php?page=create_groups.php">Create Groups</a></li>';
		echo '</ul>';
		echo '</li>';
	}
echo '</ul>';
echo '<img src="'.SIBSON_STYLE.'/honey/FOS-logo.png" id="mainLogo"/>';
echo '</div>';
echo '<div id="navmenu">';
if ($type=="group"){
$list = new StudentList($Id);
}
else if ($type=="person") {
global $person;	
	
$groupid = $person->currentClass();	
$list = new StudentList($groupid);	
}
echo $list->menuList($Id); // The currenty id is passed through so that this person will be highlighted in the navigation list.
	
echo '</div>';
}	


function custom_dashboard_tasks(){
	echo "<div id='option-dialog'></div>";
	echo "<div id='option-buttons'>";
	sibson_open_options_dialog_button('create_new_group', 'Create a new group');
	echo "</div>";
}

function custom_dashboard_group_history() {

$personId =$_GET['person_id'];

$person = new Person($personId);

$history = $person->showGroupHistory();


}	


function custom_dashboard_maths() {

			global $Id;
			global $type;
			
			echo "<div id='maths_chart_".$Id."'></div>";
			
					if ($type=="person"){
					
					$assessment = new Assessment($Id, 'maths');
					
					
					echo $assessment->get_individual_chart(true);
					}
					
					else {
						
						global $group;
					
					
					echo $group->get_group_chart('maths');
					}
			}


function custom_dashboard_reading() {
			
			global $Id;
			global $type;
			
			echo "<div id='reading_chart_".$Id."'></div>";
			
					if ($type=="person"){
					
					$assessment = new Assessment($Id, 'reading');
					
					
					echo $assessment->get_individual_chart(true);
					}
					
					else {
						
						global $group;
					
					
					echo $group->get_group_chart('reading');
					}

}
function custom_dashboard_writing() {


global $Id;
	global $type;
			
			echo "<div id='writing_chart_".$Id."'></div>";
			
					if ($type=="person"){
					
					$assessment = new Assessment($Id, 'writing');
					
					
					echo $assessment->get_individual_chart(true);
					}
					
					else {
						
						global $group;
					
					
					echo $group->get_group_chart('writing');
					}

}	



function custom_dashboard_maths_select(){
	
global $Id;
global $type;

		if ($type=="person"){
		
		$assessment = new Assessment($Id, 'maths', 'individual');
		echo $assessment->get_indicatorbuttons();
			
		}
		else if ($type=="group"){
		
		$assessment = new Assessment($Id, 'maths', 'group');
		echo $assessment->get_indicatorbuttons();
			
		}


	
}

function custom_stage_1_knowledge(){
	global $Id;
	global $type;
	
	if ($type=="person"){

		$assessment = new Assessment($Id, 'maths', 'individual');
		$currentData = $assessment->currentData(true);
		$securePercent = $assessment->currentPercent($currentData, 'secure');
		$developingPercent  = $assessment->currentPercent($currentData, 'developing');
		$notAssessedPercent = 100 - $developingPercent - $securePercent;
		echo "<div class='level'>";
		echo "Stage ".$currentData;
		echo "</div>";
		echo "<div class='progress'>";
		if ($securePercent>0){
		echo "<span class='secure' style='width: {$securePercent}%'>{$securePercent}%</span>";
		}
		if ($developingPercent>0){
		echo "<span class='developing' style='width: {$developingPercent}%'>{$developingPercent}%</span>";
		}
		if ($notAssessedPercent>0){
		echo "<span class='noyetassessed' style='width: {$notAssessedPercent}%'>{$notAssessedPercent}%</span>";
		}
		
		echo "</div>";
		echo $assessment->get_indicatorlist($currentData, 'knowledge');
	
	}
	else if ($type== "group"){
		echo "<div class='level'>";
			echo "Stage 4";
			echo "</div>";
		$assessment = new Assessment($Id, 'maths', 'group');
		
		echo $assessment->get_group_indicatorlist(4, 'knowledge');
	}
	
}

function custom_stage_1_strategy(){
	
	global $Id;
		global $type;
	
	if ($type=="person"){

$assessment = new Assessment($Id, 'maths', 'individual');
$currentData = $assessment->currentData(true);
$securePercent = $assessment->currentPercent($currentData, 'secure');
$developingPercent  = $assessment->currentPercent($currentData, 'developing');
$notAssessedPercent = 100 - $developingPercent - $securePercent;
echo "<div class='level'>";
echo "Stage ".$currentData;
echo "</div>";
echo "<div class='progress'>";
if ($securePercent>0){
echo "<span class='secure' style='width: {$securePercent}%'>{$securePercent}%</span>";
}
if ($developingPercent>0){
echo "<span class='developing' style='width: {$developingPercent}%'>{$developingPercent}%</span>";
}
if ($notAssessedPercent>0){
echo "<span class='noyetassessed' style='width: {$notAssessedPercent}%'>{$notAssessedPercent}%</span>";
}

echo "</div>";

echo $assessment->get_indicatorlist($currentData, 'strategy');
	}
	else if ($type== "group"){
		echo "<div class='level'>";
			echo "Stage 4";
			echo "</div>";
		$assessment = new Assessment($Id, 'maths', 'group');
		
		echo $assessment->get_group_indicatorlist(4, 'strategy');
	}
}

function custom_stage_2_knowledge(){
	
global $Id;
		global $type;
	
	if ($type=="person"){

$assessment = new Assessment($Id, 'maths', 'individual');
$currentData = $assessment->currentData(true)+1;
$securePercent = $assessment->currentPercent($currentData, 'secure');
$developingPercent  = $assessment->currentPercent($currentData, 'developing');
$notAssessedPercent = 100 - $developingPercent - $securePercent;
echo "<div class='level'>";
echo "Stage ".$currentData;
echo "</div>";
echo "<div class='progress'>";
if ($securePercent>0){
echo "<span class='secure' style='width: {$securePercent}%'>{$securePercent}%</span>";
}
if ($developingPercent>0){
echo "<span class='developing' style='width: {$developingPercent}%'>{$developingPercent}%</span>";
}
if ($notAssessedPercent>0){
echo "<span class='noyetassessed' style='width: {$notAssessedPercent}%'>{$notAssessedPercent}%</span>";
}

echo "</div>";
echo $assessment->get_indicatorlist($currentData, 'knowledge');

}
	else if ($type== "group"){
		echo "<div class='level'>";
			echo "Stage 5";
			echo "</div>";
		$assessment = new Assessment($Id, 'maths', 'group');
		
		echo $assessment->get_group_indicatorlist(5, 'knowledge');
	}
}

function custom_stage_2_strategy(){

global $Id;
	global $type;
	
	if ($type=="person"){

$assessment = new Assessment($Id, 'maths', 'individual');
$currentData = $assessment->currentData(true)+1;
$securePercent = $assessment->currentPercent($currentData, 'secure');
$developingPercent  = $assessment->currentPercent($currentData, 'developing');
$notAssessedPercent = 100 - $developingPercent - $securePercent;
echo "<div class='level'>";
echo "Stage ".$currentData;
echo "</div>";
echo "<div class='progress'>";
if ($securePercent>0){
echo "<span class='secure' style='width: {$securePercent}%'>{$securePercent}%</span>";
}
if ($developingPercent>0){
echo "<span class='developing' style='width: {$developingPercent}%'>{$developingPercent}%</span>";
}
if ($notAssessedPercent>0){
echo "<span class='noyetassessed' style='width: {$notAssessedPercent}%'>{$notAssessedPercent}%</span>";
}

echo "</div>";


echo $assessment->get_indicatorlist($currentData, 'strategy');
	}
	else if ($type== "group"){
		echo "<div class='level'>";
			echo "Stage 5";
			echo "</div>";
		$assessment = new Assessment($Id, 'maths', 'group');
		
		echo $assessment->get_group_indicatorlist(5, 'strategy');
	}
}


function custom_level(){

global $Id;
	global $type;
	global $subject;
	if ($type=="person"){

$assessment = new Assessment($Id, $subject, 'individual');
$currentData = $assessment->currentData(true)-1+1;

echo "<div class='level'>";
echo "Level ".$currentData;
echo "</div>";

echo $assessment->get_indicatorlist($currentData);
	}
	else if ($type== "group"){
		echo "<div class='level'>";
			echo "Stage 5";
			echo "</div>";
		$assessment = new Assessment($Id, $subject, 'group');
		
		echo $assessment->get_group_indicatorlist($currentData);
	}
}

function custom_level_1(){

global $Id;
	global $type;
		global $subject;
	if ($type=="person"){

$assessment = new Assessment($Id, $subject, 'individual');
$currentData = $assessment->currentData(true)+1;

echo "<div class='level'>";
echo "Level ".$currentData;
echo "</div>";

echo $assessment->get_indicatorlist($currentData);
	}
	else if ($type== "group"){
		echo "<div class='level'>";
			echo "Stage 5";
			echo "</div>";
		$assessment = new Assessment($Id, $subject, 'group');
		
		echo $assessment->get_group_indicatorlist($currentData);
	}
}


function custom_dashboard_reading_select(){
	
global $Id;
global $type;

		if ($type=="person"){
		
		$assessment = new Assessment($Id, 'reading', 'individual');
		echo $assessment->get_indicatorbuttons();
			
		}
		else if ($type=="group"){
		
		$assessment = new Assessment($Id, 'reading', 'group');
		echo $assessment->get_indicatorbuttons();
			
		}


	
}

function custom_dashboard_group_reading() {
global $Id;
global $group;


echo "<div id='reading_chart_".$Id."'></div>";
echo $group->get_group_chart('reading');
}
function custom_dashboard_group_writing() {
global $Id;
global $group;

echo "<div id='writing_chart_".$Id."'></div>";
echo $group->get_group_chart('writing');

}	
function custom_dashboard_ethnicty() {
global $Id;
global $group;
echo "<div class='spacer'>&nbsp;</div>";
echo "<div id='comment_pie' class='pie'></div>";
echo $group->get_pie_chart_comments();
echo "<div id='ethnicity_pie'  class='pie'></div>";
echo $group->ethnicity_chart();

echo "<div class='spacer'>&nbsp;</div>";
}




?>