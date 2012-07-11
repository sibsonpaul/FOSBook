<?php

class Group{
	
	public $id = "";
	private $groupName ="";	
	public $groupType ='';
	private $imageUrl ="";
	private $room ="";
	private $currentYear ="";
	private $idArray = array();
	private $groupLeader = "";
	private $YearGroup="";
	private $Year="";
	private $user_level="";
	private $team ="";
	
	public function __construct($ID){ // on instantiation the group id is passed as a paramater that will be used for all the info.
		
	$this->id = absint($ID);	
	$this->currentYear = date(Y);
	$this->userId = $current_user->ID;
	$this->userType = get_user_meta($this->userId, 'user_type', true);
	$userdata = get_userdata( $this->userId );
	$this->user_level =$userdata->user_level;
	
	global $wpdb;
	
	if (is_array($ID)){
		$this->groupLeader = '';
					$this->groupName = $ID['name'];
					$this->room = $ID['name']; 
					$this->YearGroup = $ID['YearGroup'];
					$this->Year =date('Y');
					$this->groupType = 'yeargroup';
					
					$this->idArray = $ID['ids'];
		
	}
	else {
		

				$group = $wpdb->get_row($wpdb->prepare("SELECT wp_groups.wp_group_id, 
					wp_groups.wp_user_id, 
					wp_groups.room, 
					wp_groups.year, 
					wp_groups.type, 
					wp_groups.group_name, 
					wp_groups.Team, 
					wp_groups.Team_order, 
					wp_groups.YearGroup
				FROM wp_groups
				WHERE wp_groups.wp_group_id = %d order by year asc", $this->id ));	
		
					$this->groupLeader = $group->wp_user_id;
					$this->groupName = $group->group_name;
					$this->room = $group->room; 
					$this->YearGroup = $group->YearGroup;
					$this->Year = $group->year;
					$this->groupType = $group->type;
					$this->team = $group->Team_order;
	}
	
	}
	
	public function showName(){
	
	echo $this->groupName;	
		
	}
	public function returnName(){
	
	return $this->groupName;	
		
	}
	public function showRoom(){
	
	echo $this->room;	
		
	}
	public function returnRoom(){
	
	return $this->room;	
		
	}
	public function showYearGroup(){
	
	echo $this->YearGroup;	
		
	}	
	
	public function returnYearGroup(){
	
	return $this->YearGroup;	
		
	}	
	public function showChildren(){
		$idArray = $this->get_id_array();
		   echo    "<dl  class='post_list'>"; 
	foreach($idArray as $person_id){
	 $person = new Person($person_id);
	 	
	 $person->showPersonDetails();
		
	}
	echo "</dl>";
		
	}
	
	public function showChildrenTable(){
		$idArray = $this->get_id_array();
	echo    '<table border="0" >';
	echo "<tr class='head'>"; 
	echo "<td >";
	
	echo "Name";
	echo "</td>";
	
	echo "<td >";
	
	echo "Email address";
	echo "</td>";
	
	echo "<td>";
	
	echo "Phone";
	echo "</td>";
		echo "<td >";
	
	echo "Mobile Phone";
	echo "</td>";
	
	echo "</tr>";	
	$i =1;
	foreach($idArray as $person_id){
	 $person = new Person($person_id);
	 	
	if ($i % 2 == 0){
	$class= "even";	
	}
	else {
	$class="odd";	
	}
	 $person->showPersonTableRow($class);
		$i++;
	}
	echo "</table>";
		
	}

	
	public function showChildren2(){
		$idArray = $this->get_id_array();
		
		foreach($idArray as $person_id){
		 $person = new Person($person_id);
			
		echo  $person->metaBadge();
			
	}
	
		
	}
	
public function showDetail(){


		echo "<div class='detail' id='group_".$this->id."'>";
		echo $this->childStack();
		echo "<div class='stack_detail'>";
		echo "<h3>";
		echo $this->Year;
		echo "</h3>";
		echo "<p><a href='?accessId=".$this->id."&type=Group' rel='external' >";
		echo $this->returnName();
		echo "</a></p>";
		echo "<p>";
		$count = count($this->get_id_array());
		if ($count==1){
		echo $count." person in this group.";	
		}
		else {
		echo $count." people in this group.";
		}
		echo "</p>";
		echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b">';
		echo '<a  href="#dialog" data-rel="dialog"  data-icon="arrow-u" data-postid="'.$this->id.'"  data-dialogtype="deleteGroup" data-title="Delete this Group" data-pagetype="group" data-classtype="Person" class="loaddialog"  data-theme="b" data-role="button">Delete</a>';
		echo '<a href="#dialog" data-rel="dialog"  data-icon="arrow-u" data-postid="'.$this->id.'" data-dialogtype="editGroup"  data-title="Edit the group named '.$this->returnName().'" class="loaddialog" data-role="button" data-theme="b">Edit</a>';
		echo '</div>';
		echo "</div>";
							
		echo "</div>";
}

public function groupBadge(){
	
	
		$badgeArray = array(
		'id' =>$this->id, 
		'image'=> $this->returnImage('thumbnail'), 
		'name' => $this->returnName(),
		'selectable'=> '',
		'indicatorId'=> '',
		'theme' => ''
		);
	
			
			
		sibson_badge_from_array($badgeArray);
	
}


public function returnEmail(){
	
	$user = get_userdata( $this->groupLeader  );
	return $user->user_email;
	
	
}

public function returnTeamLeaderEmail(){
	
	if ($this->groupType== "Class"){
		$team = $this->team;
		$search = "team_leader_".$team;
		global $wpdb;
		$person_id = $wpdb->get_var("Select wp_person_id from wp_peoplemeta where meta_value = '$search'");
		$person = new Person($person_id);
		$userid = $person->staffMemberId();
	$user = get_userdata( $userid  );
	return $user->user_email;
	
	}
}
public function returnDetailArray(){


	
		$detailArray = array (
			'year'=> $this->Year,
			'name' => $this->returnName(),
			'ids' =>$this->get_id_array(),
			'type' =>$this->groupType,
			'room' => $this->room, 
			'yeargroup' => $this->YearGroup
		);
		
		return $detailArray;
}

public function childStack(){
	
	$idArray = $this->get_id_array();
	
	$rand_keys = array_rand($idArray, 3);
	
	$person1 = $idArray[$rand_keys[0]];
	$person2 = $idArray[$rand_keys[1]];
	$person3 = $idArray[$rand_keys[2]];
	

	$pers1 = new Person($person1);
	$pers2 = new Person($person2);
	$pers3 = new Person($person3);
	
	$badge = '<div class="image_stack">';
	$badge .= $pers1->returnBadge(false, false,'rotate1', 'photo1');
	$badge .= $pers2->returnBadge(false, false, 'rotate2', 'photo2');
	$badge .= $pers3->returnBadge(false, false, 'rotate3', 'photo3');
	$badge .= "</div>";
	return $badge;
}
public function showRegisterSelect(){
	
	$blackDates = sibson_closed_dates();
	
	$idArray = $this->get_id_array();
		   echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."?accessId=".$this->id."&formType=rollForm&type=Group' id='roll_form' method='post'>";	
		    echo '<label for="mydate">Change the Date</label>';
			 ?>
			<input name="rolldate" id="rolldate" type="date" data-role="datebox" value="<?php echo date("l jS F"); ?>"
   data-options='{"mode": "calbox", "blackDates": [<?php echo $blackDates; ?>], "disableManualInput": true, "dateFormat": "ddd ddSS mmm" }'>
            
            <br />
                <?php 
			
			 	  sibson_form_nonce('roll_form');
			 echo    "<dl  class='post_list'>";
		  
register_list($idArray, $date, 'roll');
		echo "</dl>";
		  echo "<input type='submit' value='Next' id='form_submit' data-inline='true' data-theme='b' data-icon='arrow-r' data-iconpos='right' />";
		  echo "</form>";

	
	
	
}

public function indicator_badge_list($indicatorid){

$idArray = $this->get_id_array();
		   echo "<form data-initialForm='' data-ajax='false' action='".htmlentities($_SERVER['PHP_SELF'])."?accessId=".$this->id."&formType=groupSlider&type=Group' id='slider_form' method='post'>";	
		 
		  
	foreach($idArray as $person_id){
			
			$person = new Person ($person_id);
		
               $person->selectableBadge('indicator', $indicatorid);
			
			
			
	}

	
}

public function showAssessmentSpreadsheet($pageType){
	 echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$this->id."&formType=groupSpreadsheet&type=Group&referrer=".$pageType."' id='spreadsheet_form' method='post'>";	
		     echo "<input type='submit' value='Save' id='form_submit' data-inline='true' data-theme='b'  />";
			 echo "<input type='hidden' name='subject' value='".$pageType."' />";
			 	  sibson_form_nonce('spreadsheet_form');
			
	echo '<table class="spreadsheet">';
	echo '<tr class="heading">';
	echo '<td>';
	echo 'Name';
	echo '</td>';
	echo '<td>';
	echo 'Maths';
	echo '</td>';
	echo '<td>';
	echo 'Reading';
	echo '</td>';
	echo '<td>';
	echo 'Writing';
	echo '</td>';
	echo '</tr>';
	$idArray = $this->get_id_array();
		
		  
	foreach($idArray as $person_id){
		
			$person = new Person ($person_id);
			$person->spreadsheetRow();	
	}
		echo '</table>';
		  echo "<input type='submit' value='Save' id='form_submit' data-inline='true' data-theme='b'  />";
		  echo '</form>';
}

public function showAssessmentSpreadsheetGoals($pageType){
	
	echo '<table class="spreadsheet">';
	echo '<tr class="heading">';
	echo '<td>';
	echo 'Name';
	echo '</td>';
	echo '<td>';
	echo 'Maths';
	echo '</td>';
	echo '<td>';
	echo 'Reading';
	echo '</td>';
	echo '<td>';
	echo 'Writing';
	echo '</td>';
	echo '</tr>';
	$idArray = $this->get_id_array();
		
		  
	foreach($idArray as $person_id){
		
			$person = new Person ($person_id);
			$person->spreadsheetGoalsRow();	
	}
		echo '</table>';
		 
}
	
public function showAssessmentSliders($pageType){

if ($pageType == "Spelling" ||$pageType == "writing" ||$pageType == "reading" ||$pageType == "maths" ){
	
		$idArray = $this->get_id_array();
		   echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$this->id."&formType=groupSlider&type=Group' id='slider_form' method='post'>";	
		     echo "<input type='submit' value='Save' id='form_submit' data-inline='true' data-theme='b'  />";
			 echo "<input type='hidden' name='subject' value='".$pageType."' />";
			 	  sibson_form_nonce('slider_form');
			 echo    "<dl  class='post_list'>";
		  
	foreach($idArray as $person_id){
			$assessment = new Assessment( $person_id, $pageType, 'individual');
			$person = new Person ($person_id);
			
			echo "<dt class='post'> ";
         
                  $person->showBadge();
                                         
                                                  echo "<span class='post_author tk-head'>";
                                                    echo   "<a href='?accessId=".$person_id."' data-ajax='false'  >";        
                                                     $person->showFirstName();
													  echo " ";
													  $person->showLastName();
                                                           echo  " </a>";    
														    echo   "</span>";
                                                       echo "</dt>";
												echo "<dd class='post format_text tk-body'>" ;
												 echo  "<p>I am currently working at ";
												  $assessment->currentData();
												  echo ". ";
												  $assessment->returnTargetStatement($person->showCurrenYearLevelforNatStandards());
												  echo ".</p><br />";
												$assessment->slider($this->returnYearGroup(), "group");
												echo "<div id='form_submit_".$person_id."'></div>";
												
							
												  echo "</dd>"; 	
									  
									
				
	}
	
		echo "</dl>";
		
		  echo "<input type='submit' value='Save' id='form_submit' data-inline='true' data-theme='b'  />";
		  echo "</form>";

}


	
	
}

public function showAssessmentData($pageType){

global $wpdb;

$idArray = $this->get_id_array();
$idList= implode(",", $idArray);
$data = $wpdb->get_results ("SELECT wp_assessment_terms.assessment_short as Level, wp_assessment_terms.assessment_description as description, wp_assessment_terms.assessment_type as type, wp_assessment_data.assessment_value, wp_assessment_data.person_id, wp_assessment_data.date, max(wp_assessment_data.cycle), wp_assessment_terms.assessment_measure
			FROM wp_assessment_terms left JOIN wp_assessment_data ON wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject  where wp_assessment_data.assessment_subject ='$pageType' and person_id in ($idList) group by wp_assessment_data.cycle, wp_assessment_data.person_id order by assessment_value asc");

foreach ($data as $key=>$d){
	
	$id = $d->person_id;
	$person = new Person($id);
	if ($pageType =="6 year net"){
		$desc = "";
		
	}
	else {
	$desc = $d->assessment_measure." ".$d->assessment_value."<br/><p>". date('F Y', strtotime($d->date))."</p>";
	}
		$content[$key] = array(
										'id' => '',
										'title'  => '',
										'show_icon'=>false,
										'icon_image' => '',
										'icon_name' =>'',
										'icon_desc' =>'',
										'the_content' =>  $desc,
										'badge'=>$person->returnBadge(true, false),
										'post_type'=> '',
										'classlist' => '', 
										'status_message' => '',
										'link' => '',
										'buttons' => ''
										);
										
							
											 
		echo return_basic_display_template ($content[$key]);									


}





}
		public function showCount(){

			$idArray = $this->get_id_array();		
			echo "There are ";
			echo count($idArray);
			echo " in this group.";
		
	}
	
	
	public function returnCount(){
		$idArray = $this->get_id_array();		

			return count($idArray);
		
	}
	
	
	public function showImage(){
		
		
	$person_id = get_user_meta($this->groupLeader, 'person_id', true);
	$person = new Person($person_id);
	
	echo $person->returnImage('thumbnail');
	}
	
	public function returnImage(){
		
		
	$person_id = get_user_meta($this->groupLeader, 'person_id', true);
	$person = new Person($person_id);
	
	return $person->returnImage('thumbnail');
	}
	
	public function returnTeacherName(){
			
	$person_id = get_user_meta($this->groupLeader, 'person_id', true);
	$person = new Person($person_id);
	
	return $person->returnName();
		
	}
	
	public function returnTeacherId(){
		$person_id = get_user_meta($this->groupLeader, 'person_id', true);
	
	
	return $person_id;
		
		
	}
	
	public function showLinks(){
		
			
		if ($this->groupType =="Staff"){
			
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=home" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/home.png" class="ui-li-icon ui-li-thumb">Home</a></li>';	
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=knowinggoals" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/knowing.png" class="ui-li-icon ui-li-thumb">Knowing the children</a></li>';
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=teamgoals" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/team.png" class="ui-li-icon ui-li-thumb">Being a team</a></li>';
		 	echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=creatinggoals" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/creating.png" class="ui-li-icon ui-li-thumb">Creating great learning</a></li>';
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=learnersgoals" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/learners.png" class="ui-li-icon ui-li-thumb">Adults as learners</a></li>';
			
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=environmentgoals" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/environment.png" class="ui-li-icon ui-li-thumb">Valuing our people and place</a></li>';
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=expectationsgoals" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/expectations.png" class="ui-li-icon ui-li-thumb">Upholding high expectations</a></li>';
		}
		else {
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=home" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/home.png" class="ui-li-icon ui-li-thumb">Home</a></li>';
			if ($this->YearGroup>3){
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=targets" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/target.png" class="ui-li-icon ui-li-thumb">Group Targets</a></li>';
			}
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=readinggoalSpread&fullscreen=true" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/foslearn.png" class="ui-li-icon ui-li-thumb">Group Goals</a></li>';
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=data" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/data.png" class="ui-li-icon ui-li-thumb">Compare Data</a></li>';
			
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=assessments" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/assessments.png" class="ui-li-icon ui-li-thumb">Assessments</a></li>';
		 	echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=reading" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/reading.png" class="ui-li-icon ui-li-thumb">Reading</a></li>';
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=writing" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/writing.png" class="ui-li-icon ui-li-thumb">Writing</a></li>';
			echo '<li data-icon="false"><a href="?type=Group&accessId='.$this->id.'&pageType=maths" rel="external" data-transition="fade"><img src="'.SIBSON_IMAGES.'/maths.png" class="ui-li-icon ui-li-thumb">Maths</a></li>';
		}
		
	}
	
public function get_id_array(){
	global $wpdb;
if ($this->groupType =="yeargroup"){
	
	$idArray=$this->idArray;
}
else {

	$groupIds = $wpdb->get_results($wpdb->prepare("SELECT wp_group_relationships.wp_person_id
FROM wp_people INNER JOIN wp_group_relationships ON wp_people.wp_person_id = wp_group_relationships.wp_person_id
WHERE wp_group_relationships.`vacated` = 0 AND wp_people.`vacated` = 0 AND wp_group_relationships.wp_group_id = %d order by first_name", $this->id ));
$idArray= array();
foreach($groupIds as $personId):

$idArray[] = $personId->wp_person_id;

endforeach;
}
return $idArray;

 
}

public function get_tag_array(){
	global $wpdb;

	$groupIds = $wpdb->get_results($wpdb->prepare("SELECT wp_group_relationships.wp_person_id
FROM wp_people INNER JOIN wp_group_relationships ON wp_people.wp_person_id = wp_group_relationships.wp_person_id
WHERE wp_group_relationships.`vacated` = 0 AND wp_people.`vacated` = 0 AND wp_group_relationships.wp_group_id = %d ", $this->id));
$idArray= array();
foreach($groupIds as $personId):

$idArray[] = "'".$personId->wp_person_id."'";

endforeach;

return $idArray;
 
}

	public function get_group_comment_count(){
	
	global $wpdb;
	$idArray = $this->get_id_array();
	
	$Gates = 0;
	$ESOL = 0;
	$SEN = 0;
	
	foreach ($idArray as $id){
		
		$gatesCount = $this->sibson_get_comment_count($id, 'GATES');
		if ($gatesCount['Count']>0){
		$Gates ++;	
		
			
		}
		$esolCount = $this->sibson_get_comment_count($id, 'ESOL');
		if ($esolCount['Count']>0){
		$ESOL ++;	
		
		}
		$senCount = $this->sibson_get_comment_count($id, 'SpecialNeeds');
		if ($senCount['Count']>0){
		$SEN ++;	
		
		}
		
		
	}
	

$countArray= array('Gates'=>$Gates,'ESOL'=>$ESOL,'SEN'=>$SEN);

return $countArray;
}

public function sibson_get_comment_count($Id, $subject, $subjectName){
	
	global $wpdb;
	if ($subject =='SpecialNeeds'){
	$query = "(wp_terms.slug = 'referral' or wp_terms.slug = 'outcomes' or wp_terms.slug = 'progress')";
	
	
	}
	else if ($subject=="ESOL"){
	$query = "(wp_terms.slug = 'pastoral_care' or wp_terms.slug = 'about_family')";	
	}
	else {
		
		$query = "wp_terms.slug ='".$subject."'";
	}
	
$post_Ids=$wpdb->get_results($wpdb->prepare("SELECT wp_term_relationships.object_id
FROM wp_term_relationships INNER JOIN wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
	 INNER JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
where wp_terms.slug = %d", $Id ));

foreach ($post_Ids as $thisID){
	
	$postIDArray[] = $thisID->object_id;
	
}

$count=$wpdb->get_var("SELECT count(wp_term_relationships.object_id)
FROM wp_term_relationships INNER JOIN wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
	 INNER JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
where $query  and object_id in (".implode(',', $postIDArray).")");
	
$commentCount = array('Cat' =>$subject, 'Count' => $count);

return $commentCount;

}

public function ethnicity_chart(){
	
	echo "<div id='ethnicity_chart'></div>";
	echo "<div id='studentList'></div>";
	
	
global $wpdb;
$idArray = $this->get_id_array();

$assessDataSQL =$wpdb->get_results("SELECT count(DISTINCT wp_peoplemeta.wp_person_id) AS count, wp_peoplemeta.meta_value
FROM wp_peoplemeta INNER JOIN wp_people ON wp_peoplemeta.wp_person_id = wp_people.wp_person_id
where wp_peoplemeta.meta_key = 'Ethnic Origin' and wp_peoplemeta.wp_person_id in (".implode(",", $idArray).") 
group by wp_peoplemeta.meta_value ");

 ?>

<script>

 google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Ethnicity');
        data.addColumn('number', 'Number of Children');
        data.addRows([
         <?php foreach ($assessDataSQL as $assessData):
	
	echo "['".$assessData->meta_value."'";
	echo ",";
	echo $assessData->count."],";
	endforeach;?>
        ]);
	

        var options = {
     width: 400, height: 400,
		  'backgroundColor': 'transparent',
          title: 'Ethnic Makeup'
        };

	
        var chart = new google.visualization.PieChart(document.getElementById('ethnicity_chart'));
        chart.draw(data, options);
		google.visualization.events.addListener(chart, 'select', selectHandler);
	
	function selectHandler(e){
	var selection = chart.getSelection();
	var message = '';
		   for (var i = 0; i < selection.length; i++) {
				var item = selection[i];
				 rowdata = data.getValue(item.row,0);
				
			  }
				jQuery.post(	MyAjax.ajaxurl,
							{action : 'ajax_fetch_auto_group',typeid : <?php echo $this->id;?>,type: 'ethnicity',subject : rowdata}, 
									 function(data) {
													
													jQuery('#studentList').html(data);
										
				
						
										}
		
					)
			}
      }
    
	   
</script>
	
<?php 	
}

public function get_pie_chart_comments(){
	echo "<div id='comment_chart'></div>";
	
	$idArray = $this->get_id_array();
	$commentCount = $this->get_group_comment_count();


 ?>

<script>

 google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawSupportChart);
      function drawSupportChart() {
        var supportdata = new google.visualization.DataTable();
        supportdata.addColumn('string', 'Support Programmes');
        supportdata.addColumn('number', 'Number of Children');
        supportdata.addRows([
		['GATES',
        <?php echo $commentCount['Gates'];?>], 
		   ['ESOL',
           <?php echo $commentCount['ESOL'];?>], 
		   ['SpecialNeeds',
           <?php echo $commentCount['SEN'];?>]
        ]);
	

        var supportoptions = {
     width: 400, height: 400,
		  'backgroundColor': 'transparent',
          title: 'Support Programmes'
        };

	
        var support = new google.visualization.PieChart(document.getElementById('comment_chart'));
        support.draw(supportdata, supportoptions);
		google.visualization.events.addListener(support, 'select', selectHandler);
	
	function selectHandler(e){
	var selection = support.getSelection();
	var message = '';
		   for (var i = 0; i < selection.length; i++) {
				var item = selection[i];
				 rowdata = supportdata.getValue(item.row,0);
				
			  }
				jQuery.post(	MyAjax.ajaxurl,
							{action : 'ajax_fetch_auto_group',typeid : <?php echo $this->id;?>,type: 'comments',subject : rowdata}, 
									 function(data) {
													
													jQuery('#studentList').html(data);
										
				
						
										}
		
					)
			}
      }
    
	   
</script>

<?php }



public function fetch_min_max_data($idArray, $type, $minmax){
	
global $wpdb;
	
	$minMaxData = $wpdb->get_row($wpdb->prepare("SELECT min(wp_assessment_terms.assessment_value) as low, max(wp_assessment_terms.assessment_value) as high
FROM wp_people INNER JOIN wp_assessment_data ON wp_people.wp_person_id = wp_assessment_data.person_id
	 INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_subject = wp_assessment_terms.assessment_subject AND wp_assessment_data.assessment_value = wp_assessment_terms.assessment_value
WHERE  wp_assessment_data.person_id IN (".implode(',', $idArray).") AND wp_assessment_data.area = 'OTJ'  and wp_assessment_data.assessment_subject = %s", $type  ));
	
	$data = array('low' =>$minMaxData->low, 'high'=> $minMaxData->high);
return 	$data;	
	
}
public function fetch_chart_data($dataArray, $idArray, $type, $cycle){
	global $wpdb;
	
	$groupData = $wpdb->get_results($wpdb->prepare("SELECT wp_assessment_terms.assessment_description, 
	wp_people.first_name, 
	wp_people.last_name,
	wp_people.gender, 
	max(wp_assessment_data.date), 
	wp_assessment_data.cycle, 
	wp_assessment_data.area, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_subject, 
	count(wp_assessment_data.assessment_value) as count, 
	wp_assessment_terms.assessment_value
FROM wp_people INNER JOIN wp_assessment_data ON wp_people.wp_person_id = wp_assessment_data.person_id
	 INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_subject = wp_assessment_terms.assessment_subject AND wp_assessment_data.assessment_value = wp_assessment_terms.assessment_value
WHERE ( ( wp_assessment_data.person_id IN (".implode(',', $idArray).") ) AND ( wp_assessment_data.area = 'OTJ' ) and wp_assessment_data.assessment_subject = %s and cycle = %s  ) group by  wp_assessment_data.assessment_value
ORDER BY `wp_assessment_terms`.`assessment_value` ",$type, $cycle ));
	
foreach ($groupData as $data):
	$count = $data->count;
	$Cat = "'".$data->assessment_description."'";
	$value = $data->assessment_value;

	$dataArray[$value]=$count;	
	

endforeach;

return 	$dataArray;
	
	
}
public function get_group_indicatorlist($subject, $level){
	
	global $wpdb;

	
	$searchSubject = $subject."desc";
	
	$indicatorlistSQL =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_terms.ID, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value,
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description
	FROM wp_assessment_terms
	WHERE wp_assessment_terms.assessment_value = %s AND wp_assessment_terms.assessment_subject = '$searchSubject' order by assessment_type desc", $level));

foreach ($indicatorlistSQL as $indicatorList){

$indicators[] = array('ID'=>$indicatorList->ID, 'desc'=>$indicatorList->assessment_description, 'type' =>$indicatorList->assessment_type);
	
}


	$developingDataSQL =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_terms.ID, 
	count(wp_assessment_data.area) AS count, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.ID
WHERE wp_assessment_data.person_id IN (".implode(',', $this->idArray).") AND (wp_assessment_terms.assessment_value = %s and wp_assessment_terms.assessment_subject ='$searchSubject' and wp_assessment_data.area = 'developing')
GROUP BY wp_assessment_data.assessment_value ", $level));

	
	foreach ($developingDataSQL as $develop){
		
		$developingArray[$develop->ID]= $develop->count;
		
	}

	
	for ($i=0; $i< count($indicators); $i++){
	
	$type = $indicators[$i]['type'];
	
	
	$class = $dataArray[$indicators[$i]['ID']]['area'];
	
	if ($class==''){
		
	$class = 'notassessed';	
	}
	
	$indicatorId = $indicators[$i]['ID'];
	
	
	echo "<li class='{$class}Group' data-theme='d' data-hiddenid='{$indicatorId}' data-groupid='{$Id}' data-subject='{$Subject}'><a href='?type=assessmentList&typeid=".$GroupId."&indicatorId=".$indicatorId."' >";
	echo $indicators[$i]['desc'];
	if ($developingArray[$indicatorId]>0){
	echo "<span class='ui-li-count'>".$developingArray[$indicatorId]."</span>";
	}
	echo "</a>";
	echo "</li>";
	
		
	}
	echo "</ul>";
	
	
}



public function groupjobList(){

echo "The list below shows progress through the jobs for the current cycle for the children in this group. Once a job has been completed for all the children in the group it will say 100% complete.";
echo "<ul data-role='listview' data-inset='true' data-theme='b' data-divider-theme='e'>";
	$currentCycle = sibson_get_current_cycle();
	
	echo '<li data-role="list-divider"  >Cycle '.$currentCycle[0]['currentName'].' to do list.</li>';
	
	$joblist = fetch_job_list($currentCycle);
	$cycle = get_cycle_dates($currentCycle[0]['currentName'], $currentCycle[0]['currentYear']);	
	
	
	foreach($joblist as $job){

	
	
		
				echo "<li data-icon='false'>";
				
					echo '<a href="#" data-inline="true" data-theme="b">'.$job->job_name;	
					$jobdone = $this->check_job($id, $job, $cycle['start'], $cycle['end'], $cycle['id']);
					echo $jobdone;
					echo '</a>'; 
				echo "</li>";
				
			
	}
	
	echo "</ul>";
}


public function check_job($id, $job, $start, $end, $cycleid){
	
	
	
	echo "<span class='ui-li-count'>";
	$groupTotal = $this->returnCount();
	
	$post_type = $job->post_type;
	$job_type = $job->job_type;
	
	if ($job_type == "post"){
	
	$current_year = date('Y');
	$count =0;
	  $the_query = new WP_Query( array( 
																'post_type' => $post_type,
																	'year' => $current_year,
																	'post_status' => 'publish',
																	'tax_query' => array(
																	array(
																		'taxonomy' => 'person_id',
																		'field' => 'slug',
																		'terms' => $this->get_tag_array()
																		)
																	)
																) 
															);
		
		while ( $the_query->have_posts() ) : 
							$the_query->the_post();
							$post_id = get_the_ID();
							$post_date = get_the_date("Y-m-d");
							
							if ($post_date <= $end && $post_date >= $start){
								$count ++;
							}
												
												
											
						endwhile;
						
						$percent = $count/$groupTotal *100;
						
						return ceil($percent)."% complete";
	}
	
	else if ($job_type == "assessment"){
		
	$percent = $this->fetchDataByCycle($cycleid, $post_type)/$groupTotal *100;
		
			return ceil($percent)."% complete";
		
	}
	
	else if ($job_type == "goals"){
		
			$percent = $this->fetchGoalsByCycle($cycleid, $post_type)/$groupTotal *100;
		
			return ceil($percent)."% complete";
		
	}
					
	
	
	
	echo "<span>";


	
}

public function targetSpreadsheet($chartArray, $totalinClass){

echo "The targets below are based on children moving by two sub levels in the year. ";
				echo "If all children meet their targets then the following will be true.";
				echo "<br />";
				echo "<table style='width:100%; text-align:center'>";
				echo "<tr style='font-weight:bold'>";
				echo "<td width='15%' class='blank'>";
				
				echo "</td>";
				echo "<td width='15%' class='wellbelow'>";
				echo "Well below";
				echo "</td>";
					echo "<td width='15%' class='below'>";
					echo "Below";
				echo "</td>";
					echo "<td width='15%' class='at'>";
				echo "At";
				echo "</td>";
				echo "<td width='15%' class='above'>";
				echo "Above";
				echo "</td>";
				echo "<td width='15%' class='well above'>";
				echo "Well Above";
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td class='blank'>";
				echo "Children";
				echo "</td>";
				echo "<td class='wellbelow'>";
				echo $chartArray['wellbelow'];
				echo "</td>";
					echo "<td class='below'>";
				echo $chartArray['below'];
				echo "</td>";
					echo "<td class='at'>";
				echo $chartArray['at'];
				echo "</td>";
					echo "<td class='above'>";
				echo $chartArray['above'];
				echo "</td>";
					echo "<td class='well above'>";
				echo $chartArray['well above'];
				echo "</td>";
				echo "</tr>";
					echo "<tr>";
				echo "<td class='blank'>";
				echo "Percentage";
				echo "</td>";
				echo "<td class='wellbelow'>";
				$percent = ($chartArray['wellbelow']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
					echo "<td class='below'>";
				$percent = ($chartArray['below']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
					echo "<td class='at'>";
				$percent = ($chartArray['at']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
					echo "<td class='above'>";
				$percent = ($chartArray['above']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
					echo "<td class='well above'>";
				$percent = ($chartArray['well above']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
				echo "</tr>";
				
				echo "</table>";	
	
}

public function annualReportSpreadsheet($chartArray, $totalinClass ){
	
				echo "<br />";
				echo "<table style='width:100%; text-align:center'>";
				echo "<tr style='font-weight:bold'>";
				echo "<td width='15%' class='blank'>";
				
				echo "</td>";
				echo "<td width='15%' class='wellbelow'>";
				echo "Well below";
				echo "</td>";
					echo "<td width='15%' class='below'>";
					echo "Below";
				echo "</td>";
					echo "<td width='15%' class='at'>";
				echo "At";
				echo "</td>";
				echo "<td width='15%' class='above'>";
				echo "Above";
				echo "</td>";
				echo "<td width='15%' class='well above'>";
				echo "Well Above";
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td class='blank'>";
				echo "Children";
				echo "</td>";
				echo "<td class='wellbelow'>";
				echo $chartArray['wellbelow'];
				echo "</td>";
					echo "<td class='below'>";
				echo $chartArray['below'];
				echo "</td>";
					echo "<td class='at'>";
				echo $chartArray['at'];
				echo "</td>";
					echo "<td class='above'>";
				echo $chartArray['above'];
				echo "</td>";
					echo "<td class='well above'>";
				echo $chartArray['well above'];
				echo "</td>";
				echo "</tr>";
					echo "<tr>";
				echo "<td class='blank'>";
				echo "Percentage";
				echo "</td>";
				echo "<td class='wellbelow'>";
				$percent = ($chartArray['wellbelow']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
					echo "<td class='below'>";
				$percent = ($chartArray['below']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
					echo "<td class='at'>";
				$percent = ($chartArray['at']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
					echo "<td class='above'>";
				$percent = ($chartArray['above']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
					echo "<td class='well above'>";
				$percent = ($chartArray['well above']/$totalinClass)*100;
				echo ceil($percent)."%";
				echo "</td>";
				echo "</tr>";
				
				echo "</table>";	
	
	
}

public function targetPage($subject){

 			$idArray = $this->get_id_array();
				$totalinClass = 0;
				$chartArray = array(
				'wellbelow'=>0,
				'below'=>0,
				'at' =>0,
				'above'=>0,
				'well above'=>0
				);
				echo "<div id='page_content'>";
				foreach ($idArray as $id){
				
				$person = new Person($id);
				$assessment = new Assessment($id, $subject);
				$target = $person->groupTargetBox($assessment);	
				if ($target['lastYearValue']>0){
					$totalinClass++; 
				}
				$chartArray[$target['standard']] ++; 
			
				$displayArray[] = $target['box'];
					
				}
				echo "<h2>".ucfirst($subject)." Targets</h2>";
				$this->targetSpreadsheet($chartArray, $totalinClass);
				
				
				
				foreach ($displayArray as $display){
				
				echo $display;	
					
				}
}

public function idList(){

	$idArray = $this->get_id_array();
		$idList = implode(",", $idArray);	
	
	return $idList;
}

public function fetchDataByCycle($cycle, $post_type){
		
		global $wpdb;
		$idList = $this->idList();
			$Data=$wpdb->get_var($wpdb->prepare("SELECT count(ID)
			FROM wp_assessment_data where assessment_subject ='reading' and person_id in ($idList) and wp_assessment_data.area = 'OTJ' and cycle = $cycle group by assessment_subject", $post_type));
	
	return $Data;
		
		
	}
	
	
public function fetchGoalsByCycle($cycle, $post_type){
		
		global $wpdb;
		
		$idList = $this->idList();
		
			$Data=$wpdb->get_results($wpdb->prepare("SELECT count(ID) FROM wp_assessment_data where assessment_subject = '$post_type'  and person_id in ($idList) and wp_assessment_data.area = 'developing' and cycle = $cycle group by assessment_subject"));
	
	return count($Data);
		
		
	}

public function showContent($pageType){


	if ($pageType =="home"){
					
					echo '<h2 class="tk-head">'.$this->groupName.'</h2>';
					
				if($this->groupType=="Staff"){
				
				}
				else{
					
					
							
					sibson_page_buttons('group', '', $this->id, $this->returnName());
					echo "<p class='print_hide'>Select a button below to highlight the children.</p>";
					sibson_show_key();
					
					echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
					echo '<a href="" data-rel="dialog" data-icon="arrow-d" id="trip" data-theme="b" class="highlight" data-role="button">Trip Permission</a>';
					echo '<a href="" data-rel="dialog" data-icon="arrow-d" id="digital" data-theme="b" class="highlight" data-role="button">Digital Safety</a>';
					echo '<a href="" data-rel="dialog" data-icon="arrow-d" id="medical" data-theme="b" class="highlight" data-role="button">Medical</a>';
					echo '<a href="" data-rel="dialog" data-icon="arrow-d" id="readinghighlight" data-theme="b" class="highlight" data-role="button">Reading</a>';
					echo '<a href="" data-rel="dialog" data-icon="arrow-d" id="writinghighlight" data-theme="b" class="highlight" data-role="button">Writing</a>';
					echo '<a href="" data-rel="dialog" data-icon="arrow-d" id="mathshighlight" data-theme="b" class="highlight" data-role="button">Maths</a>';
					echo '<a href="" data-rel="dialog" data-icon="arrow-d" id="gates" data-theme="b" class="highlight" data-role="button">GATES</a>';
					echo '<a href="" data-rel="dialog" data-icon="arrow-d" id="esol" data-theme="b" class="highlight" data-role="button">ESOL</a>';
					echo '<a href="" data-rel="dialog" data-icon="arrow-d" id="support" data-theme="b" class="highlight" data-role="button">Support</a>';
					echo '</div>';
				}
					$this->showChildren2();
													
														
	}
	
	else if ($pageType == "charts"){
	$this->ethnicity_chart();
					$this->get_pie_chart_comments();
	
}
	else if ($pageType=="reading" || $pageType=="writing" ||$pageType=="maths"){
		
						
							 page_header($pageType, $this->user_level);
							 echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b">';
								echo '<a href="#" class="load_page"  data-icon="arrow-d" data-pagetype="'.$pageType.'goals" data-groupid="'.$this->id.'" data-theme="b" data-role="button">Set Goals</a>';
								echo '<a href="#" class="load_page"  data-icon="arrow-d" data-pagetype="'.$pageType.'" data-groupid="'.$this->id.'" data-theme="b" data-role="button">Data Sliders</a>';
								echo '<a href="#" class="load_page"  data-icon="arrow-d" data-pagetype="spreadsheet" data-referrer="'.$pageType.'"	 data-groupid="'.$this->id.'" data-theme="b" data-role="button">Data Spreadsheet</a>';
								echo '<a href="#" class="load_page"  data-icon="arrow-d" data-pagetype="spreadsheetgoals" data-referrer="'.$pageType.'"	 data-groupid="'.$this->id.'" data-theme="b" data-role="button">Goals Spreadsheet</a>';
								echo '<a href="#" class="load_page"  data-icon="arrow-d" data-pagetype="'.$pageType.'groups" data-groupid="'.$this->id.'" data-theme="b" data-role="button">Create Groups</a>';
								echo "</div>";			 
                			echo "<div id='page_content'>";
							
                           $this->showAssessmentSliders($pageType);
									echo "</div>";
	
	}
	
		else if ($pageType=="knowinggoals" || $pageType=="learnersgoals" ||$pageType=="teamgoals" || $pageType=="creatinggoals" || $pageType=="environmentgoals" ||$pageType=="expectationsgoals"){
		
						
							 page_header($pageType, $this->user_level);
				
		$assessment = new Assessment( $this->id, $pageType, 'staffgroup');
				  $assessment->get_indicatorbuttons(1);
									  
			
	}
	else if ($pageType=="roll" ){
		
						 
							
							 page_header($pageType, $this->user_level);		 
                			
                           $this->showRegisterSelect();
						 
					
						
							
					
	}
	
	else if ($pageType=="assessments" ){
				 
                			
                           	 page_header($pageType, $this->user_level);
								
						$assessment = new Assessment($this->id, $pageType, 'group');
						
						$assessment->showAssessmentsList();	
						echo "<div id='page_content'>";
						echo "</div>";
						 
					
						
							
					
	}
	else if ($pageType=="phoneTable" ){
				 
                			
            
								
						$this->showChildrenTable();
						 
					
						
							
					
	}
	else if ($pageType=="foslearn" ){
				 
            require('foslearn.php');			
            $learn = new FOSLearn();
			
					page_header('foslearn', $this->user_level);
					
					$weekArray = sibson_get_current_week();
	
	echo "Term ".$weekArray[0]->term.", ".$weekArray[0]->year;
	$thisweekId = $weekArray[0]->year."_".$weekArray[0]->thisWeek."_".$weekArray[0]->term;
	
	echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
			
	
			
	foreach ($weekArray as $week){
	$id = $week->year."_".$week->school_week."_".$week->term;
		
	if ($week->thisWeek == $week->school_week){
		$theme = "a";
	}
	else {
		$theme = "b";
	}
	echo '<a href="#" data-id="'.$id.'"  data-title="'.$id.'"  data-icon="arrow-d" data-theme="'.$theme.'" data-role="button">Week '.$week->school_week.'</a>';
	
	}
	
	echo '</div>';			
						$learn->showWeeksTable($this->id, $thisweekId);
						 
					
						
							
					
	}
	else if ($pageType=="data" ){
				 
           
			
					page_header('data', $this->user_level);
					
				$assessment = new Assessment( $this->id, $pageType, 'group');
						 $assessment->compare_spelling_data(false, 'group_data');
						  $assessment->compare_spelling_data(true, 'whole_school_data');
					 $assessment->progress_towards_goals(false, 'writing_group_data');
					
						
							
					
	}
		else if ($pageType=="targets" ){
				 
           
			
				page_header('targets', $this->user_level);
				
					echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
					echo "<a href='#' class='load_page_content' data-action='ajax_load_targets' data-title='Maths targets for ".$this->returnName()."' data-groupid='".$this->id."' data-pagetype='maths' data-role='button' data-inline='true' data-theme='b'>";
					echo "Maths";
					echo "</a>";
					echo "<a href='#' class='load_page_content' data-action='ajax_load_targets' data-title='Maths targets for ".$this->returnName()."' data-groupid='".$this->id."' data-pagetype='reading' data-role='button' data-inline='true' data-theme='b'>";
					echo "Reading";
					echo "</a>";
					echo "<a href='#' class='load_page_content' data-action='ajax_load_targets' data-title='Maths targets for ".$this->returnName()."' data-groupid='".$this->id."' data-pagetype='writing' data-role='button' data-inline='true' data-theme='b'>";
					echo "Writing";
					echo "</a>";
				
				
					echo '</div>';
				
				$this->targetPage('maths');	
				
				echo "</div>";
						
							
					
	}
	else if ($pageType=="readinggoalSpread"){
					
						echo "<h3>";
	echo $this->returnName();
	echo " - ";
	echo "Reading Goals";
	echo "</h3>";	
	$assessment = new Assessment($this->id, 'reading', 'group');
	
	
	$assessment->groupGoalsSpreadsheet($this->get_id_array());
		
		
					
			}	
			else if ($pageType=="writinggoalSpread"){
					
							echo "<h3>";
	echo $this->returnName();
	echo " - ";
	echo "Writing Goals";
	echo "</h3>";	
	$assessment = new Assessment($this->id, 'writing', 'group');
	
	
	$assessment->groupGoalsSpreadsheet($this->get_id_array());
		
		
					
			}	
			else if ($pageType=="mathsgoalSpread"){
					
				echo "<h3>";
	echo $this->returnName();
	echo " - ";
	echo "Maths Goals";
	echo "</h3>";	
	$assessment = new Assessment($this->id, 'maths', 'group');
	
	
	$assessment->groupGoalsSpreadsheet($this->get_id_array());
		
		
					
			}
				else if ($pageType=="teaching"){
				
				
				$indicator = $_GET['teachingId'];
				
				sibson_teaching_idea_page($indicator, $this->id);
				
				
									
			}	
	
	
	else {
						
			  echo    "<dl id='".$pageType."_post_list' class='post_list'>"; 
						  		
				$tagArray =implode(',',$this->get_tag_array()) ;
						
							
					$the_query = new WP_Query( array( 
						'post_type' => $pageType,
						'tax_query' => array(
						array(
							'taxonomy' => 'person_id',
							'field' => 'slug',
							'terms' => $this->get_tag_array()
							)
						)
					) 
				);	
						 
	   	
    sibson_display_posts($the_query, $this->user_level, $this->userid);
	}
					
		
	
		 
	}
	
public function get_id_array_for_year_group(){
	
		$yearGroup = $this->returnYearGroup();
		$year = $this->currentYear;
		
		global $wpdb;
		$otherClasses = $wpdb->get_results("Select wp_group_id from wp_groups where YearGroup = $yearGroup and type = 'Class' and year = $year");
		
		$idArray =  $this->get_id_array();
		foreach ($otherClasses as $other){
		
			$theId = $other->wp_group_id;
				if ($theId == $this->id){
					
				}
				else {
				
				$nextGroup = new Group ($theId);
				$theNextIdArray = $nextGroup->get_id_array();
				
						foreach ($theNextIdArray as $nextId){
						array_push($idArray, $nextId);
						}
					
				}
			
		}
		
		return $idArray;
}

public function standards_pie_chart($type, $year){ // $type is the subject eg reading. $year is either true or false if it is true then it will return the pie chart for the whole year group rather than just this class.
	
	global $wpdb;
	
	if ($year == true){
		$title = ucfirst($type).", year". $yearGroup;
		$yearGroup = $this->returnYearGroup();
		$year = $this->currentYear;
		
		$otherClasses = $wpdb->get_results("Select wp_group_id from wp_groups where YearGroup = $yearGroup and type = 'Class' and year = $year");
		
		$idArray =  $this->get_id_array();
		foreach ($otherClasses as $other){
		
		$theId = $other->wp_group_id;
		if ($theId == $this->id){
			
		}
		else {
		
		$nextGroup = new Group ($theId);
		$theNextIdArray = $nextGroup->get_id_array();
		
		foreach ($theNextIdArray as $nextId){
		array_push($idArray, $nextId);
		}
			
		}
			
		}
		
	}
	else {
	$title = ucfirst($type).", ". $this->returnName();
	$idArray = $this->get_id_array();
	}
	$wbelow =0;
	$below = 0;
	$at = 0;
	$above = 0;
	
	foreach ($idArray as $id){
	
	$person = new Person($id);

	$result = $person->returnStandardData($type);
	

		if ($result == "wellbelow"){
			
				$wbelow++;
			
			}
		else if ($result == "below"){
			
				$below++;
			
			}
			else if ($result == "at"){
				$at++;
			}
			else if ($result == "above"){
				$above++;
			}
		$result ="";	
	
	}
	
	
	
	echo "<div id='".$this->id."_".$type."_chart_div' class='pie_chart'></div>";
	?>

 <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['OTJ', 'Children'],
          ['Well below',  <?php echo $wbelow;?>],
          ['Below', <?php echo $below;?>],
          ['At',  <?php echo $at;?>],
          ['Above', <?php echo $above;?>]
        ]);

        var options = {
          title: '<?php echo $title;?>',
		  backgroundColor: "none",
		  width: 400 
        };

        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $this->id;?>_<?php echo $type;?>_chart_div'));
        chart.draw(data, options);
      }
    </script>
<?php

}

public function pie_chart($type, $year=false){ // $type is the subject eg reading. $year is either true or false if it is true then it will return the pie chart for the whole year group rather than just this class.
	
	global $wpdb;
	
			if ($year == true){
				$title = ucfirst($type).", year". $yearGroup;
				$yearGroup = $this->returnYearGroup();
				$year = $this->currentYear;
				
				$otherClasses = $wpdb->get_results("Select wp_group_id from wp_groups where YearGroup = $yearGroup and type = 'Class' and year = $year");
				
				$idArray =  $this->get_id_array();
				foreach ($otherClasses as $other){
				
				$theId = $other->wp_group_id;
				if ($theId == $this->id){
					
				}
				else {
				
				$nextGroup = new Group ($theId);
				$theNextIdArray = $nextGroup->get_id_array();
				
						foreach ($theNextIdArray as $nextId){
						array_push($idArray, $nextId);
						}
					
				}
					
				}
				
			}
			else {
			$title = ucfirst($type).", ". $this->returnName();
			$idArray = $this->get_id_array();
			}
	
	$wbelow =0;
	$below = 0;
	$at = 0;
	$above = 0;
	$cycleArray = sibson_get_current_cycle();
	$cycle = $cycleArray[0]['currentId']-1;
	
	$data = $wpdb->get_results("SELECT wp_assessment_terms.assessment_description, 
	wp_assessment_terms.assessment_target, 
	count(wp_assessment_data.person_id) as count, 
	wp_assessment_data.assessment_value
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.assessment_value
where wp_assessment_data.assessment_subject ='$type' and wp_assessment_terms.assessment_subject ='$type' and cycle = $cycle and wp_assessment_data.person_id in (".implode(",", $idArray).")
group by wp_assessment_data.assessment_value");

	
echo "<div id='".$this->id."_".$type."_chart_div' class='pie_chart'></div>";
	?>

 <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['OTJ', 'Children'],
         <?php foreach ($data as $d){
		
				echo "[";
				echo "'".$d->assessment_description."'";
				echo ",";
				echo $d->count;
				echo "],";
					
				}?>
        ]);

        var options = {
          title: '<?php echo $title;?>',
		  backgroundColor: "none",
		  width: 400 
        };

        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $this->id;?>_<?php echo $type;?>_chart_div'));
        chart.draw(data, options);
      }
    </script>
<?php
}
}

?>