<?php

class FOSLearn{
	

	
	public function __construct(){ // on instantiation the class.
	
	}
	
	public function showWeeksTable($groupid, $weekId){
		
		
	global $wpdb;
	


	echo "<table>";
	echo "<tr>";
	
	echo "<td >";
	echo "<p class='rotate'>";
	echo $weekId;
	echo "</p>";
	echo "</td>";
	echo "<td>";
	echo "<p class='rotate'>";
	echo $weekId;
	echo "</p>";
	echo "</td>";
	echo "<td>";
		echo "<p class='rotate'>";
	echo $weekId;
	echo "</p>";
	echo "</td>";
	echo "<td>";
		echo "<p class='rotate'>";
	echo $weekId;
	echo "</p>";
	echo "</td>";
	
	echo "</tr>";	
	
	
	echo "</table>";	
		
	}
	
	
	
	
}

?>