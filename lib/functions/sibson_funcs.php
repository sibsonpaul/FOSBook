<?php

/**

Miscellaneous functions that call bits of data to be used in classes or called directly from the script. 

	1. BUTTONS AND LINKS.
	2. ASSESSMENT DETAILS.
	3. MENUS.
	4. POST PRESENTATION.


**/


// BUTTONS AND LINKS.


function sibson_button($type, $title, $id, $label){
	
	echo "<a href='#dialog' data-rel='dialog' data-role='button' data-inline='true' data-theme='b' data- data-dialogtype='".$type."' data-id='".$id."' data-title='".$title."' class='loaddialog'>";
	echo $label;									
	echo "</a>";	
	
}

function return_sibson_button($type, $title, $id, $label, $url){
	
	$button = "<a href='".$url."' data-rel='dialog' data-role='button' data-inline='true' data-theme='b' data- data-dialogtype='".$type."' data-id='".$id."' data-title='".$title."' class='loaddialog'>";
	$button .= $label;									
	$button .= "</a>";	
	
	return $button;
}



function update_or_insert_people_meta($meta_key, $meta_value, $person_id){
	
		
			global $wpdb;
			
			$check = $wpdb->get_row($wpdb->prepare("Select umeta_id, meta_value from wp_peoplemeta where wp_person_id = %d and meta_key = %s", $person_id, $meta_key));
			
			$person = new Person($person_id);
			
			if ($check->umeta_id){  // if already exists.
			
	
				
				$result = $wpdb->update( 'wp_peoplemeta', array('meta_value' => $meta_value), array ( 'umeta_id' => $check->umeta_id ));
				
										 if ($result == 1){
												$old ="$check->meta_value";
												$logData ="Meta data changed for key ($meta_key), value set to $meta_value. Old value was $check->meta_value ";
												 
											$log = new changeLog();
												$data = array(
												'table'=> 'wp_peoplemeta',
												'oldvalue' => $old,
												'newvalue' => $logData,
												'name'=> $person->returnName()
												);
												$log->insertLog($data);
												}
				}
				else {
					$result =  $wpdb->insert( 'wp_peoplemeta', array('wp_person_id'=> $person_id, 'meta_key' => $meta_key, 'meta_value' => $meta_value));
					
											 if ($result == 1){
													$old ="";
													 $logData ="Meta data added for key ($meta_key), value set to $meta_value ";
													 
												$log = new changeLog();
													$data = array(
													'table'=> 'wp_peoplemeta',
													'oldvalue' => $old,
													'newvalue' => $logData,
													'name'=> $person->returnName()
													);
													$log->insertLog($data);
													}
				}
	
	
	
}

function sibson_badge($id, $image, $title, $detail, $ajax ="true", $selectable ="false", $pageType='', $meta, $class=''){


echo '<a ';
if ($ajax==false && $selectable == false){
echo 'href="?accessId='.$id.'&pageType='.$pageType.'" rel="external" ';

}
else if ($ajax==true && $selectable==false) {
echo 'href="#dialog" data-rel="dialog" ';
}
else if ($ajax==false && $selectable==true) {

}

echo 'data-id="'.$id.'" ';
echo $meta;
echo ' class="badge  '.$class.'" >';
echo '<span class="avatar">'.$image.'</span>';
echo '<span class="name">' . $title . '</span>';
echo "<br />";

for ($i=0; $i<count($detail);$i++){

echo $detail[$i];

}
if ($selectable == true){
echo '<br /><input type="checkbox" class="chkbx" id="chbx_'.$id.'" name="'.$id.'"/>';
}
echo "<br /></a>";	
	
}


function show_indicator($id){
	
	global $wpdb;
	
	$detail =$wpdb->get_var($wpdb->prepare("SELECT
	assessment_description
FROM wp_assessment_terms
where ID = %d",$id));
	
	echo $detail;
}

function sibson_badge_from_array($badgeArray){
	
if ($badgeArray['indicatorId']){
		
		switch ($badgeArray['theme']){
			
		case "secure";
		$theme = "d personSecure";
		break;
		case "developing";
		$theme = "f personDeveloping";
		break;
		case "notsetyet";
		$theme = "notsetyet";
		break;
		default;
		$theme = "notsetyet";
		
		}
}
else {
	switch ($badgeArray['theme']){
	 case "selected";
	 $theme = "d ";
	 break;	
	}
	
	$theme .= "selectable";
	

}

echo '<a ';


echo 'data-personid="'.$badgeArray['id'].'" ';

echo ' class="badge '.$theme.'" '; 
echo 'data-id="'.$badgeArray['indicatorId'].'" data-name="'.$badgeArray['name'].'">';
if ($badgeArray['counter']==true){
echo '<span class="counter red hidden"></span>';	
}

echo '<span class="avatar">'.$badgeArray['image'].'</span>';
echo '<span class="name">' . $badgeArray['name'] . '</span>';
echo "<br />";
echo "<br /></a>";	
	
}


function sibson_badge_return($id, $image, $title, $detail, $ajax ="true", $selectable ="false", $pageType, $addClass, $photoNumber){


$badge = '<a ';
if ($ajax==false && $selectable == false){
$badge .= 'href="?accessId='.$id.'&pageType='.$pageType.'"';
$class="load-person";
}
else if ($ajax==true && $selectable==false) {
$class ="ajaxLink";
}
else if ($ajax==false && $selectable==true) {
$class ="selectBox";
}

$badge .= 'data-id="'.$id.'" rel="external"';
$badge .= 'class="badge  '.$class.' '. $addClass.'" id="'.$photoNumber.'">';
$badge .= '<span class="avatar">'.$image.'</span>';
$badge .= '<span class="name">' . $title . '</span>';
$badge .= "<br />";

for ($i=0; $i<count($detail);$i++){

$badge .= $detail[$i];

}
if ($selectable == true){
$badge .= '<br /><input type="checkbox" class="chkbx" id="chbx_'.$id.'" name="'.$id.'"/>';
}
$badge .= "<br /></a>";	
	
return $badge;	
}

function sibson_link_badge($image, $url, $title, $count){
	
	echo '<a ';

echo 'href="'.$url.'"';
echo 'data-ajax="false" ';
echo 'class="badge" >';
echo '<span class="avatar">'.$image.'</span>';
echo '<span class="name">' . $title . '</span>';
if ($count>0){
echo '<span class="counter red">'.$count.'</span>';
}
echo "<br />";


echo "<br /></a>";
	
}
function sibson_nav_li($id, $image, $title, $current){

global $subject;


echo "<li>";


echo '<a ';
echo 'href="?accessId=';
echo $id.'"';
echo " rel='external'>";
echo $image;
echo $title;


echo "</a></li>";	
	
}

// ASSESSMENT DETAILS.

function get_cycle_dates($cycle, $year){
	
	global $wpdb;



$cycle=$wpdb->get_row("SELECT min(date) as min, max(date) as max, cycleid FROM wp_school_dates WHERE wp_school_dates.cycle = $cycle and YEAR(wp_school_dates.date) = $year");

	$cycleArray = array('start' => $cycle->min, 'end' => $cycle->max, 'id' => $cycle->cycleid );
	
	return $cycleArray ;
	
}

function get_previous_cycle_dates($cycleid){
	
	global $wpdb;

$offsetCycle = $cycleid-1;
$cycle=$wpdb->get_row("SELECT min(date) as min, max(date) as max, cycleid FROM wp_school_dates WHERE wp_school_dates.cycleid = $offsetCycle");

$name = sibson_get_cycle_from_id($offsetCycle);

	$cycleArray = array('start' => $cycle->min, 'end' => $cycle->max, 'id' => $cycle->cycleid, 'name'=>$name );
	
	return $cycleArray ;
	
}


function get_next_cycle_dates($cycleid){
	
	global $wpdb;

$offsetCycle = $cycleid+1;
$cycle=$wpdb->get_row("SELECT min(date) as min, max(date) as max, cycleid FROM wp_school_dates WHERE wp_school_dates.cycleid = $offsetCycle");

$name = sibson_get_cycle_from_id($offsetCycle);

	$cycleArray = array('start' => $cycle->min, 'end' => $cycle->max, 'id' => $cycle->cycleid, 'name'=>$name );
	
	return $cycleArray ;
	
}


function sibson_get_current_cycle(){

global $wpdb;
$date = date('Y-m-d');


$cycle=$wpdb->get_row("SELECT *, YEAR(date) As year FROM wp_school_dates WHERE wp_school_dates.date = '$date'");

$cycleid = $cycle->cycleid;
$cycleid2 = $cycle->cycleid-1;
$cycleid3 = $cycle->cycleid-2;
$cycleid4 = $cycle->cycleid-3;

$detail = $wpdb->get_results("Select * from wp_cycles where cycleid in ($cycleid, $cycleid2, $cycleid3, $cycleid4) order by cycleid desc");

foreach ($detail as $d){
	
	$cycleArray[] = array('currentId' => $d->cycleid, 'currentName' => $d->Cycle, 'currentYear' => $d->Year );
	
	
}

	return $cycleArray ;


}


function sibson_get_current_week(){

global $wpdb;

$cycle=$wpdb->get_results("select (select school_week from wp_school_dates where date =  CURDATE()) as thisWeek, school_week, term, YEAR(date) as year from wp_school_dates where term = (Select term from wp_school_dates where date =  CURDATE()) and YEAR(date) = YEAR(now()) group by school_week");



	return $cycle ;


}

function sibson_get_cycle_from_id($cycle){

global $wpdb;



$cycle=$wpdb->get_var($wpdb->prepare("SELECT cycle FROM wp_cycles WHERE cycleid = %d", $cycle));



	return $cycle ;


}

function sibson_get_cycle_detail_from_id($cycle){

global $wpdb;



$cycle=$wpdb->get_row($wpdb->prepare("SELECT cycle as name, year FROM wp_cycles WHERE cycleid = %d", $cycle));



	return array('name'=> $cycle->name, 'year'=>$cycle->year );


}





function sibson_lookup_cycle_id($cycleString){
	global $wpdb;
	
	$cycle=$wpdb->get_var($wpdb->prepare("SELECT wp_cycles.cycleid FROM wp_cycles WHERE CONCAT('Cycle ',wp_cycles.Cycle, ', ',wp_cycles.Year) = %s", $cycleString));
	
	return $cycle;
	
}


function sibson_lookup_level_value($levelName, $subject){
	global $wpdb;
	
	$value=$wpdb->get_var($wpdb->prepare("SELECT  assessment_value from wp_assessment_terms where assessment_subject = %s and assessment_description = %s", $subject, $levelName));
	
	return $value;
	
}


// MENUS

function sibson_profile_menu_li($title, $subject, $id, $currentSubject){
	

	if ($currentSubject == $subject){

		$current = "data-theme='a'";	
		
		}


	echo '<li data-icon="false" '.$current.'><a href="?accessId='.$id.'&pageType='.$subject.'" class="tk-menu" data-ajax="false" data-transition="fade" ><img src="'.SIBSON_IMAGES.'/'.$subject.'.png" class="ui-li-icon ui-li-thumb">'.$title.'</a></li>';

}

function sibson_show_comment_counts($id, $all, $thisYear){
	
	for ($i=0; $i<count($all); $i++){
		echo "<li>";
		echo "<span class='check' >";
		echo '<span class="state">';	 
		echo 'Total';
		echo '</span>';
		echo '<span class="day">';
		echo $all[$i]->total;
		echo '</span>';
		echo "</span>";
		echo "<span class='check' >";
		echo '<span class="state">';	 
		echo date('Y');
		echo '</span>';
		echo '<span class="day">';
		echo $thisYear[$i]->total;
		echo '</span>';
		echo "</span>";
	
		echo "<a href='index.php?post_type=".$all[$i]->post_type."&person_id=".$id."'><span class='icon'><img src='".SIBSON_IMAGES."/".$all[$i]->post_type.".png'></span><span class='detail'>".ucfirst($all[$i]->post_type)."</span>";
		echo "</a>";
		echo "</li>";
			
	}
}



// POST PRESENTATION.



function get_the_image_by_scan( $post_id ) {

	/* Search the post's content for the <img /> tag and get its URL. */
	preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $post_id ), $matches );

	/* If there is a match for the image, return its URL. */
	if ( isset( $matches ) && !empty( $matches[1][0] ) )
		return array( 'src' => $matches[1][0] );

	return false;
}



function sibson_create_a_group($groupDetail){

/* Passed an array with the following values:
$groupDetail = array(
	'user_id'=> - user who will own this group
	'room'=> the location of this group
	'year'=>  the year the group exists in
	'type'=>	the type of group
	'group_name'=> the name
	 'team'=> the team the group is in (if any)
	 'team_order'=>  the order 
	 'yearGroup'=> the year group if any
)
*/

global $wpdb; 


 $current_user = wp_get_current_user();
$user_id = $current_user->ID;;	
$room = $groupDetail['room'];	
$year = $groupDetail['year'];	
$type = $groupDetail['type'];	
$group_name = $groupDetail['group_name'];	
$team = $groupDetail['team'];	
$team_order = $groupDetail['team_order'];	
$yearGroup = $groupDetail['yearGroup'];	
	
$groupid = $groupDetail['group_id'];


if ($groupid){
$update = $wpdb->update( 'wp_groups', array('wp_user_id' => $user_id, 'room' => $room, 'year' => $year, 'type' => $type,	'group_name' => $group_name, 'Team' => $team, 'team_order' =>$team_order, 'YearGroup'=> $yearGroup), array('wp_group_id' => $groupid));

				if ($update ==1 ){
										 $oldPost = "Group";
										 $logData = "Group updated - $groupid";
												 
										$log = new changeLog();
											$data = array(
											'table'=> 'wp_groups',
											'oldvalue' => $oldPost,
											'newvalue' => $logData,
											'name'=> ''
											);
											$log->insertLog($data);
										}
	
	return $groupid;
	
	
}
else {
$insert = $wpdb->insert( 'wp_groups', array('wp_user_id' => $user_id, 'room' => $room, 'year' => $year, 'type' => $type,	'group_name' => $group_name, 'Team' => $team, 'team_order' =>$team_order, 'YearGroup'=> $yearGroup));
	
 $newGroup= $wpdb->insert_id;	
 if ($insert ==1 ){
										 $oldPost = "0";
										 $logData = "New Group created $newGroup";
												 
										$log = new changeLog();
											$data = array(
											'table'=> 'wp_groups',
											'oldvalue' => $oldPost,
											'newvalue' => $logData,
											'name'=> ''
											);
											$log->insertLog($data);
										}	
	return $newGroup;
}
}

function sibson_create_group_form($id, $post_id){

		if ($post_id){
		
		$group = new Group($post_id);	
			$detail = $group->returnDetailArray();
			$type = $detail['type'];
			$name = $detail['name'];
			$year = $detail['year'];
			$yeargroup = $detail['yeargroup'];
			$list= $detail['ids'];	
			$location = $detail['room'];
		}
	echo "<div class='form_page' data-name='Location'>";
		
			echo '<fieldset data-role="controlgroup" data-type="horizontal" data-theme="b" >';
				echo 	"<legend>Where will this group be?:</legend>";
				for ($i=1; $i<25; $i++){	
					echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-'.$i.'" value="Room '.$i.'"';
					if ($location == 'Room '.$i){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="radio-comp-'.$i.'">Room '.$i.'</label>';
					
				}
					echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-25" value="admin"';
					if ($location == 'admin'){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="radio-comp-25">Admin Block</label>';
					echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-26" value="village" ';
					if ($location == 'village'){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="radio-comp-26">Village</label>';
					echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-27" value="other"  ';
					if ($location == 'other'){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="radio-comp-27">Other</label>';
			echo "</fieldset>";	
			echo "</div>";	
			
			
	echo "<div class='form_page' data-name='Type'>";
	
	echo '<fieldset data-role="controlgroup" data-type="horizontal" data-theme="b" >';
					echo 	"<legend>What year group are the children in?:</legend>";
					echo '<input data-theme="b" type="radio" name="year-group" id="year-group-0" value="0"  ';
					if ($yeargroup == 0){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="year-group-0">Year 0</label>';	
					echo '<input data-theme="b" type="radio" name="year-group" id="year-group-1" value="1" ';
					if ($yeargroup == 1){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="year-group-1">Year 1</label>';
					echo '<input data-theme="b" type="radio" name="year-group" id="year-group-2" value="2"  ';
					if ($yeargroup == 2){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="year-group-2">Year 2</label>';
					echo '<input data-theme="b" type="radio" name="year-group" id="year-group-3" value="3"  ';
					if ($yeargroup == 3){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="year-group-3">Year 3</label>';
					echo '<input data-theme="b" type="radio" name="year-group" id="year-group-4" value="4"  ';
					if ($yeargroup == 4){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="year-group-4">Year 4</label>';
					echo '<input data-theme="b" type="radio" name="year-group" id="year-group-5" value="5"  ';
					if ($yeargroup == 5){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="year-group-5">Year 5</label>';
					echo '<input data-theme="b" type="radio" name="year-group" id="year-group-6" value="6" ';
					if ($yeargroup == 6){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="year-group-6">Year 6</label>';
					echo '<input data-theme="b" type="radio" name="year-group" id="year-group-7" value="7"  ';
					if ($yeargroup == 7){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="year-group-7">Mixed</label>';
			
			echo "</fieldset>";	
			echo '<fieldset data-role="controlgroup" data-type="horizontal" data-theme="b" >';
					echo 	"<legend>What type of group is this?:</legend>";
					echo '<input data-theme="b" type="radio" name="type-group" id="year-group-0" value="esol"  ';
					if ($type == "esol"){
						echo " checked='checked' ";
						
					};
					echo '/>';
					echo '<label data-theme="b" for="year-group-0">ESOL</label>';	
					echo '<input data-theme="b" type="radio" name="type-group" id="year-group-1" value="gates"   ';
					if ($type == "gates"){
						echo " checked='checked' ";
						};
					echo '/>';
					echo '<label data-theme="b" for="year-group-1">GATES</label>';
					echo '<input data-theme="b" type="radio" name="type-group" id="year-group-2" value="Support"   ';
					if ($type == "Support"){
						echo " checked='checked' ";
						};
					echo '/>';
					echo '<label data-theme="b" for="year-group-2">Support</label>';
					echo '<input data-theme="b" type="radio" name="type-group" id="year-group-4" value="Reading"   ';
					if ($type == "Reading"){
						echo " checked='checked' ";
						};
					echo '/>';
					echo '<label data-theme="b" for="year-group-4">Reading</label>';
					echo '<input data-theme="b" type="radio" name="type-group" id="year-group-5" value="Writing"   ';
					if ($type == "Writing"){
						echo " checked='checked' ";
						};
					echo '/>';
					echo '<label data-theme="b" for="year-group-5">Writing</label>';
					echo '<input data-theme="b" type="radio" name="type-group" id="year-group-6" value="Maths"   ';
					if ($type == "Maths"){
						echo " checked='checked' ";
						};
					echo '/>';
					echo '<label data-theme="b" for="year-group-6">Maths</label>';
					echo '<input data-theme="b" type="radio" name="type-group" id="year-group-7" value="Release"   ';
					if ($type == "Release"){
						echo " checked='checked' ";
						};
					echo '/>';
					echo '<label data-theme="b" for="year-group-7">Release</label>';
			
			echo "</fieldset>";	
			
			echo "</div>";
			echo "<div class='form_page' data-name='Children'>";
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
			echo "<ul id='hiddenCheckboxes'>";
				if($list){
				foreach ($list as $pers){
						
							$p = new Person($pers);
							echo '<span id="label_'.$pers.'">'.$p->returnName().'</span><input type="checkbox" class="hidden_checkbox" id="check_'.$pers.'" name="person_'.$pers.'" checked="checked" />';
							
						
							}
			}
			else {
				

				$person= new Person($id);		
				$groupid = $person->currentClass();	
					if($groupid){
					$group = new Group($groupid);	
					$idArray = $group->get_id_array();
							foreach ($idArray as $pers){
						
							$p = new Person($pers);
								echo '<span id="label_'.$pers.'">'.$p->returnName().'</span><input type="checkbox" class="hidden_checkbox" id="check_'.$pers.'" name="person_'.$pers.'" checked="checked" />';
					
							}
					}
				}
				echo "</ul>";	
			
			echo '<ul id="selectableList">';
			
			if($list){
				foreach ($list as $pers){
							echo "<li>";
							$p = new Person($pers);
							$p->selectableBadge('','','selected');
							echo "</li>";
							}
			}
			else {
				

				$person= new Person($id);		
				$groupid = $person->currentClass();	
					if($groupid){
					$group = new Group($groupid);	
					$idArray = $group->get_id_array();
							foreach ($idArray as $pers){
							echo "<li>";
							$p = new Person($pers);
							$p->selectableBadge('','','selected');
							echo "</li>";
							}
					}
				}
					echo "</ul>";
				
								
				echo "</div>"; 	
			echo "<div class='form_page' data-name='Finish'>";
			
	    
                
            echo  '<label for="name">What would you like to call the Group?</label>'; 
            echo  '<input type="text" name="name" id="name" value="'.$name.'"/><br />';
           if ($post_id){
			   echo '<input type="submit" name="submit" id="submit" value="Update" data-inline="true" data-theme="b"/>';
		   }
		   else {
			echo '<input type="submit" name="submit" id="submit" value="Create" data-inline="true" data-theme="b"/>';
		   }
	echo "</div>";
	echo '</form>';
	
}



 function sibson_find_assessment_detail($assessment_value, $subject){
	 
	 
global $wpdb;


	$detail=$wpdb->get_var($wpdb->prepare( "SELECT wp_assessment_terms.assessment_short
FROM wp_assessment_terms
where wp_assessment_terms.assessment_value = %s and 
	wp_assessment_terms.assessment_subject = %s", $assessment_value, $subject));
	
	return $detail;
	 
 }
 
 function sibson_explanation($type){
	 
	
	
	if ($type=="reading" || $type=="writing" ||$type=="maths"){
	
	echo "<div data-theme='e' class='highlight'>";
	echo "<h3>Notes for trial.</h3>";
	switch ($type){
		
		case "reading";
	echo "The progress chart for reading may not be fully up to date. In year 1 and 2 children are generally working through the reading colour wheel. In year 3 and 4 children are generally working at Level 2. In year 5 and 6 children are generally working at level 3. <br />Goals that appear here can be clicked on for handy tips and ideas to support reading progress.";
	echo "Explanations of assessments will appear here along with goals and links to helpful videos/ websites. These sections are not all complete for this trial.";
	break;
	
	case "writing";
	echo "The progress chart for writing may not be fully up to date as teachers are currently analysing writing samples. In year 1 and 2 children are generally working at Level 1. In year 3 and 4 children are generally working at Level 2. In year 5 and 6 children are generally working at level 3. <br />Goals that appear here can be clicked on for handy tips and ideas to support reading progress.";
	break;
	
	case "maths";
	echo "The progress chart for maths may not be fully up to date. The chart may look very flat at this time. This is because number is assessed in 'Stages' rather then 'Levels' Each stage is very broad and usually takes two years for children to progress through. In 2012 we will be doing some work on grading children's progress through each stage so that these charts are more useful. in Year 1 and 2 children are generally working on Stage 1,2,3 and 4. In Year 3 and 4 children are generally working at Stage 5. In Year 5 and 6 children are generally working at Stage 6.";
	echo "Explanations of assessments will appear here along with goals and links to helpful videos/ websites. These sections are not all complete for this trial.";
	break;
		
	}

	echo "</div";
	
	}
 }


function get_post_by_title($page_title, $output = OBJECT, $ID=false) {
    global $wpdb;
        $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s", $page_title ));
        if ( $post )
           if ($ID == false){ 
			return get_post($post, $output);
		   }
		   else if ($ID == true){
			   
			return $post;   
		   }

    return null;
}



function  page_header($pageType, $userLevel){
	$year = date(Y);
	switch ($pageType){
		case "home";
		$heading = "Digital Learning Report ".$year."";
		if ($userLevel >7){
		$postTitle = "Welcome - staff";
		}
		else {
			$postTitle = "Welcome - parent";
		}
		
		break;
		case "foslearn";
		$heading = " FOS Learning";
		$postTitle = "";
		break;
		case "visitors";
		$heading = " Visitor Stats";
		$postTitle = "";
		break;
		case "targets";
		$heading = " Group Targets";
		$postTitle = "";
		break;
		case "baseline";
		$heading = " Baseline Data ";
		$postTitle = "";
		break;
		case "school_stats";
		$heading = " Whole School Statistics ";
		$postTitle = "";
		break;
		case "data";
		$heading = " Compare Data ";
		$postTitle = "";
		break;
		case "general";
		$heading = " General comments";
		$postTitle = "";
		break;
		case "teacher";
		$heading = " Teacher conversation";
		$postTitle = "";
		break;
		case "information";
		$heading = " General information";
		$postTitle = "";
		break;
		case "assessments";
		$heading = " Assessments";
		$postTitle = "";
		break;
		case "sparkle";
		$heading = " Sparkle and Belonging";
		$postTitle = $pageType;
		break;
		case "thinker";
		$heading = " Thinker";
		$postTitle = $pageType;
		break;
		
		case "team_player";
		$heading = " Team Player";
		$postTitle = $pageType;
		break;
		
		case "dream_maker";
		$heading = " Dream Maker";
		$postTitle = $pageType;
		break;
		
		case "communicator";
		$heading = " Communicator";
		$postTitle = $pageType;
		break;
		case "reading";
		$heading = " Reading";
		$postTitle = $pageType;
		break;
		case "writing";
		$heading = " Writing";
		$postTitle = $pageType;
		break;
		case "maths";
		$heading = " Maths";
		$pageType="maths";
		$postTitle = $pageType;
		break;
		case "expectations";
		$heading = " Upholding high expectations";
		
		$postTitle = $pageType;
		break;
		case "knowing";
		$heading = " Knowing the children.";
		
		$postTitle = $pageType;
		break;
		case "learners";
		$heading = " Adults as learners.";
		
		$postTitle = $pageType;
		break;
		case "team";
		$heading = " Being a team.";
		
		$postTitle = $pageType;
		break;
		case "creating";
		$heading = " Creating great learning.";
		
		$postTitle = $pageType;
		break;
		case "environment";
		$heading = " Valuing our people and place.";
		
		$postTitle = $pageType;
		break;
		case "goals";
		$heading = " My Goals.";
		
		$postTitle = $pageType;
		break;
		case "environmentgoals";
		$heading = " Valuing our people and place.";
		$pageType="environment";
			$postTitle = $pageType;
		break;
		
		case "creatinggoals";
		$heading = " Creating great learning.";
		$pageType="creating";
			$postTitle = $pageType;
		break;
		
		case "learnersgoals";
		$heading = " Adults as learners.";
		$pageType="learners";
			$postTitle = $pageType;
		break;
		
		case "teamgoals";
		$heading = " Being a team.";
		$pageType="team";
			$postTitle = $pageType;
		break;
		
		case "knowinggoals";
		$heading = " Knowing the children.";
		$pageType="knowing";
			$postTitle = $pageType;
		break;
		case "expectationsgoals";
		$heading = " Upholding high expectations";
			$pageType="expectations";
			$postTitle = $pageType;
		break;
		
		case "readinggoals";
		$heading = " Reading Goals";
			$pageType="reading";
			$postTitle = $pageType;
		break;
		case "writinggoals";
		$heading = " Writing Goals";
			$pageType="writing";
			$postTitle = $pageType;
		break;
		case "mathsgoals";
		$heading = " Maths goals";
		$pageType="maths";
		$postTitle = $pageType;
		break;
		case "images";
		$heading = " Images";
		$postTitle = $pageType;
		
		break;
			case "roll";
		$heading = " Attendance Register";
		$postTitle = $pageType;
		
		break;
		
		case "confirm";
		$heading = " Please confirm";
		$postTitle = $pageType;
		
		break;
		case "confirm_email";
		$heading = " Email sent";
		$postTitle = "email";
		
		break;
		case "groups";
		$heading = " My Groups";
		$postTitle = $pageType;
		
		break;
		case "support";
		$heading = " Support Programmes";
		$postTitle = $pageType;
		
		break;
		case "behaviour";
		$heading = " Support Programmes";
		$postTitle = $pageType;
		
		break;
		case "staff";
		$heading = " My Learning";
		$postTitle = 'staff home';
		
		break;
		
		
		}
	
						echo "<h2 class='tk-head'>";
						echo "<img src='".SIBSON_IMAGES."/".$pageType."_head.png' />";
						echo $heading;
						 echo "</h2>";    

		echo "<div class='format_text'><p class='intro'>";
			$detail = get_post_by_title($postTitle);
		echo $detail->post_content;
		echo "</p></div>";

}

function  replace_name($string, $personData, $name){
	

	
				$gender = $personData->returnGender();
				
				if  ($gender == "Male"){
				$find = array($name, " she ", " her ", "She ", "Her ", );	
				$replace   = array($personData->returnFirstName(), " he ", " his ", "He ", "His ");
				}
				else {
				$find = array($name, " he ", " his ", "He ", "His ");
				$replace   = array($personData->returnFirstName(), " she ", " her ", "She ", "Her ", );	
					
				}
				
				
				$updatedComment = str_replace($find, $replace, $string);
				return $updatedComment;

}

function sibson_post_buttons($userLevel, $post_id, $author, $id, $user, $pageType){
	
if ($userLevel==10 || $author== $user){
	
	$buttons .= '<div data-role="controlgroup" data-type="horizontal" data-theme="b">';
		$buttons .= '<a href="#dialog" data-rel="dialog"  data-icon="delete" data-id="'.$id.'"  data-dialogtype="delete" data-title="Delete this Post" data-pagetype="'.$pageType.'" data-classtype="Person" data-postid="'.$post_id.'" class="loaddialog" data-theme="b" data-role="button">Delete</a>';
		$buttons .= '<a href="#dialog" data-rel="dialog"  data-icon="info"  data-id="'.$id.'"   data-dialogtype="edit" data-title="Edit this Post" data-pagetype="'.$pageType.'" data-classtype="Person" data-postid="'.$post_id.'" class="loaddialog" data-role="button" data-theme="b">Edit</a>';
		$buttons .= '<a href="#dialog" data-rel="dialog"  data-icon="forward"  data-id="'.$id.'"   data-dialogtype="reuse" data-title="Re use this Post" data-pagetype="'.$pageType.'" data-classtype="Person" data-postid="'.$post_id.'" class="loaddialog" data-role="button" data-theme="b">Re-use</a>';
		$buttons .= '</div>';

}

else {
	
}
	return $buttons;
}


function google_cal_feed($url) {
	$feed_url = $url;
	
	$xmlstr = file_get_contents($feed_url);
	

	$xml = new SimpleXMLElement($xmlstr);

	echo '<div id="events">';
	foreach($xml->entry as $entry) {
		echo '<div class="event">';
		
		$gd = $entry->children('http://schemas.google.com/g/2005');

		$event_link = $entry->link->attributes()->href;

		
			echo '<h3><a href="' . $event_link  . '">' . $entry->title . "</a></h3>\n";
	

		$start = date("l, F j \\f\\r\o\m g:ia", strtotime($gd->when->attributes()->startTime) + 7200);
		$end = date("g:ia", strtotime($gd->when->attributes()->endTime) + 7200);

		echo "<p class='event_time'>$start to $end</p></div>";
	}
	echo '</div>';
}


// FORMS

function sibson_form_post_type_select( $pageType, $selection){
	
	if ($pageType){
		
		echo '<input type="hidden" value="'.$pageType.'" name="radio-comp" id="radio-comp"/>';
		
	}
	
	
	else {
	
				echo "<div class='form_page' data-name='Key Competency'>";
								echo '<fieldset data-role="controlgroup" data-type="horizontal" data-theme="b" >';
									
									
										
										echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-1" class="radio" value="general" ';
										if($selection == "general"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label data-theme="b" for="radio-comp-1"><img src="'.SIBSON_IMAGES.'/general.png" style="width:20px; margin-right: 10px"/></label>';
										
										echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-2"  class="radio" value="sparkle" ';
										if($selection == "sparkle"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-comp-2"><img src="'.SIBSON_IMAGES.'/sparkle.png" style="width:20px; margin-right: 10px" /></label>';
										
										echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-3"  class="radio" value="thinker"  ';
										if($selection == "thinker"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-comp-3"><img src="'.SIBSON_IMAGES.'/thinker.png" style="width:20px; margin-right: 10px"/></label>';
										
										echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-4"  class="radio" value="communicator" ';
										if($selection == "communicator"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-comp-4"><img src="'.SIBSON_IMAGES.'/communicator.png" style="width:20px; margin-right: 10px"/></label>';
										
										echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-5"  class="radio" value="dream_maker" ';
										if($selection == "dream_maker"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-comp-5"><img src="'.SIBSON_IMAGES.'/dream_maker.png" style="width:20px; margin-right: 10px"/></label>';
										
										echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-6"  class="radio" value="team_player" ';
										if($selection == "team_player"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-comp-6"><img src="'.SIBSON_IMAGES.'/team_player.png" style="width:20px; margin-right: 10px" /></label>';
										
										echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-7"  class="radio" value="reading"  ';
										if($selection == "reading"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-comp-7"><img src="'.SIBSON_IMAGES.'/reading.png" style="width:20px; margin-right: 10px" /></label>';
										
										echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-8"  class="radio" value="writing"  ';
										if($selection == "writing"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-comp-8"><img src="'.SIBSON_IMAGES.'/writing.png" style="width:20px; margin-right: 10px" /></label>';
										
										echo '<input data-theme="b" type="radio" name="radio-comp" id="radio-comp-9"  class="radio" value="maths"  ';
										if($selection == "maths"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-comp-9"><img src="'.SIBSON_IMAGES.'/maths.png" style="width:20px; margin-right: 10px" /></label>';
										
								echo '</fieldset>';
						echo "</div>";
	}
	
		

}

function sibson_form_subject_select($type, $selection){
	if ($type == "sparkle" || $type == "reading" || $type == "maths" || $type =="writing" || $type=="home" || $type=="behaviour"){ // Sparkle, reading, maths and wiriting comments do not need a catagory assigning to them.
	
		echo '<input type="hidden" name="select-subject" id="select-subject" value="0"/>';
		
	}
	else if ($type == 'communicator' || $type == 'thinker' || $type == 'dream_maker' || $type == 'team_player'){
	
			echo "<div class='form_page' data-name='Subject'>";
							echo '<fieldset data-role="controlgroup"  data-theme="b" >';
							
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-science" value="science"   ';
										if($selection == "science"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label data-theme="b" for="radio-subject-science"><img src="'.SIBSON_IMAGES.'/science.png" style="width:20px; margin-right: 10px"/>Science</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-social_science" value="social_science"   ';
										if($selection == "social_science"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-subject-social_science"><img src="'.SIBSON_IMAGES.'/social_science.png" style="width:20px; margin-right: 10px" />Social Science</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-arts" value="arts"    ';
										if($selection == "arts"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-subject-arts"><img src="'.SIBSON_IMAGES.'/arts.png" style="width:20px; margin-right: 10px" />The Arts</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-music" value="music"   ';
										if($selection == "music"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-subject-music"><img src="'.SIBSON_IMAGES.'/music.png" style="width:20px; margin-right: 10px" />Music</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-maori" value="maori"    ';
										if($selection == "maori"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-subject-maori"><img src="'.SIBSON_IMAGES.'/maori.png" style="width:20px; margin-right: 10px" />Maori</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-technology" value="technology"    ';
										if($selection == "technology"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-subject-technology"><img src="'.SIBSON_IMAGES.'/technology.png" style="width:20px; margin-right: 10px" />Technology</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-pe" value="pe"    ';
										if($selection == "pe"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-subject-pe"><img src="'.SIBSON_IMAGES.'/pe.png" style="width:20px; margin-right: 10px" />Health and PE</label>';
										
										
								echo '</fieldset>';
						echo "</div>";
										
   												
									
	}
		else if ($type == 'support'){
	
			echo "<div class='form_page' data-name='Subject'>";
							echo '<fieldset data-role="controlgroup"  data-theme="b" >';
							
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-esol" value="esol"  ';
										if($selection == "esol" || $selection == "ESOL"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label data-theme="b" for="radio-subject-esol"><img src="'.SIBSON_IMAGES.'/esol.png" style="width:20px; margin-right: 10px"/>ESOL</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-support" value="learning_support"   ';
										if($selection == "learning_support"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-subject-support"><img src="'.SIBSON_IMAGES.'/support.png" style="width:20px; margin-right: 10px" />Learning Support</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-subject" id="radio-subject-gates" value="gates"  ';
										if($selection == "gates"){
										echo 'checked="checked" '; 
									}
										echo '/>';
										echo '<label for="radio-subject-gates"><img src="'.SIBSON_IMAGES.'/gates.png" style="width:20px; margin-right: 10px" />GATES</label>';
										
										
										
										
								echo '</fieldset>';
						echo "</div>";
										
   												
									
	}
						
}

function sibson_form_upload($type, $document=false){
	
	if ($type == "behaviour"){
		
		
	}
	else {
		
		if ($document==true){
			echo "<div class='form_page' data-name='Document details'>";
			
				echo '<legend>What would you like to name this resource?</legend>';
								
								echo "<input id ='document_name' type='text'  name='document_name' />"; 
								echo '<legend>Please explain a bit more about this resource.</legend>';
								
								echo "<textarea id ='document_desc' type='text'  name='document_desc'></textarea>"; 
								
						echo "</div>";		
								
					echo "<div class='form_page' data-name='Upload'>";
					echo '<legend>Upload the document (this can only be in the form of a pages document or a pdf):</legend>';				
								echo "<input id ='image_upload' type='file' class='multi' name='document[]' accept='pdf|pages'/>";
								echo "<input data-theme='b' type='submit' value='Done' class='next' id='form_submit' data-inline='true' data-theme='b' />";
							
								
						echo '</div>';
		}
		else{
				echo "<div class='form_page' data-name='Upload an image'>";
								echo '<legend>Upload an image:</legend>';
								
								echo "<input id ='image_upload' type='file' class='multi' name='image[]' accept='png|gif|jpg|jpeg|pdf'/>";
						echo '</div>';
				}
	}
}

function sibson_text_area($content, $id, $type){
	if ($type=="images"){
		
		echo '<input type="hidden" name="postcontent" id="post_content" value=" "/>'; // id changed to post_content (underscore added) so that the javascript doesn't upgrade this to a WYSIWYG editor.
		echo "<input type='hidden' name='person_id' value='".$id."' />";
	}
	else {
		echo '<div class="form_page" data-name="Write">';
								echo '<legend>Write:</legend>';
								echo "<textarea id='postcontent' name='postcontent' data-theme='b'>";
								echo $content;
								echo "</textarea>";
								echo "<input type='hidden' name='person_id' value='".$id."' />";
						echo '</div>';	
	}
}


function sibson_form_resources($type, $contentId, $content){
		echo '<div class="form_page" data-name="'.$type.'">';
								echo '<legend>'.$type.':</legend>';
								echo "<textarea id='".$contentId."' name='".$contentId."' data-theme='b'>";
								echo $content;
								echo "</textarea>";
								echo "<input type='hidden' name='person_id' value='".$id."' />";
						echo '</div>';	
	
	
}
function sibson_refer($pageType){
	
	if ($pageType == "behaviour"){
			echo '<div class="form_page" data-name="Action">';
								echo "What follow up action would like (if any)?";
								
								echo '<div data-role="fieldcontain" data-role="controlgroup">';
								echo	'<fieldset data-role="controlgroup">';
								echo	 '<legend>Agree to the terms:</legend>';
								echo		   '<input type="checkbox" name="checkbox-teamleader" data-theme="b" id="checkbox-1" class="custom" />';
								echo		  ' <label for="checkbox-1">Email a followup request to the team leader</label>';
								
								echo		   '<input type="checkbox" name="checkbox-ap" data-theme="b" id="checkbox-2" class="custom" />';
								echo		  ' <label for="checkbox-2">Email a followup request Ass. Principal</label>';
								
								
							
								echo		'</fieldset>';
								echo	'</div>';
								
							


						echo '</div>';	
	}
	else {
		
		
	}
	
}

function sibson_text_area_mail($id){
	echo '<legend>Email addresses:</legend>';
	
	$group = new Group($id);
		$emailList = $group->get_id_array();
		foreach ($emailList as $key =>$email){
	
			$person = new Person($email);	
			$address = $person->return_email();
			
			$explodeAddress = explode(",", $address);
			foreach ($explodeAddress as $exploded){
				
			$valid = is_email(trim($exploded));
			if ($valid==true){
				if ($key==0){
					$to .= $exploded;
				}
				else {
					$to .= ", ".$exploded;
				}
				}
			}
				
			}
		echo '<textarea row="4"  name="email_list"> '.$to.'</textarea>';
		echo '<legend>Subject:</legend>';
		
		echo '<input type="text" name="subject" value="" />';
								echo '<legend>Write:</legend>';
								echo "<textarea id='postcontent' name='postcontent' data-theme='b'>";
								echo $content;
								echo "</textarea>";
								echo "<input type='hidden' name='person_id' value='".$id."' />";
									echo "<input data-theme='b' type='submit' value='Send message' class='next' id='form_submit' data-inline='true' data-theme='b' />";
					

}
								
	


function sibson_form_publish($date){
	
	
			echo '<div class="form_page" data-name="Finish" >';
						
						echo '<fieldset data-role="controlgroup" data-type="horizontal">';
								echo '<legend>Publish:</legend>';
								echo '<input type="radio" name="radio-publish" id="radio-choice-publish" value="publish"  data-theme="b"/>';
								echo '<label for="radio-choice-publish">Parents can view</label>';
								echo '<input type="radio" name="radio-publish" id="radio-choice-draft" value="draft"  checked="checked" data-theme="b" />';
								echo '<label for="radio-choice-draft">Draft</label>';
								
								
					echo '</fieldset>';
				
					?>
            <div id="date_picker">        
			<input name="post_date" id="post_date" type="date" data-role="datebox" value="<?php if ($date) { echo  date('l jS F Y', strtotime($date));;} else { echo date("l jS F Y"); }; ?>"
   data-options='{"mode": "calbox", "blackDates": [<?php echo $blackDates; ?>], "disableManualInput": true, "dateFormat": "ddd ddSS mmm YYYY" }'>
            </div>
            <br />
                <?php 
						echo "<input data-theme='b' type='submit' value='Done' class='next' id='form_submit' data-inline='true' data-theme='b' />";
						echo '</div>';
	
}
function sibson_form_staff_publish($date){
					echo '<div class="form_page" data-name="Finish" >';
					echo '<input type="hidden" name="radio-publish" id="radio-choice-publish" value="publish"  data-theme="b"/>';
					?>
            <div id="date_picker">        
			<input name="post_date" id="post_date" type="date" data-role="datebox" value="<?php if ($date) { echo  date('l jS F Y', strtotime($date));;} else { echo date("l jS F Y"); }; ?>"
   data-options='{"mode": "calbox", "blackDates": [<?php echo $blackDates; ?>], "disableManualInput": true, "dateFormat": "ddd ddSS mmm YYYY" }'>
            </div>
            <br />
                <?php 
						echo "<input data-theme='b' type='submit' value='Done' class='next' id='form_submit' data-inline='true' data-theme='b' />";
						echo '</div>';
	
}
	
function sibson_form_nonce($form){
	
	if ( function_exists('wp_nonce_field') )
	wp_nonce_field('sibson_' . $form);
	
}


	



function sibson_display_images($the_query, $user_level, $id){
	
			while ( $the_query->have_posts() ) : 
							$the_query->the_post();
											$post_id = get_the_ID();
											
											$term_list = wp_get_post_terms($post_id, 'person_id', array("fields" => "all"));
												 foreach ($term_list as $p_id) {  
													$person_id =  $p_id->slug;
													$label = $p_id->name;
												}
												
						
											$post_thumbnail_id = get_post_thumbnail_id( $post_id );	
										
										if ( !empty( $post_thumbnail_id ) ){
											
											echo "<span class='imagePage post-".$post_id."'>";
											$img_tag = wp_get_attachment_image($post_thumbnail_id, 'thumbnail');
											echo $img_tag;
											echo "<br />";
											echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$id."&formType=setProfileImage&imageId=".$post_thumbnail_id."' name='profile_image_form_".$post_id."' id='profile_image_form' method='post'>";	
											sibson_form_nonce('profile_image_form');
											
											echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b">';
	echo '<a href="#dialog"  data-dialogtype="delete" data-title="Delete this Image" data-pagetype="Images" data-classtype="Person" data-postid="'.$post_id.'" class="loaddialog" data-rel="dialog"  data-icon="delete" data-theme="b" data-role="button">Delete this image</a>';
	echo "<input type='submit' name='submit' data-theme='b' data-inline='true' value='Set as profile image' />";
	echo '</div>';
											
											
											echo "<br />";
											echo "</form>";
											echo "</span>";
										}

		
						endwhile;
						echo "<br />";
						echo "<div class='spacer'>&nbsp;</div>";
					
}

function sibson_show_key(){

echo '<div class="key">';
					echo '<h3>Key</h3>';
					echo '<span class="key_circle"><span class="dot ui-btn-up-e"></span><span class="text"> Working towards</span></span>';
						echo '<span class="key_circle"><span class="dot ui-btn-up-d"></span><span class="text"> Working at</span></span>';
							echo '<span class="key_circle"><span class="dot ui-btn-up-c"></span><span class="text"> Working above</span></span>';
					echo '</div>';		
	
	
}

function sibson_show_indicator_key(){

echo '<div class="key">';
					echo '<h3>Key</h3>';
					echo '<span class="key_circle"><span class="dot ui-btn-up-b"></span><span class="text"> Not set</span></span>';
						echo '<span class="key_circle"><span class="dot ui-btn-up-f"></span><span class="text"> Current Goal</span></span>';
							echo '<span class="key_circle"><span class="dot ui-btn-up-d"></span><span class="text"> Secure</span></span>';
					echo '</div>';		
	
	
}




function sibson_show_key_bar(){

echo "<div id='progress'>";

echo "<span id='above_key secure ui-btn-up-d ui-btn-corner-left ui-shadow' ></span>";

echo "<span class='at_key developing ui-btn-up-f ui-shadow'></span>";

echo "<span class='below_key notassessed ui-btn-up-b ui-shadow ui-btn-corner-right '></span>";


echo "</div>";
}


	
function sibson_page_buttons($type, $pageType, $id, $name){ // Type indicates if this page is a group page. PageType is a subject eg writing. Id is the id of the group of person concenred. name is a string to be used where neeeded.
	
	switch ($pageType){
	case "images";
	$action = "Upload an image...";
	$title = "Upload an image for ".$name;
	
	break;
	case "writing";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=writinggoals" rel="external" data-theme="b" data-icon="arrow-d" data-role="button">Set Goals</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=writing"  data-icon="arrow-d" rel="external" data-theme="a" data-role="button">Set Data</a>';
	break;
	case "writinggoals";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=writinggoals" rel="external" data-theme="a" data-icon="arrow-d" data-role="button">Set Goals</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=writing"   data-icon="arrow-d" rel="external" data-theme="b" data-role="button">Set Data</a>';
	break;
	case "reading";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=readinggoals" rel="external" data-theme="b" data-icon="arrow-d"  data-role="button">Set Goals</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=reading"  data-icon="arrow-d" rel="external" data-theme="a" data-role="button">Set Data</a>';
	break;
	case "readinggoals";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=readinggoals" rel="external" data-theme="a" data-icon="arrow-d"  data-role="button">Set Goals</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=reading"  data-icon="arrow-d" rel="external" data-theme="b" data-role="button">Set Data</a>';
	break;
	case "maths";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=mathsgoals" rel="external" data-theme="b" data-icon="arrow-d" data-role="button">Set Goals</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=maths"  data-icon="arrow-d" rel="external" data-theme="a" data-role="button">Set Data</a>';
	break;
	case "mathsgoals";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=mathsgoals" rel="external" data-theme="a" data-icon="arrow-d"  data-role="button">Set Goals</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=maths"  data-icon="arrow-d" rel="external" data-theme="b" data-role="button">Set Data</a>';
	break;
	case "general";
	$action = "Write something...";
	break;
	case "thinker";
	$action = "Write something...";
	break;
	case "dream_maker";
	$action = "Write something...";
	break;
	case "team_player";
	$action = "Write something...";
	break;
	case "communicator";
	$action = "Write something...";
	break;	
	case "sparkle";
	$action = "Write something...";
	break;
	case "teacher";
	$action = "Write something...";
	$description = sibson_post_template('writing questions for children');
	
	$extraButtons = '<a href="#dialog" data-rel="dialog"  data-icon="arrow-u" data-dialogtype="write" class="loaddialog"  data-title="Writing questionnaire for '.$name.'" data-description="'.$description.'" data-pagetype="'.$pageType.'" data-id="'.$id.'" data-theme="b" data-role="button">Writing questionnaire</a>';
	
	break;
	break;
	case "support";
	$action = "Write something...";
	$description = sibson_post_template('behaviour template');
	$extraButtons = '<a href="#dialog" data-rel="dialog"  data-icon="arrow-u" data-dialogtype="write" class="loaddialog"  data-title="Record a behaviour incident for '.$name.'" data-description="'.$description.'" data-pagetype="behaviour" data-id="'.$id.'" data-theme="b" data-role="button">Record a behaviour incident</a>';
	break;
	case "behaviour";
	$action = "Write something...";
	$description = sibson_post_template('behaviour template');
	$extraButtons = '<a href="#dialog" data-rel="dialog"  data-icon="arrow-u" data-dialogtype="write" class="loaddialog"  data-title="Record a behaviour incident for '.$name.'" data-description="'.$description.'" data-pagetype="behaviour" data-id="'.$id.'" data-theme="b" data-role="button">Record a behaviour incident</a>';
	break;
	
	case "goals";
	$action = "Set a new goal";
	$title="Set a new goal";
	$desc = sibson_post_template('staff goals template');

	
	break;
	
	case "environment";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=environment"  data-icon="arrow-d" rel="external" data-theme="a" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=environmentgoals" rel="external" data-theme="b" data-role="button">Set Goals</a>';
	break;
	case "environmentgoals";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=environment"  data-icon="arrow-d" rel="external" data-theme="b" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=environmentgoals" rel="external" data-theme="a" data-role="button">Set Goals</a>';
	break;
	
	case "learners";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=learners"  data-icon="arrow-d" rel="external" data-theme="a" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=learnersgoals" rel="external" data-theme="b" data-role="button">Set Goals</a>';
	break;
	case "learnersgoals";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=learners"  data-icon="arrow-d" rel="external" data-theme="b" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=learnersgoals" rel="external" data-theme="a" data-role="button">Set Goals</a>';
	break;
	
	case "team";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=team"  data-icon="arrow-d" rel="external" data-theme="a" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=teamgoals" rel="external" data-theme="b" data-role="button">Set Goals</a>';
	break;
	case "teamgoals";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=team"  data-icon="arrow-d" rel="external" data-theme="b" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=teamgoals" rel="external" data-theme="a" data-role="button">Set Goals</a>';
	break;
	
	case "knowing";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=knowing"  data-icon="arrow-d" rel="external" data-theme="a" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=knowinggoals" rel="external" data-theme="b" data-role="button">Set Goals</a>';
	break;
	case "knowinggoals";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=knowing"  data-icon="arrow-d" rel="external" data-theme="b" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=knowinggoals" rel="external" data-theme="a" data-role="button">Set Goals</a>';
	break;
	
		case "creating";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=creating"  data-icon="arrow-d" rel="external" data-theme="a" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=creatinggoals" rel="external" data-theme="b" data-role="button">Set Goals</a>';
	break;
	case "creatinggoals";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=creating"  data-icon="arrow-d" rel="external" data-theme="b" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=creatinggoals" rel="external" data-theme="a" data-role="button">Set Goals</a>';
	break;
	
			case "expectations";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=expectations"  data-icon="arrow-d" rel="external" data-theme="a" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=expectationsgoals" rel="external" data-theme="b" data-role="button">Set Goals</a>';
	break;
	case "expectationsgoals";
	$action = "Write something...";
	$extraButtons = '<a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=expectations"  data-icon="arrow-d" rel="external" data-theme="b" data-role="button">Comments</a><a href="'.get_bloginfo('url').'?accessId='.$id.'&pageType=expectationsgoals" rel="external" data-theme="a" data-role="button">Set Goals</a>';
	break;
	
	
	case "groups";
	$action = "Add a new group...";
	break;
	}
	
	if ($type=='group'){
	
		echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
				if (!$pageType){
					echo '<a href="'.get_bloginfo('url').'?accessId='.$id.'&type=Group&print=true" rel="external" id="print" data-theme="b" data-role="button">Print a basic classlist</a>';
					echo '<a href="'.get_bloginfo('url').'?accessId='.$id.'&type=Group&print=true&pageType=phoneTable" rel="external" id="print" data-theme="b" data-role="button">Print an address classlist</a>';
					echo '<a href="#dialog" data-rel="dialog"  data-icon="plus"  data-icon="arrow-u" class="loaddialog" data-title="Duplicate a group" data-id="'.$id.'" data-dialogtype="duplicate_group" data-theme="b" data-role="button">Duplicate this group</a>';
					echo '<a href="#dialog" data-rel="dialog"  data-icon="gear"  data-icon="arrow-u" data-postid="'.$id.'" data-dialogtype="editGroup"  data-title="Edit the group named '.$name.'" class="loaddialog" data-role="button" data-theme="b">Edit this group</a>';
					echo '<a href="#dialog" data-rel="dialog"  data-icon="arrow-u"   data-icon="arrow-u" data-id="'.$id.'" data-dialogtype="emailGroup"  data-title="Email the parents in the group named '.$name.'" class="loaddialog" data-role="button" data-theme="b">Email the parents</a>';
				}
				else {
						
				
				
				}
		echo $extraButtons;
		echo '</div>';
	
	}
	if ($type=='person'){
		if ($pageType=="groups"){
			echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
			echo '<a href="#dialog" data-id="'.$id.'" data-dialogtype="groupform" data-title="'.$title.'" class="loaddialog" data-rel="dialog"    data-icon="arrow-u" data-theme="b" data-role="button">'.$action.'</a>';
		
			echo '</div>';
		}
		else {
			echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
			echo '<a href="#dialog" data-rel="dialog"  data-icon="arrow-u" data-dialogtype="write" class="loaddialog"  data-title="'.$title.'" data-description="'.$desc.'" data-pagetype="'.$pageType.'" data-id="'.$id.'" data-theme="b" data-role="button">'.$action.'</a>';
			echo $extraButtons;
			echo '</div>';
		}
	}

	
}

function sibson_closed_dates(){
	
global $wpdb;

$year = date('Y');

$dates=$wpdb->get_results("SELECT date FROM wp_school_dates WHERE YEAR(wp_school_dates.date)  =$year and school_status='closed'");
	$end = count($dates);
	foreach ($dates as $key =>$date){ 
	if ($key==($end-1)){
	$dateArray.= '"'.$date->date.'"';	
	}
	else {
		$dateArray.= '"'.$date->date.'", ';	
	}
	}
	return $dateArray;
	
}

function sibson_get_date_id($date){
	
	global $wpdb;
if (!isset($date)){
	$date = date("Y-m-d");
}

$dateId=$wpdb->get_var("SELECT Id FROM wp_school_dates WHERE wp_school_dates.date = '$date'");
	
	return $dateId;
	
}

function register_list($idArray, $date, $pageType){
	
foreach($idArray as $person_id){
			$assessment = new Assessment( $person_id, $pageType, 'individual');
			$person = new Person ($person_id);
			
			echo "<dt class='post'> ";
           echo  "<span class='avatar'>";
                  $person->showImage();
                                                 echo   "</span>";
                                                  echo "<span class='post_author tk-head'>";
                                                    echo   "<a href='?accessId=".$person_id."' data-ajax='false'  >";        
                                                     $person->showFirstName();
													  echo " ";
													  $person->showLastName();
                                                           echo  " </a>";    
														    echo   "</span>";
                                                       echo "</dt>";
												echo "<dd class='post format_text tk-body'>" ;
												
												$dateId = sibson_get_date_id($date);
												$assessment->register( "group", "am", $dateId);
												$assessment->register( "group", "pm", $dateId);
												
												
							
												  echo "</dd>"; 	
									  
									
				
	}	
}

function sibson_display_edit_options($id){
	
echo '<a href="#" data-personid="'.$id.'" data-role="button" data-theme="b" data-inline="true">Has left</a>';	
	
}


function salt_n_pepper($Id){
	
$salt = "NaCl"; //the chemical symbol for salt.
$salt ="pipernigrum"; //the latin for black pepper. 	
	
$secureId = md5($salt.$Id.$pepper);

return $secureId;	
	
}

function fetch_job_list($currentCycle){
	
	global $wpdb;
	$year = $currentCycle[0]['currentYear'];
	$cycle = $currentCycle[0]['currentName'];
	
	
	$joblist = $wpdb->get_results("SELECT * FROM wp_jobs WHERE year = $year and cycle = $cycle");

	
	
	return $joblist;
	
}

function show_individual_job_list($id){
	
	echo "<ul data-role='listview' data-inset='true' data-theme='b' data-divider-theme='e'>";

	
	$currentCycle = sibson_get_current_cycle();
	
	echo '<li data-role="list-divider"  >Cycle '.$currentCycle[0]['currentName'].'</li>';
	
	$joblist = fetch_job_list($currentCycle);
	$cycle = get_cycle_dates($currentCycle[0]['currentName'], $currentCycle[0]['currentYear']);
	
	$jobCount = count($joblist);
	
	foreach($joblist as $job){

	$jobdone = check_job($id, $job, $cycle['start'], $cycle['end'], $cycle['id']);
	
			if ($jobdone >0){
			$jobCount--;	
			}
			else {
				echo "<li data-icon='false'>";
				if ($job->url == "#write"){
					echo '<a href="#dialog" data-rel="dialog"  data-icon="arrow-u" data-inline="true" data-theme="b" class="loaddialog" data-title="'.$job->job_name.'" data-dialogtype="write" data-id="'.$id.'" data-pagetype="'.$job->post_type.'" data-classtype="'.$job->subject.'" data-description="'.$job->description.'" >'.$job->job_name.'</a>'; 	
				}
				else {
					echo '<a href="'.$job->url.$id.'" rel="external" data-inline="true" data-theme="b">'.$job->job_name.'</a>'; 	
				}
				echo "</li>";
				
			}
		if ($jobCount==0){
			echo "<li data-icon='check'>";
				echo "All jobs are complete for this cycle.";
					echo "</li>";	
				}
	}
	
	echo "</ul>";
	
	
	
}

function check_job($id, $job, $start, $end, $cycleId){
	
	$post_type = $job->post_type;
	$job_type = $job->job_type;
	
	if ($job_type == "post"){
	
	$current_year = date('Y');



	  $the_query = new WP_Query( array( 
																'post_type' => $post_type,
																	'year' => $current_year,
																	'post_status' => 'publish',
																	'tax_query' => array(
																	array(
																		'taxonomy' => 'person_id',
																		'field' => 'slug',
																		'terms' => $id
																		)
																	)
																) 
															);	
		
		while ( $the_query->have_posts() ) : 
							$the_query->the_post();
							$post_id = get_the_ID();
							$post_date = get_the_date("Y-m-d");
							
							if ($post_date <= $end && $post_date >= $start){
								return $post_id;
							}
												
												
											
						endwhile;
					
						
	}
	
	else if ($job_type == "assessment"){
		
		$assessment = new Assessment ($id, $post_type);
		
		return $assessment->fetchDataByCycle($cycleId);
		
	}
	
	else if ($job_type == "goals"){
		
			$assessment = new Assessment ($id, $post_type);
			
			return $assessment->fetchGoalsByCycle($cycleId);
	}
					
	
	
}

function fetch_staff_job_list($id, $area){
	
	global $wpdb;
	
	
	$joblist = $wpdb->get_results($wpdb->prepare("SELECT wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description,
	wp_assessment_terms.assessment_link, 
	wp_assessment_data.person_id, 
	wp_assessment_data.area
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.ID WHERE person_id = %d and area = %s", $id, $area));

	
	
	return $joblist;
	
}

function show_staff_job_list($id){
	
	echo "<ul data-role='listview' data-inset='true' data-theme='b' data-divider-theme='e'>";
	echo '<li data-role="list-divider"  >My Goals</li>';
	$joblist = fetch_staff_job_list($id, 'developing');
	$joblistpd = fetch_staff_job_list($id, 'pd');
	
	
	foreach($joblist as $job){
			
		echo "<li data-icon='false'>";
		
	
		
			echo '<a href="#dialog" data-rel="dialog"  data-icon="arrow-u" class="loaddialog" data-inline="true" data-theme="b" class="loaddialog"  data-dialogtype="post" data-indicatortype="'.$job->assessment_type.'" data-postid="'.$job->assessment_link.'" data-title="'.$job->assessment_description.'" >'.$job->assessment_description.'</a>'; 	
		
		echo "</li>";
	}
	echo '<li data-role="list-divider"  >My PD requests</li>';
		foreach($joblistpd as $jobpd){
			
		echo "<li data-icon='false'>";
		
				echo '<a href="#dialog" data-rel="dialog"  data-icon="arrow-u" class="loaddialog" data-inline="true" data-theme="b" class="loaddialog"  data-dialogtype="post" data-indicatortype="'.$jobpd->assessment_type.'" data-postid="'.$jobpd->assessment_link.'" data-title="'.$jobpd->assessment_description.'" >'.$jobpd->assessment_description.'</a>'; 		
		
		echo "</li>";
	}
	

	
	echo "</ul>";
	
	
	
}

function check_job_staff($id, $job, $start, $end, $cycleId){
	
	
	
}


function sibson_posts_to_html($the_query, $user_level, $user, $id, $yearLevel, $name, $pronoun){
		$content = array();	
	
	if ( have_posts() ) :
			while ( $the_query->have_posts() ) : 
							$the_query->the_post();
											$post_id = get_the_ID();
											
											$term_list = wp_get_post_terms($post_id, 'person_id', array("fields" => "all"));
												 foreach ($term_list as $p_id) {  
													$person_id =  $p_id->slug;
													$label = $p_id->name;
												}
										$category = get_the_category();
										$user_person_id = get_the_author_meta('person_id');
										$user_person = new Person($user_person_id);
										$class_array =get_post_class();
										foreach ($class_array as $class){ 
										$classlist .= $class." ";
										};
										$post_type = get_post_type();
										 $status = get_post_status(); 
										  if ($status=="draft"){
															$status_message = "<p class='draft'>Draft (parents can not see this post until it is published.)</p>";   
															   
														   } 
									if ($category){					   
										 $show_icon = "true";
										 }
									else {	   
										 $show_icon = "false";
										}
									 $author = get_the_author_meta('ID');
									 $post_date = get_the_date("l jS F Y");
									 
										$buttons =	 sibson_post_buttons($user_level, $post_id, $author, $person_id, $user, $post_type);		

										$content[$post_id] = array(
										'date'=>get_the_date(),
										'id' => $post_id,
										'title'  => get_the_date(),
										'show_icon'=>$show_icon,
										'icon_image' => $category[0]->slug,
										'icon_name' =>$category[0]->name,
										'icon_desc' =>$category[0]->category_description,
										'the_content' => get_the_content(),
										'badge'=>$user_person->returnBadge(true, false),
										'post_type'=>$post_type,
										'classlist' => $classlist, 
										'status_message' => $status_message,
										'link' => get_permalink(),
										'buttons' => $buttons,
										);
										
							
											 
											
											$classlist=""; // reset the class list to avoid the passing of the previous posts class through to the next one.
											$status_message =""; // reset the status message.
						endwhile;
					
						endif;
                         
						 foreach ($content as $c){			
							echo return_basic_display_template($c);
							   
						}
						
						
										$assessmentR = new Assessment($id, 'reading', 'individual');
										$assessmentW = new Assessment($id, 'writing', 'individual');
										$assessmentM = new Assessment($id, 'maths', 'individual');
									
									/*	$readingData = $assessmentR->return_years_data($yearLevel, $name, $pronoun);
									     foreach ($readingData as $rd){
											 
										$content[$rd['id']] =	$rd; 
										 }
										 $writingData = $assessmentW->return_years_data($yearLevel, $name, $pronoun);
									     foreach ($writingData as $wd){
											 
										$content[$wd['id']] =	$wd; 
										 }
										  $mathsData = $assessmentM->return_years_data($yearLevel, $name, $pronoun);
									     foreach ($mathsData as $md){
											 
										$content[$md['id']] =	$md; 
										 }
									*/
									
									$readingGoals = $assessmentR->return_years_goals($name);
									$writingGoals = $assessmentW->return_years_goals($name);
									$mathsGoals = $assessmentM->return_years_goals($name);
									
									
							
							
						
				
				
			
	
	
}



function sibson_display_teaching_posts($the_query, $user_level, $user, $person_id, $term_id, $indicator){
		$content = array();	
	if ( have_posts() ) :
			while ( $the_query->have_posts() ) : 
							$the_query->the_post();
											$post_id = get_the_ID();
											
										
								  
										 $show_icon = "false";
										
										 
									 $user_person_id = get_the_author_meta('person_id');
										$user_person = new Person($user_person_id);
									
								
										$content[$post_id] = array(
										
										'id' => $post_id,
										'title'  => get_the_title(),
										'show_icon'=>'',
										'icon_image' => '',
										'icon_name' =>'',
										'icon_desc' =>'',
										'badge'=>$user_person->returnBadge(true, false),
										'the_content' => get_the_content(),
										
										'buttons' => '',
										);
										
							
											 
											basic_display_teaching_template ($content[$post_id]);
											
											
						endwhile;
					
						endif;
                               
					
			
	
	
}

function basic_display_teaching_template($content){
	
						  			  
							echo "<dt class='post ";
							 echo $content['classlist'];
							echo "'>";
											
										 echo $content['badge'];
	                                       
                                                           echo   "<span class='post_time tk-body'>";
                                                          
														     echo $content['title'];
															  
                                                               echo  "</span>";
															
															echo $content['status_message'];
                                                          
												
													   echo "</dt>";
												echo "<dd id='post_";
												echo $content['id'];
												echo "' class='post format_text tk-body ".$content['classlist']."' >";
												echo "<p>";
												  
												echo $content['the_content'];
												 
												 echo "</p>";
												
												  echo "<div class='spacer'>&nbsp;</div>";
												  echo "<br />";
												  echo $content['buttons'];
												  echo "</dd>"; 	
												 
												
												
}

function sibson_display_posts($the_query, $user_level, $user){
		$content = array();	
	if ( have_posts() ) :
			while ( $the_query->have_posts() ) : 
							$the_query->the_post();
											$post_id = get_the_ID();
											
											$term_list = wp_get_post_terms($post_id, 'person_id', array("fields" => "all"));
												 foreach ($term_list as $p_id) {  
													$person_id =  $p_id->slug;
													$label = $p_id->name;
												}
										$category = get_the_category();
										$user_person_id = get_the_author_meta('person_id');
										$user_person = new Person($user_person_id);
										$class_array =get_post_class();
										foreach ($class_array as $class){ 
										$classlist .= $class." ";
										};
										$post_type = get_post_type();
										 $status = get_post_status(); 
										  if ($status=="draft" && $post_type !="goals"){
															$status_message = "<p class='draft'>Draft (parents can not see this post until it is published.)</p>";   
															   
														   } 
									if ($category){					   
										 $show_icon = "true";
										 }
									else {	   
										 $show_icon = "false";
										}
									 $author = get_the_author_meta('ID');
									 $post_date = get_the_date("l jS F Y");
									 
										$buttons =	 sibson_post_buttons($user_level, $post_id, $author, $person_id, $user, $post_type);		

										$content[$post_id] = array(
										'id' => $post_id,
										'title'  => get_the_date(),
										'show_icon'=>$show_icon,
										'icon_image' => $category[0]->slug,
										'icon_name' =>$category[0]->name,
										'icon_desc' =>$category[0]->category_description,
										'the_content' => get_the_content(),
										'badge'=>$user_person->returnBadge(true, false),
										'post_type'=> $post_type,
										'classlist' => $classlist, 
										'status_message' => $status_message,
										'link' => get_permalink(),
										'buttons' => $buttons,
										);
										
							
											 
											basic_display_template ($content[$post_id]);
											$classlist=""; // reset the class list to avoid the passing of the previous posts class through to the next one.
											$status_message =""; // reset the status message.
											
						endwhile;
					
						endif;
                               
						echo "</dl>";
			
	
	
}

function sibson_display_post($post_id, $user_level, $user){
		$content = array();	
		
		$post= get_post($post_id);
		$term_list = wp_get_post_terms($post_id, 'person_id', array("fields" => "all"));
												 foreach ($term_list as $p_id) {  
													$person_id =  $p_id->slug;
													$label = $p_id->name;
												}
										
										$category = get_the_category($post_id);
										$user_person_id = get_the_author_meta('person_id', $user);
										$user_person = new Person($user_person_id);
										$class_array =get_post_class('', $post_id);
										foreach ($class_array as $class){ 
										$classlist .= $class." ";
										};
										$post_type = $post->post_type;
										 $status = $post->post_status;
										  if ($status=="draft"){
															$status_message = "<p class='draft'>Draft (parents can not see this post until it is published.)</p>";   
															   
														   } 
									if ($category){					   
										 $show_icon = "true";
										 }
									else {	   
										 $show_icon = "false";
										}
									 $author =  $post->post_author;
									 $post_date = $post->post_date;
									 
										$buttons =	 sibson_post_buttons($user_level, $post_id, $author, $person_id, $user, $post_type);		

										$content[$post_id] = array(
										'id' => $post_id,
										'title'  => get_the_date(),
										'show_icon'=>$show_icon,
										'icon_image' => $category[0]->slug,
										'icon_name' =>$category[0]->name,
										'icon_desc' =>$category[0]->category_description,
										'the_content' => $post->post_content,
										'post_type'=>$post->post_type, 
										'badge'=>$user_person->returnBadge(true, false),
										'classlist' => $classlist, 
										'status_message' => $status_message,
										'link' => '',
										'buttons' => $buttons,
										);
										
							
											 
											basic_display_template ($content[$post_id]);
					
                               
			
	
	
}



function basic_display_template ($content){
	
	/*
	
	This template presents content in a standard way. It takes an array called $content which is used to populate the html. The array needs to include:
										'id' => ccn be any ineteger and is used to identify the content block should it be needed by javascript.
										'title'  => the title to show.
										'show_icon' => true or false whether there is an icon to display on the right of the content block.
										'icon_image' => the image for the icon.
										'icon_name' =>  the name for the icon
										'icon_desc' => a description of the icon.
										'the_content' => the main content to display
										'badge'=> a image tag to display a badge if needed.
										'classlist' => spaced list to assign classes to the html elements.
										'status_message' => an optional status or warning message.
										'link' = any href to add to the title.  
										'buttons' = any html to create buttons a the end of the content.	
												 
					
										);
										
											
	
	
	
	*/
	
	
							echo "<dt class='post ";
							 echo $content['classlist'];
							echo "'>";
											
										 echo $content['badge'];
	                                             echo "<span class='post_author tk-head'>";
                                                        
                                                             echo   "</span>";
                                                           echo   "<span class='post_time tk-body'>";
                                                            echo   "<a href='";
															echo $content['link'];
															echo "'  data-ajax='false'>";  
														     echo $content['title'];
															   echo  " </a>";  
                                                               echo  "</span>";
															
															echo $content['status_message'];
                                                          
												if ($content['show_icon'] == 'true'){		  
													  echo "<span class='icon tk-body' title='".$content['icon_name']."' >";
                                                   		 echo   "<img src='".SIBSON_IMAGES."/".$content['icon_image'].".png' alt='".$content['icon_name']."' class='showTooltip' title='".$content['icon_desc']."' /><p>".ucfirst($content['icon_name'])."</p><br />"; 
                                                       echo "</span>"; 
												}
													   echo "</dt>";
												echo "<dd id='post_";
												echo $content['id'];
												echo "' class='post format_text tk-body ".$content['classlist']."' >";
												echo "<p>";
												  
												echo $content['the_content'];
												 
												 echo "</p>";
												 $iconTypes = array ('team_player', 'dream_maker', 'thinker', 'communicator');
												 $type = sibson_convert_type($content['post_type']);
												 if (in_array($content['post_type'], $iconTypes)){
												
												echo "<img src='".SIBSON_IMAGES."/".$content['post_type'].".png' />";
												echo $type." comment";
												
												 }
												  echo "<div class='spacer'>&nbsp;</div>";
												  echo "<br />";
												  echo $content['buttons'];
												  echo "</dd>"; 	
	
}

function sibson_convert_type($type){
	
	$explode = explode("_", $type);
	
	
	$returnType = ucfirst($explode[0])." ".ucfirst($explode[1]);
	
	return $returnType;

	
	
	
}

function return_basic_display_template ($content){
	
	/*
	
	This template presents content in a standard way. It takes an array called $content which is used to populate the html. The array needs to include:
										'id' => ccn be any ineteger and is used to identify the content block should it be needed by javascript.
										'title'  => the title to show.
										'show_icon' => true or false whether there is an icon to display on the right of the content block.
										'icon_image' => the image for the icon.
										'icon_name' =>  the name for the icon
										'icon_desc' => a description of the icon.
										'the_content' => the main content to display
										'badge'=> a image tag to display a badge if needed.
										'classlist' => spaced list to assign classes to the html elements.
										'status_message' => an optional status or warning message.
										'link' = any href to add to the title.  
										'buttons' = any html to create buttons a the end of the content.	
												 
					
										);
										
											
	
	
	
	*/
	
	
							$display = "<dt class='post ";
							 $display .= $content['classlist'];
							 $display .=  "'>";
											
										  $display .=  $content['badge'];
	                                              $display .=  "<span class='post_author tk-head'>";
                                                        
                                                              $display .=    "</span>";
                                                            $display .=    "<span class='post_time tk-body'>";
                                                             $display .=    "<a href='";
															 $display .=  $content['link'];
															 $display .=  "'  data-ajax='false'>";  
														      $display .=  $content['title'];
															    $display .=   " </a>";  
                                                                $display .=   "</span>";
															
															 $display .=  $content['status_message'];
                                                          
												if ($content['show_icon'] == 'true'){		  
													   $display .=  "<span class='icon tk-body' title='".$content['icon_name']."' >";
                                                   		  $display .=    "<img src='".SIBSON_IMAGES."/".$content['icon_image'].".png' alt='".$content['icon_name']."' class='showTooltip' title='".$content['icon_desc']."' /><p>".ucfirst($content['icon_name'])."</p><br />"; 
                                                        $display .=  "</span>"; 
												}
													    $display .=  "</dt>";
												 $display .=  "<dd id='post_";
												 $display .=  $content['id'];
												 $display .=  "' class='post format_text tk-body ".$content['classlist']."' >";
												 $display .=  "<p>";
												  
												 $display .=  $content['the_content'];
												 
												  $display .=  "</p>";
												 $iconTypes = array ('team_player', 'dream_maker', 'thinker', 'communicator');
												 $type = sibson_convert_type($content['post_type']);
												 if (in_array($content['post_type'], $iconTypes)){
												
												$display .= "<img src='".SIBSON_IMAGES."/".$content['post_type'].".png' />";
													$display .= $type." comment";
												
												 }
												   $display .=  "<div class='spacer'>&nbsp;</div>";
												   $display .=  "<br />";
												   $display .=  $content['buttons'];
												   $display .=  "</dd>";
												   
												   return $display; 	
	
}


function staff_home_page(){
	
		
	 $post = get_post_by_title('staff home');
	 
	 echo $post->post_content;
	 
	
}

function sibson_fetch_filter_list($subject){


echo '<ul>';

if ($subject == "writing"){
	
echo '<li class="filter" data-type="vocabulary"><img src="'.SIBSON_IMAGES.'/vocabulary.png" /></li>';
echo '<li class="filter" data-type="structure"><img src="'.SIBSON_IMAGES.'/structure.png" /></li>';
echo '<li class="filter" data-type="spelling"><img src="'.SIBSON_IMAGES.'/spelling.png" /></li>';
echo '<li class="filter" data-type="grammar"><img src="'.SIBSON_IMAGES.'/grammar.png" /></li>';
echo '<li class="filter" data-type="punctuation"><img src="'.SIBSON_IMAGES.'/punctuation.png" /></li>';
echo '<li class="filter" data-type="layout"><img src="'.SIBSON_IMAGES.'/layout.png" /></li>';
echo '<li class="filter" data-type="language"><img src="'.SIBSON_IMAGES.'/language.png" /></li>';
echo '<li class="filter" data-type="content"><img src="'.SIBSON_IMAGES.'/content.png" /></li>';
echo '<li class="filter" data-type="audience"><img src="'.SIBSON_IMAGES.'/audience.png" /></li>';
}

else if ($usbject=="reading"){
	
}
else if ($subject== "maths"){

echo '<li class="filter" data-type="Strategy"><img src="'.SIBSON_IMAGES.'/strategy.png" /></li>';
echo '<li class="filter" data-type="Knowledge"><img src="'.SIBSON_IMAGES.'/knowledge.png" /></li>';
echo '<li class="filter" data-type="geometry"><img src="'.SIBSON_IMAGES.'/geometry.png" /></li>';
echo '<li class="filter" data-type="measurement"><img src="'.SIBSON_IMAGES.'/Measurement.png" /></li>';
echo '<li class="filter" data-type="statistics"><img src="'.SIBSON_IMAGES.'/statistics.png" /></li>';

	
}


echo '</ul>';
	
}

function sibson_radio_list($data, $orientation){
	
	// $data must be an array of names, labels and sst or not.
	
	echo '<fieldset data-role="controlgroup"  data-theme="b" data-type="'.$orientation.'">';
							
								foreach ($data as $choice){	
								
								$radioName = $choice['name'];
								$id = $choice['id'];
								$value = $choice['value'];
								$existing = $choice['existing'];
								$title = $choice['title'];
							
									
										echo '<input data-theme="b" type="radio" name="'.$radioName.'" id="radio-type-'.$id.'" value="'.$value.'"  ';
										if ($existing == $value){
										echo "checked='checked'";
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-type-'.$id.'">'.$title.'</label>';
								}
									
			echo '</fieldset>';		
	
}

function sibson_stanine_lookup(){



}
function sibson_select_group_ids_by_year($yearGroup){
	
	global $wpdb;
	$year = date('Y');
	$groups = $wpdb->get_results("Select wp_group_id from wp_groups where year= $year and type ='class' and YearGroup = $yearGroup");
	
	return $groups;
	
}

function sibson_post_template($title){
	
	$detail = get_post_by_title($title);
		return $detail->post_content;
	 
}

function sibson_check_user_can_ajax(){


$current_user = wp_get_current_user();
$userId = $current_user->ID;	
$userdata = get_userdata( $userId  );

return $userdata->user_level;	
	
}

function email_the_teachers( $message, $person_id){
	
	// email the teachers associated with a child when a new post has been added.
	
	global $wpdb;
	
	$person = new Person($person_id);
	
	$classArray = $person->returnCurrentClassInfo();
	
	is_email ($classArray['email']);
	
	global $current_user;
			  get_currentuserinfo();
	
	$from = $current_user->user_email;
	
	
	$to = strtolower($classArray['email']);
	
	if ($from == $to){
		// don't send and email if the user is the same person as the class teacher.
	}
	else {
		
			$subject = "A new comment has been made for ".$person->returnName();
			
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	
		
		$message = $message;
		// More headers
	
		
		$headers .= 'From: <'.$from.'>' . "\r\n";
		
		mail($to,$subject,$message,$headers);
	}
}

function email_a_referral( $message, $person_id, $post){
		
	global $wpdb;
	
	
	$person = new Person($person_id);
	
	$classArray = $person->returnCurrentClassInfo();
	global $current_user;
			  get_currentuserinfo();
	
	$from = $current_user->user_email;
	

	
	$to = strtolower($classArray['teamleader']);

	
	if ($post['checkbox-ap']){
		
		$to .= ", ".returnAPEmail();
		$to .= ", ".returnPrincipalEmail();
		
	}
		
			$subject = "A behaviour referral has been made for ".$person->returnName();
			
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	
		
	
		
		$headers .= 'From: <'.$from.'>' . "\r\n";
		
		mail($to,$subject,$message,$headers);
	
	
}

function returnPrincipalEmail(){
	
		$search = "principal";
		global $wpdb;
		$person_id = $wpdb->get_var("Select wp_person_id from wp_peoplemeta where meta_value = '$search'");
		
	
		$person = new Person($person_id);
		$userid = $person->staffMemberId();
	$user = get_userdata( $userid  );
	$email = $user->user_email;
	
	
	
	return $email;
}

function returnAPEmail(){
	
	
		$search = "ap";
		global $wpdb;
		$person_id = $wpdb->get_results("Select wp_person_id from wp_peoplemeta where meta_value = '$search'");
		
	foreach ($person_id as $key=>$p){
		$person = new Person($p->wp_person_id);
		$userid = $person->staffMemberId();
	$user = get_userdata( $userid  );
	$email .= $user->user_email;
	
	if ($key+1 < count($person_id)){
	$email .= ", ";
	}
	}
	
	return $email;
	
}

function check_access_rights(){
	
	$current_user = wp_get_current_user();
	$userdata = get_userdata( $current_user->ID  );
	$user_level =$userdata->user_level;
	
	if ($user_level < 7){
	
	return false;	
	}
	

}

function sibson_get_value_from_string($subject, $value){
	
global $wpdb;

$AdjustedValue = $wpdb->get_var($wpdb->prepare("Select assessment_value from wp_assessment_terms where assessment_subject = %s and assessment_description = %s", $subject, $value));	
	
	return $AdjustedValue;
	
	
}

function check_content_of_page($post){
	
	$postContent = get_post($post, 'ARRAY_A');
	
	if  ($postContent['post_content'] == "As our new digital reporting system grows and develops, more information will be added. This will include videos, images and ideas to help parents to support their children at home. We have not yet added any information for this goal but we will be adding this over the coming months. Thanks!"){
		
		return false;}
		
		else {
			
			return true;
		}
	
	
	
}

function convert_year_to_text($number){
	
	$words= array (
	1=>"one", 2=>"two", 3=>"three", 4=>"four", 5=>"five", 6=>"six", 7=>"seven"
	
	)	;
	
	return $words[$number];
	
	
}

function sibson_fetch_indicator_by_target( $target){
	
	global $wpdb;
	
	$term = $wpdb->get_var($wpdb->prepare("Select ID from wp_assessment_terms where assessment_target = %s", $target));
	
	return $term;
	
	
}


function sibson_fetch_indicator_term( $indicator){
	
	global $wpdb;
	
	$term = $wpdb->get_var($wpdb->prepare("Select assessment_target from wp_assessment_terms where ID = %d", $indicator));
	
	return $term;
	
	
	
}

function sibson_fetch_teaching_links($term_id, $person_id, $indicator, $type){
	
	
	
	echo "<ul data-role='listview' data-inset='true' data-theme='b'>";
	echo "<li data-role='heading' data-theme='f'>";
	
	echo "Resources";
	echo "</li>";
		$new_query = new WP_Query( array( 'post_type' => 'teaching',
																	'post_status'=>'publish' ,
																		'category_name'=>$type,
																		'tax_query' => array(
																		array(
																			'taxonomy' => 'indicator',
																			'field' => 'ID',
																			'terms' => $term_id
																			)
																		)
																	) 
																);	
		
		while ( $new_query->have_posts() ) : 
				$new_query->the_post();
				echo "<li data-icon='arrow-d'>";					
					$content  = get_the_content();	
					echo $content;						
				echo "</li>";								
											
		endwhile;


echo '<li data-icon="plus" data-role="divider" data-theme="a"><a href="#dialog" data-rel="dialog"  data-dialogtype="document" class="loaddialog" data-inline="true"  data-pagetype="'.$type.'" data-description="'.$person_id.'" data-pagetype="document" data-id="'.$indicator.'" data-theme="b">Add a new resource</a></li>';

echo "</ul>";
	
	
}


function sibson_teaching_idea_page($indicator, $id){
	
			$term = sibson_fetch_indicator_term( $indicator);
			 $fixCommaProblem = explode (",",$term);
			
				echo "<h2 class='tk-head'>";
				echo ucfirst($term)."</h2>";
				$term_id  = get_term_by( 'name',  $term, 'indicator' , 'ARRAY_A' );
				
				
				echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
					echo 	'<a href="#dialog" data-rel="dialog" data-icon="plus" data-theme="b" data-role="button" data-inline="true" data-dialogtype="document" class="loaddialog" data-inline="true"  data-description="'.$id.'" data-pagetype="document" data-id="'.$indicator.'" data-theme="b">Upload a new document</a>';
					echo 	'<a href="#dialog" data-rel="dialog" data-icon="plus" data-dialogtype="teachingIdea" class="loaddialog"  data-pagetype="teaching" data-description="'.$id.'"  data-id="'.$indicator.'" data-theme="b" data-role="button">Add a new idea</a>';
		
		echo "</div>";
		
				$the_query = new WP_Query( array( 'post_type' => 'teaching',
																		
																		
																		'tax_query' => array(
																		array(
																			'taxonomy' => 'indicator',
																			'field' => 'ID',
																			'terms' => $term_id
																			)
																		)
																	) 
																);	
																
										sibson_display_teaching_posts($the_query,'', '', $id, $term_id, $indicator);	

}
?>