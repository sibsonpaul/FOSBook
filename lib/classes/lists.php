<?php

class StudentList{
	
	private $id = "";
	private $currentYear ="";
	private $groups = array();
	private $idArray="";
	public function __construct($ID, $idArray){
global $wpdb;		
		// When the class is instartiated take the id passed through and query the database to populate all the variables.
	$this->idArray = $idArray;
	$this->currentYear = date(Y);
	
	if ($ID){ // if an ID has been passed then set the class local variable for id. 
	$this->id = $ID;
	}
	else { // if no variable has been passed use the users own group id.
	global $current_user;
	get_currentuserinfo();
	$userid = $current_user->ID;
		
$this->id = $wpdb->get_var("SELECT 
wp_groups.wp_group_id
FROM wp_groups where wp_user_id = $userid and year = $this->currentYear ");

	}
	


if ($this->idArray == ""){ // If no id array has been passed, create one from the group id.
	
	$groups = $wpdb->get_results($wpdb->prepare("SELECT 
	wp_people.wp_person_id
FROM wp_group_relationships INNER JOIN wp_people ON wp_group_relationships.wp_person_id = wp_people.wp_person_id INNER JOIN wp_groups on wp_group_relationships.wp_group_id = wp_groups.wp_group_id
WHERE wp_people.`vacated` = 0 AND wp_group_relationships.`vacated` = 0 AND wp_group_relationships.wp_group_id = %d order by first_name ", $this->id));
	
	}
else { // or else assign the passed variable to this local variable.
	$groups = $this->idArray;

}
		foreach ($groups as $person): // Now use the array of ids to populate a groups array.
			
			if ($this->idArray==""){
			$id = $person->wp_person_id;
			}
			else {
			$id = $person;	
			}
			
			$student= new Person($id);
			$this->groups[] = $student->fullArray();
			endforeach;
	
	}
	
	
public function getImageList(){
	

$imageList =$wpdb->get_results("SELECT wp_peoplemeta.meta_value as image_id, wp_peoplemeta.wp_person_id as id 
FROM wp_peoplemeta 
where wp_peoplemeta.meta_key = 'profile_image' and wp_peoplemeta.wp_person_id in (".implode(",", $this->idArray).") ");
	
	
	foreach ($imageList as $image){
	
	$imageArray[] = array ('id' => $image->id, 'image'=> wp_get_attachment_image($image->image_id, 'thumb'));	
		
	}
	
	 return $imageArray;
	
}
public function badgeList($ajax=false, $selectable=false){
	

	//Check to see if an image has been set for this person and then echo the image if it exists.

echo "<ul id='badgeList'>";
	
foreach ($this->groups as $key=>$group){
				
				
				$PersonImage=$group['image'];
					
				echo "<li>";
				sibson_badge($group['id'], $PersonImage, $group['name'] , array($group['teacher']), $ajax, $selectable); // Calls the function for drawing a badge. Pases an id and image url, a title, an array of extra detail and booleon values for whether the badge is ajax enabled and/or selectable.
				
				echo "</li>";
			}
		
			echo "</ul>";
			echo "<div class='spacer'>&nbsp;</div>";
	}
	
public function menuList($currentId){
	

echo "<ul data-role='listview' data-inset='true'>";
foreach ($this->groups as $key=>$group){
				
				$imageFilePath = $group['image'];
					
					if (fopen($imageFilePath, "r")){
					
					$PersonImage="<img src='".$imageFilePath."' class='ui-li-icon ui-li-thumb'>";
					}
					else {
					$PersonImage="<img src='".SIBSON_IMAGES."/Avatar.png' class='ui-li-icon ui-li-thumb'>";
					}
				if (in_array($key, array(1,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41))) {
				$listClass = "alt";
				}
				else {
				$listClass = "";	
				}
				if ($currentId == $group['id']){
				$current = "true";	
				}
					
			
			
					sibson_nav_li($group['id'], $PersonImage, $group['name'] ,  $current);
				$current ='';
			
			}
		
			echo "</ul>";
			echo "<div class='spacer'>&nbsp;</div>";
			
	}
	
	public function selectList(){
		
	//Check to see if an image has been set for this person and then echo the image if it exists.
echo "<div class='spacer'>&nbsp;</div>";
echo "<ul>";
foreach ($this->groups as $key=>$group){
				
				$imageFilePath = $group['image'];
					
					if (fopen($imageFilePath, "r")){
					
					$PersonImage="<img src='".$imageFilePath."' class='badgeImage'>";
					}
					else {
					$PersonImage="";
					}
				if (in_array($key, array(1,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41))) {
				$listClass = "alt";
				}
				else {
				$listClass = "";	
				}
				echo "<li class='badge'>";
				sibson_badge($group['id'], $PersonImage, $group['name'] , array($group['teacher']), false, true);
				
				echo "</li>";
			}
		
			echo "</ul>";
			echo "<div class='spacer'>&nbsp;</div>";
		
		
	}
	
	public function groupArray(){
		
		return $this->groups;
		
	}
	
	
	
}

class GroupList{
	
	private $id = "";
	private $currentYear ="";
	private $type = "";
	private $query = "";
	private $html = array();
	private $groups = array();
	private $idArray=array();

	public function __construct($ID, $type, $query, $idArray, $year){
		
		// When the class is instartiated take the id passed through and query the database to populate all the variables.

	$this->id = $ID;
	
	
	$this->currentYear = date(Y);	
	
	$this->type = $type;
	$this->idArray = $idArray;
	
	global $wpdb;
	
	if ($this->type=="groups"){
			$groups = $wpdb->get_results($wpdb->prepare("SELECT wp_groups.wp_group_id, 
					wp_groups.wp_user_id, 
					wp_groups.room, 
					wp_groups.year, 
					wp_groups.type, 
					wp_groups.group_name, 
					wp_groups.Team, 
					wp_groups.team_order, 
					wp_groups.YearGroup, 
					wp_usermeta.meta_key, 
					wp_usermeta.meta_value
				FROM wp_users INNER JOIN wp_groups ON wp_users.ID = wp_groups.wp_user_id
					 INNER JOIN wp_usermeta ON wp_usermeta.user_id = wp_users.ID
				WHERE Year = $this->currentYear AND wp_groups.wp_user_id = %d and wp_usermeta.meta_key = 'person_id' order by year desc", $this->id));	
				
			}
		else if ($this->type=="nextyear"){
			$newYear = $this->currentYear+1;
			$groups = $wpdb->get_results("SELECT wp_groups.wp_group_id, 
					wp_groups.wp_user_id, 
					wp_groups.room, 
					wp_groups.year, 
					wp_groups.type, 
					wp_groups.group_name, 
					wp_groups.Team, 
					wp_groups.team_order, 
					wp_groups.YearGroup, 
					wp_usermeta.meta_key, 
					wp_usermeta.meta_value, 
					wp_users.display_name
				FROM wp_users INNER JOIN wp_groups ON wp_users.ID = wp_groups.wp_user_id
					 INNER JOIN wp_usermeta ON wp_usermeta.user_id = wp_users.ID
				WHERE year = $newYear AND wp_groups.type = 'Class' and wp_usermeta.meta_key = 'person_id' $query order by year desc");
			
		}
		else if ($this->type=="group_from_array"){
			$groups = $wpdb->get_results("SELECT wp_groups.wp_group_id, 
					wp_groups.wp_user_id, 
					wp_groups.room, 
					wp_groups.year, 
					wp_groups.type, 
					wp_groups.group_name, 
					wp_groups.Team, 
					wp_groups.team_order, 
					wp_groups.YearGroup, 
					wp_usermeta.meta_key, 
					wp_usermeta.meta_value, 
					wp_users.display_name
				FROM wp_users INNER JOIN wp_groups ON wp_users.ID = wp_groups.wp_user_id
					 INNER JOIN wp_usermeta ON wp_usermeta.user_id = wp_users.ID
				WHERE wp_group_id in (".implode(",", $this->idArray).") and wp_usermeta.meta_key = 'person_id' order by year desc");		
			
			
		}
		else {
			$groups = $wpdb->get_results("SELECT wp_groups.wp_group_id, 
					wp_groups.wp_user_id, 
					wp_groups.room, 
					wp_groups.year, 
					wp_groups.type, 
					wp_groups.group_name, 
					wp_groups.Team, 
					wp_groups.team_order, 
					wp_groups.YearGroup, 
					wp_usermeta.meta_key, 
					wp_usermeta.meta_value, 
					wp_users.display_name
				FROM wp_users INNER JOIN wp_groups ON wp_users.ID = wp_groups.wp_user_id
					 INNER JOIN wp_usermeta ON wp_usermeta.user_id = wp_users.ID
				WHERE year = $this->currentYear AND wp_groups.type = 'Class' and wp_usermeta.meta_key = 'person_id' $query order by ABS(room) ");	
			
			
		}
	foreach ($groups as $key=>$group):
					
					$person = new Person ($group->meta_value);
					$profile_image = $person->returnImage('thumbnail');
				$count = $this->countStudents($group->wp_group_id);	
				if ($count>0){
				$this->groups[]= array('id'=>$group->wp_group_id, 'teacher' =>$group->display_name, 'yeargroup'=>$group->YearGroup, 'Team' => $group->Team, 'image'=> $profile_image, 'room' => $group->room, 'name' => $group->group_name, 'count'=>$count, 'year' =>$group->year, 'user_id' => $group->wp_user_id);
				}
			endforeach;		
	
	}
	
	
	public function countStudents($groupid){
		
		global $wpdb;
				$count = $wpdb->get_var($wpdb->prepare("SELECT count(wp_group_relationships.wp_group_id)
			FROM wp_group_relationships
			WHERE wp_group_relationships.wp_group_id = %d AND wp_group_relationships.`vacated`=0", $groupid));
			return $count;		
		
	}
	
	public function badgeList(){
		
	
	//Check to see if an image has been set for this person and then echo the image if it exists.

echo "<ul id='groupBadgeList'>";
	
foreach ($this->groups as $key=>$group){
				
				$profile_image = $group['image'];
			
				echo "<li>";
				sibson_link_badge( $profile_image, '?type=Group&accessId='.$group['id'], $group['name'], $group['count'] ); // Calls the function for drawing a badge. Pases an id and image url, a title, an array of extra detail and booleon values for whether the badge is ajax enabled and/or selectable.
				
				echo "</li>";
			}
		
			echo "</ul>";
			echo "<div class='spacer'>&nbsp;</div>";
	}
	public function menuList($ajax){ //$ajax is optional variable which will make the links use ajax instead of a href.
		
		
		echo "<div class='spacer'>&nbsp;</div>";
			echo "<ul>";
			foreach ($this->groups as $key=>$group){
				
				$imageFilePath = $group['image'];
					
					if (fopen($imageFilePath, "r")){
					
					$PersonImage="<img src='".$imageFilePath."' class='badgeImage'>";
					}
					else {
					$PersonImage="";
					}
				if (in_array($key, array(1,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41))) {
				$listClass = "alt";
				}
				else {
				$listClass = "";	
				}
				echo "<li>";
				if ($ajax == "true"){
					
					echo '<a class="ajaxLink badge '.$listClass.'" data-id="'.$group['id'].'" ><span class="avatar">'.$PersonImage.'</span> <span class="name">' . $group['name'] . '</span><br />'.$group['teacher'].'<br /><span class="count">'.$group['count'].' Children</span><span class="counter">'.$group['year'].'</span></a>';
				}
				else if ($ajax == "link"){
					
					echo '<a class="pageAjaxLink badge '.$listClass.'" data-select="false" data-id="'.$group['id'].'" ><span class="avatar">'.$PersonImage.'</span> <span class="name">' . $group['name'] . '</span><br />'.$group['teacher'].'<br /><span class="count">'.$group['count'].' Children</span><span class="counter">'.$group['year'].'</span></a>';
				}
				else {
					
					echo '<a href="index.php?group_id='.$group['id'].'" class="badge '.$listClass.'" ><span class="avatar">'.$PersonImage.'</span> <span class="name">' . $group['name'] . '</span><br />'.$group['teacher'].'<br /><span class="count">'.$group['count'].' Children</span><span class="counter">'.$group['year'].'</span>';
					echo '</a>';
					
					
				}
				echo "</li>";
			}
			echo "</ul>";
			echo "<div class='spacer'>&nbsp;</div>";
	}
	
	public function jsonList(){
		echo json_encode($this->groups);
	}
	
	public function groupArray(){
		
		return $this->groups;
		
	}
	
	public function returnIdArray(){
		
		return $this->idArray;
		
	}
	
	public function subMenuList(){
		
			foreach ($this->groups as $key=>$group){
					
					echo "<li><a ";
					echo "href='index.php?group_id=";
					echo $group['id'];
					echo "' data-select='false' ";
					echo "data-id='";
					echo $group['id'];
					echo "' ";
					echo ">";
					echo "".$group['name']."";
					echo "</a>";
					echo "</li>";
		
		
		}
	}
	
	public function adminList(){
		
			foreach ($this->groups as $key=>$group){
					
					$thisGroup = new StudentList ($group['id']);
					
					echo "<div class='desc'>";
					echo "".$group['name']."";
				echo "</div>";
				
					$title = $group['teacher']." - 2012";
				$desc  = get_post_by_title($title );
				
				
				echo $desc->post_content;
				
				echo "<div class='desc'>";
				echo $description;
				echo "</div>";
		
		$ids = $thisGroup->badgeList();
		
		
		
		}
	}
	
}

class AutoStudentList {
	
	private $type="";
	private $id="";
	private $subject ="";
	private $idArray="";
	private $level="";
	private $cycle="";
	
	public function __construct($ID, $type, $subject, $level, $cycle){
		
		// When the class is instartiated take the id passed through and query the database to populate all the variables.
		
	$this->id = $ID;	// The Id of the group.
	$this->type = $type; //The type of query to use.
	$this->subject= $subject; // The variable for the query.
	$this->level= $level;
	$this->cycle= $cycle;
	
	
	
	
	global $wpdb;
	
	if ($this->type == "ethnicity"){
	$this->idArray = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT wp_people.wp_person_id	
FROM wp_group_relationships INNER JOIN wp_people ON wp_group_relationships.wp_person_id = wp_people.wp_person_id
	 INNER JOIN wp_peoplemeta ON wp_peoplemeta.wp_person_id = wp_people.wp_person_id
	 INNER JOIN wp_groups ON wp_group_relationships.wp_group_id = wp_groups.wp_group_id
WHERE wp_people.`vacated` = 0 AND wp_group_relationships.`vacated` = 0 AND wp_group_relationships.wp_group_id = %d and wp_peoplemeta.meta_key ='Ethnic Origin' and 
wp_peoplemeta.meta_value =%s", $this->id, $this->subject));


	
	}
	
else if ($this->type == "comments"){
	
	
	
}
else if ($this->type == "reading"){
	
	$group = new Group($this->id);
	$groupArray = $group->get_id_array();
	
	$cycleid= sibson_lookup_cycle_id($this->cycle);
	$level= sibson_lookup_level_value($this->level, $this->subject);
	
	$this->idArray = $wpdb->get_results("SELECT 
	wp_people.wp_person_id
FROM wp_assessment_data INNER JOIN wp_people ON wp_assessment_data.person_id = wp_people.wp_person_id
where wp_assessment_data.person_id in (".implode(",", $groupArray).") and 
	wp_assessment_data.assessment_subject = '$this->subject' and 
wp_assessment_data.area = 'OTJ' and 
	wp_assessment_data.assessment_value = $level and  
	wp_assessment_data.cycle = $cycleid ");
	
}
else if ($this->type == "writing"){
	
	$group = new Group($this->id);
	$groupArray = $group->get_id_array();
	
	$cycleid= sibson_lookup_cycle_id($this->cycle);
	$level= sibson_lookup_level_value($this->level, $this->subject);
	
	$this->idArray = $wpdb->get_results("SELECT 
	wp_people.wp_person_id
FROM wp_assessment_data INNER JOIN wp_people ON wp_assessment_data.person_id = wp_people.wp_person_id
where wp_assessment_data.person_id in (".implode(",", $groupArray).") and 
	wp_assessment_data.assessment_subject = '$this->subject' and 
wp_assessment_data.area = 'OTJ' and 
	wp_assessment_data.assessment_value = $level and  
	wp_assessment_data.cycle = $cycleid ");
	
}

else if ($this->type == "maths"){
	
	$group = new Group($this->id);
	$groupArray = $group->get_id_array();
	
	$cycleid= sibson_lookup_cycle_id($this->cycle);
	$level= sibson_lookup_level_value($this->level, $this->subject);
	
	$this->idArray = $wpdb->get_results("SELECT 
	wp_people.wp_person_id
FROM wp_assessment_data INNER JOIN wp_people ON wp_assessment_data.person_id = wp_people.wp_person_id
where wp_assessment_data.person_id in (".implode(",", $groupArray).") and 
	wp_assessment_data.assessment_subject = '$this->subject' and 
wp_assessment_data.area = 'OTJ' and 
	wp_assessment_data.assessment_value = $level and  
	wp_assessment_data.cycle = $cycleid ");
	

	
}
	
}
	
public function showList(){
	
		$list = new StudentList('', $this->idArray);
		echo $list->menuList();
		
	}
	
}


class StaffList{
	
	
	public function menuList(){
	
	global $wpdb;
	
	$staff = $wpdb->get_results("SELECT wp_people.wp_person_id, wp_people.first_name, 
	wp_people.last_name
FROM wp_peoplemeta INNER JOIN wp_people ON wp_peoplemeta.wp_person_id = wp_people.wp_person_id
where wp_peoplemeta.meta_value ='staff' and wp_people.vacated <> 'true' order by first_name");
	
	

	//Check to see if an image has been set for this person and then echo the image if it exists.


echo "<h2>My Colleagues</h2>";
echo "<dl id='people_list' class='ui-grid-b'>";
				foreach ($staff as $key =>$staffmember):
				$imageURL=get_person_profile_image($staffmember->wp_person_id);
			$imageFileName = $imageURL;
			$imageFilePath = SIBSON_UPLOADS.$imageFileName;
			if (fopen($imageFilePath, "r")){
			$PersonImage="<span class='avatar'><img src='".$imageFilePath."'></span>";
			}
			else {
			$PersonImage="";
			}
	$label = " ".$staffmember->first_name." ".$staffmember->last_name;
	$link = '?Id='.$staffmember->wp_person_id.'&pageType=home';
	$role =get_person_role($staffmember->wp_person_id);			
			if (in_array ($key, array(3,6,9,12,15,18,21,24,27,30,33,36,39,42,45,48))){
				echo '<div class="ui-block-a">';
			}
			else {
				echo '<div class="ui-block-b">';
			}
				echo '<a href="'.get_bloginfo('url').'?Id='.$staffmember->wp_person_id.'"  ><dt class="person">'.$PersonImage.' <span class="name">' . $label . '</span></dt><dd class="person format_text">'.$role.'</dd></a>';
				echo '</div>';
				endforeach;
				echo  "</dl>";
	}
	
}


class AdminList{
	
	private $listArray=array();
	private $headingArray= array();
	private $type ="";
	private $icon = "";


	public function __construct($array, $type){
		
		// When the class is instartiated take the id passed through and query the database to populate all the variables.
		
	$this->listArray = $array;	
	$this->type = $type;
	
	if ($type=="Groups"){
		
		$this->icon="users";
		$this->headingArray[0]="Group Name";
		$this->headingArray[1]="Teacher";
		$this->headingArray[2]="Year Group";
		$this->headingArray[3]="Team";
		$this->headingArray[4]="Number in Group";	
			
		}
	else if ($type=="Students"){
		
		$this->icon="users";
		$this->headingArray[0]="Name";
		$this->headingArray[1]="Carers";
		$this->headingArray[2]="Mobile";
		$this->headingArray[3]="Home Phone";
		$this->headingArray[4]="Email Address";	
			
		}	
	}
	
// Return the html to create an admin page list

	public function returnAdminHTML(){	
			
			// Page heading.
			echo '<div class="wrap">';
			echo '<div id="icon-'.$this->icon.'" class="icon32"><br></div>';
			echo '<h2>'.$this->type.'</h2>';
		
			//Table heading
			echo '<table class="widefat fixed comments" cellspacing="0"><thead><tr>';
			echo '<th scope="col" id="cb" class="manage-column column-cb check-column" style="">';
			echo '</th>';
			echo '<th scope="col" id="Name" class="manage-column column-author  desc">';
			echo '<span>'.$this->headingArray[0].'</span>';
			echo '</a></th>';
			echo '<th scope="col" id="teacher" class="manage-column column-comment">'.$this->headingArray[1].'</a></th>';
			echo '<th scope="col" id="response" class="manage-column desc" style="">'.$this->headingArray[2].'</a></th>';
			echo '<th scope="col" id="response" class="manage-column desc" style="">'.$this->headingArray[3].'</a></th>';
			echo '<th scope="col" id="response" class="manage-column column-response  desc" style="">'.$this->headingArray[4].'</span></a></th>';
			echo '</tr></thead>';
			
			
			//Table content.
		
			foreach ($this->listArray as $list){
				
				if ($this->type=="Groups"){
				
				$column = array();
				$column[0]= $list['name'];
				$column[1]= $list['teacher'];
				$column[2]= $list['yeargroup'];
				$column[3]= $list['Team'];
				$column[4]= $list['count'];
				$column[5]= $list['image'];
				$column[6]= 'index.php?group_id='.$list['id'];
				}
				else if ($this->type=="Students"){
				
				$column = array();
				$column[0]= $list['name'];
				$column[1]= $list['parents'];
				$column[2]= $list['Mobile'];
				$column[3]= $list['home_phone'];
				$column[4]= $list['email'];
				$column[5]= $list['image'];
				$column[6]= "index.php?person_id=".$list['id'];
				}
				 
			
					echo '<tr id="post-89313" class="alternate author-self status-publish format-default iedit" valign="top">';
					echo '<th scope="row" class="check-column"></th>';
					echo '<td class="post-title page-title column-title"><strong>';
					echo '<a href="'.$column[6].'" title="Edit this item">';
				 	$imageFilePath = $column[5];
					if (fopen($imageFilePath, "r")){
					$PersonImage="<img src='".$imageFilePath."' class='personImage'>";
					}
					else {
					$PersonImage="";
					}	
					echo $PersonImage." ".$column[0];
					echo '</a></strong>';
					echo '<div class="row-actions"><span class="edit">';
					echo '<a href="admin.php?page=group_handle&groupid='.$list['id'].'" title="Edit this item">Edit</a> | </span>';
					echo '<span class="trash"><a class="submitdelete" title="Move this item to the Trash" href="wp-admin/post.php?post=89313&amp;action=trash&amp;_wpnonce=5e25fcc6bb">Trash</a> | </span>';
					echo '<span class="view"><a href="?learning_post=my-post-29" title="View "My post"" rel="permalink">View</a></span></div>';
					echo '</div></td>';			
					echo '<td ><a href="">';
					echo $column[1];
					echo '</a></td>';
					echo '<td ><a href="">';
					echo $column[2];
					echo '</a></td>';
					echo '<td ><a href="">';
						echo $column[3];
					echo '</a></td>';
					echo '<td class="date column-date">';
							echo $column[4];
					echo '</td>';
					echo '</tr>';
					
			}
			
			//table footer
					
		echo '<tfoot><tr>';
			echo '<th scope="col" id="cb" class="manage-column column-cb check-column" style="">';
			echo '</th>';
			echo '<th scope="col" id="Name" class="manage-column column-author sortable desc">';
			echo '<span>'.$this->headingArray[0].'</span>';
			echo '</th>';
			echo '<th scope="col" id="teacher" class="manage-column column-comment">'.$this->headingArray[1].'</th>';
			echo '<th scope="col" id="response" class="manage-column sortable desc" style="">'.$this->headingArray[2].'</th>';
			echo '<th scope="col" id="response" class="manage-column sortable desc" style="">'.$this->headingArray[3].'</th>';
			echo '<th scope="col" id="response" class="manage-column column-response sortable desc" style="">'.$this->headingArray[4].'</span></th>';
			echo '</tr></tfoot>
		
			<tbody id="the-comment-list" class="list:comment"></tbody>
		</table>';
			echo '</div>';	
			
	}
}



?>