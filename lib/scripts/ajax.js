// 
jQuery(function($) {
	var $info = jQuery("#form_dialog");
    $info.dialog({                   
        'dialogClass'   : 'wp-dialog', 
		'title' 		: 'Select Students',          
        'modal'         : true,
        'autoOpen'      : false, 
        'closeOnEscape' : true,  
		'width'			: 800,
		'height'		: 600,    
        'buttons'       : {
			"Save":function(){
				
				jQuery('#form_dialog input:checkbox').each( function() {
					if(this.checked){
						var tagId = jQuery(this).attr('name');
						var postContent = jQuery('#quickPostContent').val();
						var CatId = 3;
						var postId = 11;
						var postType = 'sparkle';
						 savePostData(postContent, tagId, CatId, postId, postType)
						
					}
				})
				jQuery(this).dialog('close');
				
			},
            "Cancel": function() {
                jQuery(this).dialog('close');
            }
			
        }
		
		
    });

    
	jQuery(".open-dialog").click(function(event) {
        event.preventDefault();
        $info.dialog('open');
		var theAction = jQuery(this).data('action');
		var theQuery = jQuery(this).data('query');
	
		jQuery.post(	ajaxurl,
						{
							action : theAction,
							query: theQuery
						}, 
						function( response ) {
							jQuery('#form_dialog').html(response);
									}
	
				)

    });
	
	jQuery(".open-nav-dialog").click(function(event) {
        event.preventDefault();
		jQuery('#students').html("Loading...");
		var theAction = jQuery(this).data('action');
		var theQuery = jQuery(this).data('query');
	
		jQuery.post(	ajaxurl,
						{
							action : theAction,
							query: theQuery
						}, 
						function( response ) {
							jQuery('#students').html(response);
									}
	
				)

    });
	

jQuery('.ajaxLink').live('click', function (){
	jQuery('#form_dialog').html("Loading...");
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
							jQuery('#form_dialog').html(response);
									}
	
				)

    });
	
jQuery('.pageAjaxLink').live('click', function (){
		jQuery('#students').html("Loading...");
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
jQuery('#publish_to_group').live('click', function(){
	
	var postContent = jQuery('#content').html();
	var tagId = 345;
	var CatId = 3;
	var postId = 11;
	var postType = 'sparkle';
	
	savePostData(postContent, tagId, CatId, postId, postType);
});



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
		
	jQuery('#feedback').html(response);
	
	}
);							  
}



})