<?php 
/* * *
 * Processed form data into a proper post array, uses wp_insert_post() to add post. 
 * 
 * @param array $pfs_data POSTed array of data from the form
 */
 

/**
 * Create post from form data, including uploading images
 * @param array $post
 * @param array $files
 * @return string success or error message.
 */
 
function sibson_submit_slider_assessment($post, $get, $page){
	
	check_admin_referer('sibson_slider_form');
	check_access_rights();
	
	$sibson_data = $post;
	global $wpdb;
	
	// Find out what the current assessment cycle is.
	$cycle = sibson_get_current_cycle();
	$thisCycle = $cycle[0]['currentId'];
	
	$subject = $sibson_data['subject'];
	$person_id = absint($sibson_data['person_id']);
	$person = new Person($person_id);
	$value = $sibson_data['slider']+1;
	$update ='OTJ';
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');
	
$assessment= new Assessment($person_id, $subject);

	
// Check to see if a value already exists for this person and this cycle.
	  
	 $check = $wpdb->get_row($wpdb->prepare("SELECT ID, assessment_value from wp_assessment_data where person_id = %d and cycle = $thisCycle and assessment_subject= %s and area ='OTJ'", $person_id, $subject ));

// If it does then update it.
	
	
	if ($check){
		
		$existingValue = $check->assessment_value;
		$ID = $check->ID;
		if ($existingValue == $value){
			
			//Do nothing if the current assessment data is the same as the newly added one.
			
		}
		
// If is different then update the db with the new value.
		
		else {
			 $result = $wpdb->update( 'wp_assessment_data', array(  'assessment_value' => $value), array('ID' => $ID));
			 
			 if ($result == 1){
										 $logData ="assessment_value: $value and ID = $ID";
										 
									$log = new changeLog();
										$data = array(
										'table'=> 'wp_assessment_data',
										'oldvalue' => $existingValue,
										'newvalue' => $logData,
										'name'=> $person->returnName()
										);
										$log->insertLog($data);
										}
			 
		}
		
	}
	
// If no data exists for this person and cycle then insert it.	
	else {
	 $result = $wpdb->insert( 'wp_assessment_data', array( 'person_id' => $person_id, 'assessment_subject' => $subject, 'assessment_value' => $value, 'cycle'=> $thisCycle,'user_id'=> $user, 'date'=> $current_Date, 'area' => $update ));
	  if ($result == 1){
										 $logData ="person_id' => $person_id, 'assessment_subject' => $subject, 'assessment_value' => $value, 'cycle'=> $thisCycle,'user_id'=> $user, 'date'=> $current_Date, 'area' => $update";
										 
									$log = new changeLog();
										$data = array(
										'table'=> 'wp_assessment_data',
										'oldvalue' => 0,
										'newvalue' => $logData,
										'name'=> $person->returnName()
										);
										$log->insertLog($data);
										}
	}
	
	$person = new Person($person_id);
	
	$person->showContent($subject);
								
	
}



function sibson_submit_group_slider_assessment($post, $get, $page){
	
	check_admin_referer('sibson_slider_form');
	check_access_rights();
	page_header('confirm');
	
	
	global $wpdb;
	
	// Find out what the current assessment cycle is.
	$cycle = sibson_get_current_cycle();
	$thisCycle = $cycle[0]['currentId'];
	
	$subject = $post['subject'];
	$update ='OTJ';
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');
	$groupId = absint($get['accessId']);
	$resultsArray = array();
	$group = new Group($groupId);
	$yearGroup = $group->returnYearGroup();
	
	$assessment= new Assessment('', $subject);
			
			$subjectarray = $assessment->get_subject_data_array();
			
					foreach ($subjectarray as $key => $sub){ // start loop.
						
						$resultsArray[$key] = array('name'=>$sub, 'results' => array());
						
				
					} // end loop.
	
				foreach($post as $key=>$value) { // start loop.
				
						
						$split = explode("-", $key); // split the name into an array so that the person id can be extracted.
							if($split[0] == "slider"){
							
						$person_id = $split[1]; // Set the person id.
					
						
						array_push($resultsArray[$value]['results'], $person_id);
						}
			
				
				} // end loop.


  echo "<form data-initialForm='' data-ajax='false' action='".get_bloginfo('url')."?accessId=".$groupId."&formType=groupSliderConfirm&type=Group' id='confirm_assessment_form' method='post'>";	
		    echo '<a href="" data-inline="true" data-theme="b" data-role="button" data-rel="back">No, I want to go back</a>';
			 echo "<input type='submit' value='Confirm and save' id='form_submit' data-inline='true' data-theme='b'  />";
			 echo "<input type='hidden' name='subject' value='".$subject."' />";
			 	  sibson_form_nonce('confirm_assessment_form');

echo "<dl class='post_list'>";
			foreach ($resultsArray as $key =>$result){ //start loop.
			
								if (!empty($result['results'])){ //start if
								$adjustedValue = $key+1;
								echo "<dt class='post'> ";
									echo "<span class='post_author tk-head'><a href='#' >";
											   echo  trim ( $result['name'], "'" ) ;                                
									 echo "</a></span></dt>";
										echo "<dd class='post format_text tk-body'><p>" ;
										echo "The children listed below are working at ".trim ( $result['name'], "'" ).".";
										$assessment->standardStatement( $yearGroup, $adjustedValue, 'they', 'they', true);
										echo "</p>";
											foreach ($result['results'] as $id){ //start subloop.
												$person = new Person($id);
												$person ->showBadge();
										echo   '<input type="hidden" name="confirm-'.$id.'" id="confim-'.$id.'" value="'.$adjustedValue.'"  />';
											}	// end subloop.								
							echo "<div class='spacer'></div>";								    
					  echo "</dd>"; 	
															
					
				}// end if.
	

			} //end loop.
echo "</dl>";

echo "</form>";


	
	
}

function sibson_submit_spreadsheet_data($post, $get, $page){
	
	
	check_admin_referer('sibson_spreadsheet_form');
	check_access_rights();
	global $wpdb;
	
	// Find out what the current assessment cycle is.
	$cycle = sibson_get_current_cycle();
	$thisCycle = $cycle[0]['currentId'];
	
	
	$update ='OTJ';
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');

	
	foreach($post as $key=>$value) { //start loop.
	
			
			$split = explode("_", $key); // split the name into an array so that the person id can be extracted.
			if($split[0] == "cell"){ // start if.
				
			$person_id = $split[1]; // Set the person id.
			
			$person= new Person ($person_id);
			
			$subject = $split[2];
			$adjustedValue = sibson_get_value_from_string($subject, $value);
			
	  // Check to see if a value already exists for this person and this cycle.

	
				 $check = $wpdb->get_row($wpdb->prepare("SELECT ID, assessment_value from wp_assessment_data where person_id = %d and cycle = $thisCycle and assessment_subject= %s and area ='OTJ'", $person_id, $subject ));
				
				// If it does then update it.
	
				if ($check){
						
						$existingValue = $check->assessment_value;
						$ID = $check->ID;
						if ($existingValue == $adjustedValue){
							
						//	Do nothing if the current assessment data is the same as the newly added one.
							
						}
						
				// If is different then update the db with the new value.
						
						else {
							 $result = $wpdb->update( 'wp_assessment_data', array(  'assessment_value' => $adjustedValue), array('ID' => $ID));
							
							if ($result == 1){
										 $insertData ="assessment_value: $adjustedValue and ID = $ID";
										 
									$log = new changeLog();
										$data = array(
										'table'=> 'wp_assessment_data',
										'oldvalue' => $existingValue,
										'newvalue' => $insertData,
										'name'=> $person->returnName()
										);
										$log->insertLog($data);
										}
						}
						
					}
					
				// If no data exists for this person and cycle then insert it.	
					else {
					
					$insertData = array( 'person_id' => $person_id, 'assessment_subject' => $subject, 'assessment_value' => $adjustedValue, 'cycle'=> $thisCycle,'user_id'=> $user, 'date'=> $current_Date, 'area' => $update );	
					 $result = $wpdb->insert( 'wp_assessment_data',$insertData);
					$logData = "'person_id' => $person_id, 'assessment_subject' => $subject, 'assessment_value' => $adjustedValue, 'cycle'=> $thisCycle,'user_id'=> $user, 'date'=> $current_Date, 'area' => $update";
					if ($result == 1){
							$log = new changeLog();
							$data = array(
							'table'=> 'wp_assessment_data',
							'oldvalue' => 0,
							'newvalue' => $logData,
							'name'=> $person->returnName()
							);
							$log->insertLog($data);
						}
					}
			
			
			
			}// end if.
	

}


	$group = new Group(absint($get['accessId']));
	
	$group->showContent($get['referrer']);
	
}

function sibson_submit_group_slider_confirm($post, $get, $page){
	

	check_admin_referer('sibson_confirm_assessment_form');
	check_access_rights();
	global $wpdb;
	
	// Find out what the current assessment cycle is.
	$cycle = sibson_get_current_cycle();
	$thisCycle = $cycle[0]['currentId'];
	
	$subject = $post['subject'];
	$update ='OTJ';
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');

	
	foreach($post as $key=>$value) { //start loop.
	
			
			$split = explode("-", $key); // split the name into an array so that the person id can be extracted.
			
			
			if($split[0] == "confirm"){ // start if.
				
			$person_id = $split[1]; // Set the person id.
			$person= new Person ($person_id);
			
			$adjustedValue =  $value;
			
	
			// Check to see if a value already exists for this person and this cycle.
			
			
				  
			 $check = $wpdb->get_row($wpdb->prepare("SELECT ID, assessment_value from wp_assessment_data where person_id = %d and cycle = $thisCycle and assessment_subject= %s and area ='OTJ'", $person_id, $subject));
			
			// If it does then update it.
			
						if ($check){
								
								$existingValue = $check->assessment_value;
								$ID = $check->ID;
								if ($existingValue == $adjustedValue){
									
								//	Do nothing if the current assessment data is the same as the newly added one.
									
								}
								
						// If is different then update the db with the new value.
								
								else {
									 $result = $wpdb->update( 'wp_assessment_data', array(  'assessment_value' => $adjustedValue), array('ID' => $ID));
								
							if ($result == 1){
										 $insertData ="assessment_value: $adjustedValue and ID = $ID";
										 
									$log = new changeLog();
										$data = array(
										'table'=> 'wp_assessment_data',
										'oldvalue' => $existingValue,
										'newvalue' => $insertData,
										'name'=> $person->returnName()
										);
										$log->insertLog($data);
										}
								}
								
							}
							
			// If no data exists for this person and cycle then insert it.	
				else {
				
				$insertData = array( 'person_id' => $person_id, 'assessment_subject' => $subject, 'assessment_value' => $adjustedValue, 'cycle'=> $thisCycle,'user_id'=> $user, 'date'=> $current_Date, 'area' => $update );	
					 $result = $wpdb->insert( 'wp_assessment_data',$insertData);
					$logData = "'person_id' => $person_id, 'assessment_subject' => $subject, 'assessment_value' => $adjustedValue, 'cycle'=> $thisCycle,'user_id'=> $user, 'date'=> $current_Date, 'area' => $update";
					if ($result == 1){
							$log = new changeLog();
							$data = array(
							'table'=> 'wp_assessment_data',
							'oldvalue' => 0,
							'newvalue' => $logData,
							'name'=> $person->returnName()
							);
							$log->insertLog($data);
						}
					
				}
						
				unset($check); 
			}
}// end foreach

	$group = new Group(absint($get['accessId']));
	$group->showContent($subject);
	
}
 
function  sibson_copy_post($post, $get, $page){
	
	check_admin_referer('sibson_post_form');
	check_access_rights();
	$sibson_data = $post;
	
	$sibson_files = $files;

	$post_id = $post['existing_post_id']; // if the post already exists and this is an edit, then the existing post id will be higher than 0.
	
	$originalPost = get_post($post_id);
	
	$category = get_the_category($post_id);
									
	$current_user = wp_get_current_user();
	$userId = $current_user->ID;	
	$userdata = get_userdata( $userId );
	$user_level =$userdata->user_level;							
	
	$post_type = get_post_type($post_id);
	$slug = $category[0]->slug;

	$category = get_category_by_slug($slug); 
 	 $catId = $category->term_id;
	$post_author = $orginalPost->post_author;	
	$post_status = $originalPost->post_status;		
	$user_person_id = get_user_meta($userId, 'person_id', true);
	$user_person = new Person($user_person_id);


	$term_list = wp_get_post_terms($post_id, 'person_id', array("fields" => "all"));
												 foreach ($term_list as $p_id) {  
													$person_id =  $p_id->slug;
													$label = $p_id->name;
												}
	
	$originalPerson = new Person( $person_id );
		$orginalName = $originalPerson->returnFirstName();
		
	echo "<h2>Posts successfully copied</h2>";	
	echo "<dl class='post_list'>";	
			foreach($post as $key=>$value) { // start loop.
				
						$split = explode("_", $key); // split the name into an array so that the person id can be extracted.
							if($split[0] == "person"){
							
							$person_id = $split[1]; // Set the person id.
							$person = new Person ($person_id);
							$name = $person->returnFirstName();
							
							
				
				$string = replace_name($originalPost->post_content, $person, $orginalName);
			
			$title = $name." ".$person->returnLastName()."-".$post_type;									
			$postarr = array();
			$postarr['post_author'] = $post_author;
            $postarr['post_title'] = $title;
            $postarr['post_content'] =  $string;
			$postarr['tax_input'] =  array( 'person_id' => array( $person_id ) ) ;
			if ($catId){
			$postarr['post_category'] = array( $catId );
			}
			$postarr['post_type'] = $post_type;
			$postarr['post_status'] = $post_status;
		
		
		
			 $new_post_id = wp_insert_post($postarr);
		
									 if ($new_post_id > 0){
										 $oldPost = "Post copied from $orginalName.";
										 $logData ="New Post created for $post_type in the $catId category.";
												 
										$log = new changeLog();
											$data = array(
											'table'=> 'wp_posts',
											'oldvalue' => $oldPost,
											'newvalue' => $logData,
											'name'=> $person->returnName()
											);
											$log->insertLog($data);
										}
						sibson_display_post( $new_post_id, $user_level, $userId );
					
							
					
						}
	}	
	echo '</dl>';
	echo "<div class='spacer'>&nbsp;</div>";	
	
	
}


function sibson_submit_post($post,$files, $get, $page){
	
	
	check_admin_referer('sibson_post_form');
	check_access_rights();
	$sibson_data = $post;
	
	$sibson_files = $files;

	$post_type = $sibson_data['radio-comp'];
    $postcontent = $sibson_data['postcontent'];
	$person_id = $sibson_data['person_id'];

	$current_user = wp_get_current_user();
	$post_author = $current_user->ID;
	$post_date = $sibson_data['post_date'];
	
	$post_title  = $sibson_data['post_title'];
	
	$today = date('Y-m-d H:i:s');
 	$formated_date = date('Y-m-d H:i:s', strtotime($post_date));
	if ($formated_date > $today){
		$post_status = 'future';
	}
	else {
		$post_status = $sibson_data['radio-publish'];
	}
	
	$person = new Person($person_id);

	
	$cat= $sibson_data['radio-subject'];
	
	if ($post_title){
		$title=$post_title;
	}
	else {
		$title = $person->returnName()." - ".$cat;
	}
	$category = get_category_by_slug($cat); 
  	$catId = $category->term_id;
	
	$imgAllowed = 0;
	$result = Array(
		'image'=>"",
		'error'=>"",
		'success'=>"",
		'post'=>""
	);
	$success = False;
	$upload = False;
	
    if ( current_user_can('publish_posts') ) {
        if (array_key_exists('image',$sibson_files)) { 
            /* play with the image */
            switch (True) {
            case (1 < count($sibson_files['image']['name'])):
                // multiple file upload
                $result['image'] = "multiple";
                $file = $sibson_files['image'];
                for ( $i = 0; $i < count($file['tmp_name']); $i++ ){
                    if( ''!=$file['tmp_name'][$i] ){
                        $imgAllowed = (getimagesize($file['tmp_name'][$i])) ? True : (''==$file['name'][$i]);
                        if ($imgAllowed){
                            $upload[$i+1] = sibson_upload_image(array('name'=>$sibson_files["image"]["name"][$i], 'tmp_name'=>$sibson_files["image"]["tmp_name"][$i]));
		                    if (False === $upload[$i+1]){
		                        $result['error'] = __("There was an error uploading the image.",'sibson_domain');
		                    } else {
		                        $success[$i+1] = True;
		                    }
                        } else {
                            $result['error'] = __("Incorrect filetype. Only images (.gif, .png, .jpg, .jpeg) are allowed.",'sibson_domain');
                        }
                    }
                }
                break;
            case ((1 == count($sibson_files['image']['name'])) && ('' != $sibson_files['image']['name'][0]) ):
                // single file upload
                $file = $sibson_files['image'];
                $result['image'] = 'single';
                $imgAllowed = (getimagesize($file['tmp_name'][0])) ? True : (''==$file['name'][0]);
                if ($imgAllowed){
                    $upload[1] = sibson_upload_image( array( 'name'=>$file["name"][0], 'tmp_name'=>$file["tmp_name"][0] ) );
                   
                    if (False === $upload[1]){
                        $result['error'] = __("There was an error uploading the image.",'sibson_domain');
                    } else {
                        $success[1] = True;
                    }
                } else {
                    $result['error'] = __("Incorrect filetype. Only images (.gif, .png, .jpg, .jpeg) are allowed.",'sibson_domain');
                }
                break;
            default: 
                $result['image'] = 'none';
            }
        }
        if ( '' != $result['error'] ) return $result; // fail if the image upload failed.
        
       
        /* manipulate $sibson_data into proper post array */
        $has_content_things = ($title != '') && ($postcontent != '');
        if ( !current_user_can('publish_posts')) ;
        if ( $has_content_things ) {
            $content = $postcontent;

            if ( is_user_logged_in() ){
	            global $user_ID;
	            get_currentuserinfo();
	        }
            if (is_array($success)){
                foreach(array_keys($success) as $i){
                 $default_attr = array(
					
					'class'	=> "alignleft",
					
				);
				  $image_link =  wp_get_attachment_image_src( $upload[$i], 'large');
				  $img_tag = wp_get_attachment_image($upload[$i], 'medium', false, $default_attr);
				  $imageTag = "<a href='".$image_link[0]."' class='alignleft' data-ajax='false' >".$img_tag."</a>";
				  $fullcontent = $imageTag.$content;
				  $image_id = $upload[$i];
                }
            } 
          	else {
			
				$fullcontent = $content;
				
			}
		

            $postarr = array();
			$existingPost = $_POST['existing_post_id']; // if the post already exists and this is an edit, then the existing post id will be higher than 0.
				if ($existingPost >0){
					$postarr['ID'] = $existingPost; //Only set a post id if one already exists. That way the post will be updated instead of inserted.
					
				}
			
			  if ($post_type== "post"){
			// don't add a person_id tag to content which has a post type of post.
			
		}
		else if ($post_type =='teaching'){
		
			$term = sibson_fetch_indicator_term(  $sibson_data['indicator_id']);
		
		
				$postarr['tax_input'] =  array( 'indicator' => array( $term ) ) ;
				$title="Teaching Idea";
				
		}
		else {
			
			$postarr['tax_input'] =  array( 'person_id' => array( $person_id ) ) ;
		}
			if ($cat){
			$postarr['post_category'] = array( $catId );
			}
			
			$postarr['post_author'] = $post_author;
			if ($formated_date>0){
			$postarr['post_date'] = $formated_date;
			}
			$postarr['post_title'] = $title;
            $postarr['post_content'] =  $fullcontent;
			$postarr['post_type'] = $post_type;
			$postarr['post_status'] = $post_status;
		
		
		
			 $post_id = wp_insert_post($postarr);
			 						 if ($post_id > 0){
										 $oldPost = "New post";
										 $logData ="New Post created for $post_type in the $catId category.";
												 
										$log = new changeLog();
											$data = array(
											'table'=> 'wp_posts',
											'oldvalue' => $oldPost,
											'newvalue' => $logData,
											'name'=> $person->returnName()
											);
											$log->insertLog($data);
										}
		
				set_post_thumbnail( $post_id, $image_id );
				
			
			
				email_the_teachers( $fullcontent, $person_id);
				
				$referrer = sanitize_text_field($get['pageType']);
	
					$pageType = $referrer;
					if ($pageType == "home" || $pageType == "post"){
					$pageType = sanitize_text_field($_POST['indicator_type']);	
					}
				if ($pageType == "behaviour"){
					email_a_referral( $fullcontent, $person_id, $post);
				}
         
            
            if (0 == $post_id) {
                $result['error'] = __("Unable to insert post- unknown error.",'sibson_domain');
            } else {
                $result['success'] = __("Post added, please wait to return to the previous page.",'sibson_domain');
                $result['post'] = $post_id;
            }
        } else {
             $result['error'] = __("You've left a field empty. All fields are required",'sibson_domain');
        }
    }
	
	$referrer = sanitize_text_field($get['pageType']);
	
	$pageType = $referrer;
	if ($pageType == "home" || $pageType == "post"){
	$pageType = sanitize_text_field($_POST['indicator_type']);	
	}

if ( $sibson_data['is_group']=="true"){

$group = new Group ($person_id);
$group->showContent($pageType);	
	
}
else {
	$person->showContent($pageType);						
}
}

/** Upload documents 

**/

function sibson_upload_document($post,$files, $get, $page){
	
	
	check_admin_referer('sibson_post_form');
	check_access_rights();
	$sibson_data = $post;
	
	$sibson_files = $files;
	
	$document_name = $sibson_data['document_name'];
$document_desc = $sibson_data['document_desc'];

	
        if (array_key_exists('document',$sibson_files)) { 
   	
   		/* play with the image */
            switch (True) {
            case (1 < count($sibson_files['image']['name'])):
                // multiple file upload
                $result['document'] = "multiple";
                $file = $sibson_files['document'];
                for ( $i = 0; $i < count($file['tmp_name']); $i++ ){
                    if( ''!=$file['tmp_name'][$i] ){
                        $docAllowed = (filesize($file['tmp_name'][$i])) ? True : (''==$file['name'][$i]);
                        if ($docAllowed){
                            $upload[$i+1] = sibson_upload_doc(array('name'=>$sibson_files["document"]["name"][$i], 'tmp_name'=>$sibson_files["document"]["tmp_name"][$i]));
		                    if (False === $upload[$i+1]){
		                        $result['error'] = __("There was an error uploading the image.",'sibson_domain');
		                    } else {
		                        $success[$i+1] = True;
		                    }
                        } else {
                            $result['error'] = __("Incorrect filetype. Only pages documents or pdf files are allowed.",'sibson_domain');
                        }
                    }
                }
                break;
            case ((1 == count($sibson_files['document']['name'])) && ('' != $sibson_files['document']['name'][0]) ):
                // single file upload
                $file = $sibson_files['document'];
                $result['document'] = 'single';
                $docAllowed = (filesize($file['tmp_name'][0])) ? True : (''==$file['name'][0]);
                if ($docAllowed){
                    $upload[1] = sibson_upload_doc( array( 'name'=>$file["name"][0], 'tmp_name'=>$file["tmp_name"][0] ) );
                   
                    if (False === $upload[1]){
                        $result['error'] = __("There was an error uploading the document.",'sibson_domain');
                    } else {
                        $success[1] = True;
                    }
                } else {
                     $result['error'] = __("Incorrect filetype. Only pages documents or pdf files are allowed.",'sibson_domain');
                }
                break;
            default: 
                $result['document'] = 'none';
            }
        }
		
if  ( $upload[1] > 1){
	
	$link = wp_get_attachment_url( $upload[1]);
	
	
	$content =  "<a href='".$link."' data-role='button'  data-theme='b' data-inline='true' data-ajax='false'>";
	$extensionExplode = explode(".", $link);
	
		$content .= "Download this ".$extensionExplode[1]." document";
	
	
	$content .= "</a>";
	$content .= $document_desc;
	
	
            $postarr = array();
			

		
            $postarr['post_title'] = $document_name;
            $postarr['post_content'] =  $content;
		
			wp_insert_term($sibson_data['category'], 'category', array(
								'description' => $sibson_data['category'],
								'slug' => $sibson_data['category']
								));
			
			wp_insert_term($term , 'indicator', array(
								'description' => $term ,
								'slug' => $term 
								));
			
			
			
			$term = sibson_fetch_indicator_term(  $sibson_data['indicator_id']);
		
		
				$postarr['tax_input'] =  array( 'indicator' => array( $term ) ) ;
		
	
			$postarr['post_type'] ='teaching';
			$postarr['post_status'] = 'publish';
		
		
		
			 $post_id = wp_insert_post($postarr);
			 
			
			
 
}
else {
	
	echo "Sorry no go";
}
	
	$person_id = $post['person_id'];
	$person = new Person($person_id);
	
	$indicator= $sibson_data['indicator_id'];

	sibson_teaching_idea_page($indicator, $person_id);
	
	
}

function sibson_upload_doc($file){
    $file = wp_upload_bits( $file["name"], null, file_get_contents($file["tmp_name"]));
 
    if (false === $file['error']) {
        $wp_filetype = wp_check_filetype(basename($file['file']), null );
        $attachment = array(
         'post_mime_type' => $wp_filetype['type'],
         'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['file'])),
         'post_content' => '',
         'post_status' => 'inherit',
        );
        $attach_id = wp_insert_attachment( $attachment, $file['file'] );
        // you must first include the image.php file
        // for the function wp_generate_attachment_metadata() to work
        require(ABSPATH . "wp-admin" . '/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file['file'] );
        wp_update_attachment_metadata( $attach_id,  $attach_data );
        return $attach_id;
    } else {
        //TODO: er, error handling?
        return false;
    }
}

/**
 * Upload images
 */
function sibson_upload_image($image){
    $file = wp_upload_bits( $image["name"], null, file_get_contents($image["tmp_name"]));
 
    if (false === $file['error']) {
        $wp_filetype = wp_check_filetype(basename($file['file']), null );
        $attachment = array(
         'post_mime_type' => $wp_filetype['type'],
         'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['file'])),
         'post_content' => '',
         'post_status' => 'inherit',
        );
        $attach_id = wp_insert_attachment( $attachment, $file['file'] );
        // you must first include the image.php file
        // for the function wp_generate_attachment_metadata() to work
        require(ABSPATH . "wp-admin" . '/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file['file'] );
        wp_update_attachment_metadata( $attach_id,  $attach_data );
        return $attach_id;
    } else {
        //TODO: er, error handling?
        return false;
    }
}

function sibson_update_profile_image($post, $get, $person){
	
	check_admin_referer('sibson_profile_image_form');
	
	global $wpdb;
	$id = absint($get['accessId']);
	$attach_id = absint($get['imageId']);
	
	
		$meta_id= $wpdb->update( 'wp_peoplemeta', array('meta_value' => $attach_id), array( 'wp_person_id'=> $id, 'meta_key' => 'profile_image'));
					
					if ($meta_id == 0){
						$new_id= $wpdb->insert( 'wp_peoplemeta', array('meta_value' => $attach_id, 'wp_person_id'=> $id, 'meta_key' => 'profile_image'));
						
						 		 if ($new_id >0 ){
										 $oldPost = "Profile Picture Changed";
										 $logData = $attach_id;
												 
										$log = new changeLog();
											$data = array(
											'table'=> 'wp_peoplemeta',
											'oldvalue' => $oldPost,
											'newvalue' => $logData,
											'name'=> $person->returnName()
											);
											$log->insertLog($data);
										}
		
					}		 
										 echo "The profile picture has been updated.";
									
									
	
	
}


function sibson_update_register($post, $get, $page){
	
	check_admin_referer('sibson_roll_form');
	check_access_rights();
	$sibson_data = $post;
		
	global $wpdb;
	$current_user = wp_get_current_user();
	$user = $current_user->ID;				
					
	foreach($sibson_data as $key=>$value) {
	
	
	
		$split = explode("-", $key);
			if($split[0] == "radiochoice"){
					
				$person_id = $split[3];
				$dateId =  $split[2];
				$period = $split[1];
				
				 $result = $wpdb->insert( 'wp_attendance_register', array( 'person_id' => $person_id, 'dateId' => $dateId, 'time_period' => $period, 'code'=> $value,'user_id'=> $user ));
		
		}
	}
		

		$page->showContent('roll');
}

function sibson_create_a_new_group($post, $get, $page){
	
	
	check_admin_referer('sibson_post_form');
	
	check_access_rights();
	

switch ($post['year-group']){
	case 0;
	$team = 'New Entrants';
	$team_order = '1';
	break;
	case 1;
	$team = 'New Entrants';
	$team_order = '1';
	break;
	case 2;
	$team = 'Year 2';
	$team_order = '2';
	break;
	case 3;
	$team = 'Middle';
	$team_order = '3';
	break;
	case 4;
	$team = 'Middle';
	$team_order = '3';
	break;
	case 5;
	$team = 'Senior';
	$team_order = '4';
	break;
	case 6;
	$team = 'Senior';
	$team_order = '4';
	break;
	case 7;
		switch ($post['type-group']){
			case "esol";
			$team = 'ESOL';
			$team_order = '5';
			break;
			case "gates";
			$team = 'GATES';
			$team_order = '6';
			break;
			case "support";
			$team = 'Support';
			$team_order = '7';
			break;
		}
		
	break;
	
}
	
	$groupDetail = array(
	'user_id'=> $post['post_author'],
	'room'=> $post['radio-comp'],
	'year'=> date('Y'),
	'type'=> $post['type-group'],
	'group_name'=> esc_html($post['name']),
	 'team'=> $team,
	 'team_order'=> $team_order, 
	 'yearGroup'=> $post['year-group']
);
	
	
	$newGroup = sibson_create_a_group($groupDetail);
	
	echo $newGroup;
		
	
	foreach($post as $key=>$value) { // start loop.
				
						
						$split = explode("_", $key); // split the name into an array so that the person id can be extracted.
							if($split[0] == "person"){
							
							$person_id = $split[1]; // Set the person id.
					
						
						$resultsArray[]= $person_id;
						}
	}
	foreach ($resultsArray as $person){
		
		global $wpdb;
	$insert = $wpdb->insert( 'wp_group_relationships', array(  'wp_group_id' => $newGroup,  'wp_person_id'=>$person, 'vacated' =>0 ));	
	
	}
	$group = new Group ($newGroup);
	
	$group -> showDetail();
}



function sibson_edit_a_new_group($post, $get, $page){
	
	
	check_admin_referer('sibson_post_form');
	

switch ($post['year-group']){
	case 0;
	$team = 'New Entrants';
	$team_order = '1';
	break;
	case 1;
	$team = 'New Entrants';
	$team_order = '1';
	break;
	case 2;
	$team = 'Year 2';
	$team_order = '2';
	break;
	case 3;
	$team = 'Middle';
	$team_order = '3';
	break;
	case 4;
	$team = 'Middle';
	$team_order = '3';
	break;
	case 5;
	$team = 'Senior';
	$team_order = '4';
	break;
	case 6;
	$team = 'Senior';
	$team_order = '4';
	break;
	case 7;
		switch ($post['type-group']){
			case "esol";
			$team = 'ESOL';
			$team_order = '5';
			break;
			case "gates";
			$team = 'GATES';
			$team_order = '6';
			break;
			case "support";
			$team = 'Support';
			$team_order = '7';
			break;
		}
		
	break;
	
}

if ($post['existing_post_id']){
	
$existingGroup = new Group ($post['existing_post_id']);
if ($existingGroup->groupType=="Class"){
$type= "Class";	
	
}
else {
	
$type = $post['type-group'];	
}
}
else {
	$type = $post['type-group'];
}

		
	$editGroup = sibson_create_a_group( array(
	'group_id' =>$post['existing_post_id'],
	'user_id'=> $post['post_author'],
	'room'=> $post['radio-comp'],
	'year'=> date('Y'),
	'type'=> $type,
	'group_name'=> $post['name'],
	 'team'=> $team,
	 'team_order'=> $team_order, 
	 'yearGroup'=> $post['year-group']
));
		
			
	
	foreach($post as $key=>$value) { // start loop.
				
						
						$split = explode("_", $key); // split the name into an array so that the person id can be extracted.
							if($split[0] == "person"){
							
							$person_id = $split[1]; // Set the person id.
					
						
						$resultsArray[]= $person_id;
						}
	}
	global $wpdb;
	$clear = $wpdb->query("delete from wp_group_relationships where wp_group_id = $editGroup");
	
	foreach ($resultsArray as $person){
		
	$insert = $wpdb->insert( 'wp_group_relationships', array(  'wp_group_id' => $editGroup,  'wp_person_id'=>$person, 'vacated' =>0 ));	
	
	if ($insert ==1 ){
		
		$person = new Person($person);
		$name = $person->returnName();
		$group = $editGroup;
										 $oldPost = "0";
										 $logData = "$name added to the Group named $group";
												 
										$log = new changeLog();
											$data = array(
											'table'=> 'wp_group_relationships',
											'oldvalue' => $oldPost,
											'newvalue' => $logData,
											'name'=> ''
											);
											$log->insertLog($data);
										}	
	
	}
	$group = new Group ($editGroup);
	
	if (!$post['existing_post_id']){
	echo "<h2>Group created.</h2>";
	}
	else {
		echo "<h2>Group updated.</h2>";
	}
	$group -> showDetail();
}


 function sibson_staff_audit($post, $get, $object){
	 
	check_admin_referer('sibson_staff_audit');
	 
	 $personId = $post['personId'];
	 $assessmentSubject = $post['assessment_subject'];

	
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');	
	
	global $wpdb;

	foreach($post as $key=>$value) { //start loop.
	
			
			$split = explode("-", $key); // split the name into an array so that the person id can be extracted.
			if($split[0] == "radio"){ // start if.
				
			$Id = $split[2];
			$update = $value;
			}// end if.

$check =$wpdb->get_var("select ID from  wp_assessment_data where person_id= $personId and assessment_value = $Id");

if ($check){
	
	$result = $wpdb->update( 'wp_assessment_data', array('assessment_subject' => $assessmentSubject, 'user_id'=> $user, 'date'=> $current_Date, 'area' => $update ), array('ID' => $check) );
	
}
else {

	$result = $wpdb->insert( 'wp_assessment_data', array( 'person_id' => $personId, 'assessment_subject' => $assessmentSubject, 'assessment_value' => $Id, 'user_id'=> $user, 'date'=> $current_Date, 'area' => $update ));
}
	}

	$object->showContent(sanitize_text_field($get['pageType'])); 
	 
 }
 
 function sibson_observation($post, $get, $object){
	 
	check_admin_referer('sibson_observation');
	 
	 $personId = $post['personId'];
	 $assessmentSubject = "classroom_observation";

	
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');
	
	
	global $wpdb;

	foreach($post as $key=>$value) { //start loop.
	
			
			$split = explode("-", $key); // split the name into an array so that the person id can be extracted.
			if($split[0] == "radio"){ // start if.
				
			$Id = $split[2];
			$update = $value;
			

			$result = $wpdb->insert( 'wp_assessment_data', array( 'person_id' => $personId, 'assessment_subject' => $assessmentSubject, 'assessment_value' => $Id, 'user_id'=> $user, 'date'=> $current_Date, 'area' => $update ));
	
		}// end if.
	}
	$object->showContent(sanitize_text_field($get['pageType'])); 
	
	
 }
 
 function sibson_goal_setting($post, $get, $object){
	 
	check_admin_referer('sibson_goal_setting');
	 
	 $personId = $post['personId'];
	 $assessmentSubject = $post['assessment_subject']."desc";

	
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');
	
	
	$cycleArray = sibson_get_current_cycle();
	$cycle =  $cycleArray[0]['currentId'];	
	
	global $wpdb;

	foreach($post as $key=>$value) { //start loop.
	
			
			$split = explode("-", $key); // split the name into an array so that the person id can be extracted.
			if($split[0] == "radio"){ // start if.
				
			$Id = $split[2];
			$update = $value;
			}// end if.

$check =$wpdb->get_var($wpdb->prepare("select ID from  wp_assessment_data where person_id= $personId and assessment_value = %d", $Id));

if ($check){
	
	$result = $wpdb->update( 'wp_assessment_data', array('assessment_subject' => $assessmentSubject, 'user_id'=> $user, 'date'=> $current_Date, 'area' => $update, 'cycle' =>$cycle ), array('ID' => $check) );
	
}
else {

	$result = $wpdb->insert( 'wp_assessment_data', array( 'person_id' => $personId, 'assessment_subject' => $assessmentSubject, 'assessment_value' => $Id, 'user_id'=> $user, 'date'=> $current_Date, 'area' => $update, 'cycle' =>$cycle ));
}
	}

	$object->showContent(sanitize_text_field($get['pageType'])); 
	
	 
 }
 
 function sibson_new_assessment($post, $get, $page){
	 
	 check_admin_referer('sibson_post_form');
	
	$sibson_data = $post;
	global $wpdb;
	$current_user = wp_get_current_user();
	$user = $current_user->ID;
	$current_Date = date('Y-m-d H:i:s');
	
	// Find out what the current assessment cycle is.
	$cycle = sibson_get_current_cycle();
	$thisCycle = $cycle[0]['currentId'];
	
	$subject = $sibson_data['subject'];
	$person_id = absint($sibson_data['person_id']);
	
	if($subject=="ESOL Listening" || $subject=="ESOL Speaking" || $subject=="ESOL Writing" || $subject=="ESOL Reading"){
		
		foreach($post as $key=>$value) { //start loop.
	
			$split = explode("-", $key); // split the name into an array so that the person id can be extracted.
			if($split[0] == "radio"){ // start if.
				
			$Id = $split[1];
			$result = $wpdb->insert( 'wp_assessment_data', array( 'person_id' => $person_id, 'assessment_subject' => $subject, 'assessment_value' => $Id, 'user_id'=> $user, 'date'=> $current_Date, 'area' => $value, 'cycle' =>'' ));	
			}// end if.
		
		}
		
		
	}
	else if($subject=="6 year net" || $subject=="5 year net"){
		
		foreach($post as $key=>$value) { //start loop.
	
			
			$split = explode("-", $key); // split the name into an array so that the person id can be extracted.
			if($split[0] == "radio"){ // start if.
				
			$Id = $split[1];
			$result = $wpdb->insert( 'wp_assessment_data', array( 'person_id' => $person_id, 'assessment_subject' => $subject, 'assessment_value' => $Id, 'user_id'=> $user, 'date'=> $current_Date, 'area' => $value, 'cycle' =>'' ));	
			}// end if.
		
		}
		
		
	}
	else {
	
	$value = $sibson_data['slider']+1;
	$update ='OTJ';
	
	
	
// Check to see if a value already exists for this person and this cycle.
	  
	 $check = $wpdb->get_row($wpdb->prepare("SELECT ID, assessment_value from wp_assessment_data where person_id = %d and cycle = $thisCycle and assessment_subject= %s", $person_id, $subject));

// If it does then update it.
	
	
	if ($check){
		
		$existingValue = $check->assessment_value;
		$ID = $check->ID;
		if ($existingValue == $value){
			
			//Do nothing if the current assessment data is the same as the newly added one.
			
		}
		
// If is different then update the db with the new value.
		
		else {
			 $result = $wpdb->update( 'wp_assessment_data', array(  'assessment_value' => $value), array('ID' => $ID));
		}
		
	}
	
// If no data exists for this person and cycle then insert it.	
	else {
	 $result = $wpdb->insert( 'wp_assessment_data', array( 'person_id' => $person_id, 'assessment_subject' => $subject, 'assessment_value' => $value, 'cycle'=> $thisCycle,'user_id'=> $user, 'date'=> $current_Date, 'area' => $update ));
	}
	}
	$person = new Person($person_id);
	
	
	$person->showContent('assessments');
								
	 
 }


function sibson_send_mail($post, $get, $object){
	
	check_admin_referer('sibson_send_email');
	
	$message = esc_html($post['postcontent']);
	
	$group = new Group(absint($post['group_id']));
	
	
	
$list = explode(",", $post['email_list']);	

foreach ($list as $key => $l){
	
	is_email($i);
	
	if ($key == 0){
		$confirmedList .= $l;
	}
	else {
		$confirmedList .= ",".$l;
	}
	
	
}

$to =  returnPrincipalEmail();


$subject = esc_html($post['subject']);


// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

// More headers
global $current_user;
      get_currentuserinfo();

$headers .= 'From: <'.$current_user->user_email.'>' . "\r\n";
$headers .= "\r\nBcc: ".$confirmedList."\r\n\r\n";
$headers .= "\r\nX-Mailer: PHP/" . phpversion();

mail($to,$subject,$message,$headers);

page_header('confirm_email');
echo "<h3>Subject:</h3>";
echo '<p>';	
echo $subject;
echo '</p>';		
echo "<h3>Message:</h3>";
echo '<p>';		
echo $message;
echo '</p>';		


echo "<h3>An email has been sent to the following addresses:</h3>";
echo '<br/>';	

foreach ($list as $l){
is_email($l);
echo $l;
echo "</br>";	
	
}
	



}

function sibson_insert_update_person($post, $get, $object){
	
	check_admin_referer('sibson_enrolment_form');
	
	
	
	$person_id = $post['person_id'];
	
	$core_info = array('id' => $person_id,'first' => $post['first_name'], 'last' => $post['last_name'], 'gender' =>$post['radio-gender'], 'dob' => $post['dob']);
	
	sibson_update_person_core_info($core_info);
	
	
	
	foreach ($post as $key=> $data){
		
		
		if (in_array($key, array('person_id', '_wpnonce', 'first_name', '_wp_http_referer', 'last_name', 'dob', 'radio-gender', 'radio-living') )){
			
		}
		else {
		
		update_or_insert_people_meta($key, $data, $person_id);
		
	
		
		}
	}
	
	$person = new Person($person_id);
	$person->showContent('information');
	
}
	
	
function sibson_update_person_core_info($core_info){
	
	$id = $core_info['id'];
	$person = new Person($id);
	global $wpdb;
	
	if ($person->returnActualFirstName() != $core_info['first']){
		
		 $result = $wpdb->update( 'wp_people', array(  'first_name' => $core_info['first']), array('wp_person_id' => $id));
		  if ($result == 1){
			  $new = $core_info['first'];
										$old =$person->returnActualFirstName();
										$logData ="First Name changed to $new";
										 
									$log = new changeLog();
										$data = array(
										'table'=> 'wp_people',
										'oldvalue' => $old,
										'newvalue' => $logData,
										'name'=> $person->returnName()
										);
										$log->insertLog($data);
										}
	}
	if ($person->returnLastName() != $core_info['last']){
		
		 $result = $wpdb->update( 'wp_people', array(  'last_name' => $core_info['last']), array('wp_person_id' => $id));
		 if ($result == 1){
			  $new = $core_info['last'];
										$old =$person->returnLastName();
										$logData ="Last Name changed to $new";
										 
									$log = new changeLog();
										$data = array(
										'table'=> 'wp_people',
										'oldvalue' => $old,
										'newvalue' => $logData,
										'name'=> $person->returnName()
										);
										$log->insertLog($data);
										}
	}
	
	
$dob = $person->returnDOB(true);
$newdob = date('Y-m-d', strtotime($core_info['dob']));	
if ($dob != $newdob){
		
		 $result = $wpdb->update( 'wp_people', array(  'dob' => $newdob), array('wp_person_id' => $id));
		  if ($result == 1){
			
										$old = $dob;
										$logData ="Last Name changed to $newdob";
										 
									$log = new changeLog();
										$data = array(
										'table'=> 'wp_people',
										'oldvalue' => $old,
										'newvalue' => $logData,
										'name'=> $person->returnName()
										);
										$log->insertLog($data);
										}
	}
	
	if ($person->returnGender() != $core_info['gender']){
		
		 $result = $wpdb->update( 'wp_people', array(  'gender' =>$core_info['gender']), array('wp_person_id' => $id));
		  if ($result == 1){
			$new = $core_info['gender'];
										$old =$person->returnGender();
										$logData ="Gender changed to $new";
										 
									$log = new changeLog();
										$data = array(
										'table'=> 'wp_people',
										'oldvalue' => $old,
										'newvalue' => $logData,
										'name'=> $person->returnName()
										);
										$log->insertLog($data);
										}
	}
	
	
		
}

?>
