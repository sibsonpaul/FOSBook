<?php 
get_header();

if($_GET['accessId']){
	
	$accessId = $_GET['accessId'];
	}
	else {
	$accessId =0;	
	}

if($_GET['type']){
	
	$type = $_GET['type'];
	}
	else {
	$type = 'Person';	
	}

if($_GET['pageType']){
	
	$pageType = sanitize_text_field($_GET['pageType']);
	}
	else {
	$pageType = 'home';	
	}
	
if($_GET['fullscreen']){
	$fullscreen = "true";
	
}
$access = new LockandKey($accessId, $type, $pageType);
$classType = $access->fetchType();

$pageType = $access->fetchPageType();
$userLevel = $access->userLevel();
$person_access_level = $access->returnPageAccess();

$page = new $classType ($access->fetchId(), $person_access_level);
	?>
<div data-role="page" class="page" id="main">
 		      
<div data-role="content" >
		<div id="printTab">
           	<a href="javascript:window.print()" id="printButton"><img src="<?php  echo SIBSON_IMAGES;?>/printer.png" alt="print this page" id="print-button" /><span class="button_text">Print this page</span></a>
         </div>   
            <?php
			
		
			 $access->topMenu();
			 
			?>
		

				<div class="content-menu red">
                  		 <div id="sibson-homeheader">
									 	<span class="profileBadge tk-head">
                                         			<span  class="avatar">
													<?php $page->showImage('thumbnail');?></span>
                                                    
                                                   <span class="name"> <?php $page->showName();?>
                                           				</span>
                                        </span>
									
                         </div>
                         
                            <ul data-role="listview" data-inset="true" data-theme="b" class="tk-calluna">
	                 				 <?php $page->showLinks($pageType, $person_access_level);?>
                            </ul> 
              		 </div>
                  
                  
									<div id="logo">
                                    <img src="<?php  echo SIBSON_IMAGES;?>/FOS-logo.png" />
                                     </div>
                                         
                                    
                      <div class="<?php $class = ($fullscreen=="true" ?  "fullscreen-content" :  "main-content");
					  echo $class;?>">     
                                     <span class="print-only"> <?php $page->showName();?>
                                           				</span>
                                <?php 
									echo $access->fetchId;
										
										if ($_POST && $userLevel>7){
											require('lib/includes/form_submit.php');
												$formType = $_GET['formType'];
													switch ($formType){
														 case "new_post";
														 sibson_submit_post($_POST,$_FILES, $_GET, $page);
														 break;
														 case "reusePost";
														 sibson_copy_post($_POST, $_GET, $page); 
														 break;
														 case "new_document";
														 sibson_upload_document($_POST,$_FILES, $_GET, $page);
														 break;
														 case "slider";
														 sibson_submit_slider_assessment($_POST, $_GET, $page);
														 break;
														 case "groupSlider";
														 sibson_submit_group_slider_assessment($_POST, $_GET, $page);
														 break;
														 case "groupSliderConfirm";
														 sibson_submit_group_slider_confirm($_POST, $_GET, $page);
														 break;
														 case "groupSpreadsheet";
														 sibson_submit_spreadsheet_data($_POST, $_GET, $page);
														 break;
														 case "setProfileImage";
														 sibson_update_profile_image($_POST, $_GET, $page);
														 break;
														 case "rollForm";
														 sibson_update_register($_POST, $_GET, $page);
														 break;
														 case "new_group";
														 sibson_create_a_new_group($_POST, $_GET, $page); 
														 break;
														 case "edit_group";
														 sibson_edit_a_new_group($_POST, $_GET, $page); 
														 break;
														 case "staff_audit";
														 sibson_staff_audit($_POST, $_GET, $page); 
														 break;
														 case "observation";
														 sibson_observation($_POST, $_GET, $page); 
														 break;
														 case "goal_setting";
														 sibson_goal_setting($_POST, $_GET, $page); 
														 break;
														   case "new_assessment";
														 sibson_new_assessment($_POST, $_GET, $page); 
														 break;
														 case "send_email";
														 sibson_send_mail($_POST, $_GET, $page); 
														 break;
														 case "enrolment";
														 sibson_insert_update_person($_POST, $_GET, $page); 
														 break;
														 
														 
																				 
												}
												
											
											}
										else 
										{	
									
										$page->showContent($pageType);
 								
								} ?>
 <?php if ($print == true){?>

<?php }
else {?>	
           </div>    
          </div>  
         <div id="myfooter"> Designed by Paul Sibson --
Copyright Fendalton Open-air School 2012 </div>  

                    
</div>	


 <?php
			echo '<div  data-role="page" class="page" id="dialog" >';
			echo '<div data-role="header" data-theme="e"><h2 id="dialog_heading"></h2></div>';		  
		echo '<div data-role="content" id="dialog_content" >';
								  
						
			echo '</div>';
			echo '<div data-role="footer" data-theme="e"><h2></h2></div>';	
		echo '</div>';	;?>
 <?php }?>
<?php  get_footer();?>   
 
 
 
           


