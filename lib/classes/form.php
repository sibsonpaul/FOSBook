<?php

class Form{
	
	private $type = "";
		private $id = "";
	
	public function __construct($type, $ID){
		
		// When the class is instartiated take the id passed through and query the database to populate all the variables.
	
	$this->type = $type;
	$this->id = $ID;
		

	}
	
	public function post_form(){
		
	function get_category_id($cat_name){
			$term = get_term_by('slug', $cat_name, 'category');
			return $term->term_id;
		}
		
	$category_ID = get_category_id($this->type);
	$args = array('parent'=>$category_ID, 'style' => 'none', 'hide_empty' =>0, 'orderby'=>'name');
	
	$categories =$categories = get_categories( $args );


	echo '<form id="'.$this->type.'_form" data-initialForm="" method="post" action="'.$_SERVER['REQUEST_URI'].'" >';
  

	echo '<div data-role="fieldcontain">';
    echo '<fieldset data-role="controlgroup" data-type="horizontal" >';

      $i= 1;
	   foreach($categories as $category) { 
	echo   '<input type="radio" name="radio-choice-'.$I.'" id="radio-choice-'.$i.'" value="'.$category->term_id. '"  />';
    echo   '<label for="radio-choice-'.$i. '">'. $category->name.'</label>';
		$i++;
			}
 echo '</fieldset>';
echo '</div>';
	echo '<textarea type="text" id="'.$this->type.'_textbox" name="'.$this->type.'_textbox" class="tinymce"></textarea>';
   echo '<div data-inline="true">';
 	echo '<input type="hidden" name="post_submitted" id="post_submitted" value="true" />';
    echo '<input type="hidden" id="'.$this->type.'_person_id" name="'.$this->type.'_person_id" value="'.$this->id.'" />';
    echo '<input type="button" value="Save" class="post_submit_button" name="'.$this->type.'" data-inline="true"/>';
	echo '</div>';
    echo '</form>';	
		
		
		
	}
	
	
}

?>