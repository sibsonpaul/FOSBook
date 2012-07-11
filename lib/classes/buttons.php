<?php 



/** 
 * The Class
 */
class Button
{
   
	
    public function __construct($ID)
    {
		
    }

   
    public function navigation_link($action, $name, $query)
    {
			
		$ajaxaction	= "ajax_".$action;
		$title = $name;
		
			
		echo "<a ";
		echo "href='".get_bloginfo('url')."/wp-admin/admin-ajax.php'";
		echo "class='open-dialog  button-primary'";
		echo "data-action='".$ajaxaction."'";
		echo "data-query='".$query."'";
		echo "title='".$title."'";
		echo "accesskey='p'";
		echo ">";
		echo "".$name."";
		echo "</a>";
        
    }


  
}

?>