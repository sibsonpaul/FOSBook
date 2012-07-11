<?php 

class LockandKey{


	private $id=0;
	private $type="Person"; //Always set the type to be person if the user level is less than 7, this is to ensure that parents only ever have access to a child page.
	private $pageType ="";
	public $userAccessIds ="";
	private $user_level =1;
	private $staffId = 0;
	private $userId = "";
	private $person_access_level ="low";
	private $username;
	
	public function __construct($ID, $type, $pageType){
		
	

	$this->pageType= $pageType;
	$current_user = wp_get_current_user();
	$userId = $current_user->ID;
	$this->userId = $userId;
	$userdata = get_userdata( $userId );
	$this->user_level =$userdata->user_level;
	//Check the array of Ids that user has right to view
	$this->userAccessIds = get_user_meta($userId, 'access_array', true); //Put that list of Ids into an array.
	$this->staffId =  get_user_meta($userId, 'person_id', true); // Fetch staff members own person_id.
	  $this->username = $userdata->first_name." ".$userdata->last_name;
    
	if ( $this->user_level > 7 ) {
	
		$this->type= $type;
	}
	else if ($this->user_level < 7){
		
		switch ($pageType){
		case "home";
		$this->pageType = "home";	
		break;
		case "general";
		$this->pageType = "general";	
		break;
		case "sparkle";
		$this->pageType = "sparkle";	
		break;
		case "thinker";
		$this->pageType = "thinker";	
		break;
		case "communicator";
		$this->pageType = "communicator";	
		break;
		case "dream_maker";
		$this->pageType = "dream_maker";	
		break;
		case "team_player";
		$this->pageType = "team_player";	
		break;
		case "writing";
		$this->pageType = "writing";	
		break;
		case "maths";
		$this->pageType = "maths";	
		break;
		case "reading";
		$this->pageType = "reading";	
		break;
		case "reading_stnds";
		$this->pageType = "reading_stnds";	
		break;
		case "writing_stnds";
		$this->pageType = "writing_stnds";	
		break;
		case "maths_stnds";
		$this->pageType = "maths_stnds";	
		break;
		
		default;
		$this->pageType = "home";			
		break;	
		}
	
		
	}
	
	
	if ($type =="Person"){

		$this->setPersonId($ID);
	}
	else if ($type=="Group"){
	
		$this->setGroupId($ID);
		
	}
	else if ($type == "YearGroup"){
		
		$this->setYearGroupId($ID);
	}
	
	else if ($type =="Admin"){
	
	$this->setAdminId($ID);
		
	}
	
	
		
}

// Function to retunr the current users permission level.

public function userLevel(){
	
return $this->user_level;	
	
}


public function setPersonId($ID){
	
if (preg_match('/^[a-f0-9]{32}$/', $ID)){ // If the ID passed through the url is a md5 hash then the check to see if this user has permission to view the page.
			
			
				foreach ($this->userAccessIds as $person_id){ 		 // Each user has an array of accessIds that they can access. Iterate through the array and check if they match the ID being passed.
					
						$currentId = $person_id;
						
						$makeIdSecure = salt_n_pepper($currentId);  // convert the id to an md5 encrypted string.
					
							if ($ID == $makeIdSecure){ // if the id matches the secure id passed via the url, use it to set the id for the page.
							$this->id = $currentId;	
							break;
							}
							else {
						
							$this->id = $this->userAccessIds[0]; // if no id has been set default to the first one in the users list.
						
							}
					
				} //end for loop.	
			
		}
		
else { // else the Id is not an md5 it is an integer and so must be checked.
			
		if ( $this->user_level <  7 ) {
				
					$this->id=  $this->userAccessIds[0]; // set the id to the users default if they do not have admin rights that are higher than 7.	
				}
			else { // if the user has a user level higher than 7, they are a member of staff and so can be given a plain integer person_id and can access children's reports. However first we need to check if the id is actually for a member of staff so that their privacy can be protected and their own appraisal kept confidential.
							if ($ID==0){
								$this->id = $this->staffId;
									$this->person_access_level = "full";
							}
							else {
								$person = new Person($ID);
								$personType = $person->returnPersonType();
								
								if ($personType == "staff"){
										if ($this->userAccessIds){
												
											foreach ($this->userAccessIds as $person_id){ 		 // Each user has an array of accessIds that they can access. Iterate through the array and check if they match the ID being passed.
											
												$currentId = $person_id;
												if ($ID == $currentId || $ID == $this->staffId ){ // if the id matches id passed via the url, use it to set the id for the page.
													$this->id = $ID;
													$this->person_access_level = "full"; //give full access to the staff members pages.
												break;
												}
												
												else {
												
														$this->id = $ID; // set to the id passed through.
														$this->person_access_level = "low";
													
											} 
										} //end for loop.
									
								}// end if access array exists.
										else {
											
											if ($ID == $this->staffId ){ // if the id matches id passed via the url, use it to set the id for the page.
													$this->id = $ID;
													$this->person_access_level = "full"; //give full access to the staff members pages.
												break;
												}
												
												else {
												
													$this->id = $ID; // set to the users own id.
													$this->person_access_level = "low";
											
												}
										
									}
						}
								else {
		
							$this->id = $ID; // only pass back the number as an integer if the user has a permission level higher than 7 and the person type is not a staff member.
						}
			}
				
	}		
}
	
}
public function setGroupId($ID){

			
		if ( $this->user_level <  7 ) {
				
					$this->id=  $this->userAccessIds[0]; // set the id to the users default if they do not have admin rights that are higher than 7.	
					$this->type="Person";
				}
				else {
					
				$this->id = $ID; // only pass back the number as an integer if the user has a permission level higher than 7.
					
			}
					
	
}

public function setYearGroupId($ID){

			
		if ( $this->user_level <  7 ) {
				
					$this->id=  $this->userAccessIds[0]; // set the id to the users default if they do not have admin rights that are higher than 7.	
					$this->type="Person";
				}
				else {
					
				$this->type = "Group";
					$yearGroup= $ID;
					
					$groupArray = array( 'name' => "Year ".$ID, 'YearGroup' => $ID, 'ids' =>array() );
					$groupIds = sibson_select_group_ids_by_year($yearGroup);
						 foreach ($groupIds as $group){
							  $group = new Group ($group);
							  $thisIdArray= $group->get_id_array();
							  foreach ($thisIdArray as $thisId){
								   array_push($idArray['ids'], $thisId);
							  }
						}
	
				$this->id = $groupArray; // only pass back the number as an integer if the user has a permission level higher than 7.
					
			}
					
	
}
public function setAdminId($ID){

			
		if ( $this->user_level <  7 ) {
				
					$this->id=  $this->userAccessIds[0]; // set the id to the users default if they do not have admin rights that are higher than 7.	
					$this->type="Person";
				}
				else {
					
				$this->id = $ID; // only pass back the number as an integer if the user has a permission level higher than 7.
				$this->type = "Admin";	
			}
					
	
}

public function returnPageAccess(){

return $this->person_access_level;	
	
}
public function fetchType(){
	
return $this->type;	
	
	
}

public function fetchPageType(){
	
return $this->pageType;		
	
}
public function fetchId(){
	
$sanitisedId = 	absint( $this->id );
return $sanitisedId;	
	
}

	
public function staffMenu(){
	
if ($this->user_level>7){

echo '<div class="sideMenu">';
		if ($this->type=="Group"){
		$list = new StudentList($this->id);
		}
		else if ($this->type=="Person") {
		 $person= new Person($this->id);	
			
		$groupid = $person->currentClass();	
		$list = new StudentList($groupid);	
		}
echo $list->menuList($Id); 
echo '</div>';	
	
}
	
	
}
	
	
public function topMenu(){
	

if ($this->user_level<7){	

echo '<div id="topNav">';

echo '<a href="'.wp_logout_url( ).'" rel="external" target="_self" class="yellow">Log Out</a>';  
	$i = 0;
	foreach ($this->userAccessIds as $person_id){ 		 // Each user has an array of accessIds that they can access. Iterate through the array and check if they match the ID being passed.
				
		
			$currentId = $person_id;
			$makeIdSecure = salt_n_pepper($currentId); 
			switch ($i){
			
			case 0;
			$colour = "red";
			break;
			case 1;
			$colour = "blue";
			break;
			case 2;
			$colour = "green";
			break;
			case 3;
			$colour = "yellow";
			break;
					
	}
	$i++;
	
		echo  '<a href="?accessId='.$makeIdSecure.'" rel="external" target="_self" class="menuButton'.$i.' '.$colour.'">';
		$person = new Person ($currentId);
		echo $person->returnFirstName();
		echo   "</a>"; 
		
		 
		}
	echo '</div>';
	
}
else {

echo '<div id="topNav">';
echo '<a href="'.wp_logout_url( ).'" rel="external" target="_self" class="yellow">Log Out</a>';  	

echo '<a class="blue loaddialog" href="#dialog" data-dialogtype="stuff" data-id="'.$this->id.'" data-title="Do Stuff" data-pagetype="'.$this->pageType.'" data-classtype="'.$this->type.'" data-rel="dialog">Do Stuff</a>';
echo '<a class="red loaddialog" href="#dialog" data-dialogtype="people" data-id="'.$this->id.'" data-title="Find People" data-pagetype="'.$this->pageType.'" data-classtype="'.$this->type.'" data-rel="dialog">Find People</a>';
echo '<a class="green loaddialog" href="#dialog" data-dialogtype="groups" data-id="'.$this->id.'" data-title="Find Groups" data-pagetype="'.$this->pageType.'" data-classtype="'.$this->type.'" data-rel="dialog">Find Groups</a>';
echo '<a class="light" href="'.htmlentities($_SERVER['PHP_SELF']).'" rel="external"  data-rel="dialog">'.$this->username.'</a>';
	
echo '</div>';
		
	
	
}

      
		
	
}


}

?>