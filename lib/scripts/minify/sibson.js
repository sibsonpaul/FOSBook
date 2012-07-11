jQuery(document).ready(function(){
	
	try{Typekit.load();}catch(e){}
		
		
	var pageNonce = MyAjax.sibson_nonce_for_ajax;
	

jQuery(".loaddialog").live("click", function(){
	type = $(this).data('dialogtype');
	id = $(this).data('id');
	pagetype = $(this).data('pagetype');
	title = $(this).data('title');
	classtype = $(this).data('classtype');
	postid = $(this).data('postid');
	description=$(this).data('description');
	indicatortype = $(this).data('indicatortype');
	
	jQuery('#dialog_heading').html(title);
	jQuery('#dialog_content').html('Loading...');
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : 'ajax_fetch_dialog_content',
							theType: type,
							theId: id,
							thePageType: pagetype,
							theClassType: classtype,
							post_id: postid,
							Nonce: pageNonce,
							desc: description,
							indtype: indicatortype
						}, 
						function( response ) {
							jQuery('#dialog_content').html(response);
						
							$('#dialog_content a.button').buttonMarkup();
							
							$('#post_form').formToWizard();
							$('#post_form').trigger( "create" );
							$('#dialog_content').trigger( "create" );
							
							if ( $('#postcontent').length ){  // change the textarea into a wysiwyg editor. 
										jQuery('#postcontent').css("height","100%").css("width","100%").htmlbox({
																			idir: MyAjax.imageUrl+'/images/',
												  toolbars:[
													[
													// Cut, Copy, Paste
													"separator","cut","copy","paste",
													// Undo, Redo
													"separator","undo","redo",
													// Bold, Italic, Underline, Strikethrough, Sup, Sub
													"separator","bold","italic","underline",
													// Ordered List, Unordered List, Indent, Outdent
													"separator","ol","ul","indent","outdent",
													// Hyperlink, Remove Hyperlink, Image
		"separator","link","unlink"
													
													],
													[// Show code
		"separator","code",
        // Formats, Font size, Font family, Font color, Font, Background
        "separator","formats","fontsize","fontfamily",
		"separator","fontcolor","highlight",
		],
												],
												icons:"default",
												skin:"red"
											});
							}
							$('#image_upload').customFileInput();	
							if (type =="people"){
							$('#searchBox').textinput();
							$('#searchBox').suggest(MyAjax.ajaxurl+"?action=ajax_search_people&tax=person_id&Nonce="+pageNonce, {multiple:true, multipleSep: ","});
							}
							if (type =="groups"){
							$('#groupsearchBox').textinput();
							$('#groupsearchBox').suggest(MyAjax.ajaxurl+"?action=ajax_search_group&Nonce="+pageNonce, {multiple:true, multipleSep: ",", resultsId: 'groupBadgeList'});
							}
							if (type =="reuse" || type =="groupform"){
							$('#searchBoxSelectable').textinput();
							$('#searchBoxSelectable').suggest(MyAjax.ajaxurl+"?action=ajax_search_selectable&Nonce="+pageNonce, {multiple:true, multipleSep: ",", resultsId: 'selectableList'});
							}
						}
	
				)
	
	
});


jQuery('.cell').live('change', function(){

	var value = $(this).val();
	var subject = $(this).data("subject");	
	
	if (subject == "maths" || subject =="writing"){
			switch (value){
			case "1b":
			$(this).val("1 Basic");
			break
			case "1 b":
			$(this).val("1 Basic");
			break
			case "1B":
			$(this).val("1 Basic");
			break
			case "1 B":
			$(this).val("1 Basic");
			break
			case "1 Basic":
			$(this).val("1 Basic");
			break
			case "1p":
			$(this).val("1 Proficient");
			break
			case "1 p":
			$(this).val("1 Proficient");
			break
			case "1P":
			$(this).val("1 Proficient");
			break
			case "1 P":
			$(this).val("1 Proficient");
			break
			case "1 Proficient":
			$(this).val("1 Proficient");
			break
			case "1a":
			$(this).val("1 Advanced");
			break
			case "1 a":
			$(this).val("1 Advanced");
			break
			case "1A":
			$(this).val("1 Advanced");
			break
			case "1 A":
			$(this).val("1 Advanced");
			break
			case "1 Advanced":
			$(this).val("1 Advanced");
			break
			
			case "2b":
			$(this).val("2 Basic");
			break
			case "2 b":
			$(this).val("2 Basic");
			break
			case "2B":
			$(this).val("2 Basic");
			break
			case "2 B":
			$(this).val("2 Basic");
			break
			case "2 Basic":
			$(this).val("2 Basic");
			break
			case "2p":
			$(this).val("2 Proficient");
			break
			case "2 p":
			$(this).val("2 Proficient");
			break
			case "2P":
			$(this).val("2 Proficient");
			break
			case "2 P":
			$(this).val("2 Proficient");
			break
			case "2 Proficient":
			$(this).val("2 Proficient");
			break
			case "2a":
			$(this).val("2 Advanced");
			break
			case "2 a":
			$(this).val("2 Advanced");
			break
			case "2A":
			$(this).val("2 Advanced");
			break
			case "2 A":
			$(this).val("2 Advanced");
			break
			case "2 Advanced":
			$(this).val("2 Advanced");
			break
			
			case "3b":
			$(this).val("3 Basic");
			break
			case "3 b":
			$(this).val("3 Basic");
			break
			case "3B":
			$(this).val("3 Basic");
			break
			case "3 B":
			$(this).val("3 Basic");
			break
			case "3 Basic":
			$(this).val("3 Basic");
			break
			case "3p":
			$(this).val("3 Proficient");
			break
			case "3 p":
			$(this).val("3 Proficient");
			break
			case "3P":
			$(this).val("3 Proficient");
			break
			case "3 P":
			$(this).val("3 Proficient");
			break
			case "3 Proficient":
			$(this).val("3 Proficient");
			break
			case "3a":
			$(this).val("3 Advanced");
			break
			case "3 a":
			$(this).val("3 Advanced");
			break
			case "3A":
			$(this).val("3 Advanced");
			break
			case "3 A":
			$(this).val("3 Advanced");
			break
			case "3 Advanced":
			$(this).val("3 Advanced");
			break
			
			case "4b":
			$(this).val("4 Basic");
			break
			case "4 b":
			$(this).val("4 Basic");
			break
			case "4B":
			$(this).val("4 Basic");
			break
			case "4 B":
			$(this).val("4 Basic");
			break
			case "4 Basic":
			$(this).val("4 Basic");
			break
			case "4p":
			$(this).val("4 Proficient");
			break
			case "4 p":
			$(this).val("4 Proficient");
			break
			case "4P":
			$(this).val("4 Proficient");
			break
			case "4 P":
			$(this).val("4 Proficient");
			break
			case "4 Proficient":
			$(this).val("4 Proficient");
			break
			case "4a":
			$(this).val("4 Advanced");
			break
			case "4 a":
			$(this).val("4 Advanced");
			break
			case "4A":
			$(this).val("4 Advanced");
			break
			case "4 A":
			$(this).val("4 Advanced");
			break
			case "4 Advanced":
			$(this).val("4 Advanced");
			break
			
				case "5b":
			$(this).val("5 Basic");
			break
			case "5 b":
			$(this).val("5 Basic");
			break
			case "5B":
			$(this).val("5 Basic");
			break
			case "5 B":
			$(this).val("5 Basic");
			break
			case "5 Basic":
			$(this).val("5 Basic");
			break
			case "5p":
			$(this).val("5 Proficient");
			break
			case "5 p":
			$(this).val("5 Proficient");
			break
			case "5P":
			$(this).val("5 Proficient");
			break
			case "5 P":
			$(this).val("5 Proficient");
			break
			case "5 Proficient":
			$(this).val("5 Proficient");
			break
			case "5a":
			$(this).val("5 Advanced");
			break
			case "5 a":
			$(this).val("5 Advanced");
			break
			case "5A":
			$(this).val("5 Advanced");
			break
			case "5 A":
			$(this).val("5 Advanced");
			break
			case "5 Advanced":
			$(this).val("5 Advanced");
			break
			
			case "6b":
			$(this).val("6 Basic");
			break
			case "6 b":
			$(this).val("6 Basic");
			break
			case "6B":
			$(this).val("6 Basic");
			break
			case "6 B":
			$(this).val("6 Basic");
			break
			case "6 Basic":
			$(this).val("6 Basic");
			break
			case "6p":
			$(this).val("6 Proficient");
			break
			case "6 p":
			$(this).val("6 Proficient");
			break
			case "6P":
			$(this).val("6 Proficient");
			break
			case "6 P":
			$(this).val("6 Proficient");
			break
			case "6 Proficient":
			$(this).val("6 Proficient");
			break
			case "6a":
			$(this).val("6 Advanced");
			break
			case "6 a":
			$(this).val("6 Advanced");
			break
			case "6A":
			$(this).val("6 Advanced");
			break
			case "6 A":
			$(this).val("6 Advanced");
			break
			case "6 Advanced":
			$(this).val("6 Advanced");
			break
			
			case "7b":
			$(this).val("7 Basic");
			break
			case "7 b":
			$(this).val("7 Basic");
			break
			case "7B":
			$(this).val("7 Basic");
			break
			case "7 B":
			$(this).val("7 Basic");
			break
			case "7 Basic":
			$(this).val("7 Basic");
			break
			case "7p":
			$(this).val("7 Proficient");
			break
			case "7 p":
			$(this).val("7 Proficient");
			break
			case "7P":
			$(this).val("7 Proficient");
			break
			case "7 P":
			$(this).val("7 Proficient");
			break
			case "7 Proficient":
			$(this).val("7 Proficient");
			break
			case "7a":
			$(this).val("7 Advanced");
			break
			case "7 a":
			$(this).val("7 Advanced");
			break
			case "7A":
			$(this).val("7 Advanced");
			break
			case "7 A":
			$(this).val("7 Advanced");
			break
			case "7 Advanced":
			$(this).val("7 Advanced");
			break
			
			case "8b":
			$(this).val("8 Basic");
			break
			case "8 b":
			$(this).val("8 Basic");
			break
			case "8B":
			$(this).val("8 Basic");
			break
			case "8 B":
			$(this).val("8 Basic");
			break
			case "8 Basic":
			$(this).val("8 Basic");
			break
			case "8p":
			$(this).val("8 Proficient");
			break
			case "8 p":
			$(this).val("8 Proficient");
			break
			case "8P":
			$(this).val("8 Proficient");
			break
			case "8 P":
			$(this).val("8 Proficient");
			break
			case "8 Proficient":
			$(this).val("8 Proficient");
			break
			case "8a":
			$(this).val("8 Advanced");
			break
			case "8 a":
			$(this).val("8 Advanced");
			break
			case "8A":
			$(this).val("8 Advanced");
			break
			case "8 A":
			$(this).val("8 Advanced");
			break
			case "8 Advanced":
			$(this).val("8 Advanced");
			break
			

		
		default:
		$(this).val("Sorry, that is not a valid input"); 
		
		}
	}
	else if (subject == "reading"){
	
	switch (value){
		
			case "Magenta":
			$(this).val("Magenta");
			break
			case "magenta":
			$(this).val("Magenta");
			break
			case "m":
			$(this).val("Magenta");
			break
			case "M":
			$(this).val("Magenta");
			break
			
			case "Red":
			$(this).val("Red");
			break
			case "red":
			$(this).val("Red");
			break
			case "r":
			$(this).val("Red");
			break
			case "R":
			$(this).val("Red");
			break
			
			case "Yellow":
			$(this).val("Yellow");
			break
			case "yellow":
			$(this).val("Yellow");
			break
			case "y":
			$(this).val("Yellow");
			break
			case "Y":
			$(this).val("Yellow");
			break
			
			case "Dark Blue":
			$(this).val("Dark Blue");
			break
			case "Dark blue":
			$(this).val("Dark Blue");
			break
			case "dark blue":
			$(this).val("Dark Blue");
			break
			case "db":
			$(this).val("Dark Blue");
			break
			case "Db":
			$(this).val("Dark Blue");
			break
			case "DB":
			$(this).val("Dark Blue");
			break
			case "Dk Blue":
			$(this).val("Dark Blue");
			break
			case "dk blue":
			$(this).val("Dark Blue");
			break
			
			case "Green":
			$(this).val("Green");
			break
			case "green":
			$(this).val("Green");
			break
			case "g":
			$(this).val("Green");
			break
			case "G":
			$(this).val("Green");
			break
			
			case "Light Blue":
			$(this).val("Light Blue");
			break
			case "light blue":
			$(this).val("Light Blue");
			break
			case "Light blue":
			$(this).val("Light Blue");
			break
			case "lb":
			$(this).val("Light Blue");
			break
			case "Lb":
			$(this).val("Light Blue");
			break
			case "LB":
			$(this).val("Light Blue");
			break
			case "L Blue":
			$(this).val("Light Blue");
			break
			case "l blue":
			$(this).val("Light Blue");
			break
			case "Turquoise":
			$(this).val("Light Blue");
			break
			case "turquoise":
			$(this).val("Light Blue");
			break
			
			case "Purple":
			$(this).val("Purple");
			break
			case "purple":
			$(this).val("Purple");
			break
			case "p":
			$(this).val("Purple");
			break
			case "P":
			$(this).val("Purple");
			break
			
			case "Gold":
			$(this).val("Gold");
			break
			case "gold":
			$(this).val("Gold");
			break
			case "gl":
			$(this).val("Gold");
			break
			case "GL":
			$(this).val("Gold");
			break
			
			case "2b":
			$(this).val("2 Basic");
			break
			case "2 b":
			$(this).val("2 Basic");
			break
			case "2B":
			$(this).val("2 Basic");
			break
			case "2 B":
			$(this).val("2 Basic");
			break
			case "2 Basic":
			$(this).val("2 Basic");
			break
			case "2p":
			$(this).val("2 Proficient");
			break
			case "2 p":
			$(this).val("2 Proficient");
			break
			case "2P":
			$(this).val("2 Proficient");
			break
			case "2 P":
			$(this).val("2 Proficient");
			break
			case "2 Proficient":
			$(this).val("2 Proficient");
			break
			case "2a":
			$(this).val("2 Advanced");
			break
			case "2 a":
			$(this).val("2 Advanced");
			break
			case "2A":
			$(this).val("2 Advanced");
			break
			case "2 A":
			$(this).val("2 Advanced");
			break
			case "2 Advanced":
			$(this).val("2 Advanced");
			break
			
			case "3b":
			$(this).val("3 Basic");
			break
			case "3 b":
			$(this).val("3 Basic");
			break
			case "3B":
			$(this).val("3 Basic");
			break
			case "3 B":
			$(this).val("3 Basic");
			break
			case "3 Basic":
			$(this).val("3 Basic");
			break
			case "3p":
			$(this).val("3 Proficient");
			break
			case "3 p":
			$(this).val("3 Proficient");
			break
			case "3P":
			$(this).val("3 Proficient");
			break
			case "3 P":
			$(this).val("3 Proficient");
			break
			case "3 Proficient":
			$(this).val("3 Proficient");
			break
			case "3a":
			$(this).val("3 Advanced");
			break
			case "3 a":
			$(this).val("3 Advanced");
			break
			case "3A":
			$(this).val("3 Advanced");
			break
			case "3 A":
			$(this).val("3 Advanced");
			break
			case "3 Advanced":
			$(this).val("3 Advanced");
			break
			
			case "4b":
			$(this).val("4 Basic");
			break
			case "4 b":
			$(this).val("4 Basic");
			break
			case "4B":
			$(this).val("4 Basic");
			break
			case "4 B":
			$(this).val("4 Basic");
			break
			case "4 Basic":
			$(this).val("4 Basic");
			break
			case "4p":
			$(this).val("4 Proficient");
			break
			case "4 p":
			$(this).val("4 Proficient");
			break
			case "4P":
			$(this).val("4 Proficient");
			break
			case "4 P":
			$(this).val("4 Proficient");
			break
			case "4 Proficient":
			$(this).val("4 Proficient");
			break
			case "4a":
			$(this).val("4 Advanced");
			break
			case "4 a":
			$(this).val("4 Advanced");
			break
			case "4A":
			$(this).val("4 Advanced");
			break
			case "4 A":
			$(this).val("4 Advanced");
			break
			case "4 Advanced":
			$(this).val("4 Advanced");
			break
			
				case "5b":
			$(this).val("5 Basic");
			break
			case "5 b":
			$(this).val("5 Basic");
			break
			case "5B":
			$(this).val("5 Basic");
			break
			case "5 B":
			$(this).val("5 Basic");
			break
			case "5 Basic":
			$(this).val("5 Basic");
			break
			case "5p":
			$(this).val("5 Proficient");
			break
			case "5 p":
			$(this).val("5 Proficient");
			break
			case "5P":
			$(this).val("5 Proficient");
			;break
			case "5 P":
			$(this).val("5 Proficient");
			break
			case "5 Proficient":
			$(this).val("5 Proficient");
			break
			case "5a":
			$(this).val("5 Advanced");
			break
			case "5 a":
			$(this).val("5 Advanced");
			break
			case "5A":
			$(this).val("5 Advanced");
			break
			case "5 A":
			$(this).val("5 Advanced");
			break
			case "5 Advanced":
			$(this).val("5 Advanced");
			break
			default : 
			$(this).val("Sorry, that is not a valid input"); 
	}
	
}

})


jQuery('li.filter').live('click', function(){
	
	$('dt').hide();
	$('dd').hide();
	type = $(this).data('type');
	$('dt.'+type).show();
	$('dd.'+type).show();
	
	
});
	
jQuery('#above_key').css('width', jQuery('.reading_theme_e').size()+'%');


	
jQuery(".main-content > .badge").live("click", function(){
	theId = $(this).data('id');
	name =  $(this).data('name');
	jQuery('#dialog_heading').html(name);
	jQuery('#dialog_content').html('Loading...');
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : 'ajax_fetch_child_detail',
							Id: theId,
							Nonce: pageNonce
						}, 
						function( response ) {
							jQuery('#dialog_content').html(response);
							
							
					
									}
	
				)
	
	
});

jQuery(".selectable").live("click", function(){
	
	id = $(this).data('personid');
	name = $(this).data('name');
	
	checkbox_id = $('#check_'+id);
	label_id = $('#label_'+id);
	if (checkbox_id.length){
	checkbox_id.remove();
	label_id.remove();
	
	}
	else {
	
		checkboxLi =  '<span id="label_'+id+'">'+name+'</span><input type="checkbox" class="hidden_checkbox" id="check_'+id+'" name="person_'+id+'" checked="checked" />';
		$('#hiddenCheckboxes').append(checkboxLi);
	}
	if ($(this).hasClass('d')){
		  $(this).removeClass('d');
	}
	else {
	  $(this).addClass('d');	
	}
	 
	
	
});



jQuery(".indicator_group_detail").live("click", function(){
	theId = $(this).data('id');
	theIndicatorId =  $(this).data('indicatorid');
	
	jQuery('#dialog_content').html('Loading...');
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : 'ajax_fetch_group_show_children_by_indicator',
							Id: theId, 
							indicatorid: theIndicatorId,
							Nonce: pageNonce
						}, 
						function( response ) {
							jQuery('#dialog_content').html(response);
							
							
					
									}
	
				)
	
	
});
	
jQuery(".highlight").live('click', function() {
       $(this).removeClass('ui-btn-up-d');
	$('.highlight').removeClass('ui-btn-up-f');
	$(this).addClass('ui-btn-up-f');
		var searchType = jQuery(this).attr('id');
		jQuery('.badge').removeClass('f');
		jQuery('.badge').removeClass('b');
		jQuery('.badge').removeClass('e');
		jQuery('.badge').removeClass('c');
		jQuery('.badge').removeClass('d');
		jQuery('.badge').each(function (){
		
		value = jQuery(this).data(searchType);
		if (searchType == "readinghighlight" || searchType == "writinghighlight" ||searchType == "mathshighlight"){
		console.log(value);
			jQuery(this).addClass(value);
		}
		else {
			if (value =="yes"){
			jQuery(this).addClass('f');
			}
		}
		
	})
			

				
				
				
    });	

jQuery("#confirm_delete").live('click', function(){
	
	var postId = jQuery('#delete_post_id').val();
	
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : 'myajax_ajax_remove_post',
							id : postId,
							Nonce: pageNonce
						}, 
						function( response ) {
							jQuery('.ui-dialog').dialog('close');
							jQuery('.post-'+postId).hide();
							
						}
	
				)
	
});


jQuery("#confirm_delete_group").live('click', function(){
	
	var postId = jQuery('#delete_group_id').val();
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : 'myajax_ajax_remove_group',
							id : postId,
							Nonce: pageNonce
						}, 
						function( response ) {
							jQuery('.ui-dialog').dialog('close');
							jQuery('#group_'+postId).hide();
							
						}
	
				)
	
});



jQuery('#close_confirm').live('click', function(){
	jQuery('.ui-dialog').dialog('close');
})



jQuery("#slider_submit").live('click', function(){
	jQuery('#dialog_content').html('checking...');
	var personid = jQuery(this).data('personid');
	var thisValue = jQuery('#slider_'+personid).val();
	var thisSubject = jQuery(this).data('subject');
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : 'fetch_standard_desc_confirmation',
							id : personid,
							subject: thisSubject,
							value: thisValue,
							Nonce: pageNonce
						}, 
						function( response ) {
							jQuery('#dialog_content').html(response);
						
							jQuery('#dialog_content a').buttonMarkup();
						}
	
				)
	
});

jQuery("#confirm_save").live('click', function(){
	
	form = $(this).data('formid');
	if (form){
	$('#'+form).submit();	
	}
	else {
	
	$('#slider_form').submit();
	}
});


jQuery('#rolldate').live("change", function(){
	
	jQuery('.post_list').html("Loading...");
	var date = jQuery(this).val();
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : 'myajax_fetch_register_list',
							theDate: date,
							Nonce: pageNonce
						}, 
						function( response ) {
							
							jQuery('.post_list').html(response);
							jQuery('#main').page('destroy').page();
							
						}
	
				)
});

jQuery('#write > .ui-header > .ui-btn').live("click", function(){
	
		jQuery('#post_form').find(':input').each(function() {
				switch(this.type) {
	
				case 'textarea':
	
					jQuery(this).html('');
	
					break;
	
				case 'radio':
	
					this.checked = false;
					jQuery(this).checkboxradio("refresh");	
	
			}
	
		});
			
	
})




jQuery(".editPost").live('click', function() {
       	
		var postId= jQuery(this).data('id');
		var author = jQuery(this).data('author');
		var post_date = jQuery(this).data('postdate');
		var category = jQuery(this).data('subject');
		var status = jQuery(this).data('status');
		var post_type = jQuery(this).data('type');
		
		var postcontent = jQuery('#post_'+postId+' >p').html();
			jQuery('#postcontent').html(postcontent);
			jQuery('#existing_post_id').val(postId);
			jQuery('#post_author').val(author);	
			jQuery('#post_date').val(post_date);
			jQuery('#radio-comp').val(post_type);
			jQuery('#radio-choice-'+status).prop("checked","checked").checkboxradio("refresh");	
			jQuery('#radio-subject-'+category).prop("checked","checked").checkboxradio("refresh");	
    });
	
	jQuery("#write_button").live('click', function() {
       
			jQuery('#existing_post_id').val();
			jQuery('#post_author').val();	
			jQuery('#post_date').val();	
					
    });
	
	jQuery(".change_post_meta").live('click', function() {
       
	   var post_type = jQuery(this).data('type');
	    var desc = jQuery(this).data('description');
		var cat = jQuery(this).data('subject');
			jQuery('#existing_post_id').val();
			jQuery('#post_author').val();	
			jQuery('#post_date').val();	
			jQuery('#radio-comp').val(post_type);
			jQuery('#select-subject').val(cat);
			jQuery('#postcontent').html(desc);
			
			
					
    });

jQuery('.loadPeopleByAlphabet').live("click", function(){
	
	$(this).removeClass('ui-btn-up-d');
	$('.loadPeopleByAlphabet').removeClass('ui-btn-up-f');
	$(this).addClass('ui-btn-up-f');
	
	theLetter = $(this).data('letter');
	theAction = 'ajax_people_by_alphabet';
	
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : theAction,
							letter: theLetter,
							Nonce: pageNonce
							
						}, 
						function( response ) {
							jQuery('#selectableList').html(response);
							
					
									})
	
});

jQuery('.load_page').live("click", function(){
	jQuery('#page_content').html('Loading...');
	$(this).removeClass('ui-btn-up-d');
	$('.load_page').removeClass('ui-btn-up-f');
	$(this).addClass('ui-btn-up-f');
	
	group_id = $(this).data('groupid');
	page_type = $(this).data('pagetype');
	referrer = $(this).data('referrer');
	theAction = 'ajax_load_page_goals';
	
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : theAction,
							groupid :group_id,
							pageType: page_type,
							refer: referrer,
							Nonce: pageNonce
							
						}, 
						function( response ) {
							jQuery('#page_content').html(response);
								$('#page_content').trigger( "create" );
					
									})
	
});

jQuery('.load_page_content').live("click", function(){
	jQuery('#page_content').html('Loading...');
	$(this).removeClass('ui-btn-up-d');
	$('.load_page_content').removeClass('ui-btn-up-f');
	$(this).addClass('ui-btn-up-f');
	
	group_id = $(this).data('groupid');
	page_type = $(this).data('pagetype');
	theAction =  $(this).data('action');
	
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : theAction,
							groupid :group_id,
							pageType: page_type,
							Nonce: pageNonce
							
						}, 
						function( response ) {
							jQuery('#page_content').html(response);
								jQuery('#page_content').trigger( "create" );
					
									})
	
});

jQuery('.createGroup').live("click", function(){
		
	peoplestring = $(this).data('peoplestring');
	yeargroup = $(this).data('yeargroup');
page_type = $(this).data('pagetype');
	theAction = 'ajax_create_auto_group';
	theRoom= $(this).data('room');
	
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : theAction,
							year :yeargroup,
							people:peoplestring,
							pageType: page_type,
							room: theRoom,
							Nonce: pageNonce
							
						}, 
						function( response ) {
							jQuery('#dialog_content').html(response);
							jQuery('#dialog_content').trigger( "create" );
							
					
									})
	
});


	
jQuery('.loadIndicatorsButton').live("click", function(){
	var subject=jQuery(this).data('subject');
	jQuery('#custom_'+subject).html('Loading...');
	$(this).removeClass('ui-btn-up-d');
	$('.loadIndicatorsButton').removeClass('ui-btn-up-f');
	$(this).addClass('ui-btn-up-f');
	
	var id=jQuery(this).data('id');
	var level=jQuery(this).data('level');
	var theAction = jQuery(this).data('action');
	jQuery.post(	MyAjax.ajaxurl,
						{
							action : theAction,
							theId : id,
							theSubject : subject,
							theLevel: level,
							Nonce: pageNonce
							
						}, 
						function( response ) {
							jQuery('#custom_'+subject).html(response);
							$('#custom_'+subject).trigger( "create" );
							
					
									}
	
				)
	

})


$('.secure').live('click', function(event){
	 event.preventDefault();
		$(this).removeClass('secure');
		$(this).addClass('notassessed');
	
		$(this).removeClass('ui-btn-up-d');
		
		var thisLinkId = $(this).data('id'); 
		var thisSubject = $(this).data('subject');
		var person_id = $(this).data('personid'); 
		var newValue = 'notassessed';
		var text = $('#set_text_'+thisLinkId);
		var thisButton = $(this).find('.ui-btn-text');
		thisButton.html('Saving...');
		
		$.post(
					
					MyAjax.ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'update_indicator',
				
						// other parameters can be added along with "action"
						
						Id : thisLinkId,
						personId: person_id, 
						update: newValue,
						subject: thisSubject,
						Nonce: pageNonce
						
				
					},
					function( response ) {
					text.html(response);
					thisButton.html('Goal');
					}
				);
		
		
		
	})
	

$('.personSecure').live('click', function(event){
	 event.preventDefault();
		$(this).removeClass('personSecure');
		$(this).addClass('personDeveloping');
	
		$(this).removeClass('d');
		$(this).addClass('f');
		var thisLinkId = $(this).data('id'); 
		var person_id = $(this).data('personid'); 
		var newValue = 'developing';
		
		var thisBadge = $(this).find('.name');
			var counter = $(this).find('.counter');
		var name = thisBadge.html();
		thisBadge.html('Saving...');
		
		$.post(
					
					MyAjax.ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'update_indicator',
				
						// other parameters can be added along with "action"
						
						Id : thisLinkId,
						personId: person_id, 
						update: newValue,
						Nonce: pageNonce
						
				
					},
					function( response ) {
					
					thisBadge.html(name);
						counter.removeClass('hidden');
					counter.html('<span id="'+person_id+'_counter">'+response+'</span>');
					$('#'+person_id+'_counter').fadeOut(3000, function (){
					counter.addClass('hidden');
						
					});
					}
				);
		
		
		
	})	
	
$('.personDeveloping').live('click', function(event){
	 event.preventDefault();
		$(this).removeClass('personDeveloping');
		$(this).addClass('personSecure');
	
		$(this).removeClass('f');
		$(this).addClass('d');
		var thisLinkId = $(this).data('id'); 
		var person_id = $(this).data('personid'); 
		var newValue = 'secure';
		
		var thisBadge = $(this).find('.name');
		var counter = $(this).find('.counter');
		
		var name = thisBadge.html();
		thisBadge.html('Saving...');
		
		$.post(
					
					MyAjax.ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'update_indicator',
				
						// other parameters can be added along with "action"
						
						Id : thisLinkId,
						personId: person_id, 
						update: newValue,
						Nonce: pageNonce
						
				
					},
					function( response ) {
					thisBadge.html(name);
						counter.removeClass('hidden');
					counter.html('<span id="'+person_id+'_counter">'+response+'</span>');
					$('#'+person_id+'_counter').fadeOut(3000, function (){
					counter.addClass('hidden');
						
					});
					
				
					
					}
				);
		
		
		
	})	
	
$('.notsetyet').live('click', function(event){
	 event.preventDefault();
		$(this).removeClass('notsetyet');
		$(this).addClass('personDeveloping');
	
	
		$(this).addClass('f');
		var thisLinkId = $(this).data('id'); 
		var person_id = $(this).data('personid'); 
		var newValue = 'developing';
		
		var thisBadge = $(this).find('.name');
			var counter = $(this).find('.counter');
		var name = thisBadge.html();
		thisBadge.html('Saving...');
		
		
		$.post(
					
					MyAjax.ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'insert_indicator',
				
						// other parameters can be added along with "action"
						
						Id : thisLinkId,
						personId: person_id, 
						update: newValue,
						Nonce: pageNonce
						
				
					},
					function( response ) {
					thisBadge.html(name);
					counter.removeClass('hidden');
					counter.html('<span id="'+person_id+'_counter">'+response+'</span>');
					$('#'+person_id+'_counter').fadeOut(3000, function (){
					counter.addClass('hidden');
						
					});
					
					}
				);
		
		
		
	})			
	
		$('.developing').live('click', function(event){
			 event.preventDefault();
		
		$(this).removeClass('developing');
		$(this).addClass('secure');
		$(this).addClass('ui-btn-up-d');
		$(this).removeClass('ui-btn-up-f');
		
		var thisLinkId = $(this).data('id'); 
		var thisSubject = $(this).data('subject');
		var person_id = $(this).data('personid'); 
		var newValue = 'secure';
		var text = $('#set_text_'+thisLinkId);
		var thisButton = $(this).find('.ui-btn-text');
		thisButton.html('Saving...');
		
		//Put some laoding or saving text here.
		$.post(
					
					MyAjax.ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'update_indicator',
				
						// other parameters can be added along with "action"
						
						Id : thisLinkId,
						personId: person_id, 
						update: newValue,
						subject: thisSubject,
						Nonce: pageNonce
						
				
					},
					function( response ) {
						text.html(response);
					
					thisButton.html('Secure');
					$(this).removeClass('ui-btn-up-f');
					}
				);
		
		
	})
	
	
	
	$('.notassessed').live('click', function(event){
			 event.preventDefault();
		$(this).removeClass('notassessed');
		$(this).addClass('developing');
		
		$(this).removeClass('ui-btn-up-b');
		$(this).addClass('ui-btn-up-f');
		var personId = $(this).data('personid'); 
		var subject= $(this).data('subject');
		var indicatorId = $(this).data('id');
		var newValue = 'developing';
		var assessment_subject = $(this).data('subject');
		var text = $('#set_text_'+indicatorId);
		var thisButton = $(this).find('.ui-btn-text');
		thisButton.html('Saving...');
		
	jQuery.post(
					
					MyAjax.ajaxurl,
					{
						// here we declare the parameters to send along with the request
						// this means the following action hooks will be fired:
						// wp_ajax_myajax-submit
						action : 'insert_indicator',
				
						// other parameters can be added along with "action"
						
						Id : indicatorId, 
						update: newValue,
						personId: personId,
						assessmentSubject: assessment_subject,
						Nonce: pageNonce
						
				
					},
					function( response ) {
						
						text.html(response);
						
						
						thisButton.html('Set as Complete');	
					
					}
				);
				
		
		
	})
	
	
	
})


$(document).bind("mobileinit", function(){
  $.extend(  $.mobile , {
    ajaxEnabled: false
  });
});

//============================= START OF CLASS ==============================//
// CLASS: HtmlBox                                                            //
//===========================================================================//
   /**
    * HtmlBox is a cross-browser widget that replaces the normal textboxes with
    * rich text area like in OpenOffice Text. It has Ajax support out of the box.
    * PS. It requires JQuery in order to function.
    * TODO: Smilies, CSS for Safari
    *<code>
    * </code>
    * Copyright@2007-2011 Remiya Solutions All rights reserved! 
	* @author Remiya Solutions
	* @version 4.0.3
    */
(function($){ 
$.fn.htmlbox=function(options){
    // START: Settings
        // Are there any plugins?
    var colors = (typeof document.htmlbox_colors === 'function')?document.htmlbox_colors():['silver','silver','white','white','yellow','yellow','orange','orange','red','red','green','green','blue','blue','brown','brown','black','black'];
	var styles = (typeof document.htmlbox_styles === 'function')?document.htmlbox_styles():[['No Styles','','']];
	var syntax = (typeof document.htmlbox_syntax === 'function')?document.htmlbox_syntax():[['No Syntax','','']];
	var urm = (typeof htmlbox_undo_redo_manager === 'function')?new htmlbox_undo_redo_manager():false;
	// Default option
	var d={
	    toolbars:[["bold","italic","underline"]],      // Buttons
		idir:"style/images/",// HtmlBox Image Directory, This is needed for the images to work
		icons:"default",  // Icon set
		about:false,
		skin:"default",  // Skin, silver
		output:"xhtml",  // Output
		toolbar_height:24,// Toolbar height
		tool_height:16,   // Tools height
		tool_width:16,    // Tools width
		tool_image_height:16,  // Tools image height
		tool_image_width:16,  // Tools image width
		css:"body{margin:3px;font-family:verdana;}p{margin:0px;}",
		success:function(data){alert(data);}, // AJAX on success
		error:function(a,b,c){return this;}   // AJAX on error
	};
	
	// User options
    d = $.extend(d, options);
    
    // Is forward slash added to the image directory
    if(d.idir.substring(d.idir.length-1)!=="/"){d.idir+="/";}
    // END: Settings
	
	// ------------- START: PRIVATE METHODS -----------------//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: get_selection                                              //
    //=====================================================================//
	   /**
	    * Returns the selected (X)HTML code
	    * @access private
	    */
	var get_selection = function(){
	    var range;
		if($.browser.msie){
	       range = d.iframe.contentWindow.document.selection.createRange();
		   if (range.htmlText && range.text){return range.htmlText;}
	    }else{
		   if (d.iframe.contentWindow.getSelection) {
		       var selection = d.iframe.contentWindow.getSelection();
		       if (selection.rangeCount>0&&window.XMLSerializer){
                   range=selection.getRangeAt(0);
                   var html=new XMLSerializer().serializeToString(range.cloneContents());
			       return html;
               }if (selection.rangeCount > 0) {
		           range = selection.getRangeAt(0);
			       var clonedSelection = range.cloneContents();
			       var div = document.createElement('div');
			       div.appendChild(clonedSelection);
			       return div.innerHTML;
		       }
			}
		}
	};
    //=====================================================================//
    //  METHOD: get_selection                                              //
    //========================== END OF METHOD ============================//
	
	//========================= START OF METHOD ===========================//
    //  METHOD: in_array                                                   //
    //=====================================================================//
	 /**
	    * Coppies the PHP in_array function. This is useful for Objects.
	    * @access private
	    */
	var in_array=function(o,a){
	   for (var i in a){ if((i===o)){return true;} }
       return false;
	};
    //=====================================================================//
    //  METHOD: in_array                                                   //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: insert_text                                                //
    //=====================================================================//
	   /**
	    * Inserts text at the cursor position or selection
	    * @access private
	    */
	var insert_text = function(text,start,end){
	    if($.browser.msie){
		    d.iframe.contentWindow.focus();
	        if(typeof d.idoc.selection !== "undefined" && d.idoc.selection.type !== "Text" && d.idoc.selection.type !== "None"){start = false;d.idoc.selection.clear();}
		    var sel = d.idoc.selection.createRange();sel.pasteHTML(text);
			if (text.indexOf("\n") === -1) {
			    if (start === false) {} else {
                    if (typeof start !== "undefined") {
                        sel.moveStart("character", - text.length + start);
                        sel.moveEnd("character", - end);
                    } else {
                        sel.moveStart("character", - text.length);
                    }
                }
                sel.select();
            }
		}else{
		    d.idoc.execCommand("insertHTML", false, text);
		}
		// Updating the textarea component, so whenever it is posted it will send all the data
	    if ($("#"+d.id).is(":visible") === false) {
	        var html = $("#1"+d.id).is(":visible")?$("#"+d.id).val():html = d.iframe.contentWindow.document.body.innerHTML;		    
	        html = (typeof getXHTML === 'function')?getXHTML(html):html;
		    $("#"+d.id).val(html);
			if(urm){urm.add(html);} // Undo Redo
		    if(undefined!==d.change){d.change();}
	    }		
	};
    //=====================================================================//
    //  METHOD: insert_text                                                //
    //========================== END OF METHOD ============================//

	//========================= START OF METHOD ===========================//
    //  METHOD: keyup                                                      //
    //=====================================================================//
	   /**
	    * Keyup event.
	    * @access private 
	    */
	var keyup = function(e){
	    // Updating the textarea component, so whenever it is posted it will send all the data
		var html = $("#1"+d.id).is(":visible")?$("#"+d.id).val():html = d.iframe.contentWindow.document.body.innerHTML;
		if(urm){urm.add(html);} // Undo Redo
	    html = (typeof getXHTML === 'function')?getXHTML(html):html;
		$("#"+d.id).val(html);
		if(undefined!==d.change){d.change();}
	};
    //=====================================================================//
    //  METHOD: keyup                                                      //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: style                                                      //
    //=====================================================================//
	   /**
	    * Sets the CSS style to the HtmlBox iframe
	    * @access private
	    */
    var style = function(){
	    // START: HtmlBox Style
        if(d.css.indexOf("background:")===-1){d.css+="body{background:white;}";}
        
        
		if( d.idoc.createStyleSheet) {
		  d.idoc.createStyleSheet().cssText=d.css;
		}else {
		  var css=d.idoc.createElement('link');
		  css.rel='stylesheet'; css.href='data:text/css,'+escape(d.css);
		  if($.browser.opera){
			 d.idoc.documentElement.appendChild(css);
		  }else{
			 d.idoc.getElementsByTagName("head")[0].appendChild(css);
		  }
		}
		// END: HtmlBox Style
	};
    //=====================================================================//
    //  METHOD: style                                                      //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: toolbar                                                    //
    //=====================================================================//
	   /**
	    * The toolbar of HtmlBox
	    * @return this
		* @access private
	    */
	var toolbar=function(){
	    var h = "";
	    if(d.about&&!in_array(d.toolbars[0],"about")){d.toolbars[0][d.toolbars[0].length]="separator";d.toolbars[0][d.toolbars[0].length]="about";}
		for(var k=0;k<d.toolbars.length;k++){
		    var toolbar = d.toolbars[k];
			h += "<tr><td class='"+d.id+"_tb' valign='middle'><table cellspacing='1' cellpadding='0'>";
			for(var i=0;i<(toolbar.length);i++){
				var img = (d.icons==="default")?d.idir+"default/"+toolbar[i]+".gif":d.idir+d.icons+"/"+toolbar[i]+".png";
	            if(undefined===toolbar[i]){continue;}
	            // START: Custom button
	            else if(typeof(toolbar[i])!=='string'){
	                img = d.idir+d.icons+"/"+toolbar[i].icon;
	                var cmd = "var cmd = unescape(\""+escape( toolbar[i].command.toString() )+"\");eval(\"var fn=\"+cmd);fn()'";
	                h += "<td class='"+d.id+"_html_button' valign='middle' align='center' onclick='"+cmd+"' title='"+toolbar[i].tooltip+"'><image src='"+img+"'></td>";
			    }
	            // END: Custom button
				else if(toolbar[i]==="separator"){h += "<td valign='middle' align='center'><image src='"+d.idir+"separator.gif' style='margin-right:1px;margin-left:3px;height:13px;'></td>";}
				else if(toolbar[i]==="fontsize"){
				    h += "<td valign='middle' align='center'><select id='"+d.id+"_fontsize' onchange='global_hb[\""+d.id+"\"].cmd(\"fontsize\",this.options[this.selectedIndex].value)' style='font-size:12px;'><option value='' selected>- SIZE -</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option></select></td>";
			    }else if(toolbar[i]==="fontfamily"){
				    h += "<td valign='middle' align='center'><select id='"+d.id+"_fontfamily' onchange='global_hb[\""+d.id+"\"].cmd(\"fontname\",this.options[this.selectedIndex].value)' style='font-size:12px;'><option value='' selected>- FONT -</option><option value='arial' style='font-family:arial;'>Arial</option><option value='courier' style='font-family:courier;'>Courier</option><option value='cursive' style='font-family:cursive;'>Cursive</option><option value='georgia' style='font-family:georgia;'>Georgia</option><option value='monospace' style='font-family:monospace;'>Monospace</option><option value='tahoma' style='font-family:tahoma;'>Tahoma</option><option value='verdana' style='font-family:verdana;'>Verdana</option></select></td>";
				}else if(toolbar[i]==="formats"){
				    h += "<td valign='middle' align='center'><select id='"+d.id+"_formats' onchange='global_hb[\""+d.id+"\"].cmd(\"format\",this.options[this.selectedIndex].value)' style='font-size:12px;'><option value='' selected>- FORMATS -</option><option value='h1'>Heading 1</option><option value='h2'>Heading 2</option><option value='h3'>Heading 3</option><option value='h4'>Heading 4</option><option value='h5'>Heading 5</option><option value='h6'>Heading 6</option><option value='p'>Paragraph</option><option value='pindent'>First Indent</option><option value='pre'>Preformatted</option></select></td>";
				}else if(toolbar[i]==="fontcolor"){
				    h += "<td valign='middle' align='center'><select id='"+d.id+"_fontcolor' onchange='global_hb[\""+d.id+"\"].cmd(\"fontcolor\",this.options[this.selectedIndex].value)' style='font-size:12px;'><option value='' selected>-COLOR-</option>";
					for(var m=0;m<colors.length;m++){ if(m%2){continue;}
					   h+="<option value='"+colors[m]+"' style='background:"+colors[m]+";color:"+colors[m]+";'>"+colors[m]+"</option>";
					}
					h += "</select></td>";
				}else if(toolbar[i]==="highlight"){
				    h += "<td valign='middle' align='center'><select id='"+d.id+"_highlight' onchange='global_hb[\""+d.id+"\"].cmd(\"backcolor\",this.options[this.selectedIndex].value)' style='font-size:12px;'><option value='' selected>-HIGHLIGHT-</option>";
					for(var n=0;n<colors.length;n++){ if(n%2){continue;}
					   h+="<option value='"+colors[n]+"' style='background:"+colors[n]+";color:"+colors[n]+";'>"+colors[n]+"</option>";
					}
					h += "</select></td>";
				}else if(toolbar[i]==="styles"){
				    h += "<td valign='middle' align='center'><select id='"+d.id+"_styles' onchange='global_hb[\""+d.id+"\"].cmd(\"styles\",this.options[this.selectedIndex].value);this.options[0].selected=\"true\";' style='font-size:12px;' style='background:white;'><option value='' selected>-STYLES-</option>";
					for(var o=0;o<styles.length;o++){ if(o%2){continue;}
					   h+="<option value='"+o+"' style='background:white;color:red;'>"+styles[o][0]+"</option>";
					}
					h += "</select></td>";
				}else if(toolbar[i]==="syntax"){
				    h += "<td valign='middle' align='center'><select id='"+d.id+"_syntax' onchange='global_hb[\""+d.id+"\"].cmd(\"syntax\",this.options[this.selectedIndex].value);this.options[0].selected=\"true\";' style='font-size:12px;'><option value='' selected>-SYNTAX-</option>";
					for(var p=0;p<syntax.length;p++){ if(p%2){continue;}
					   h+="<option value='"+p+"' style='background:white;color:red;'>"+syntax[p][0]+"</option>";
					}
					h += "</select></td>";
				}
				// Commands
				var cmds = {"about":"About","bold":"Bold","center":"Center","code":"View Code","copy":"Copy","cut":"Cut","hr":"Insert Line","link":"Insert Link","image":"Insert Image","indent":"Indent","italic":"Italic","justify":"Justify","left":"Left","ol":"Numbered List","outdent":"Outdent","paragraph":"Insert Paragraph","paste":"Paste","quote":"Quote","redo":"Redo","removeformat":"Remove Format","right":"Right","strike":"Strikethrough","striptags":"Strip Tags","sub":"Subscript","sup":"Superscript","ul":"Bulleted List","underline":"Underline","undo":"Undo","unlink":"Remove Link"};
				if(in_array(toolbar[i],cmds)){h += "<td class='"+d.id+"_html_button' valign='middle' align='center' onclick='global_hb[\""+d.id+"\"].cmd(\""+toolbar[i]+"\")' title='"+cmds[toolbar[i]]+"'><image src='"+img+"'></td>";}
		    }
			h += "</table></td></tr>";
		}
		return h;
	};
    //=====================================================================//
    //  METHOD: toolbar                                                    //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: wrap_tags                                                  //
    //=====================================================================//
	   /**
	    * Wraps tags around the cursor position or selection
	    * @access private
	    */
	this.wrap_tags = function(start,end){
	   var sel = get_selection(); 
	   if(undefined===sel){sel="";}
	   if(undefined===end){end="";}
	   insert_text(start+sel+end,start.length,end.length);
	};
    //=====================================================================//
    //  METHOD: wrap_tags                                                  //
    //========================== END OF METHOD ============================//
	
	// -------------- END: PRIVATE METHODS ------------------//
	
	// ------------- START: PUBLIC METHODS -----------------//
    //========================= START OF METHOD ===========================//
    //  METHOD: _init                                                      //
    //=====================================================================//
	/**
	  * Draws the HtmlBox on the screen
	  * @return this
	  * @access private	  
	  */
	this._init = function(is_init){
	    if(undefined===window.global_hb){global_hb=[];}
        if(!$(this).attr("id")){$(this).attr("id","jqhb_"+global_hb.length);d.id="jqhb_"+global_hb.length;global_hb[d.id]=global_hb;}else{d.id=$(this).attr("id");}
	    if(undefined === global_hb[d.id]){global_hb[d.id]=this;}
	    // START: Timeout to allow creation of DesignMode
	    //if(undefined===is_init){setTimeout("global_hb['"+d.id+"'].init(true)",250);return false;}
		// END: Timeout to allow creation of DesignMode
		d.ta_wrap_id = d.id+"_wrap";
		var w='100%';var h=$(this).css("400");$(this).wrap("<table id='"+d.id+"_wrap' width='"+w+"' style='height:"+h+";border:2px solid #E9EAEF;' cellspacing='0' cellpadding='0'><tr><td id='"+d.id+"_container'></td></tr></table>");
		// START: Appending toolbar
		$(this).parent().parent().parent().parent().prepend(toolbar());
		$("."+d.id+"_tb").height(d.toolbar_height);
		
		$("."+d.id+"_html_button").each(function(){
			// Set tool dimension
		    $(this).width(d.tool_width).height(d.tool_height);
		    // Set image dimension
		    $(this).find("image").each(function(){$(this).width(d.tool_image_width).height(d.tool_image_height);});
		    // Set borders
		    $(this).css("border","1px solid transparent").css("background","transparent").css("margin","1px 1px 1px 1px").css("padding","1px");
		    $(this).mouseover(function(){$(this).css("border","1px solid #BFCAFF").css("background","#EFF2FF");});
			$(this).mouseout(function(){$(this).css("border","1px solid transparent").css("background","transparent");});
			}
		);
		
		// Selectors
		$("."+d.id+"_tb").find("select").each(function(){
		    $(this).css("border","1px solid #E9EAEF").css("background","transparent").css("margin","2px 2px 3px 2px");
			if($.browser.mozilla){$(this).css("padding","0").css("position","relative").css("top","-2px");}
		    }
		);		 
		// END: Appending toolbar
		
		// START: Skin
		// default
		var hb_border = "1px solid #7F7647";
		var hb_background = "#DFDDD1";
		var tb_border = "1px solid #7F7647";
		if(d.skin==="blue"){
			hb_border = "1px solid #7E9DB9";
			hb_background = "#D7E3F2";
			tb_border = "1px solid #7E9DB9";
		}
        if(d.skin==="red"){
		
			hb_background = "#FFD7CF";
			
		}
        if(d.skin==="green"){
			hb_border = "1px solid #8DB900";
			hb_background = "#D5EF86";
			tb_border = "1px solid #8DB900";
		}
        if(d.skin==="silver"){
			hb_border = "1px solid #DDDDDD";
			hb_background = "#F4F4F3";
			tb_border = "1px solid #DDDDDD";
		}
		
		$("#"+d.id+"_wrap").css("border",hb_border);
		$("#"+d.id+"_wrap").css("background",hb_background);
		$("#"+d.id+"_container").css("background","white");
		$("."+d.id+"_tb").css("border-bottom",tb_border);
		
		//$("."+d.id+"_tb").css("background-image","url("+d.idir+"bg_blue.gif)");
		//style='background:silver;border-bottom:1px outset white'
		// END: Skin
		try {
		      var iframe=document.createElement("IFRAME");// var doc=null;
		   $(iframe).css("width",w).css("height",h).attr("id",d.id+"_html").css("border","0");
		   $(this).parent().prepend(iframe);
		   // START: Shortcuts for less code
		   d.iframe = iframe;
		   d.idoc = iframe.contentWindow.document;
		   // END: Shortcuts
		   
		   d.idoc.designMode="on";
		   // START: Insert text
		      // Is there text in the textbox?
		   var text = ($(this).val()==="")?"":$(this).val();
		   if($.browser.mozilla||$.browser.safari){
			   //if(text===""){text="&nbsp;";}
			   d.idoc.open('text/html', 'replace'); d.idoc.write(text); d.idoc.close();
		   }else{
	           if(text!==""){d.idoc.write(text);}
			   else{
			       // Needed by IE to initialize the iframe body
			       if($.browser.msie){d.idoc.write("&nbsp;");}
			   }
		   }
		   // Needed by browsers other than MSIE to become editable
		   if($.browser.msie===false){iframe.contentWindow.document.body.contentEditable = true;}
		   // END: Insert text
		   
		   // START: HtmlBox Style
		   if(d.css.indexOf("background:")===-1){d.css+="body{background:white;}";}
		 
		   
		   if(d.idoc.createStyleSheet) {
		       setTimeout("global_hb['"+d.id+"'].set_text(global_hb['"+d.id+"'].get_html())",10);
		   }else {style();}
		   // END: HtmlBox Style
		   
		   // START: Adding events
		   if(iframe.contentWindow.document.attachEvent){
		       iframe.contentWindow.document.attachEvent("onkeyup", keyup);
		   }else{
			   iframe.contentWindow.document.addEventListener("keyup",keyup,false);
		   }
		   $(this).hide();
	    }catch(e){
	       alert("This rich text component is not supported by your browser.\n"+e);
		   $(this).show();
	    }
		return this;
	};
    //=====================================================================//
    //  METHOD: _init                                                      //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: cmd                                                        //
    //=====================================================================//
	   /**
	    * Executes a user-specified command
		* @since 2.0
	    * @return this
	    */
	this.cmd = function(cmd,arg1){
	   // When user clicks toolbar button make sure it always targets its respective WYSIWYG
       d.iframe.contentWindow.focus();
	   // START: Prepare commands
	   if(cmd==="paragraph"){cmd="format";arg1="p";}
	   var cmds = {"center":"justifycenter","hr":"inserthorizontalrule","justify":"justifyfull","left":"justifyleft","ol":"insertorderedlist","right":"justifyright","strike":"strikethrough","sub":"subscript","sup":"superscript","ul":"insertunorderedlist"};
	   if(in_array(cmd,cmds)){cmd=cmds[cmd];}
       // END: Prepare commands
	   if(cmd==="code"){
	       var text = this.get_html();
	       if($("#"+d.id).is(":visible")){		       
		       $("#"+d.id).hide();		   
		       $("#"+d.id+"_html").show();
			   this.set_text(text);
		   }else{
		       $("#"+d.id).show();
		       $("#"+d.id+"_html").hide();
			   this.set_text(text);
			   $("#"+d.id).focus();
		   }
		   
	   }else if(cmd==="link"){
		   d.idoc.execCommand("createlink", false, prompt("Paste Web Address URL Here:"));
	   }else if(cmd==="image"){
		   d.idoc.execCommand("insertimage", false, prompt("Paste Image URL Here:"));
	   }else if(cmd==="fontsize"){
		   d.idoc.execCommand(cmd, false,arg1);
	   }else if(cmd==="backcolor"){
	       if($.browser.msie){
		   d.idoc.execCommand("backcolor", false,arg1);
		   }else{
		   d.idoc.execCommand("hilitecolor", false,arg1);
		   }
	   }else if(cmd==="fontcolor"){
	       d.idoc.execCommand("forecolor", false,arg1);
	   }else if(cmd==="fontname"){
		   d.idoc.execCommand(cmd, false, arg1);
	   }else if(cmd==="cut"){
	       if($.browser.msie === false){
		       alert("Available in IExplore only.\nUse CTRL+X to cut text!");
		   }else{
	           d.idoc.execCommand('Cut');
	       }
	   }else if(cmd==="copy"){
	       if($.browser.msie === false){
		       alert("Available in IExplore only.\nUse CTRL+C to copy text!");
		   }else{
	           d.idoc.execCommand('Copy');
	       }
	   }else if(cmd==="paste"){
	       if($.browser.msie === false){
		       alert("Available in IExplore only.\nUse CTRL+V to paste text!");
		   }else{
	           d.idoc.execCommand('Paste');
	       }
	   }else if(cmd==="format"){
	       if(arg1==="pindent"){this.wrap_tags('<p style="text-indent:20px;">','</p>');}
		   else if(arg1!==""){d.idoc.execCommand('formatBlock', false, "<"+arg1+">");}
	   }else if(cmd==="striptags"){
	       var sel = get_selection();
		   sel = sel.replace(/(<([^>]+)>)/ig,"");
		   insert_text(sel); 
	   }else if(cmd==="quote"){
	       this.wrap_tags('<br /><div style="position:relative;top:10px;left:11px;font-size:11px;font-family:verdana;">Quote</div><div class="quote" contenteditable="true" style="border:1px inset silver;margin:10px;padding:5px;background:#EFF7FF;">','</div><br />');
	   }else if(cmd==="styles"){
	       this.wrap_tags(styles[arg1][1],styles[arg1][2]);
	   }else if(cmd==="syntax"){
	       this.wrap_tags(syntax[arg1][1],syntax[arg1][2]);
	   }else if(cmd==="bold"){
	       this.wrap_tags("<b>","</b>");
	   }else if(cmd==="undo"&&urm){
	       if(urm.can_undo()){
		       var undo = urm.undo();
			   this.set_text(undo);
			   return true;
		   }
	   }else if(cmd==="redo"&&urm){
	       if(urm.can_redo()){
		       var redo = urm.redo();
			   this.set_text(redo);
			   return true;
		   }
	   }else if(cmd==="about"){
		   var about = "<p>HtmlBox is a modern, cross-browser, interactive, open-source text area built on top of the excellent jQuery library.</p>";
		   about += "<p style='margin:2px;'><b>Official Website:</b> <a href='http://remiya.com' target='_blank'>http://remiya.com</a></p>";
		   about += "<p style='margin:2px;'><b>License:</b> MIT license</p>";
		   about += "<p style='margin:2px;'><b>Version:</b> 4.0</p>";
		   about += "<p style='margin:2px;'><b>Credits:</b></p>";
		   about += "<p style='margin:2px;padding-left:20px;'><a href='http://jquery.com/' target='_blank'>JQuery (JavaScript Framework)</a></p>";
		   about += "<p style='margin:2px;padding-left:20px;'><a href='http://www.famfamfam.com/lab/icons/silk/' target='_blank'>Silk (Icon Set)</a></p>";
		   var html = '<table cellspacing="3" cellpadding="0" width="100%" height="100%"  style="background:#D7E3F2;border:2px solid #7E9DB9;font-family:verdana;font-size:12px;">';
	       html += '<tr><td align="center" valign="middle" height="30" style="font-size:16px;"><b>About HtmlBox</b></td></tr>';
	       html += '<tr><td style="border:1px solid #7E9DB9;background:white;font-size:11px;" valign="top"><div style="overflow:auto;height:140px;" >'+about+'</div></td></tr>';
	       html += '<tr><td height="20"><table width="100%" style="font-family:verdana;font-size:10px;"><tr><td align="left">Copyright&copy;2009 Remiya Solutions<br>All right reserved!</td><td align="right"><button style="width:60px;height:24px;font-family:verdana;font-size:11px;" onclick="$(\'#'+d.id+'_about\').fadeOut(500);">Close</button></td></tr></table></td></tr>';
	       html += '</table>';
	       
	       var w = 600;var h = 300;
	       var top = ($(window).height()-200)/2+$(document).scrollTop();
	       var left = ($(window).width()-300)/2;
	       if ($("#"+d.id+"_about").length === 0){
               $("body").append("<div id='"+d.id+"_about' style='display:none;position:absolute;background:red;width:"+w+"px;height:"+h+"px;top:"+top+"px;left:"+left+"px;'>about</div>");
		       $("#"+d.id+"_about").html(html);
		   }else{
			   $("#"+d.id+"_about").css("top",top);
			   $("#"+d.id+"_about").css("left",left);
		   }
	       $("#"+d.id+"_about").focus();
	       $("#"+d.id+"_about").fadeIn(1000);
	   }else{
	       d.idoc.execCommand(cmd, false, null);
	   }
	   //Setting the changed text to textearea
	   if($("#"+d.id).is(":visible")===false){
	      $("#"+d.id).val(this.get_html());
	      // Register change
		  if(urm){urm.add(this.get_html());}
		  if(undefined!==d.change){d.change();}
	   }
	};
    //=====================================================================//
    //  METHOD: cmd                                                        //
    //========================== END OF METHOD ============================//
		
    //========================= START OF METHOD ===========================//
    //  METHOD: get_text                                                   //
    //=====================================================================//
	   /**
	    * Returns the text without tags of the HtmlBox
		* @since 1.2
	    * @return this
	    */
	this.get_text = function(){
	   // Is textbox visible?
	   if($("#"+d.id).is(":visible")){ return $("#"+d.id).val(); }
	   // Iframe is visible
	   var text;
	   if($.browser.msie){
	       text = d.iframe.contentWindow.document.body.innerText;
	   }else{
	       var html = d.iframe.contentWindow.document.body.ownerDocument.createRange();
		   html.selectNodeContents(d.iframe.contentWindow.document.body);
		   text = html;
	   }
	   return text;
	};
    //=====================================================================//
    //  METHOD: get_text                                                   //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: set_text                                                  //
    //=====================================================================//
	   /**
	    * Sets the text as a content of the HtmlBox
		* @since 1.2
	    * @return this
	    */
	this.set_text = function(txt){
	   var text = (undefined===txt)?"":txt;
	   if(text==="" && $.browser.safari){text = "&nbsp;";}// Bug in Chrome and Safari
	   // Is textarea visible? Writing to it.
	   if($("#"+d.id).is(":visible")){
	       $("#"+d.id).val(text);
	   }else{
	     // Textarea not visible. write to iframe
	     if($.browser.mozilla||$.browser.safari){
		   //if($.trim(text)===""){text="&nbsp;";}
		   d.idoc.open('text/html', 'replace'); d.idoc.write(text); d.idoc.close();
	     }else{
		   d.idoc.body.innerHTML = "";
	       if(text!==""){d.idoc.write(text);}
	     }
	     style(); // Setting the CSS style for the iframe
		 d.idoc.body.contentEditable = true;
		 
	   }
	   if(urm){urm.add(this.get_html());}
	   if(undefined!==d.change){d.change();}
	   return this;
	};
    //=====================================================================//
    //  METHOD: set_text                                                   //
    //========================== END OF METHOD ============================//
	
	//========================= START OF METHOD ===========================//
    //  METHOD: get_html                                                   //
    //=====================================================================//
	   /**
	    * Returns the (X)HTML content of the HtmlBox
	    * @return this
	    */
	this.get_html = function(){
	   var html;
	   if($("#"+d.id).is(":visible")){
	      html = $("#"+d.id).val();
	   }else{
	      html = d.iframe.contentWindow.document.body.innerHTML;
	   }
	   if(typeof getXHTML === 'function'){ return getXHTML(html); }else{return html;}
	};
    //=====================================================================//
    //  METHOD: get_html                                                   //
    //========================== END OF METHOD ============================//
    
    //========================= START OF METHOD ===========================//
    //  METHOD: change                                                     //
    //=====================================================================//
       /**
        * Specifies a function to be executed on text change in the HtmlBox
        */
	this.change=function(fn){d.change=fn;return this;};
    //=====================================================================//
    //  METHOD: change                                                     //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: remove                                                     //
    //=====================================================================//
       /**
        * Removes the HtmlBox instance from the DOM and the globalspace
        */
	this.remove = function(){
		global_hb[d.id]=undefined;
	    $("#"+d.id+"_wrap").remove();
	    if ($("#"+d.id+"_about").length === 0){$("#"+d.id+"_about").remove();}
	};
    //=====================================================================//
    //  METHOD: remove                                                     //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: post                                                       //
    //=====================================================================//
	   /**
	    * Posts the form data to the specified URL using Ajax
        * @param String the URL to post to
	    * @param String the text to be posted, default the (X)HTML text
	    * @return this;
	    */
	this.post=function(url,data){
	    if(undefined===data){data=this.get_html();} data=(d.id+"="+data);
		$.ajax({type: "POST", data: data,url: url,dataType: "html",error:d.error,success:d.success});
	};
    //=====================================================================//
    //  METHOD: post                                                       //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: get                                                        //
    //=====================================================================//
	   /**
	    * Gets the form data to the specified URL using Ajax
        * @param String the URL to get to
	    * @param String the text to be posted, default the (X)HTML text
	    * @return this;
	    */
	this.get=function(url,data){
	    if(undefined===data){data=this.get_html();} data=(d.id+"="+data);
		$.ajax({type: "GET", data: data,url: url,dataType: "html",error:d.error,success:d.success});
	};
    //=====================================================================//
    //  METHOD: get                                                        //
    //========================== END OF METHOD ============================//
	
    //========================= START OF METHOD ===========================//
    //  METHOD: success                                                    //
    //=====================================================================//
       /**
        * Specifies what is to be executed on successful Ajax POST or GET
        */
	this.success=function(fn){d.success=fn;return this;};
    //=====================================================================//
    //  METHOD: success                                                    //
    //========================== END OF METHOD ============================//

    //========================= START OF METHOD ===========================//
    //  METHOD: error                                                      //
    //=====================================================================//
       /**
        * Specifies what is to be executed on error Ajax POST or GET
		* @return {HtmlBox} the instance of this HtmlBox
        */
	this.error=function(fn){d.error=fn;return this;};
    //=====================================================================//
    //  METHOD: error                                                      //
    //========================== END OF METHOD ============================//

	// -------------- END: PUBLIC METHODS ------------------//
	this._init(false);
	return this;
};
})(jQuery);
//===========================================================================//
// CLASS: HtmlBox                                                            //
//============================== END OF CLASS ===============================//