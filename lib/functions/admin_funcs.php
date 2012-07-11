<?php
function fosbook_convert_csv_to_db($csvFile, $column){

	
$arrCSV = array();
// Open the CSV
if (($handle = fopen($csvFile, "r")) !==FALSE) {
// Set the parent array key to 0
$key = 0;
// While there is data available loop through unlimited times (0) using separator (,)
while (($data = fgetcsv($handle, 0, ",")) !==FALSE) {
   // Count the total keys in each row
   $c = count($data);
   //Populate the array
   for ($x=0;$x<$c;$x++) {
	if ($data[$x]==''){
		$data[$x]=0;
	}
	if($key==0){
		
	}
	else {
   $arrCSV[$key][$x] = $data[$x];
	}
   }
   $key++;
} // end while
// Close the CSV file
fclose($handle);
} // end if
	
	if ($column){
		if ($column == "mother" || $column == "father" || $column =="emergency1" || $column =="emergency2"){
			
				fosbook_update_db_parents($arrCSV, $column);	
		}
		else{
			fosbook_update_db_single($arrCSV, $column);	
	}
	}
	else {
		
	
	fosbook_update_db($arrCSV);
	}
}

function fosbook_admin_key_data($Id){
	
global $wpdb;

$keyDetails =$wpdb->get_row("SELECT * FROM wp_people WHERE wp_person_id = $Id");

$fieldNames = fosbook_get_field_array();

$oneK = $fieldNames[0][1];
$oneV = $keyDetails->sms_id;
$twoK = $fieldNames[1][1];
$twoV = $keyDetails->first_name;
$threeK = $fieldNames[4][1];
$threeV = $keyDetails->last_name;
$fourK = $fieldNames[7][1];
$fourV = $keyDetails->gender;
$fiveK = $fieldNames[19][1];
$fiveV = $keyDetails->nsn;
$sixK = $fieldNames[15][1];
$sixV = $keyDetails->dob;
$sevenK = $fieldNames[20][1];
$sevenV = $keyDetails->start_date;
	
$keyDetailsArray = array( $oneK => $oneV, $twoK=> $twoV, $threeK => $threeV, $fourK=> $fourV, $fiveK => $fiveV, $sixK=> $sixV, $sevenK => $sevenV );



return $keyDetailsArray;

}

function fosbook_admin_meta_data($Id){
	
global $wpdb;

$metaDetails =$wpdb->get_results($wpdb->prepare("SELECT * FROM wp_peoplemeta WHERE wp_person_id = %d", $Id));

$i=2;
foreach ($metaDetails as $meta){
if ($i==4||$i==7||$i==15||$i==19||$i==20){	
				}
				else {	
					$v = $meta->meta_value;
					$metaDetailsArray[$meta->meta_key] = $v;	
				}
$i++;	
}


return $metaDetailsArray;

}


function fosbook_admin_panel($keyDetails, $metaDetails, $save){
	
	$classArray = array('profile_image');
	
	// Draw the form for the key data.
		echo '<form data-initialForm="" method="post" id="detailsForm'.$keyDetails['sms_id'].'">';	
		echo '<div class="data_block" id="'.$keyDetails['sms_id'].'">';
		
        echo "<strong>Main Information for ".$keyDetails['first_name'].":<br /></strong>\n";
		
		echo '<label for="preferred_name">Preferred Name:</label>';
		echo '<input type="text" value="'.$keyDetails['first_name'].'" name="preferred_name" />';
		
		echo '<label for="preferred_last_name">Preferred Surname:</label>';
		echo '<input type="text" value="'.$keyDetails['last_name'].'" name="preferred_last_name" />';
		
		echo "<br />";
		
		echo '<label for="sms_id">SMS ID:</label>';
		echo '<input type="text" value="'.$keyDetails['sms_id'].'" name="sms_id" disabled="disabled"  />';
		
	
		echo "<br />";
		
		echo '<label for="gender">Gender:</label>';
		echo '<input type="text" value="'.$keyDetails['gender'].'" name="gender" />';
		
		echo '<label for="nsn">NSN:</label>';
		echo '<input type="text" value="'.$keyDetails['nsn'].'" name="nsn" disabled="disabled" />';
		
		echo '<label for="dob">DOB:</label>';
		echo '<input type="text" value="'.$keyDetails['dob'].'" name="dob" />';
		
		echo '<label for="start_date">Start Date:</label>';
		echo '<input type="text" value="'.$keyDetails['start'].'" name="start_date" />';
		echo '<br/>';	

// Draw the form for the meta data.
			
        echo "<strong>Extra Information for ".$keyDetails['first_name'].":<br /></strong>\n";
		
		foreach ($metaDetails as $key => $value){
		
		if(in_array($key, $classArray)){		
		$class = "class='longText'";	
		}
		if ($key=='profile_image'){
		
		echo "<img src='".FOSBOOK_UPLOADS.$value."' class='adminPanelImage' />";
			
		}
		else {
		echo '<label for="'.$key.'">'.$key.'</label>';
		echo '<input type="text" value="'.$value.'" name="'.$key.'" '.$class.'/>';	
		}
		}
		
		echo "<br /></div>";
		
echo "<input type='submit' value='Save changes' /></form>";
		
}


function fosbook_get_field_array(){
	
$fieldNameArray = array(
array('SMS ID', 'sms_id', '', ''),
array('Perferred Name','first_name', '', ''),
array('First Name', 'full_first_name', '', ''),
array('Preferred Surname', 'full_surname', '', ''), 
array('Surname','last_name', '', '<br>'), 
array('Year Group', 'Form', '', ''), 
array('Room', 'Room', '', ''), 
array('Gender','gender', '', ''), 
 array('Care Giver(s)', 'Caregiver', 'class="longText"', ''), 
array('Street', 'Address_street', '', ''),
array('Suburb', 'Suburb', '', ''), 
array('Post Code', 'post_code', '', '<br>'), 
array('Phone', 'CGiverphone', '', ''), 
array('Mobile', 'mobile', '', '<br>'), 
array('Email', 'email_address', 'class="longText"', ''), 
array(' Date of Birth', 'dob', '', ''), 
array('Admin Number', 'adminno', '', ''), 
array('Ethnic Origin', 'ethnic_origin', '', ''), 
array('First Language', 'First_Language', '', '<br>'), 
array('NSN', 'nsn', '', ''), 
array('Pacific Language', 'pacific_language', '', ''), 
array('Police Vet Name', 'police_vet_name', '', ''), 
array('Police Vet Name', 'police_vet_name_2', '', ''), 
array('Digital Safety & Use Agreement', 'digital_safety', '', ''), 
array('Digital Safety Comment', 'digital_safety_comment', '', ''), 
array('Trip Permission', 'trip_permission', '', '<br>'), 
array('Sensitive information', 'sensitive_information' , '', ''), 
array('Finance Comment','finance_comment', '', ''), 
array('Immunisations Completed?','immunisations_completed', '', ''), 
array('Immunisation comment', 'immunisation_comment', '', ''), 
array('Religious Education', 'religious_education', '', ''), 
array('Fendalton Friends', 'fendalton_friends', '', ''), 
array('Entered NZ Date', 'entered_NZ_date', '', ''), 
array('Visa Expiry','visa_expiry', '', ''), 
array('Work Permit Expiry', 'work_permit_expiry', '', ''), 
array('Non NZ Comment', 'non_NZ_comment', '', '')
 );
 

return 	$fieldNameArray;
	
}

function fosbook_get_parents_field_array($type){
	
$fieldNameArray = array(
array('SMS ID', 'sms_id', '', ''),
array($type, $type, '', ''),
array('', '', '', ''),
array($type.'_first',$type.'_first', '', ''),
array($type.'_last',$type.'_last', '', ''),
array($type.'_homephone',$type.'_homephone', '', ''),
array($type.'_mobile',$type.'_mobile', '', ''),
array($type.'_email',$type.'_email', '', ''),
array($type.'_address1',$type.'_address1', '', ''),
array($type.'_address2',$type.'_address2', '', ''),
array($type.'_workphone',$type.'_workphone', '', ''),
array($type.'_comment',$type.'_comment', '', ''),
array($type.'_address3',$type.'_address3', '', ''),
array($type.'_lives_with',$type.'_lives_with', '', ''),
array($type.'_profession',$type.'_profession', '', ''),
array($type.'_workaddress',$type.'_workaddress', '', ''),
array('', '', '', ''),
array('', '', '', ''),
array($type.'_name',$type.'_name', '', '')
 );
 

return 	$fieldNameArray;
	
}


 		

function fosbook_update_db($arrCSV){
	
global $wpdb;

foreach ($arrCSV as $row){
$fieldNames = fosbook_get_field_array();	
$smsid = $row[0];
$first = trim($row[1]);
$last = trim($row[4]);
$gender= trim($row[7]);
$nsn=$row[19];
$dob=$row[15];
$start= $row[20];

$Room = $row[6];



$checkDetails =$wpdb->get_var("SELECT wp_person_id FROM wp_people WHERE nsn = $nsn");	

if($checkDetails){
		
		$wpdb->update( 'wp_people', array( 'first_name' => $first, 'last_name' => $last, 'gender' => $gender, 'nsn'=> $nsn, 'dob' => $dob, 'start_date'=>$start ), array( 'wp_person_id' => $checkDetails ));
		
		for ($i=2; $i<count($fieldNames); $i++){
				
						$meta= $fieldNames[$i][1];
						update_or_insert_people_meta($meta,  $row[$i], $checkDetails);
						
					
				
				}
			
		}
else {
		$wpdb->insert( 'wp_people', array('sms_id'=>$smsid, 'first_name' => $first, 'last_name' => $last, 'gender' => $gender, 'nsn'=> $nsn, 'dob' => $dob, 'start_date'=>$start ));	
		$new_id = $wpdb->insert_id;
		$wpdb->insert( 'wp_peoplemeta', array( 'wp_person_id'=>$new_id,'meta_key'=>'person_type','meta_value' =>'student'));
		for ($i=2; $i<count($fieldNames); $i++){
				if ($i==4||$i==7||$i==15||$i==19||$i==20){	
						}
						else {	
						$meta= $fieldNames[$i][1];
						$wpdb->insert( 'wp_peoplemeta', array( 'wp_person_id'=>$new_id,'meta_key'=>$meta,'meta_value' => $row[$i]));
						
						}
				}
		
			}	
		
		
		}



}


function fosbook_update_db_single ($arrCSV, $column){
	
global $wpdb;


if ($column == group){
	
	foreach ($arrCSV as $row){
		
		$smsid =  $row[0];
						
						global $wpdb;
						$checkDetails =$wpdb->get_var("SELECT wp_person_id FROM wp_people WHERE sms_id = $smsid");	
				
				echo $checkDetails;
				echo "<br />";
				$room = $row[1];
				$findRoom =$wpdb->get_var("SELECT wp_group_id FROM wp_groups WHERE room = '$room' and year = 2012 and type = 'Class'");	
					
					echo "Room:";
					echo $findRoom;
						echo "<br />";
						
						$checkRoom =$wpdb->get_var("SELECT wp_group_id FROM wp_group_relationships WHERE wp_person_id = $checkDetails and wp_group_id = $findRoom");	
						
						if ($checkRoom){
							
							echo "already there";
						}
						else {
							
							$insert = $wpdb->insert( 'wp_group_relationships', array(  'wp_group_id' => $findRoom,  'wp_person_id'=>$checkDetails, 'vacated' =>0 ));
							echo $insert;
							
						}
		
		
		}
	
}
else {
foreach ($arrCSV as $row){
		
	
			
					$meta = $column;
					
						$smsid =  $row[0];
						
						global $wpdb;
						$checkDetails =$wpdb->get_var("SELECT wp_person_id FROM wp_people WHERE sms_id = $smsid");	
				
			update_or_insert_people_meta($meta,  $row[1], $checkDetails);
					
		}

}

}

function fosbook_update_db_parents($arrCSV, $column){
	
global $wpdb;


foreach ($arrCSV as $row){
		$fieldNames = fosbook_get_parents_field_array($column);	
		$smsid = $row[0];
		


$checkDetails =$wpdb->get_var("SELECT wp_person_id FROM wp_people WHERE sms_id = $smsid");	
if($checkDetails){
		
		for ($i=3; $i<count($fieldNames); $i++){	
						$meta= $fieldNames[$i][1];
						update_or_insert_people_meta($meta,  $row[$i], $checkDetails);
				
				
				}
	}
	
}
}

function createeTapSettingsMenu() {

                ?>
                   <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post" enctype="multipart/form-data" id="uploadForm" name="uploadForm"> 
                     <input type="file"  name="ufile" /> 
                     <input type="submit" value="Upload" /> 
                       if the file only has 2 columns please give the name for the second column.<input type="text" name="type" id="type" />
                    </form> 
             
                <?php 
                        $upload = wp_upload_bits($_FILES["ufile"]["name"], null, file_get_contents($_FILES["ufile"]["tmp_name"]));
                        $csvFile = $upload['file'];
                        
                        if ($csvFile){
							
							if ($_POST['type']){
								
								  fosbook_convert_csv_to_db($csvFile, $_POST['type']);
								
							}
						else 	{
                        fosbook_convert_csv_to_db($csvFile);
							}
                        }
                
	
}




// Display The Options Page

function eTapOptionPage () 
{
     add_options_page('Update from eTap', 'Update from eTap', 'manage_options', __FILE__, 'createeTapSettingsMenu');  
}

add_action('admin_menu','eTapOptionPage');





?>