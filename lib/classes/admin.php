<?php

class Admin{
	
	private $access = false;
	
	public function __construct($ID){
		
	
	
	$userId = $current_user->ID;
	$userdata = get_userdata( $userId );
	
	if ($userdata->user_level>7){
		
	$this->access = true;
		
	}
	
		
}

public function showImage(){
		
		
}

public function showName(){
		
		
}

public function showContent(){
	
	global $wpdb;
	
	$readingTargets = $wpdb->get_results($wpdb->prepare("select count(`wp_assessment_terms`.`assessment_target`) AS `count`,`wp_assessment_terms`.`assessment_link`, `wp_assessment_data`.`assessment_value` as ID , `wp_assessment_terms`.`assessment_target` AS `assessment_target` from  `wp_assessment_data` join `wp_assessment_terms` on  `wp_assessment_data`.`assessment_value` = `wp_assessment_terms`.`ID`    where (`wp_assessment_terms`.`assessment_subject` = 'readingdesc') group by `wp_assessment_data`.`assessment_value` order by count(`wp_assessment_terms`.`assessment_target`) desc"));
	echo "<h2>Reading Targets</h2>";
	echo "<table>";
	foreach ($readingTargets as $reading){
	
		
		
		echo "<tr>";
		echo "<td>";
			echo $reading->count;	
		echo "</td>";
		echo "<td>";
			echo $reading->assessment_target;	
		echo "</td>";
		echo "<td>";
			echo $reading->assessment_link;	
		echo "</td>";
		echo "<td>";
		echo "<a href='?p=";
		echo $reading->assessment_link;
		echo "' data-role='button' rel='external' data-inline='true' data-theme='b'>";
			echo "Edit";
			echo "</a>";
		echo "</td>";
			echo "<td>";
			$tick = check_content_of_page($reading->assessment_link);
			if ($tick == true){
			echo "Yes";	
			}
		echo "</td>";
	
		echo "</tr>";
		
	
		
	}
	echo "</table>";
	
}

public function showLinks(){
	
					sibson_profile_menu_li('Home', 'home', '', $current);
					sibson_profile_menu_li('My Groups', 'groups', '', $current);
					sibson_profile_menu_li('Account', 'account', '', $current);
				
	
}
	
}



?>