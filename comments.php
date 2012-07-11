<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>  
<?php endif; ?>  
  
<?php if(!empty($post->post_password)) : ?>  
    <?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>  
    <?php endif; ?>  
<?php endif; ?>  
  
 <br />


	<dl id='comment_list_<?php the_ID();?>' >
    <?php foreach($comments as $comment) : ?>  
        <dt id="comment-<?php comment_ID(); ?>" class="comment">
        
        	<?php
			 $user_id = $comment->user_id;
			 $user_person_id = get_user_meta($user_id, 'person_id', true);
				$user_person = new Person($user_person_id);
			?>
          <span class="avatar">
         <?php $user_person->showBadge(true, false);?>
          </span>
           <span class="comment_author  tk-head">
           <?php  $user_person->showName(); ?></span>
      			
           </dt>
           <dd class="comment format_text  tk-body">
            <?php comment_text(); ?>  
            </dd>
            
    <?php endforeach; ?>  
    </dl>
    
    
   <!--<h3>Make a comment:</h3>
                <form id="sibson_form_<?php // the_ID();?>" method="post"  >
                <input type="hidden" value="comment" id="sibson_hidden_type_<?php // the_ID();?>" />
                
                <input type="text" id="<?php // the_ID();?>_textbox" name="<?php // the_ID();?>_textbox" />
                 <div data-inline="true">
                    <input type="button" value="Save" class="sibson_submit_button" id="<?php // the_ID();?>" data-inline="true"/>
              
				</div>
                </form>
 -->  
     </div> 
</div>     

       