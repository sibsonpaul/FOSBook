<?php

class Person{
	
	const LANG = 'some_textdomain';
	private $secureId = "";
	public $id = "";
	private $first ="";	
	private $last ="";
	private $name ="";
	private $room ="";
	private $roomId="";
	private $description ="";
	private $imageId ="";
	private $currentYear = "";
	public $personType =""; 
	private $postCount="0";
	private $user ="";
	private $studentArray = array();
	private $userType ="";
	private $metaArray =array();
	private $dob ="";
	private $person_access_level;
	public $gender="";
	public $startDate = "";
	private $user_level =1;
	private $staffRole = "";
	private $actualFirstName = "";
	private $status;
	
	public function __construct($ID, $person_access_level="low"){
		
		// When the class is instartiated take the id passed through and query the database to populate all the variables.
	$current_user = wp_get_current_user();
	$userId = $current_user->ID;	
	
	$this->person_access_level = $person_access_level;
	$this->id = absint($ID);	
	$this->currentYear = date(Y);
	$this->user = $userId;
	$this->secureId = salt_n_pepper($this->id);
	
	global $wpdb;
	
	
	$this->userId = $current_user->ID;
	$this->userType = get_user_meta($this->userId, 'user_type', true);
	$userdata = get_userdata( $this->userId );
	$this->user_level =$userdata->user_level;
	//Basic info.
	$profileSQL = $wpdb->get_row($wpdb->prepare("SELECT * FROM wp_people where wp_person_id = %d", $this->id));
	
	
	
	
	//Meta data
	
	
	
	$profileMetaSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_peoplemeta where wp_person_id = %d ", $this->id) ); // Added the prepare statement to defend against SQL injection.
		
	foreach ($profileMetaSQL as $profileMeta):
	
	$this->metaArray[$profileMeta->meta_key] = $profileMeta->meta_value;
		
	endforeach;

	//The class that the student belongs to.
	$profileGroupsSQL = $wpdb->get_row($wpdb->prepare("SELECT wp_groups.room, wp_groups.wp_group_id
	FROM wp_groups INNER JOIN wp_group_relationships ON wp_groups.wp_group_id = wp_group_relationships.wp_group_id
		 INNER JOIN wp_users ON wp_users.ID = wp_groups.wp_user_id
	where wp_person_id = %d  and type='class' and year = $this->currentYear",$this->id ));
	

	
	//If a preferred nams has been set, use that, else use the name in the person table.
		if ($profileMetaKey['preferred_name']){
		$this->first  = $profileMetaKey['preferred_name'];
		}
		else {
		$this->first  = $profileSQL->first_name;
		}
		$this->actualFirstName = $profileSQL->first_name;
		if ($profileMetaKey['description']){
		$this->description  = $profileMetaKey['description'];
		}
		$this->actualFirstName =  $profileSQL->first_name;
		$this->room = $profileGroupsSQL->room;
		$this->roomId =$profileGroupsSQL->wp_group_id;
		$this->last  = $profileSQL->last_name;
		$this->name = $this->first." ".$this->last;
		$this->dob = $profileSQL->dob;
		$this->gender = $profileSQL->gender;
		$this->startDate = $profileSQL->start_date;
		$this->status = $profileSQL->vacated;
		$this->personType= $this->metaArray['person_type'];
		$this->staffRole = $this->metaArray['role'];
		$this->imageId=$this->metaArray['profile_image'];
	}
	
	
//Functions to call to present parts of data.
	public function enrolDate(){
	
	return date('d/m/y', strtotime($this->startDate));	
		
	}
	
	public function showFirstName(){
			echo $this->first;
	}
	
	public function returnFirstName(){
			return $this->first;
	}
		public function returnLastName(){
			return $this->last;	
	}
		public function returnActualFirstName(){
			return $this->actualFirstName;	
	}
	
	public function showLastName(){
			echo $this->last;	
	}
	public function showName(){
			echo $this->name;	
	}
		public function returnName(){
			return $this->name;	
	}
	
	public function returnNameAsSlug(){
			return $this->first.$this->last;	
	}
	
	
	public function description(){
			echo $this->description;	
	}
	
	public function returnStartDate(){
		
	return $this->startDate;
	
	}
	public function returnStatus(){
	
	return $this->status;	
		
	}
	
	public function returnPersonType(){
			return $this->personType;	
	}
	
	public function staffMemberId(){
			global $wpdb;
			
			$person_user_id = $wpdb->get_var($wpdb->prepare("SELECT user_id from wp_usermeta where meta_key='person_id' and meta_value = %d", $this->id));
			
			return $person_user_id;
		
	}
	
	
	public function wholiveswith(){
		
		$mother = $this->metaArray['mother_lives_with'];
		if ($mother == "Yes"){
			$m = "Yes";	
		}
		else {
		$m = "No";	
		}
		
		
		$father = $this->metaArray['father_lives_with'];
		
		if ($father == "Yes"){
			$f = "Yes";	
		}
		else {
		$f = "No";	
		}
		
		$caregiver = $this->metaArray['caregiver_lives_with'];
		
		if ($m == "Yes" && $f == "Yes"){
			
			return "both";
		}
		else if ($m == "Yes" && $f == "No"){
			
			return "mother";
		}
		else if ($m == "No" && $f == "Yes"){
			
			return "father";
		}
		else if ($m == "No" && $f == "No"){
			
			return "caregiver";
		}
		
	}
	
	
	
public function returnFullArray(){
	
	return $this->metaArray;


}
	public function digitalSafety(){
		
		if ($this->metaArray['digital_safety'] == "Form not returned"){
				$digital = "no";	
			}
			else if ($this->metaArray['digital_safety'] == "Yes"){
			
				$digital = "yes";
			}
			else {
				
				$digital = "no";
			}
		
	return 	$digital;
	}
		public function medical(){
		
		if ($this->metaArray['medical_note'] || $this->metaArray['allergy'] ){
		
		return 	"yes";
		}
		else {
				return 	"no";
			
		}
	}
	public function returnZone(){
		return $this->metaArray['zoning'];
		
	}
		public function returnAddress1(){
		return $this->metaArray['Address_street'];
		
	}
	
	public function returnAddress2(){
			return $this->metaArray['suburb'];
		
	}
	public function returnAddress3(){
			return $this->metaArray['post_code'];
	}
	public function returnPhone(){
			return $this->metaArray['CGiverphone'];
	}
	public function	returnSiblings(){
			return $this->metaArray['siblings'];
	}
	
		public function	returnMother(){
			return $this->metaArray['mother'];
	}
	
		public function	returnAccessNotes(){
			return $this->metaArray['access'];
	}
	
public function ethnic_origin(){

return $this->metaArray['ethnic_origin'];	
	
}

		public function tripPermission(){
		
		if ($this->metaArray['trip_permission'] == "Form not returned"){
				$permission = "no";	
			}
			else if ($this->metaArray['trip_permission'] == "Yes"){
			
				$permission = "yes";
			}
			else {
				
				$permission = "no";
			}
		
	return 	$permission;
	}
		public function religiousEducation(){
		
		if ($this->metaArray['religious_education'] == "Form not returned"){
				$permission = "no";	
			}
			else if ($this->metaArray['religious_education'] == "Yes"){
			
				$permission = "yes";
			}
			else {
				
				$permission = "no";
			}
		
	return 	$permission;
	}
	
	public function showPronoun($type){
		
		
		if ($this->gender == "Female"){
			if ($type == "her"){
				echo "her";
			}
			else if ($type == "she"){
				echo "she";
			}
		}
		else {
		if ($type == "her"){
				echo "him";
			}
		else if ($type == "she"){
				echo "he";
			}	
		}
	}
	public function return_email(){
	
	return $this->metaArray['email_address'];
		
	}
	public function returnPronoun($type){
		
		
		if ($this->gender == "Female"){
			if ($type == "her"){
				return "her";
			}
			else if ($type == "she"){
				return "she";
			}
		}
		else {
		if ($type == "her"){
				return "him";
			}
		else if ($type == "she"){
				return "he";
			}	
		}
	}
	public function showImage($size ="thumb"){
	
		
			
			$PersonImage = wp_get_attachment_image($this->imageId, $size);
	
			echo $PersonImage;
	}
	public function showAge(){
		
	if ($this->personType == "student"){	
		$date = explode("-", $this->dob);
		$year =  $date[0];
		$month = $date[1];
		$day = $date[2];
		echo " is ";
		echo floor((mktime(0, 0, 0) - mktime(0, 0, 0, $month, $day, $year)) / 31556952);
		echo " years old";	
	}
		
	}
	
	public function returnAge(){
		
	if ($this->personType == "student"){	
		$date = explode("-", $this->dob);
		$year =  $date[0];
		$month = $date[1];
		$day = $date[2];
		
		return floor((mktime(0, 0, 0) - mktime(0, 0, 0, $month, $day, $year)) / 31556952);
		
	}
		
	}
	
	public function showCurrentMOEYearLevel($return){
		
	
		$dobArray = date_parse($this->dob);	// Parse DOB into an array.
		$currentYear = date('Y'); // Get the current year.
		$startYear =  $dobArray['year']+5; // Year of birth plus 5 - year that they turned 5.
		$startMonth= $dobArray['month']; // Month of birth.
		if ($startMonth<7){ // If born before July the year level is the number of years since they turned 5 plus one.
		$moeYear = $currentYear - $startYear+1;	
		}
		else {
		$moeYear = $currentYear - $startYear;
		}
		if ($return== true){
				return $moeYear;
		}
		else {
		echo $moeYear;
		}
		
	}
	
		public function returnMOEYearLevelonDate($year){
		
	if ($year){
		$dobArray = date_parse($this->dob);	// Parse DOB into an array.
		$currentYear = $year; // Get the current year.
		$startYear =  $dobArray['year']+5; // Year of birth plus 5 - year that they turned 5.
		$startMonth= $dobArray['month']; // Month of birth.
		if ($startMonth<7){ // If born before July the year level is the number of years since they turned 5 plus one.
		$moeYear = $currentYear - $startYear+1;	
		}
		else {
		$moeYear = $currentYear - $startYear;
		}
		
				return $moeYear;
	}
	else {
	
	return;	
		
	}
		
	}
	
	public function showCurrenYearLevelforNatStandards($statement='no'){
		
	$moeYear =	$this->showCurrentMOEYearLevel(true);

			$date2 = new DateTime($this->dob);
			$date1 = new DateTime(date('Y-m-d'));
			$interval = $date1->diff($date2);
			$ageinYears = $interval->y;
			$yearsinceStartedSchool = $ageinYears-5;
			$monthsinceBirthday = $interval->m;
			
			switch ($yearsinceStartedSchool){
				
				case 0;
					$standardYear = 1;
					
						if ($monthsinceBirthday <=6){
						$standardYear = 1;	
						$standardYearStatement = "less than 6 months (1 year at school National Standard)";
						
						}
						else {
						$standardYear = 1;	
						$standardYearStatement = "less than 1 year (1 year at school National Standard)";
						}
					break;
				case 1;
					if ($monthsinceBirthday <=6){
					$standardYear = 1;	
					$standardYearStatement = "less than 18 months (1 year at school National Standard)";
					}
					else {
					$standardYear = 2;
					$standardYearStatement = "less than 2 years (2 years at school National Standard)";
					}
					break;
				case 2;
					if ($monthsinceBirthday <=6){
						$standardYear = 2;	
						
						$standardYearStatement = "less than 2 and half years (2 years at school National Standard)";
						}
						else {
						$standardYear = 3;	
						$standardYearStatement = "less than 3 years (3 years at school National Standard)";
						}
					break;	
				case 3;
					if ($monthsinceBirthday <=6){
					$standardYear = 3;	
					$standardYearStatement = "more than 3 years (3 years at school National Standard)";
					}
					else  {
					$standardYear = 4;	
					$standardYearStatement = "more than 3 and half years (Year 4 National Standard)";
					}
					break;		
				case 4;
					$standardYear= $this->returnyearLevel();
					break;		
				case 5;
					$standardYear=  $this->returnyearLevel();
					break;	
				case 6;
					$standardYear=  $this->returnyearLevel();
					break;		
				case 7;
					$standardYear=  $this->returnyearLevel();
					break;	
				case 8;
					$standardYear=  $this->returnyearLevel();
					break;	
			}
	
	if ($statement == 'statement'){
		echo "For National Standards ";
		echo $this->returnPronoun('she');
				if ($yearsinceStartedSchool <=3){
				echo " has been at school for "; 
				echo $standardYearStatement;
			
				}
				else {
				echo " is in Year "; 
			
				echo $standardYear;	
				echo ". ";
				}
	}
	else {
		
	return $standardYear;	
	}
}
	
	public function showPersonTableRow($class){
		
	echo "<tr class='".$class."'>";
	echo "<td>";
	
	echo $this->returnName();
	echo "</td>";
	
	echo "<td>";
	
	echo $this->metaArray['email_address'];
	echo "</td>";
	
	echo "<td>";
	
	echo $this->metaArray['CGiverphone'];
	echo "</td>";
		echo "<td >";
	
	echo $this->metaArray['mobile'];
	echo "</td>";
	
	
	echo "</tr>";	
		
		
	}
	
public function showPersonDetails(){
	
	
	echo "<dt class='post'> ";
           echo  "<span class='avatar'>";
                    $this->showBadge();
                                                 echo   "</span>";
                                                  echo "<span class='post_author tk-head'>";
                                                    echo   "<a href='?accessId=".$this->id."' data-ajax='false' >";        
                                                     $this->showFirstName();
													  echo " ";
													  $this->showLastName();
                                                           echo  " </a>";    
														      
                                                             echo   "</span>";
                                                            echo "<span class='icon tk-body' title='Digital Safety' >";
															$digital = $this->digitalSafety();
                                                    echo   "<img src='".SIBSON_IMAGES."/".$digital.".png' alt='Digital Safety'  title='Digital Safety' /><p>Digital Safety Form</p><br />"; 
													$permission = $this->tripPermission();
                                                    echo   "<img src='".SIBSON_IMAGES."/".$permission.".png' alt='Trip Permission'  title='Trip Permission' /><p>Trip Permission Form</p><br />";
													$re = $this->religiousEducation();
                                                    echo   "<img src='".SIBSON_IMAGES."/".$re.".png' alt='Religious Education'  title='Religious Education' /><p>Religious Education</p><br />";
														$medical = $this->medical();
														if ($medical=="yes"){
                                                   			 echo   "<img src='".SIBSON_IMAGES."/medical.png' alt='Medical Notes'  title='Medical Notes' /><p>Medical Notes</p><br />";
														}
                                                       echo "</span>"; 
														
													   echo "</dt>";
												echo "<dd class='post format_text tk-body'><p>" ;
												 echo $this->showFirstName()." was born on ".$this->returnBirthday();
												echo " and ";
												$this->showAge();
												echo ". ";
												$this->showCurrenYearLevelforNatStandards('statement');
												echo  ". <br />";
												echo $this->metaArray['mother_first']." ".$this->metaArray['mother_last']." ";
												echo $this->metaArray['father_first']." ".$this->metaArray['father_last'];
												 echo  ". <br />";
												 echo "<img src='".SIBSON_IMAGES."/small_mail.png' class='mini' />";
												echo "<a href='mailto:";
												echo  $this->metaArray['Email Address'];
												echo "'>";
												echo  $this->metaArray['Email Address'];
												echo "</a>";
												$reading = new Assessment($this->id, 'reading');
												
												$readingTheme = $reading->setTheme($this->showCurrenYearLevelforNatStandards());
												
													$writing = new Assessment($this->id, 'writing');
												$writingTheme = $writing->setTheme($this->showCurrenYearLevelforNatStandards());
												$maths = new Assessment($this->id, 'maths');
												$mathsTheme = $maths->setTheme($this->showCurrenYearLevelforNatStandards());
												
												echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b">';
												echo '<a href="'.get_bloginfo('url').'?accessId='.$this->id.'&pageType=reading" class="readingButton reading_theme_'.$readingTheme.'" data-ajax="false" data-role="button" data-theme="'.$readingTheme.'">Reading</a>';
												echo '<a href="'.get_bloginfo('url').'?accessId='.$this->id.'&pageType=writing" class="writingButton writing_theme_'.$writingTheme.'" data-ajax="false" data-role="button" data-theme="'.$writingTheme.'">Writing</a>';
												echo '<a href="'.get_bloginfo('url').'?accessId='.$this->id.'&pageType=maths" class="mathsButton maths_theme_'.$mathsTheme.'" data-ajax="false" data-role="button" data-theme="'.$mathsTheme.'">Maths</a>';
												echo '</div>';
												
												  echo "</p><div class='spacer'>&nbsp;</div>";
												  echo "<br />";
												    
												  echo "</dd>"; 	
												$readingTheme ='b';
												$writingTheme ='b';
												$mathsTheme = 'b';
}

public function returnStandardData($type){
	
	$assessment = new Assessment($this->id, $type);
	
	$result = $assessment->getNationalStandard($this->showCurrenYearLevelforNatStandards());
	
	return $result;
	
}
	
	public function showFullPagePersonDetails(){
		
		$classDetail = $this->returnCurrentClassInfo();
		
									
										sibson_button('enrol_edit', 'Edit details for '.$this->returnFirstName(), $this->id, 'Edit info');
										echo '<div class="spacer"></div>';	
										echo '<p><strong>Current teacher:</strong></p>';
										echo '<div class="spacer"></div>';
    									$teacher = new Person($classDetail['teacher']);
										$teacher->showBadge();
										echo '<div class="spacer"></div>';
										echo '<p><strong>Previous teachers:</strong></p>';
										echo '<div class="spacer"></div>';
										$this->showGroupHistory();
										echo '<div class="spacer"></div>';
									  echo "<span class='icon tk-body' title='Digital Safety' >";
															$digital = $this->digitalSafety();
                                                    echo   "<img src='".SIBSON_IMAGES."/".$digital.".png' alt='Digital Safety'  title='Digital Safety' /><p>Digital Safety Form</p><br />"; 
													$permission = $this->tripPermission();
                                                    echo   "<img src='".SIBSON_IMAGES."/".$permission.".png' alt='Trip Permission'  title='Trip Permission' /><p>Trip Permission Form</p><br />";
													$re = $this->religiousEducation();
                                                    echo   "<img src='".SIBSON_IMAGES."/".$re.".png' alt='Religious Education'  title='Religious Education' /><p>Religious Education</p><br />";	
														  echo "</span>"; 
										echo '<p><strong>Date of birth</strong></p>';
										echo '<p>';
    									echo $this->returnBirthday();
										echo '</p>';
										echo '<p ><strong>Current Age:</strong></p>';
    									echo '<p>';
										echo $this->returnAge();
										echo '</p>';
										echo '<p ><strong>Current Year Level (National Standards):</strong></p>';
    									echo '<p>';
										echo  $this->showCurrenYearLevelforNatStandards();
										echo '</p>';
										echo '<p ><strong>Current funding Year Level:</strong></p>';
    									echo '<p>';
										echo  $this->showCurrentMOEYearLevel(true);
										echo '</p>';
										echo '<p><strong>Caregiver:</strong></p>';
    									echo '<p>';
										echo $this->metaArray['mother_first']." ".$this->metaArray['mother_last'].", ";
										echo $this->metaArray['father_first']." ".$this->metaArray['father_last'];
										echo '</p>';
										echo '<p><strong>Email address:</strong></p>';
    									echo '<p>';
										echo $this->metaArray['email_address'];
										echo '</p>';
										echo '<p><strong>Home Phone:</strong></p>';
    									echo '<p>';
										echo $this->metaArray['CGiverphone'];
										echo '</p>';
										echo '<p ><strong>Mobile Phone:</strong></p>';
    									echo '<p>';
										echo $this->metaArray['mobile'];
										echo '</p>';
										echo '<p><strong>Medical Notes:</strong></p>';
    									echo '<p>';
										echo $this->metaArray['medical_note'];
										echo '</p>';
										
										
												
										echo '<div class="spacer"></div>';
										sibson_button('enrol_edit', 'Edit details for '.$this->returnFirstName(), $this->id, 'Edit info');
									
												
		
	}
	
	public function showFullPersonDetails(){
	
	
	
	echo "<dt class='post'> ";
           echo  "<span class='avatar'>";
                    $this->showBadge();
					
					
                                                 echo   "</span>";
                                                  echo "<span class='post_author tk-head'>";
                                                    echo   "<a href='?accessId=".$this->id."' data-ajax='false' >";        
                                                     $this->showFirstName();
													  echo " ";
													  $this->showLastName();
                                                           echo  " </a>";    
													
                                                             echo   "</span>";
															 
															 	
														if ($this->personType=="staff"){
															
															echo "<dd class='post format_text tk-body'><p>" ;
															
														}
														else {
															
                                                           echo "<span class='icon tk-body' title='Digital Safety' >";
															$digital = $this->digitalSafety();
                                                    echo   "<img src='".SIBSON_IMAGES."/".$digital.".png' alt='Digital Safety'  title='Digital Safety' /><p>Digital Safety Form</p><br />"; 
													$permission = $this->tripPermission();
                                                    echo   "<img src='".SIBSON_IMAGES."/".$permission.".png' alt='Trip Permission'  title='Trip Permission' /><p>Trip Permission Form</p><br />";
													$re = $this->religiousEducation();
                                                    echo   "<img src='".SIBSON_IMAGES."/".$re.".png' alt='Religious Education'  title='Religious Education' /><p>Religious Education</p><br />";		
														  echo "</span>"; 
													   echo "</dt>";
												echo "<dd class='post format_text tk-body'><p>" ;
												 echo $this->showFirstName()." was born on ".$this->returnBirthday();
												echo " and ";
												$this->showAge();
												echo ". ";
												$this->showCurrenYearLevelforNatStandards('statement');
												echo  ". <br />";
												echo "Care giver: ";
												 echo $this->metaArray['Caregiver'];
												 echo  ". <br />";
												 echo "<img src='".SIBSON_IMAGES."/small_mail.png' class='mini' />";
												echo "<a href='mailto:";
												echo  $this->metaArray['email_address'];
												echo "'>";
												echo  $this->metaArray['email_address'];
												echo "</a>";
												$medical = $this->medical();
														if ($medical=="yes"){
															echo "<br />";
                                                    echo   "<strong>Medical Notes</strong><br />";
													echo $this->metaArray['medical_note'];
													if ($this->metaArray['allergy']){
													echo   "<strong>Allergic to:</strong><br />";
													
													echo $this->metaArray['allergy'];
													}
														}
													}
											
												  echo "</p><div class='spacer'>&nbsp;</div>";
												  echo "<br />";
												    
												  echo "</dd>"; 	
												
}
	

	public function returnDOB($update=false){
		
		if ($update == true){
			return date('Y-m-d', strtotime($this->dob));	
		}
		else {
			
			
		return date('F j, Y', strtotime($this->dob));
		}
		
	}
	public function returnBirthday(){
		if ($this->personType == "student"){
			return date('l jS F', strtotime($this->dob));
		}
		
	}
	
	public function showBirthday(){
		
		if ($this->personType == "student"){
			echo date('F j, Y', strtotime($this->dob));
		}
	}
	public function returnImage($size, $class=''){
			$PersonImage = wp_get_attachment_image($this->imageId, $size, '', array('class'=> $class));
	
			return $PersonImage;
	}
	
		public function returnGender(){
			
			return $this->gender;
	}
	
	public function showGroupHistory(){
			
			//Previous classes.
	global $wpdb;
	$groupHistorySQL = $wpdb->get_results($wpdb->prepare("SELECT
	wp_usermeta.meta_value
FROM wp_groups INNER JOIN wp_group_relationships ON wp_groups.wp_group_id = wp_group_relationships.wp_group_id
	 INNER JOIN wp_usermeta ON wp_groups.wp_user_id = wp_usermeta.user_id
WHERE wp_group_relationships.wp_person_id = %d and meta_key = 'person_id'
group by wp_groups.wp_user_id", $this->id ));

		foreach ($groupHistorySQL as $groupHistory):
			
			$current = $this->returnCurrentClassInfo();
			$currentTeacher = $current['teacher'];
			if ($currentTeacher == $groupHistory->meta_value) {
				
			}
			else {
			
			$person = new Person ($groupHistory->meta_value);
			$person->showBadge();
			}
		endforeach;
			
	}
	public function returnGroupByYear($year){
			
			//Previous classes.
	global $wpdb;
	$groupHistory = $wpdb->get_var($wpdb->prepare("SELECT 
	wp_groups.wp_group_id
FROM wp_group_relationships INNER JOIN wp_groups ON wp_group_relationships.wp_group_id = wp_groups.wp_group_id where type = 'Class' and year = $year and wp_person_id = %d", $this->id));

		return $groupHistory;
			
	}
	
	public function showMyGroups(){
		
		global $wpdb;
		
	$person_user_id =$this->staffMemberId();
	
		$userGroupHistorySQL = $wpdb->get_results("SELECT wp_group_id
	FROM wp_groups
	where wp_user_id = $person_user_id order by year desc");
	
		foreach ($userGroupHistorySQL as $userGroupHistory):
			
			$group = new Group ($userGroupHistory->wp_group_id);
			$group -> showDetail();
		endforeach;	
	
		
		
	}
	
	public function returnMyTopGroup(){
		
		global $wpdb;
		
	$person_user_id =$this->staffMemberId();
	
		$userGroupHistorySQL = $wpdb->get_var("SELECT wp_group_id
	FROM wp_groups
	where wp_user_id = $person_user_id order by year desc LIMIT 1");
	
		
			
			return $userGroupHistorySQL;
			
	
		
		
	}
	public function showMyGoals(){
	$assessment = new Assessment( $this->id, '', 'individual');	
	echo "<h3>Knowing the children</h3>";
	echo "<br />";
	
	echo $assessment->indicatorProgressBar('knowinggoals');
	echo "<h3>Being a team</h3>";
	echo "<br />";
		echo $assessment->indicatorProgressBar('teamgoals');
	echo "<h3>Creating great learning</h3>";
	echo "<br />";
		echo $assessment->indicatorProgressBar('learnersgoals');
	echo "<h3>Valuing our environment</h3>";
	echo "<br />";
		echo $assessment->indicatorProgressBar('environmentgoals');
	echo "<h3>Adults as learners</h3>";
	echo "<br />";
		echo $assessment->indicatorProgressBar('learnersgoals');
	echo "<h3>Upholding high expectations</h3>";
			echo $assessment->indicatorProgressBar('expectationsgoals');
	}
	
	public function showMyObservationGoals(){
		
	$assessment = new Assessment( $this->id, '', 'individual');	
	
	$assessment->observationForm();
	
	
	}
	
	public function currentClass(){
		
	if ($this->personType=="staff"){
		
		global $wpdb;
		
	$person_user_id =$this->staffMemberId();
	
		$userGroupHistorySQL = $wpdb->get_var("SELECT wp_group_id
	FROM wp_groups
	where wp_user_id = $person_user_id and type= 'Class' order by year desc LIMIT 1 ");
	 return $userGroupHistorySQL;
		
	}
	else {
		
		return $this->roomId;
	}
	}
	
	public function returnCurrentClassInfo(){
		
		$groupid = $this->roomId;
		$group = new Group($groupid);
		$teacherId = $group->returnTeacherId();
		
		$yearLevel = $group->returnYearGroup();
		
		$email = $group->returnEmail();
		
		$teamLeaderEmail= $group->returnTeamLeaderEmail();
		
		$groupArray = array( 'teacher'=> $teacherId,
							'year'=> $yearLevel, 
							'email' =>	$email, 
							'teamleader' =>$teamLeaderEmail,
							'location' => $group->returnRoom()
							);
		return $groupArray;
							
	}
	public function returnClassInfoByDate($date){
		
		
		
		$groupid = $this->returnGroupByYear($date);
		$group = new Group($groupid);
		$teacherId = $group->returnTeacherId();
		
		$yearLevel = $group->returnYearGroup();
		
		$email = $group->returnEmail();
		
		$teamLeaderEmail= $group->returnTeamLeaderEmail();
		
		$groupArray = array( 'teacher'=> $teacherId,
							'year'=> $yearLevel, 
							'email' =>	$email, 
							'teamleader' =>$teamLeaderEmail,
							'location' => $group->returnRoom()
							);
		return $groupArray;
							
	}
	
	
	public function returnMotherEmail(){
		
		return $this->metaArray['mother_email'];
		
	}
	
	public function returnFatherEmail(){

			
		return $this->metaArray['father_email'];	
		
		
		
	}
	
	public function returnMySiblings($parent){
		
		
	global $wpdb;
	if ($parent == 'mother'){
	$mother = $this->returnMotherEmail();
	
	$siblings = $wpdb->get_results($wpdb->prepare("select wp_person_id from wp_peoplemeta where meta_key ='mother_email' and meta_value = %s", $mother));
	
	}
	else if ($parent == 'father'){
		$father = $this->returnFatherEmail();
		
$siblings = $wpdb->get_results($wpdb->prepare("select wp_person_id from wp_peoplemeta where meta_key ='father_email' and meta_value = %s", $father));
	
	}
	foreach ($siblings as $sibling){
		
				if($this->id == $sibling->wp_person_id){
				
			}
	else {
	
	$person = new Person ($sibling->wp_person_id);
	$class = $person->returnCurrentClassInfo();
	$room = $class['location'];
	
	if ($parent == "mother"){
	$siblingsArray[] = array( 'first_name' =>$person->returnFirstName(), 'id' => $person->id, 'mother_email' =>$person->returnMotherEmail(), 'mother_name' => $person->metaArray['mother_first'], 'mother_last' => $person->metaArray['mother_last'], 'room' => $room);	
	}
	else if ($parent == "father"){
	$siblingsArray[] = array( 'first_name' =>$person->returnFirstName(), 'id' => $person->id, 'father_email' =>$person->returnFatherEmail(), 'father_name' => $person->metaArray['father_first'], 'father_last' => $person->metaArray['father_last'], 'room' => $room);	
	}
	
	}
	}
	
	return $siblingsArray;
		
	}
	
	public function showBadge($ajax= false, $selectable = false){
		
		sibson_badge($this->id, $this->returnImage('thumbnail'), $this->returnName(), '', $ajax, $selectable);
		
		
		
	}
	
	public function returnyearLevel(){
	
	$class = $this->returnCurrentClassInfo();
	
	return $class['year'];	
	}
	
	public function selectableBadge($type, $id, $status){
		global $wpdb;
		
		if ($type == "indicator"){

		
			$status =$wpdb->get_var($wpdb->prepare("SELECT
				area
			FROM wp_assessment_data
			where person_id = %d  and assessment_value = $id", $this->id ));
			
			if (!$status){
			$status = "notsetyet";	
			}
			
		
		
		}
		$badgeArray = array(
		'id' =>$this->id, 
		'image'=> $this->returnImage('thumbnail'), 
		'name' => $this->returnName(),
		'selectable'=> true,
		'indicatorId'=> $id,
		'theme' => $status, 
		'counter' => true
		);
	
			
			
		sibson_badge_from_array($badgeArray);
			
		
			
	
		
		
		
	}
	
	public function check_comment_count($subject){
	
	global $wpdb;
	if ($subject =='SpecialNeeds'){
	$query = "(wp_terms.slug = 'referral' or wp_terms.slug = 'outcomes' or wp_terms.slug = 'progress')";
	
	
	}
	else if ($subject=="ESOL"){
	$query = "(wp_terms.slug = 'pastoral' or wp_terms.slug = 'about' or wp_terms.slug = 'ESOL' or wp_terms.slug = 'esol')";	
	}
	else {
		
		$query = "wp_terms.slug ='".$subject."'";
	}
	
$post_Ids=$wpdb->get_results($wpdb->prepare("SELECT wp_term_relationships.object_id
FROM wp_term_relationships INNER JOIN wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
	 INNER JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
where wp_terms.slug = %d ", $this->id ));

foreach ($post_Ids as $thisID){
	
	$postIDArray[] = $thisID->object_id;
	
}

$count=$wpdb->get_var("SELECT count(wp_term_relationships.object_id)
FROM wp_term_relationships INNER JOIN wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
	 INNER JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
where $query  and object_id in (".implode(',', $postIDArray).")");
	

if  ($count){
	
	return "yes";
}
else {
return "no";	
}
	
	}
	
	
	public function metaBadge(){
		
		$meta = "data-trip='".$this->tripPermission()."'";
		$meta .= " data-digital='".$this->digitalSafety()."'";
		$meta .= " data-medical='".$this->medical()."'";
		$meta .= " data-esol='".$this->check_comment_count('ESOL')."'";
		$meta .= " data-gates='".$this->check_comment_count('GATES')."'";
		$meta .= " data-support='".$this->check_comment_count('SpecialNeeds')."'";
		
		$reading = new Assessment($this->id, 'reading');
		$readingTheme = $reading->setTheme($this->showCurrenYearLevelforNatStandards());
		$writing = new Assessment($this->id, 'writing');
		$writingTheme = $writing->setTheme($this->showCurrenYearLevelforNatStandards());
		$maths = new Assessment($this->id, 'maths');
		$mathsTheme = $maths->setTheme($this->showCurrenYearLevelforNatStandards());
		$meta .= " data-readinghighlight='".$readingTheme."'";
		$meta .= " data-writinghighlight='".$writingTheme."'";
		$meta .= " data-mathshighlight='".$mathsTheme."'";
		
		$meta .= " data-name='".$this->returnName()."'";
		
		sibson_badge($this->id, $this->returnImage('thumbnail'), $this->returnName(), '', true, false, '', $meta);
		
		
	}
	
	public function returnBadge($ajax= false, $selectable = false, $addClass='', $photoNumber=0){
		
		$badge = sibson_badge_return($this->id, $this->returnImage('thumbnail'), $this->returnName(), '', $ajax, $selectable, '', $addClass, $photoNumber);
		
		return $badge;
	}
	
	
	// Show the navigation based on the type of person and the access rights of the user.
	public function showLinks($current, $person_access_level){
	
			if ($this->user_level>7){
				$secureId = $this->id;
			}
			else {
				$secureId = $this->secureId;
			}
				if ($this->personType == "staff"){
					sibson_profile_menu_li('Home', 'home', $secureId, $current);
					sibson_profile_menu_li('My Groups', 'groups', $secureId, $current);
					
					
					if ($this->person_access_level =="full"){	
						
							sibson_profile_menu_li('My Goals', 'goals', $secureId, $current);
							sibson_profile_menu_li('Baseline Data', 'baseline', $secureId, $current);
							sibson_profile_menu_li('Knowing the children', 'knowing', $secureId, $current);
							sibson_profile_menu_li('Being a team', 'team', $secureId, $current);
							sibson_profile_menu_li('Creating great learning', 'creating', $secureId, $current);
							sibson_profile_menu_li('Adults as learners', 'learners', $secureId, $current);
							sibson_profile_menu_li('Valuing our people and place', 'environment', $secureId, $current);
							sibson_profile_menu_li('Upholding high expectations', 'expectations', $secureId, $current);
							sibson_profile_menu_li('Images', 'images', $secureId, $current);
						}
						if ($this->user_level == 10){
							
							sibson_profile_menu_li('School Stats', 'school_stats', $secureId, $current);
							sibson_profile_menu_li('Vistor Stats', 'visitor_stats', $secureId, $current);
						}
					
				}
				
				else {
					
			
				   if ($this->user_level>7){
					     sibson_profile_menu_li('Information', 'information', $secureId, $current);
						 sibson_profile_menu_li('Home', 'home', $secureId, $current);
						 sibson_profile_menu_li('Visitor Stats', 'visitors', $secureId, $current); 
						 
						 sibson_profile_menu_li('Teacher conversations', 'teacher', $secureId, $current);
					   sibson_profile_menu_li('General comments', 'general', $secureId, $current);
					sibson_profile_menu_li('Sparkle', 'sparkle', $secureId, $current);
					sibson_profile_menu_li('Thinker', 'thinker', $secureId, $current);
					sibson_profile_menu_li('Communicator', 'communicator', $secureId, $current);
					sibson_profile_menu_li('Dream Maker', 'dream_maker', $secureId, $current);
					sibson_profile_menu_li('Team Player', 'team_player', $secureId, $current);
					sibson_profile_menu_li('Reading', 'reading', $secureId, $current);
					sibson_profile_menu_li('Writing', 'writing', $secureId, $current);
					sibson_profile_menu_li('Maths', 'maths', $secureId, $current);  
					 
					   sibson_profile_menu_li('Assessments', 'assessments', $secureId, $current);
					   sibson_profile_menu_li('Images', 'images', $secureId, $current);
					    sibson_profile_menu_li('Support Programmes', 'support', $secureId, $current);
					
				   }
				   else {
					   sibson_profile_menu_li('Home', 'home', $secureId, $current);
					sibson_profile_menu_li('General comments', 'general', $secureId, $current);
					sibson_profile_menu_li('Sparkle', 'sparkle', $secureId, $current);
					sibson_profile_menu_li('Thinker', 'thinker', $secureId, $current);
					sibson_profile_menu_li('Communicator', 'communicator', $secureId, $current);
					sibson_profile_menu_li('Dream Maker', 'dream_maker', $secureId, $current);
					sibson_profile_menu_li('Team Player', 'team_player', $secureId, $current);
					sibson_profile_menu_li('Reading', 'reading', $secureId, $current);
					sibson_profile_menu_li('Writing', 'writing', $secureId, $current);
					sibson_profile_menu_li('Maths', 'maths', $secureId, $current);     
					   
				   }
		  
				}
		
	}
	
	

	
	public function checkPermission(){
		global $wpdb;
		$myaccess =$wpdb->get_var("SELECT
	wp_usermeta.meta_value
FROM wp_usermeta
where meta_key ='authorised_friends' and user_id = $user_id");

	return $myaccess;
	
		
		
	}
	
	public function find_teacher($date){
	
	
global $wpdb;


	$teacher_id=$wpdb->get_var($wpdb->prepare("SELECT wp_groups.wp_user_id FROM wp_group_relationships INNER JOIN wp_groups ON wp_group_relationships.wp_group_id = wp_groups.wp_group_id where wp_person_id = %d and type = 'Class' and Year = $date", $this->id));
	
	return $teacher_id;
}
	
	public function find_time_at_school($date){
	
	global $wpdb;
	

	}
	
public function showGoals($subject){
	
	$assessment = new Assessment($this->id, $subject, 'individual');
	
	$assessment->currentGoalsForm();
	
	
}

public function show_staff_job_list(){
	
	$id = $this->currentClass();// get an id for a class if there is one that is an actual class
	if (!$id){
	$id =	$this->returnMyTopGroup(); // if no id exists, set one based on a group (this basically means that this person is not a class teacher.
	}
	
	$group = new Group ($id);
	
	echo "<h1>Snapshot for ";
	echo $group->returnName();
	echo ".</h2>";
	
	$group->groupjobList();
	
	echo "<p> The charts below are a snapshot for this group as at the end of the last cycle.</p>";
	$group->pie_chart('reading',false);

$group->pie_chart('writing', false);
$group->pie_chart('maths', false);
	
}
	
public function spreadsheetGoalsRow(){
	
		
echo "<tr>";
echo "<td>";
echo $this->showName();
echo "</td>";	
$maths = new Assessment( $this->id, 'maths', 'individual');
echo $maths->spreadsheetGoalCell();	
	
$reading = new Assessment( $this->id, 'reading', 'individual');
echo $reading->spreadsheetGoalCell();	
	
$writing = new Assessment( $this->id, 'writing', 'individual');
echo $writing->spreadsheetGoalCell();	
echo "</tr>";	

}

public function spreadsheetRow(){
	
echo "<tr>";
echo "<td>";
echo $this->showName();
echo "</td>";	
$maths = new Assessment( $this->id, 'maths', 'individual');
echo $maths->spreadsheetCell();	
	
$reading = new Assessment( $this->id, 'reading', 'individual');
echo $reading->spreadsheetCell();	
	
$writing = new Assessment( $this->id, 'writing', 'individual');
echo $writing->spreadsheetCell();	
echo "</tr>";			
	
}



public function targetBox($assessment){

		$target =  $assessment->showTarget($this->showCurrenYearLevelforNatStandards());
		
									  echo "<div class='highlight-box-person ".$target['targetStandard']."'>";
									  if ($target['lastYearData']=="no"){
										echo "There is no data for last year.";
										}
										else {
											
									
									  echo "At the end of last year ".$this->returnFirstName()." was working at ".$target['lastYearDesc'].". ";
										
										echo $this->returnFirstName()."'s target for the end of the year is ".$target['targetDesc'].". ";
										echo $this->returnFirstName()." is currently working at ";
												 echo $assessment->returnCurrentData();
												  echo ". ";
										echo "If ".$this->returnPronoun('she')." achieves this target then ".$this->returnPronoun('she')." will be ".$target['targetStandard']." the National Standard.";
										if ($target['targetMeetsStandard']=="no"){
											echo "To meet the Standard ".$this->returnFirstName()." needs to move ".$target['gap']." sub levels from where ".$this->returnPronoun('she')." currently is.";	
										}
										}
									  	echo "</div>";
	
}

public function groupTargetBox($assessment){

		$target =  $assessment->showTarget($this->showCurrenYearLevelforNatStandards());
									  $box = "<div class='highlight-box ".$target['targetStandard']."'>";
									 $box .= $this->returnImage('thumbnail', 'miniBadge');
									 $box .= "<div class='target_text'>";
										  if ($target['lastYearData']=="no"){
										$box .= "There is no data for last year for ".$this->returnName().".";
										}
										else {
											 $box .= "At the end of last year ".$this->returnName()." was working at ".$target['lastYearDesc'].". ";
											
										 $box .= $this->returnFirstName()."'s target for the end of the year is ".$target['targetDesc'].". ";
										 $box .= $this->returnFirstName()." is currently working at ";
										$box .=	  $assessment->returnCurrentData();
										$box .= ". ";
										 $box .= "If ".$this->returnPronoun('she')." achieves this target then ".$this->returnPronoun('she')." will be ".$target['targetStandard']." the National Standard.";
										if ($target['targetMeetsStandard']=="no"){
											 $box .= "To meet the Standard ".$this->returnFirstName()." needs to move ".$target['gap']." sub levels from where ".$this->returnPronoun('she')." currently is.";	
										}
										}
										$box .= "</div>";
									  	 $box .= "</div>";
								$progress =  $assessment->progressRate($this->showCurrenYearLevelforNatStandards());
							$targetArray = array( 'box' =>$box,
							'standard' =>$target['targetStandard'],
							'lastYearValue'=>$target['lastYearValue'],
							'progress'=>$progress
							);			 
							
							 return $targetArray;
	
}



public function groupAnnualReport($assessment){

		$target =  $assessment->annualReport($this->showCurrenYearLevelforNatStandards());
		
		
							$targetArray = array( 
							'standard' =>$target['result'],
							'lastYearValue'=>$target['lastYearValue']
							
							);			 
							
							 return $targetArray;
	
}

public function showContent($pageType){

if ($this->user_level >7){
$post_status = array('publish', 'draft', 'future');
}
else {
	
$post_status = 'publish';	
}
			if ($pageType =="home"){
				
					if ($this->personType == "staff"){
																		
						page_header('staff' , $this->user_level);
						 echo "<div class='spacer'></div>";            
						
						staff_home_page();
						
						$this->show_staff_job_list();		
						
						
					}
					else {
						page_header($pageType, $this->user_level);
						
						if ($this->user_level >7){
					
							show_individual_job_list($this->id);	
						}
									echo    "<dl id='".$pageType."_post_list' class='post_list'>";
										  
										  $post_type_array =array( 'general', 'sparkle', 'thinker', 'team_player', 'communicator','dream_maker');
										   $the_query = new WP_Query( array( 
																			'year' =>$this->currentYear,
																		'post_type' => $post_type_array,
																		'post_status' => $post_status,
																		'tax_query' => array(
																		array(
																			'taxonomy' => 'person_id',
																			'field' => 'slug',
																			'terms' => $this->id
																			)
																		)
																	) 
										
																);	
									 sibson_posts_to_html($the_query, $this->user_level, $this->userid, $this->id, $this->returnyearLevel(), $this->returnActualFirstName(), $this->returnPronoun($this->returnGender()));
									
								
									echo '</dl>';	
										wp_reset_query();						
																
					}
			}
		
			else if ($pageType=="reading" || $pageType=="writing" ||$pageType=="maths"){
				
						 $assessment = new Assessment( $this->id, $pageType, 'individual');
												 
						 page_header($pageType, $this->user_level);                 
							if ($this->user_level>7){		
									 sibson_page_buttons('person', $pageType, $this->id, $this->returnFirstName());    
									}	
									else {				
									 echo "<div class='spacer'></div>";            
								
											 
									}
												
									echo  "<div id='chart_div_".$pageType."' class='chart'>"; 
												  $assessment->get_individual_chart();
								 echo "</div>";
								 echo "<p>The chart shown here shows progress over time in the ";
								 echo $pageType;
								 echo " curriculum. The teacher has recorded an 'Overall Teacher Judgment' based on assessment data and observations. If you have problems viewing this chart please use the feedback form to let us know.";
								  echo  "<p>".$this->returnFirstName()." is currently working at ";
								  					$assessment->showmeasure();
												  $assessment->currentData();
												  echo " for ".$pageType."</p>";
								echo 	$assessment->shortStandardStatement($this->showCurrenYearLevelforNatStandards(), $assessment->currentDataNumber(true, false), $this->returnFirstName(), $this->returnPronoun('she'), false);
								echo "<br />";
								
								if ($this->user_level>7){
										$secureId = $this->id;
									}
									else {
										$secureId = $this->secureId;
									}
								echo "<a href='?accessId=".$secureId."&pageType=".$pageType."_stnds' rel='external' data-role='button' data-theme='b' data-inline='true'>Read more...</a>";
								echo "<br />";
								if ($this->user_level>7){		
									echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$this->id."&formType=slider&pageType=".$pageType."' data-initialForm='' id='slider_form' method='post' enctype='multipart/form-data'>";		  
									  $assessment->slider($this->showCurrenYearLevelforNatStandards());
									 echo "<a href='#dialog' data-rel='dialog' data-role='button' data-inline='true' data-subject='".$pageType."' id='slider_submit' data-theme='b' data-personid='".$this->id."'  >Save</a>";
									  sibson_form_nonce('slider_form');
									  echo "<input type='hidden' name='person_id' value='".$this->id."' />";
									  echo "<input type='hidden' name='person_id' value='".$this->id."' />";
									 echo "<input type='hidden' name='subject' value='".$pageType."' />";
									  
									  echo "</form>";
									  
									 $this->targetBox($assessment);
								
								
								
									 
									}
											 
									//		 $assessment->currentGoals('', $this->returnFirstName());
										$Goals = $assessment->return_years_goals($this->returnFirstName());
									     
											 
									
										$display .= return_basic_display_template($Goals);
										  
										
						echo $display;
									
								   echo    "<dl id='".$pageType."_post_list' class='post_list'>"; 
								  $the_query = new WP_Query( array( 
																	
																	'post_type' => $pageType,
																	'post_status' => $post_status,
																	'tax_query' => array(
																	array(
																		'taxonomy' => 'person_id',
																		'field' => 'slug',
																		'terms' => $this->id
																		)
																	)
																) 
															);	
								sibson_display_posts($the_query, $this->user_level, $this->userid);
								wp_reset_query();							
			}
	
				else if ($pageType=="readinggoals" || $pageType=="writinggoals" ||$pageType=="mathsgoals" ){
				
							$assessment = new Assessment( $this->id, $pageType, 'individual');
												 
						  	 page_header($pageType, $this->user_level);         
							  sibson_page_buttons('person', $pageType, $this->id, $this->returnFirstName());           
											
									 echo "<div class='spacer'></div>";            
									
									if ($this->user_level>7){
											  
										$currentLevel = $assessment->currentDataNumber('', true);
										
									   $assessment->get_indicatorbuttons($currentLevel['level']);
									
									   
									}
								  
			}
				else if ($pageType=="reading_stnds" || $pageType=="writing_stnds" ||$pageType=="maths_stnds" ){
				
							$assessment = new Assessment( $this->id, $pageType, 'individual');
												 
						  	 $explodeString = explode('_', $pageType);
								echo "<h2 class='tk-head'>";
						echo "<img src='".SIBSON_IMAGES."/".$explodeString[0]."_head.png' />";
						echo " ".ucfirst($explodeString[0])." National Standards";
						 echo "</h2>";  
						 $assessment = new Assessment($this->id, $explodeString[0], 'individual');
								
							$assessment->showStandardsTable($this->returnActualFirstName(), $this->showCurrenYearLevelforNatStandards(), $this->returnImage('thumbnail', 'ui-li-thumb'));	
								
								  
			}
			
			else if ($pageType =="expectationsgoals" || $pageType =="learnersgoals" || $pageType =="teamgoals" || $pageType =="creatinggoals" || $pageType =="knowinggoals" || $pageType =="environmentgoals"){
				
				if ($this->person_access_level =="full"){
					$assessment = new Assessment( $this->id, $pageType, 'individual');
												 
						  	 page_header($pageType, $this->user_level);         
							  sibson_page_buttons('person', $pageType, $this->id, $this->returnFirstName());            
											
									 echo "<div class='spacer'></div>";            
										
								echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$this->id."&pageType=".$pageType."&formType=staff_audit' data-initialForm='' id='staff_audit' method='post' >";		
									  sibson_form_nonce('staff_audit');	
									 echo '<input type="hidden" id="personId" name="personId" value="'.$this->id.'" />';
									  echo '<input type="hidden" id="assessment_subject" name="assessment_subject" value="'.$pageType.'" />';
									 
									 
								
										
									   $assessment->get_indicatorlist(1);
									   echo '<input type="submit" value="Save Changes" data-theme="b" data-inline="true" />';
									  
									   echo '</form>';
					}
			
			}
		else if ($pageType =="expectations" || $pageType =="learners" || $pageType =="team" || $pageType =="creating" || $pageType =="knowing" || $pageType =="environment"){
				
						if ($this->person_access_level =="low"){
							
						}
						else {
						 page_header($pageType, $this->user_level);
							if ($this->user_level>7){		
									 sibson_page_buttons('person', $pageType, $this->id, $this->returnFirstName());    
									}
									   echo    "<dl id='".$pageType."_post_list' class='post_list'>"; 
									  $the_query = new WP_Query( array( 
																		
																		'post_type' => $pageType,
																		'post_status' =>  $post_status,
																		'tax_query' => array(
																		array(
																			'taxonomy' => 'person_id',
																			'field' => 'slug',
																			'terms' => $this->id
																			)
																		)
																	) 
																);	
										sibson_display_posts($the_query, $this->user_level, $this->userid);						
	
							
						}
				 }
	
		else if ($pageType=="images"){
				
						 page_header($pageType, $this->user_level);
						 if ($this->user_level>7){		
									 sibson_page_buttons('person', $pageType, $this->id, $this->returnFirstName());    
									}	
						 if ($this->user_level==10){		
									echo '<form action="wp-admin/options-general.php?page=copy_posts_by_child.php" data-ajax="false"  name="individual_image" id="individual_image" method="post"/>';
									
									echo '<input type="submit" name="info_update" data-inline="true" data-theme="b" value="copy from old fosbook"/>';
									echo '<input type="hidden" name="UPN" id="UPN"  value="'.$this->id.'"/>';
									echo '</form>';   
									}					
									
									
									  $the_query = new WP_Query( array( 
																		
																		'post_type' => array( 'general', 'sparkle', 'thinker', 'team_player', 'communicator', 'dream_maker', 'images'),
																		'post_status' =>  $post_status,
																		'tax_query' => array(
																		array(
																			'taxonomy' => 'person_id',
																			'field' => 'slug',
																			'terms' => $this->id
																			)
																		)
																	) 
																);	
										sibson_display_images($the_query, $this->user_level, $this->id, $this->userid);		
								  wp_reset_query();
			}
			else if ($pageType=="admin"){
				
					
									
									sibson_display_edit_options($this->id);		
								  
			}
			else if ($pageType=="assessments"){
				
						 page_header($pageType, $this->user_level);
								
						$assessment = new Assessment($this->id, $pageType, 'individual');
						
						$assessment->showAssessmentsList();	
						
						$assessment->showAssessmentData($this->dob);		
								  
			}
				else if ($pageType=="information"){
				
						 page_header($pageType, $this->user_level);
						 
					
						 
						require(SIBSON_FUNCTIONS.'/enrolment.php');
				sibson_enrolment_form($this->id, 'info_form');			
								  
			}
			else if ($pageType=="detail"){
				
						
									$this->showFullPersonDetails();		
								  
			}
		else if ($pageType=="groups"){
				
						 page_header($pageType, $this->user_level);
									
									sibson_page_buttons('person', $pageType, $this->id, $this->returnFirstName());    
									
									$this->showMyGroups();		
								  
			}
			
			else if ($pageType=="goals"){
					if ($this->person_access_level =="low"){
							
						}
						else {
						 page_header($pageType, $this->user_level);
									
								sibson_page_buttons('person', $pageType, $this->id, $this->returnFirstName());   
								 echo    "<dl id='".$pageType."_post_list' class='post_list'>"; 
									  $the_query = new WP_Query( array( 
																		
																		'post_type' => $pageType,
																		'post_status' =>  $post_status,
																		'tax_query' => array(
																		array(
																			'taxonomy' => 'person_id',
																			'field' => 'slug',
																			'terms' => $this->id
																			)
																		)
																	) 
																);	
																
										sibson_display_posts($the_query, $this->user_level, $this->user);	
								$this->showMyGoals();		
						}
			}	
			else if ($pageType=="readinggoalSpread"){
					
					$print = new PrintPage();
		
		$print->goal_spreadsheet($this->id, 'reading');
		
					
			}	
			else if ($pageType=="writinggoalSpread"){
					
					$print = new PrintPage();
		
		$print->goal_spreadsheet($this->id, 'writing');
		
					
			}	
			else if ($pageType=="mathsgoalSpread"){
					
					$print = new PrintPage();
		
		$print->goal_spreadsheet($this->id, 'maths');
		
					
			}	
			else if ($pageType=="baseline"){
					if ($this->person_access_level =="low"){
							
						}
						else {
						 page_header($pageType, $this->user_level);
									
									
									
									$this->showMyObservationGoals();		
						}
			}	
			
			else if ($pageType=="visitors"){
				
					 page_header($pageType, $this->user_level);
						echo "<p>Information on this page has been collected since Friday 25th May 2012 and as such some data will be missing.</p>";
						require(SIBSON_CLASSES.'/users.php');
						$mum = $this->returnMotherEmail();
						if ($mum){
						$mumuser = new userAnalysis($mum, $this->id);
						
						$mumuser->pie_chart('mother');
						}
						
						
						$dad = $this->returnFatherEmail();
						if ($dad){
						$daduser = new userAnalysis($dad, $this->id);
						
						$daduser->pie_chart('father');
						}
						
						$user = new userAnalysis('', $this->id);
						
						$userList = $user->fetch_staff_visitors();
						foreach ($userList as $was){
		
							$staffuser = new userAnalysis($was->username, $this->id, 'staff');
						
							$staffuser->pie_chart($was->username);	
							}
			}	
				else if ($pageType=="visitor_stats"){
				
					 page_header($pageType, $this->user_level);
						echo "<p>Information on this page has been collected since Friday 25th May 2012 and as such some data will be missing.</p>";
						require(SIBSON_CLASSES.'/users.php');
						
						$groupusers = new userAnalysis('whole school', $this->id);
						$groupusers->totalVisitsByGroup();
			}	
			
			else if ($pageType=="school_stats"){
				
					 page_header($pageType, $this->user_level, true);
					
						global $wpdb;
						$year = $this->currentYear-1;
						$groups = $wpdb->get_results("Select wp_group_id, YearGroup from wp_groups where type ='Class' and year = $year and YearGroup not in (1,0) group by YearGroup");
						$totalinClass =0;
						$boysTotal = 0;
						$girlsTotal = 0;
						$maoriTotal = 0;
						$pacifikaTotal = 0;
						$chartArray = array(
						'wellbelow'=>0,
						'below'=>0,
						'at' =>0,
						'above'=>0,
						'well above'=>0
						);
						$boyArray = array(
						'wellbelow'=>0,
						'below'=>0,
						'at' =>0,
						'above'=>0,
						'well above'=>0
						);
						$girlArray = array(
						'wellbelow'=>0,
						'below'=>0,
						'at' =>0,
						'above'=>0,
						'well above'=>0
						);
						$maoriArray= array(
						'wellbelow'=>0,
						'below'=>0,
						'at' =>0,
						'above'=>0,
						'well above'=>0
						);
						$pacifikaArray= array(
						'wellbelow'=>0,
						'below'=>0,
						'at' =>0,
						'above'=>0,
						'well above'=>0
						);
						
					foreach ($groups as $g){ // for each group start.
						$group = new Group($g->wp_group_id );
						
						$idArray = $group->get_id_array_for_year_group();
						
						
							foreach ($idArray as $id){ //foreach id start.
								
								$person= new Person($id);
								$ethnic = $person->ethnic_origin();
								
								$assessment = new Assessment($id, 'maths');
								
								$target = $person->groupAnnualReport($assessment);	
										if ($target['lastYearValue']>0){ // Is a value for last year start.
										$totalinClass++;	
										} // Is a value for last year end.
										$chartArray[$target['standard']] ++; 
											if ($person->returnGender() == "Male"){ // Boys start.
												if ($target['lastYearValue']>0){ // Is a value for last year start.
													$boysTotal++;	
													} // Is a value for last year end.
												$boyArray[$target['standard']] ++; 
											} // boys end
											 else if ($person->returnGender() == "Female"){ //girls start.
												$girlArray[$target['standard']] ++; 
												if ($target['lastYearValue']>0){  // Is a value for last year start.
													$girlsTotal++;	
													}  // Is a value for last year end.
											 } // girls end.
											if ($ethnic=="NZ Maori"){ // Maori start.
												$maoriArray[$target['standard']] ++; 
												if ($target['lastYearValue']>0){ // Is a value for last year start.
												$maoriTotal++;	
												} // Is a value for last year end
												
											} // Moari end
											if ($ethnic=="Tongan" || $ethnic=="Samoan" || $ethnic=="Other Pacific Isl Group" || $ethnic=="Fijian" || $ethnic =="Cook Isl Maori"){ // Pacifkia start.
											
												$pacifikaArray[$target['standard']] ++; 
												if ($target['lastYearValue']>0){ // Is a value for last year start.
												$pacifikaTotal++;	
												} // Is a value for last year end
												
											} // Pacifika end.
									
								
							}// foreach id end.
							
							
										
						} // for each group end.
						
						echo "<h3>Whole School</h3>";
							$group->annualReportSpreadsheet($chartArray, $totalinClass);
							
							echo "<h3>Boys</h3>";
							$group->annualReportSpreadsheet($boyArray, $boysTotal);
							
							echo "<h3>Girls</h3>";
							$group->annualReportSpreadsheet($girlArray, $girlsTotal);
							
							echo "<h3>Maori</h3>";
							$group->annualReportSpreadsheet($maoriArray, $maoriTotal);
							
							echo "<h3>Pacifika</h3>";
							$group->annualReportSpreadsheet($pacifikaArray, $pacifikaTotal);
							
							echo $pacifikaTotal;
			}	
			
			else if ($pageType=="teaching"){
				
				
				$indicator = $_GET['teachingId'];
				
				sibson_teaching_idea_page($indicator, $this->id);
				
				
									
			}
		
		else if ($pageType=="ESOL_AF"){
		
		$print = new PrintPage();
		
		$print->ESOL_AF($this->id);
		
		
		
	}
	
				else {
					
				
				
					 page_header($pageType, $this->user_level);
										
									if ($this->user_level>7){		
									 sibson_page_buttons('person', $pageType, $this->id, $this->returnFirstName());    
									}
									   echo    "<dl id='".$pageType."_post_list' class='post_list'>"; 
									  $the_query = new WP_Query( array( 
																		
																		'post_type' => $pageType,
																		'post_status' =>  $post_status,
																		'tax_query' => array(
																		array(
																			'taxonomy' => 'person_id',
																			'field' => 'slug',
																			'terms' => $this->id
																			)
																		)
																	) 
																);	
																
										sibson_display_posts($the_query, $this->user_level, $this->user);						
	

				
						}
					
		 
				}
}




?>