<?php 
get_header();

$show ="false";

if($_GET['type']){
	
	$type = $_GET['type'];
	}
	else {
	$type = 'Person';	
	}

if($_GET['pageType']){
	
	$pageType = $_GET['pageType'];
	}
	else {
	$pageType = 'home';	
	}

if (have_posts()) : while (have_posts()) : the_post(); 
													  
		$post_id = get_the_ID();
		$post_type = get_post_type( $post_id );
		if ($post_type=="post"){
				$show = "true";
				if($_GET['accessId']){
			
					$accessId = $_GET['accessId'];
					}
					else {
					$accessId =0;	
					}												
		}
		else {
			
		$terms = wp_get_post_terms( $post_id, 'person_id' );
		
		$userId = $current_user->ID;
		$userdata = get_userdata( $userId );
		if ($userdata->user_level > 7){
		$accessId = $terms[0]->slug;
		}
		else {
			
		$accessId = salt_n_pepper($terms[0]->slug);	
		}
		}
														
	

$access = new LockandKey($accessId, $type, $pageType);
$secureId = $access->fetchId();

echo $person_access_level;
if ($secureId == $terms[0]->slug){
$show="true";	
}
$page = new $type ($access->fetchId());

if($_GET['print']){
	$print = "true";
	
}

?> 
<?php if (!$print == true){?>


<div  data-role="page" class="page"  id="main">
 		      
<div data-role="content" >
	<div id="printTab">
           	<a href="javascript:window.print()" id="printButton"><img src="<?php  echo SIBSON_IMAGES;?>/printer.png" alt="print this page" id="print-button" /><span class="button_text">Print this page</span></a>
         </div>  
           	
              <?php $access->topMenu();?>

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
                         <?php }?> 
                      <div class="main-content">   
                                    
								
                                	<?php	if ($show=="true"){		    
                                        
											echo "<h2 class='tk-head'>";
												$title= get_the_title();
												if(substr($title,0,6)=="staff-"){
													$teachingIdea = 'true';
												$tidyTitle =substr($title, 6);
												}
												else {
												$tidyTitle =$title;	
												}
												echo ucfirst($tidyTitle);
												echo "";
												 echo "</h2>";        
										 ?>
                            
                                                               
                                                                 
                                                                 
                                                     <?php 	
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
									 
										$buttons =	 sibson_post_buttons($user_level, $post_id, $author, $secureId, $user, $post_type);		

							if ($post_type=="post"){

										
										
										echo the_content();
										if ($teachingIdea==true){
										$dialogType = "teachingIdea";
											
										}
										else {
										$dialogType	='edit';
										}
							
		echo  '<a href="#dialog" data-rel="dialog"  data-icon="info"  data-id="'.$id.'"   data-dialogtype="'.$dialogType.'" data-title="Edit this Post" data-pagetype="'.$pageType.'" data-classtype="Person" data-postid="'.$post_id.'" class="loaddialog" data-role="button" data-theme="b" data-inline="true">Edit</a>';
		
		
							}
							else {
								
								
										$content[$post_id] = array(
										'id' => $post_id,
										'title'  => get_the_date(),
										'show_icon'=>$show_icon,
										'icon_image' => $category[0]->slug,
										'icon_name' =>$category[0]->name,
										'icon_desc' =>$category[0]->category_description,
										'the_content' => get_the_content(),
										'badge'=>$user_person->returnBadge(true, false),
										'classlist' => $classlist, 
										'status_message' => $status_message,
										'link' => get_permalink(),
										'buttons' => $buttons,
										);
										
											basic_display_template ($content[$post_id]);
										comments_template( '', true );
							}
							
											 
									
									}

									else { // else show is false.
												
													echo "Sorry you do not have access to this page.";	
														
										}
													
									
																	
                           endwhile; ?>
            
			

	<?php	endif; 
	
				
	
	

	?>
	
           </div>    
          </div>     

                    
</div>	


 <?php
			echo '<div  data-role="page" class="page" id="dialog" >';
			echo '<div data-role="header" data-theme="e"><h2 id="dialog_heading"></h2></div>';		  
		echo '<div data-role="content" id="dialog_content" >';
								  
						
			echo '</div>';
		echo '</div>';	;?>

  <?php  get_footer();?>   
 
 
 
           



 
           


