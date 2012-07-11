<?php


function sibson_get_current_cycle(){

global $wpdb;
$date = date('Y-m-d');


$cycle=$wpdb->get_row("SELECT *, YEAR(date) As year FROM wp_school_dates WHERE wp_school_dates.date = '$date'");

$cycleid = $cycle->cycleid;
$cycleid2 = $cycle->cycleid-1;
$cycleid3 = $cycle->cycleid-2;
$cycleid4 = $cycle->cycleid-3;
$detail = $wpdb->get_results("Select * from wp_cycles where cycleid in ($cycleid, $cycleid2, $cycleid3, $cycleid4) order by cycleid desc");

foreach ($detail as $d){
	
	$cycleArray[] = array('currentId' => $d->cycleid, 'currentName' => $d->Cycle, 'currentYear' => $d->Year );
	
	
}

	return $cycleArray ;


}



function sibson_profile_menu_li($title, $urlVar, $subject, $id, $currentSubject, $type){
	
	if ($currentSubject == $urlVar){

$class = $subject." menu-top";	
$arrow ='<div class="wp-menu-arrow"><div></div></div>';
	
}

else {

$class = $subject;	
}

			echo "<li class='wp-has-submenu wp-menu-open $class '>";
			echo $arrow;	

			 echo '<a  href="index.php?post_type='.$urlVar.'&'.$type.'='.$id.'" data-id="'.$id.'" class="'.$class.'" data-subject="general" data-title="All '.$title.' Comments" >';
			 echo '<span class="icon"><img src="'.SIBSON_IMAGES.'/'.$subject.'.png"></span><span class="name">'.$title.'</span></a></li>';
	
}


function sibson_subject_blurb($subject, $person){
	

	
echo "Sparkle is what makes ";
$person->showFirstName();
echo " unique. This can be photos, video or anything that shows what makes ";
$person->showPronoun();
echo " special.";
	
}

?>