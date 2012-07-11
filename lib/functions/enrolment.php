<?php 

function sibson_enrolment_form($edit, $formId){
	
	$secureId = absint($edit); // set the variable passed through to be a positive integer to prevent sql injection.
	
	
	
	echo "<form data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$secureId."&pageType=information&formType=enrolment' id='".$formId."' method='post' enctype='multipart/form-data'>";
							
		echo "<input type='hidden' name='person_id' id='person_id' value='".$secureId."'	/>";					
								sibson_form_nonce('enrolment_form');
					if ($secureId){
						
						$id = $secureId;
						$person = new Person($secureId);
						
					}
			
						
							sibson_form_enrolment_basic($person) ;
								
								sibson_form_enrolment_address($person) ;
								
								sibson_form_enrolment_mother($person) ;
								
								sibson_form_enrolment_father($person) ;
								
								sibson_form_enrolment_caregiver($person);
								
								sibson_form_enrolment_forms($person);
								
								sibson_form_enrolment_emergency($person);
						
								sibson_form_enrolment_medical($person);
								
								sibson_form_enrolment_ethnicity($person);
								
								sibson_form_enrolment_other($person);
								
								sibson_form_enrolment_finish($person);	
						
					
	
							
								
							
								echo "</form>"; 
								?>
    <script>
	$('#<?php echo $formId;?>').formToWizard();
	</script>
    <?php 
								
}

function sibson_form_enrolment_basic($person) {
	if ($person){
	$zone = $person->returnZone();
	$first_name = $person->returnActualFirstName();
	$last_name = $person->returnLastName();
	$preferred_first_name = $person->returnFirstName();
	$dob = $person->returnDOB();
	$gender = $person->returnGender();
		$theme = "c";
	}
	echo "<div class='form_page' data-name='Basic'>";
							
	echo '<fieldset data-role="controlgroup"  data-theme="b" data-type="horizontal">';
							
										echo '<input data-theme="b" type="radio" name="zoning" id="radio-type-inzone" value="INZN"  ';
										if ($zone == "INZN"){
										echo "checked='checked'";
										}
									
										
										echo '/>';
										echo '<label data-theme="b" for="radio-type-inzone">Inzone</label>';
										
										
											echo '<input data-theme="b" type="radio" name="zoning" id="radio-type-ooz" value="OUTZ"  ';
											if ($zone == "OUTZ"){
										echo "checked='checked'";
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-type-ooz">Out of Zone</label>';
									
								echo '</fieldset>';	
								
								echo '<p></p>';
								echo '<label for="first_name">First Name:</label>';
								echo  '<input type="text" name="first_name" id="first_name" value="'.$first_name.'" data-theme="'.$theme.'"/>';
								echo '<label for="last_name">Last Name:</label>';
								echo  '<input type="text" name="last_name" id="last_name"  value="'.$last_name.'" data-theme="'.$theme.'"/>';
								echo '<label for="preferred_first_name">Preferred First Name:</label>';
								echo  '<input type="text" name="preferred_name" id="preferred_first_name"  value="'.$preferred_first_name.'" data-theme="'.$theme.'"/>';
								echo '<label for="dob">Date of Birth:</label>';
								?>
                                  <div id="date_picker">        
			<input name="dob" id="dob" type="date" data-role="datebox" value="<?php if ($dob){ echo $dob; } else {	echo date("l jS F Y");} ?>"
   data-options='{"mode": "calbox", "blackDates": [<?php echo $blackDates; ?>], "disableManualInput": true, "dateFormat": "ddd ddSS mmm YYYY" }'>
            </div>
                                <?php 
								echo '<fieldset data-role="controlgroup"  data-theme="b" data-type="horizontal">';
								
										echo '<input data-theme="b" type="radio" name="radio-gender" id="radio-gender-female" value="Female"  ';
										if ($gender == "Female"){
										echo "checked='checked'";
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-gender-female">Female</label>';
										
										
											echo '<input data-theme="b" type="radio" name="radio-gender" id="radio-gender-male" value="Male"  ';
										if ($gender == "Male"){
										echo "checked='checked'";
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-gender-male">Male</label>';
									
								echo '</fieldset>';	 
								   
													
	echo "</div>";
	
}
	
	
function sibson_form_enrolment_address($person) {
		if ($person){
	$address1 = $person->returnAddress1();
	$address2 = $person->returnAddress2();
	$address3 = $person->returnAddress3();
	$phone = $person->returnPhone();
	$sibling = $person->returnMySiblings('mother');	
	$theme = "e";
	foreach ($sibling as $s){
	
		$siblings = $s['first_name']." - ".$s['room'];	
		
	}
	
	}
	
	echo "<div class='form_page' data-name='Address'>";
							
						echo '<label for="address_1">Address line one:</label>';
								echo  '<input type="text" name="Address_street" id="Address_street" value="'.$address1.'" data-theme="'.$theme.'"/>';
								echo '<label for="address_2">Address line two:</label>';
								echo  '<input type="text" name="suburb" id="suburb" value="'.$address2.'" data-theme="'.$theme.'"/>';
								echo '<label for="address_3">Address line three (post code):</label>';
								echo  '<input type="text" name="post_code" id="address_3" value="'.$address3.'" data-theme="'.$theme.'"/>';
								
								echo '<label for="home_phone">Home phone:</label>';
								echo  '<input type="text" name="CGiverphone" id="home_phone" value="'.$phone.'" data-theme="'.$theme.'"/>';
								
								echo '<label for="siblings">Siblings currently attending FOS?</label>';
								echo  '<input type="text" name="siblings" id="siblings" value="'.$siblings.'" data-theme="'.$theme.'"/>';
								
								
								   
													
	echo "</div>";
}
	
	
function sibson_form_enrolment_mother($person) {
		if ($person){
	$array = $person->returnFullArray();
	
		$motherFirst = $array['mother_first'];
		$motherLasst = $array['mother_last'];
		$motherHomePhone = $array['mother_homephone'];
		$motherMobile = $array['mother_mobile'];
		$motherEmail = $array['mother_email'];
		$motherAddress1 = $array['mother_address1'];
		$motherAddress2 = $array['mother_address2'];
		$motherWorkPhone = $array['mother_workphone'];
		$motherComment = $array['mother_comment'];
		$motherAddress3 = $array['mother_address3'];
		$motherLives = $array['mother_lives_with'];
		$motherProf = $array['mother_profession'];
		$motherWorkAddress = $array['mother_workaddress'];
	$theme = "e";
	}
	echo "<div class='form_page' data-name='Mother'>";
							
	echo '<label for="mother_first_name">Mother\'s first name :</label>';
								echo  '<input type="text" name="mother_first" id="mother_first_name" value="'.$motherFirst.'"/>';
								
	echo '<label for="mother_last_name">Mother\'s last name :</label>';
								echo  '<input type="text" name="mother_last" id="mother_last_name" value="'.$motherLasst.'"/>';	
								
	echo '<label for="mother_home_phone">Mother\'s home phone :</label>';
								echo  '<input type="text" name="mother_homephone" id="mother_home_phone" value="'.$motherHomePhone.'"/>';	
								
	echo '<label for="mother_mobile_phone">Mother\'s mobile phone :</label>';
								echo  '<input type="text" name="mother_mobile" id="mother_mobile_phone" value="'.$motherMobile.'"/>';	
								
	echo '<label for="mother_email">Mother\'s email:</label>';
								echo  '<input type="text" name="mother_email" id="mother_email" value="'.$motherEmail.'"/>';																												
								
								   
													
	echo "</div>";
}


function sibson_form_enrolment_father($person) {
	
		if ($person){
	$array = $person->returnFullArray();
	
		$fatherFirst = $array['father_first'];
		$fatherLasst = $array['father_last'];
		$fatherHomePhone = $array['father_homephone'];
		$fatherMobile = $array['father_mobile'];
		$fatherEmail = $array['father_email'];
		$fatherAddress1 = $array['father_address1'];
		$fatherAddress2 = $array['father_address2'];
		$fatherWorkPhone = $array['father_workphone'];
		$fatherComment = $array['father_comment'];
		$fatherAddress3 = $array['father_address3'];
		$fatherLives = $array['father_lives_with'];
		$fatherProf = $array['father_profession'];
		$fatherWorkAddress = $array['father_workaddress'];
	$theme = "e";
	}
	echo "<div class='form_page' data-name='Father'>";
							
	echo '<label for="father_first_name">Father\'s first name :</label>';
								echo  '<input type="text" name="father_first" id="father_first_name" value="'.$fatherFirst.'"/>';
								
	echo '<label for="father_last_name">Father\'s last name :</label>';
								echo  '<input type="text" name="father_last" id="father_last_name" value="'.$fatherLasst.'"/>';	
								
	echo '<label for="father_home_phone">Father\'s home phone :</label>';
								echo  '<input type="text" name="father_homephone" id="father_home_phone" value="'.$fatherHomePhone.'"/>';	
								
	echo '<label for="father_mobile_phone">Father\'s mobile phone :</label>';
								echo  '<input type="text" name="father_mobile" id="father_mobile_phone" value="'.$fatherMobile.'"/>';	
								
	echo '<label for="father_email">Father\'s email:</label>';
								echo  '<input type="text" name="father_email" id="father_email" value="'.$fatherEmail.'"/>';																												
								
								   
													
	echo "</div>";
}
function sibson_form_enrolment_caregiver($person) {
	
	echo "<div class='form_page' data-name='Care Giver'>";
							
	
													
	echo "</div>";
}

function sibson_form_enrolment_living($person) {
	
	if ($person){
		$array = $person->returnFullArray();
	$access = $person->returnAccessNotes();
	$liveswith = $person->wholiveswith();
	$access = $array['sensitive'];
	$theme = "e";
	}
	
	echo "<div class='form_page' data-name='Living'>";
							
		echo '<fieldset data-role="controlgroup"  data-theme="b" data-type="horizontal">';
							
										echo '<input data-theme="b" type="radio" name="radio-living" id="radio-living-both" value="both"  ';
										if ($liveswith =="both"){
										echo "checked='checked'";	
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-living-both">Both parents</label>';
										
										
											echo '<input data-theme="b" type="radio" name="radio-living" id="radio-living-mother" value="mother"  ';
										if ($liveswith =="mother"){
										echo "checked='checked'";	
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-living-mother">Mother</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-living" id="radio-living-father" value="father"  ';
										if ($liveswith =="father"){
										echo "checked='checked'";	
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-living-father">Father</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-living" id="radio-living-caregiver" value="caregiver"  ';
										if ($liveswith =="caregiver"){
										echo "checked='checked'";	
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-living-caregiver">Care Giver</label>';
									
								echo '</fieldset>';	
								   
							echo "Custody/ Access arrangements the school needs to be aware of: (a copy of any custody orders must be provided for the school)";	
							echo  '<input type="text" name="access_arrangments" id="access_arrangments" value="'.$access.'" />';					
	echo "</div>";
}

function sibson_form_enrolment_forms($person){
	
	echo "<div class='form_page' data-name='Forms'>";
							
		if ($person){
	$array = $person->returnFullArray();
	
		$digtal = $array['digital_safety'];
		$digitalComment = $array['digital_safety_comment'];
		
		
		
	$theme = "e";
	}
	
	echo 	'<div data-role="fieldcontain">';					
echo '<fieldset data-role="controlgroup"  data-theme="b" data-type="horizontal">';
							
										echo '<input data-theme="b" type="radio" name="radio-living" id="radio-digtal-no" value="No"  ';
										if ($digtal =="No"){
										echo "checked='checked'";	
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-digtal-no">No</label>';
										
										
											echo '<input data-theme="b" type="radio" name="radio-living" id="radio-digtal-yes" value="Yes"  ';
										if ($digtal =="Yes"){
										echo "checked='checked'";	
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-digtal-yes">Yes</label>';
										
										echo '<input data-theme="b" type="radio" name="radio-living" id="radio-digital-noform" value="Form not returned"  ';
										if ($liveswith =="Form not returned"){
										echo "checked='checked'";	
										}
										echo '/>';
										echo '<label data-theme="b" for="radio-digital-noform">Form not returned</label>';
					echo '</fieldset>';				
								
				echo '<label for="digital_comment">Digital safety comment:</label>';
								echo  '<input type="text" name="digital_comment" id="digital_comment" value="'.$digitalComment.'"/>';						   
													
	echo "</div>";
	echo '</div>';
	
}

function sibson_form_enrolment_emergency($person){

echo "<div class='form_page' data-name='Emergency'>";
							
		if ($person){
	$array = $person->returnFullArray();
	
		$emergency1First = $array['emergency1_first'];
		$emergency1Last = $array['emergency1_last'];
		$emergency2First = $array['emergency2_first'];
		$emergency2Last = $array['emergency2_last'];
		
		$emergency1Phone = $array['emergency1_homephone'];
		$emergency1Mobile = $array['emergency1_mobile'];
		$emergency2Phone = $array['emergency2_homephone'];
		$emergency2Mobile = $array['emergency2_homephone'];
		
		
	$theme = "e";
	}
	
	echo 	'<div data-role="fieldcontain">';					
	echo '<label for="emergency1_first">Emergency contact 1 - first name :</label>';
								echo  '<input type="text" name="emergency1_first" id="emergency1_first" value="'.$emergency1First.'"/>';
								
										
	echo '<label for="emergency1_first">Emergency contact 1 - last name :</label>';
								echo  '<input type="text" name="emergency1_last" id="emergency1_last" value="'.$emergency1Last.'"/>';
	
	echo '<label for="emergency1_homephone">Emergency contact 1 - phone:</label>';
								echo  '<input type="text" name="emergency1_homephone" id="emergency1_homephone" value="'.$emergency1Phone.'"/>';							
								
	echo '<label for="emergency1_mobile">Emergency contact 1 - mobile:</label>';
								echo  '<input type="text" name="emergency1_mobile" id="emergency1_mobile" value="'.$emergency1Mobile.'"/>';							
								
										
	echo '<label for="emergency2_first">Emergency contact 2 - first name :</label>';
								echo  '<input type="text" name="emergency2_first" id="emergency2_first" value="'.$emergency2First.'"/>';
								
										
	echo '<label for="emergency2_first">Emergency contact 2 - last name :</label>';
								echo  '<input type="text" name="emergency2_last" id="emergency2_last" value="'.$emergency2Last.'"/>';
								
	
	echo '<label for="emergency1_homephone">Emergency contact 1 - phone:</label>';
								echo  '<input type="text" name="emergency1_homephone" id="emergency1_homephone" value="'.$emergency2Phone.'"/>';							
								
	echo '<label for="emergency1_mobile">Emergency contact 1 - mobile:</label>';
								echo  '<input type="text" name="emergency1_mobile" id="emergency1_mobile" value="'.$emergency2Mobile.'"/>';								
																																									
	echo '</div>';
								   
													
	echo "</div>";
	
}
						
function sibson_form_enrolment_medical($person){
		
			
	if ($person){
		$array = $person->returnFullArray();
	$Medical =  $array['medical_note'];
	$theme = "e";
	}
	
									
echo "<div class='form_page' data-name='Medical'>";
							
		echo '<label for="medical_note">Medical Notes:</label>';
								echo  '<textarea name="medical_note" id="medical_note" >'.$Medical.'</textarea>';
								   
													
echo "</div>";
}
								
function sibson_form_enrolment_ethnicity($person){
									
echo "<div class='form_page' data-name='Ethnicity'>";
							
	
								   
													
echo "</div>";
	
}
								
function sibson_form_enrolment_other($person){
								
		echo "<div class='form_page' data-name='Accounts'>";
	
	
	
								   
													
echo "</div>";
								
}
								
function sibson_form_enrolment_finish($person){
									
									echo "<div class='form_page' data-name='Finish'>";
							
	
						echo "<input data-theme='b' type='submit' value='Save' class='next' id='form_submit' data-inline='true' data-theme='b' />";
					
								   
													
	echo "</div>";
	
}
	?>