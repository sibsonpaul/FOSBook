// 
jQuery(function($) {
	
$('#wpwrap').prepend($('#custom-nav-header'));
$('#wpwrap').prepend($('#custom-nav-sidebar'));
$('#wpwrap').prepend($('#profile'));
$('#wpwrap').prepend($('#navmenu'));

var person_id = jQuery('#sibson_person_field').val();
var post_type = jQuery('#post_type').val();
loadimage = '<img src="../wp-content/themes/september/style/images/loader-contact.gif" />';
$('.add-new-h2').attr('href', 'post-new.php?post_type='+post_type+'&person_id='+person_id);

$('a.'+post_type).addClass('menu-top').parent('li').addClass('menu-top').prepend('<div class="wp-menu-arrow"><div></div></div>');



// function to add text to a text box that appears/ disappears when focus / unfocus.

function watermark(id, watermarkText, watermarkColor, activeColor) {
	$(id).val(watermarkText).css('color', watermarkColor).focus( function() {
		if($(this).val() == watermarkText) {
			$(this).val('');
			$(this).css('color', activeColor);
		}
	}).blur( function() {
		if(!$(this).val()) {
			$(this).val(watermarkText).css('color', watermarkColor);
		}
	});	
}

watermark('#quickTitle', 'Add a title here...', '#ccc', '#000');
watermark('#quickContent', 'Type your quick post here...', '#ccc', '#000');


    
	jQuery(".open-form-dialog").live('click', function(event) {
        event.preventDefault();
      
	
		var theAction = jQuery(this).data('action');
		var theQuery = jQuery(this).data('query');
		if (theAction == "ajax_post"){
		var tagId = jQuery('#quickPostID').val();
			
				var postContent = jQuery('#quickContent').val(); 
				var CatId = "";
				var postId = "";
				var postType = jQuery('#quickPostType').val();
				
				savePostData(postContent, tagId, CatId, postId, postType);
		}
		else {
			 jQuery('#form_dialog').slideDown();
	
		jQuery.post(	ajaxurl,
						{
							action : theAction,
							query: theQuery
						}, 
						function( response ) {
							jQuery('#form_dialog').html(response);
									}
	
				)
		}

    });
	jQuery(".open-dialog").live('click', function(event) {
        event.preventDefault();
        $info.dialog('open');
			
		var theAction = 'ajax_show_post';
		var theId = jQuery(this).data('id');
	
		jQuery.post(	ajaxurl,
						{
							action : theAction,
							id: theId
						}, 
						function( response ) {
							jQuery('#dialog').html(response);
						
									}
	
				)

    });
	jQuery(".open-option-dialog").live('click', function(event) {
        event.preventDefault();
        $options.dialog('open');
			
		var theAction = jQuery(this).data('action');
	
		jQuery.post(	ajaxurl,
						{
							action : theAction,
							
						}, 
						function( response ) {
							jQuery('#option-dialog').html(response);
						
									}
	
				)

    });
	
	
	
	
	
	jQuery("#savePost").live('click', function(event) {
        event.preventDefault();
		//Check to see which people have been selected.
		$('input[type=checkbox]').each(function () {// for each checkbox on the page.
			if (this.checked){ // See if it is checked.
			 var thisClass = jQuery(this).attr('class');
			 if (thisClass == "chkbx"){
			  // See if it is the correct sort of checkbox
				var tagId = jQuery(this).attr('name'); 
				var postContent = jQuery('#quickContent').val(); 
				var CatId = "";
				var postId = "";
				var postType = jQuery('#quickPostType').val();
				
				savePostData(postContent, tagId, CatId, postId, postType);
				jQuery('#form_dialog').slideUp();
			 }
			}
			
		});

		
    });
	
		
	jQuery("#savePostRemote").live('click', function(event) {
        event.preventDefault();
		jQuery('#feedback').html('Saving post, please wait...');
		//Check to see which blogs have been selected.
		$('input[type=checkbox]').each(function () {// for each checkbox on the page.
			if (this.checked){ // See if it is checked.
			 var thisClass = jQuery(this).attr('class');
			 if (thisClass == "chkbx"){
			  // See if it is the correct sort of checkbox
				var remoteURL = jQuery(this).attr('name'); 
				var postContent = jQuery('#quickContent').val(); 
				var CatId = "";
				var postId = "";
				var postType = "post";
				var postTitle =jQuery('#quickTitle').val();
				
				saveRemotePostData(postContent, postTitle, remoteURL, CatId, postId, postType);
			 }
			}
			
		});

		
    });
	
			
	jQuery(".deletePost").live('click', function(event) {
        event.preventDefault();
		var postId = jQuery(this).data('id');
				RemovePostData(postId);
			 
				
    });
	
	
	
	
jQuery('#closeForm').live('click', function (){
	
	jQuery('#form_dialog').hide();
	
});
	

jQuery('.open-ajaxLink').live('click', function (){
	event.preventDefault();
	jQuery('#form_dialog').slideDown().html(loadimage);
	var id = jQuery(this).data('id');
	var selectable = jQuery(this).data('select');
	var theAction = 'ajax_get_selectable_list';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							theId : id,
							isSelectable : selectable
						}, 
						function( response ) {
							jQuery('#form_dialog').html('<p>Select the children who would like to add this post for (names and pronouns will be automatically replaced).</p>'+response+'<input type="button" value="Post" id="savePost" class="button-primary"/><input type="button" value="Cancel" id="closeForm" class="button-secondary"/><div id="feedback"></div>');
									}
	
				)

    });

jQuery('.ajaxLink').live('click', function (){
	event.preventDefault();
	jQuery('#form_dialog').html(loadimage);
	var id = jQuery(this).data('id');
	var selectable = jQuery(this).data('select');
	var theAction = 'ajax_get_selectable_list';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							theId : id,
							isSelectable : selectable
						}, 
						function( response ) {
							jQuery('#form_dialog').html('<p>Select the children who would like to add this post for (names and pronouns will be automatically replaced).</p>'+response+'<input type="button" value="Post" id="savePost" class="button-primary"/><input type="button" value="Cancel" id="closeForm" class="button-secondary"/><div id="feedback"></div>');
									}
	
				)

    });
	
jQuery('.pageAjaxLink').live('click', function (){
		jQuery('#students').html(loadimage);
	var id = jQuery(this).data('id');
	var selectable = jQuery(this).data('select');
	var theAction = 'ajax_get_selectable_list';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							theId : id,
							isSelectable : selectable
						}, 
						function( response ) {
							jQuery('#students').html(response);
									}
	
				)

    });	


jQuery('.selectBox').live("click", function (){
	
	 jQuery(this).find(':checkbox').attr('checked', !jQuery(this).find(':checkbox').attr('checked'));
	 
	 var currentClass = jQuery(this).hasClass('checked');
	 if (currentClass ==true){
		 jQuery(this).removeClass('checked'); 
	 }
	 else {
	 jQuery(this).addClass('checked');
	 }
})


jQuery('.loadIndicatorsButton').live("click", function(){
	var subject=jQuery(this).data('subject');
	jQuery('#custom_'+subject+'_stage_1_knowledge_widget > .inside').html(loadimage);
	jQuery('#custom_'+subject+'_stage_1_strategy_widget > .inside').html(loadimage);
	jQuery('#custom_'+subject+'_stage_2_knowledge_widget > .inside').html(loadimage);
	jQuery('#custom_'+subject+'_stage_2_strategy_widget > .inside').html(loadimage);
	
	var id=jQuery(this).data('id');
	var level=jQuery(this).data('level');
	var theAction = jQuery(this).data('action');
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							theId : id,
							theSubject : subject,
							theLevel: level, 
							theType:'knowledge'
						}, 
						function( response ) {
							jQuery('#custom_'+subject+'_stage_1_knowledge_widget > .inside').html(response);
									}
	
				)
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							theId : id,
							theSubject : subject,
							theLevel: level,
							theType:'strategy'
						}, 
						function( response ) {
							jQuery('#custom_'+subject+'_stage_1_strategy_widget > .inside').html(response);
									}
	
				)	
		jQuery.post(	ajaxurl,
						{
							action : theAction,
							theId : id,
							theSubject : subject,
							theLevel: level+1, 
							theType:'knowledge'
						}, 
						function( response ) {
							jQuery('#custom_'+subject+'_stage_2_knowledge_widget > .inside').html(response);
									}
	
				)
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							theId : id,
							theSubject : subject,
							theLevel: level+1,
							theType:'strategy'
						}, 
						function( response ) {
							jQuery('#custom_'+subject+'_stage_2_strategy_widget > .inside').html(response);
									}
	
				)					
	
})


jQuery('.loadGroupIndicator').live("click", function(){
	jQuery('#custom_maths_widget > .inside').html(loadimage);
	
	var subject=jQuery(this).data('subject');
	var id=jQuery(this).data('indicatorid');
	var group=jQuery(this).data('groupid');
	var theAction = jQuery(this).data('action');
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							theId : id,
							groupId:group
						}, 
						function( response ) {
							jQuery('#custom_'+subject+'_widget > .inside').html(response);
									}
	
				)
				
	
})

$('a.secure').live('click', function(){
	 event.preventDefault();
		$(this).removeClass('secure');
		$(this).addClass('developing');
		var thisLinkId = $(this).data('indicatorid'); 
		var checkBox = $(this).data('hiddenid'); 
		var newValue = 'developing';
		//Put some laoding or saving text here.
		$.post(
					
					ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'myajax_get_update_indicator',
				
						// other parameters can be added along with "action"
						
						Id : thisLinkId, 
						update: newValue
						
				
					},
					function( response ) {
						
						jQuery('#input-'+checkBox).attr('checked', false);
						jQuery('#check-'+thisLinkId).html(response);
					
					}
				);
		
		
		
		
		
		
	})
	
		$('a.developing').live('click', function(){
			 event.preventDefault();
		
		$(this).removeClass('developing');
		$(this).addClass('secure');
		var thisLinkId = $(this).data('indicatorid'); 
		var subject = $(this).data('subject');
			var checkBox = $(this).data('hiddenid'); 
		var person_id = $(this).data('personid'); 
		var newValue = 'secure';
		jQuery('#check-'+checkBox).html('<img src="../wp-content/themes/september/style/images/loader-contact.gif" />');	
		//Put some laoding or saving text here.
		$.post(
					
					ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'myajax_get_update_indicator',
				
						// other parameters can be added along with "action"
						
						Id : thisLinkId,
						personId: person_id, 
						update: newValue
						
				
					},
					function( response ) {
						jQuery('#input-'+checkBox).prop('checked', true);
					jQuery('#check-'+thisLinkId).html(response);
					}
				);
		
		
		
		$.post(
					
					ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'myajax_update_cycle_data',
				
						// other parameters can be added along with "action"
						
						Id : thisLinkId, 
						update: newValue,
						personId: person_id,
						Subject: subject
						
				
					},
					function( response ) {
						
			
					jQuery('#current_level_box').html(response);
					}
				);
		
		
	})
	
		$('.movingUp').live('click', function(){
			 event.preventDefault();
		
		$(this).removeClass('developing');
		$(this).addClass('secure');
		var thisLinkId = $(this).data('hiddenid'); 
		var thisDataId = $('#input-'+thisLinkId).val();	
		var person_id = $(this).data('personid'); 
		var newValue = 'secure';
		var subject= $(this).data('subject');
	
		//Put some laoding or saving text here.
		$.post(
					
					ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'myajax_get_update_indicator',
				
						// other parameters can be added along with "action"
						
						Id : thisDataId,
						personId: person_id, 
						update: newValue
						
				
					}, 
					function (response){
					jQuery('#input-'+thisLinkId).prop('checked', true);	
					jQuery('#check-'+thisLinkId).html(response);
					}
				);
		
		
		
		$.post(
					
					ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'myajax_update_cycle_data',
				
						// other parameters can be added along with "action"
						
						Id : thisLinkId, 
						update: newValue,
						personId: person_id,
						Subject: subject
						
				
					},
					function( response ) {
						
					
					}
				);
		
		
	})
	
		$('.notassessed').live('click', function(){
			 event.preventDefault();
		$(this).removeClass('notassessed');
						$(this).addClass('developing');
						$(this).addClass('movingUp');
		var newValue = 'developing';
		var thisLinkId = $(this).data('hiddenid'); 
		var thisDataId = $('#input-'+thisLinkId).val();	
		
		var personId = $(this).data('personid'); 
		var subject= $(this).data('subject');
		var assessment_subject= subject+'desc';
		//Put some laoding or saving text here.
		
	jQuery.post(
					
					ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'myajax_get_insert_indicator',
				
						// other parameters can be added along with "action"
						
						Id : thisDataId, 
						update: newValue,
						personId: personId,
						assessmentSubject: assessment_subject
						
				
					},
					function( response ) {
						jQuery('#input-'+thisLinkId).prop('checked', false);
						jQuery(this).parent('li').children('span.check').html(response);	
					
					}
				);
				
		
		
	})

	$('.extraInfoButton').live('click', function(){
		
		return false;
		
	})




	$('.commentButton').live('click', function(){
		var linkId = $(this).data('Id');
		$('#hiddenCommentForm_'+linkId).show();
		$('commentButton').removeClass('ui-btn-active');
		
	})
// Save the post data that has been collected from a form.

function savePostData(postContent, tagId, CatId, postId, postType){
		
jQuery.post(
	
	ajaxurl,
	{
		// here we declare the parameters to send along with the request
		// this means the following action hooks will be fired:
		// wp_ajax_myajax-submit
		action : 'myajax_insert_or_edit_post',

		// other parameters can be added along with "action"
	   content:postContent, 
	   id: tagId,
	   type: postType,
	   thePostId: postId,
	
	},
	function( response ) {
		
	jQuery('#latestposts >ul').prepend(response).slideDown('slow');
	
	}
);							  
}

function saveRemotePostData(postContent, postTitle, remoteURL, CatId, postId, postType){
		
jQuery.post(
	
	ajaxurl,
	{
		// here we declare the parameters to send along with the request
		// this means the following action hooks will be fired:
		// wp_ajax_myajax-submit
		action : 'myajax_insert_or_edit_post_remote',

		// other parameters can be added along with "action"
	  title:postTitle,
	   content:postContent, 
	   url: remoteURL,
	   type: postType,
	   thePostId: postId,
	
	},
	function( response ) {
		
	jQuery('#feedback').html(response);
	
	}
);							  
}

function loadPersonProfile(theId){
	var theAction = 'ajax_get_person_profile';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							id: theId
						}, 
						function( response ) {
							jQuery('#profile').html(response);
									}
	
				)
	
	
}
function loadPersonLatestPosts(theId, theSubject){
	
	var theAction = 'ajax_get_person_posts';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							id: theId,
							subject:theSubject
						}, 
						function( response ) {
							jQuery('#custom_latest_updates_widget >.inside').html(response);
									}
	
				)
}

function loadTeamList(theQuery){
	var theAction = 'ajax_get_nav_group_list';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							query: theQuery
						}, 
						function( response ) {
							jQuery('#students').html(response);
									}
	
				)
}
function loadTeamProfile(theQuery){
	var theAction = 'ajax_get_team_profile';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							query: theQuery
						}, 
						function( response ) {
							jQuery('#profile').html(response);
									}
	
				)
	
}




function loadGroupList(id, selectable){
	
	var theAction = 'ajax_get_selectable_list';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							theId : id,
							isSelectable : selectable
						}, 
						function( response ) {
							jQuery('#students').html(response);
									}
	
				)
				
	
}
function loadGroupProfile(theId){
	var theAction = 'ajax_get_group_profile';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							id: theId
						}, 
						function( response ) {
							jQuery('#profile').html(response);
									}
	
				)
	
}

function loadGroupLatestPosts(theId){
		var theAction = 'ajax_get_group_posts';
	jQuery.post(	ajaxurl,
						{
							action : theAction,
							id: theId
						}, 
						function( response ) {
							jQuery('#custom_latest_updates_widget >.inside').html(response);
									}
	
				)
	
}

function RemovePostData(postId){
	
	jQuery.post(	ajaxurl,
						{
							action : 'myajax_ajax_remove_post',
							id: postId
						}, 
						function( response ) {
							jQuery('#post_'+postId).slideUp();
									}
	
				)
	
}
/*********************
//* jQuery Multi Level CSS Menu #2- By Dynamic Drive: http://www.dynamicdrive.com/
//* Last update: Nov 7th, 08': Limit # of queued animations to minmize animation stuttering
//* Menu avaiable at DD CSS Library: http://www.dynamicdrive.com/style/
*********************/

//Update: April 12th, 10: Fixed compat issue with jquery 1.4x

//Specify full URL to down and right arrow images (23 is padding-right to add to top level LIs with drop downs):
var arrowimages={down:['downarrowclass', '../wp-content/themes/September/style/images/down.gif', 23], right:['../wp-content/themes/September/style/images/rightarrowclass', 'right.gif']}

var jqueryslidemenu={

animateduration: {over: 200, out: 100}, //duration of slide in/ out animation, in milliseconds

buildmenu:function(menuid, arrowsvar){
	jQuery(document).ready(function($){
		var $mainmenu=$("#"+menuid+">ul")
		var $headers=$mainmenu.find("ul").parent()
		$headers.each(function(i){
			var $curobj=$(this)
			var $subul=$(this).find('ul:eq(0)')
			this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$subul.outerWidth(), subulh:$subul.outerHeight()}
			this.istopheader=$curobj.parents("ul").length==1? true : false
			$subul.css({top:this.istopheader? this._dimensions.h+"px" : 0})
			$curobj.children("a:eq(0)").css(this.istopheader? {paddingRight: arrowsvar.down[2]} : {}).append(
				'<img src="'+ (this.istopheader? arrowsvar.down[1] : arrowsvar.right[1])
				+'" class="' + (this.istopheader? arrowsvar.down[0] : arrowsvar.right[0])
				+ '" style="border:0;" />'
			)
			$curobj.hover(
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					this._offsets={left:$(this).offset().left, top:$(this).offset().top}
					var menuleft=this.istopheader? 0 : this._dimensions.w
					menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft
					if ($targetul.queue().length<=1) //if 1 or less queued animations
						$targetul.css({left:menuleft+"px", width:this._dimensions.subulw+'px'}).slideDown(jqueryslidemenu.animateduration.over)
				},
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					$targetul.slideUp(jqueryslidemenu.animateduration.out)
				}
			) //end hover
			$curobj.click(function(){
				$(this).children("ul:eq(0)").hide()
			})
		}) //end $headers.each()
		$mainmenu.find("ul").css({display:'none', visibility:'visible'})
	}) //end document.ready
}
}

//build menu with ID="custom-nav-header" on page:
jqueryslidemenu.buildmenu("custom-nav-header", arrowimages)

})