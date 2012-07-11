<?php

class Assessment{
	
	private $id="";
	private $subject="";
	private $type="";
	private $currentData ="";
	private $goals= array();
	private $searchSubject="";
	private $user_level="";
	
	
	public function __construct($ID, $subject, $type='individual'){
		
	$current_user = wp_get_current_user();	
	$this->userId = $current_user->ID;

	$userdata = get_userdata( $this->userId );
	$this->user_level =$userdata->user_level;
		
	$this->id=absint($ID);
	if ($subject == "mathsgoals" ){
		$this->subject = "maths";
	}
	else if ($subject == "readinggoals" ){
		$this->subject = "reading";
	}
	else if ($subject == "writinggoals" ){
		$this->subject = "writing";
	}
	else{
	$this->subject= $subject;
	}
	$this->type= $type;
	
if ($this->subject == "teamgoals" || $this->subject == "knowinggoals" || $this->subject == "expectationsgoals" || $this->subject == "learnersgoals" || $this->subject == "creatinggoals" || $this->subject == "environmentgoals" ){
	$this->searchSubject= $this->subject;
}
else {
	
	$this->searchSubject= $this->subject."desc";
}
	
	}
	
public function fetchStandardBand($cycle, $offset, $yearLevel, $subject){
	
	if ($yearLevel == 7){
		
	$myYearLevel = 6 - $offset;	
	}
	else {
	$myYearLevel = $yearLevel - $offset;
	}
	
	$bandArray= array(
			'maths'=>array(
					0=>array(
						1=>array('low'=>6, 'step'=>1), 
						2=>array('low'=>6, 'step'=>1),
						3=>array('low'=>6, 'step'=>1)
					),
					1=>array(
						1=>array('low'=>7, 'step'=>1), 
						2=>array('low'=>7, 'step'=>1),
						3=>array('low'=>8, 'step'=>1)
					),
					2=>array(
						1=>array('low'=>11, 'step'=>1), 
						2=>array('low'=>11, 'step'=>1),
						3=>array('low'=>12, 'step'=>1)
					),
					3=>array(
						1=>array('low'=>12, 'step'=>1), 
						2=>array('low'=>13, 'step'=>1),
						3=>array('low'=>13, 'step'=>1)
					),
					4=>array(
						1=>array('low'=>13, 'step'=>1), 
						2=>array('low'=>14, 'step'=>1),
						3=>array('low'=>14, 'step'=>1)
					),
					5=>array(
						1=>array('low'=>15, 'step'=>1), 
						2=>array('low'=>16, 'step'=>1),
						3=>array('low'=>16, 'step'=>1)
					),
					6=>array(
						1=>array('low'=>16, 'step'=>1), 
						2=>array('low'=>17, 'step'=>1),
						3=>array('low'=>17, 'step'=>1)
					),
					7=>array(
						1=>array('low'=>17, 'step'=>1), 
						2=>array('low'=>17, 'step'=>1),
						3=>array('low'=>18, 'step'=>1)
					)
				),
				'reading'=>array(
					0=>array(
						1=>array('low'=>1.5, 'step'=>1), 
						2=>array('low'=>1.5, 'step'=>1),
						3=>array('low'=>1.5, 'step'=>1)
					),
					1=>array(
						1=>array('low'=>3.5, 'step'=>1), 
						2=>array('low'=>3.5, 'step'=>1),
						3=>array('low'=>4.5, 'step'=>1)
					),
					2=>array(
						1=>array('low'=>4.5, 'step'=>1), 
						2=>array('low'=>5.5, 'step'=>1),
						3=>array('low'=>6.5, 'step'=>1)
					),
					3=>array(
						1=>array('low'=>9, 'step'=>1.5), 
						2=>array('low'=>9, 'step'=>1.5),
						3=>array('low'=>9, 'step'=>1.5)
					),
					4=>array(
						1=>array('low'=>11.5, 'step'=>2), 
						2=>array('low'=>11.5, 'step'=>2),
						3=>array('low'=>11.5, 'step'=>2)
					),
					5=>array(
						1=>array('low'=>12.5, 'step'=>2), 
						2=>array('low'=>12.5, 'step'=>2),
						3=>array('low'=>12.5, 'step'=>2)
					),
					6=>array(
						1=>array('low'=>13.5, 'step'=>2), 
						2=>array('low'=>13.5, 'step'=>2),
						3=>array('low'=>13.5, 'step'=>2)
					),
					7=>array(
						1=>array('low'=>14.5, 'step'=>1), 
						2=>array('low'=>14.5, 'step'=>1),
						3=>array('low'=>14.5, 'step'=>1)
					)
				),
				'writing'=>array(
					0=>array(
						1=>array('low'=>1, 'step'=>1), 
						2=>array('low'=>1, 'step'=>1),
						3=>array('low'=>1, 'step'=>1)
					),
					1=>array(
						1=>array('low'=>2, 'step'=>1), 
						2=>array('low'=>2, 'step'=>1),
						3=>array('low'=>2, 'step'=>1)
					),
					2=>array(
						1=>array('low'=>3, 'step'=>1), 
						2=>array('low'=>3, 'step'=>1),
						3=>array('low'=>3, 'step'=>1)
					),
					3=>array(
						1=>array('low'=>3, 'step'=>2), 
						2=>array('low'=>3.5, 'step'=>2),
						3=>array('low'=>3.5, 'step'=>2)
					),
					4=>array(
						1=>array('low'=>4, 'step'=>2), 
						2=>array('low'=>4.5, 'step'=>2),
						3=>array('low'=>4.5, 'step'=>2)
					),
					5=>array(
						1=>array('low'=>6, 'step'=>2), 
						2=>array('low'=>6.5, 'step'=>2),
						3=>array('low'=>6.5, 'step'=>2)
					),
					6=>array(
						1=>array('low'=>7.5, 'step'=>2), 
						2=>array('low'=>7.5, 'step'=>2),
						3=>array('low'=>7.5, 'step'=>2)
					),
					7=>array(
						1=>array('low'=>8.5, 'step'=>2), 
						2=>array('low'=>8.5, 'step'=>2),
						3=>array('low'=>8.5, 'step'=>2)
					)
					
				)

			);
	
	$low = $bandArray[$subject][$myYearLevel][$cycle]['low'];
	$step = $bandArray[$subject][$myYearLevel][$cycle]['step'];
	
	$band = array ('low'=>$low, 'step' =>$step);
		
	return $band;
		
	}
	
public function standardDescription($yearLevel, $aab){
	
	
	$descArray= array(
			'maths'=>array(
											1=>'<h4>Number and Algebra.</h4><p>In contexts that require them to solve problems or model situations, students will be able to:<ul>
						<li>Apply counting-all strategies</li>
						<li>Continue sequential patterns and number patterns based on ones.</li>
						<li>During this school year, "number" should be the focus of 60–80 percent of mathematics teaching time.</li></ul></p>
						<h4>Geometry and Measurement</h4><p>In contexts that require them to solve problems or model situations, students will be able to:<ul>
						<li>Compare the lengths, areas, volumes or capacities, and weights of objects directly</li>
						<li>Sort objects and shapes by a single feature and describe the feature, using everyday language</li>
						<li>Represent reﬂections and translations by creating patterns</li>
						<li>Describe personal locations and give directions, using everyday language.</li></ul></p>
						<h4>Statistics</h4><p>In contexts that require them to solve problems or model situations, students will be able to:<ul><li>
						Investigate questions by using the statistical enquiry cycle (with support), gathering, displaying, and/or counting category data.</li></ul></p>',
											2=>'<h4>Number and Algebra.</h4><p>In contexts that require them to solve problems or model situations, students will be able to:ul>
						<li>Apply counting-on, counting-back, skip-counting, and simple grouping strategies to combine or partition whole numbers</li>
						<li>Use equal sharing and symmetry to find fractions of sets, shapes, and quantities</li>
						<li>Create and continue sequential patterns by identifying the unit of repeat</li>
						<li>Continue number patterns based on ones, twos, fives, and tens.</li></ul>
						During this school year, "number" should be the focus of 60–80 percent of mathematics teaching time.</p>
						<h4>Geometry and Measurement</h4><p>
						In contexts that require them to solve problems or model situations, students will be able to:<ul>
						<li>Compare the lengths, areas, volumes or capacities, and weights of objects and the durations of events, using self-chosen units of measurement</li>
						<li>Sort objects and shapes by different features and describe the features, using mathematical language</li>
						<li>Represent reflections and translations by creating and describing patterns</li>
						<li>Describe personal locations and give directions, using steps and half- or quarter-turns.</li></ul>
						</p>
						<h4>Statistics</h4><p>
						</p>',
											3=>'<h4>Number and Algebra.</h4><p>
											</p>
						<h4>Geometry and Measurement</h4><p>
						</p>
						<h4>Statistics</h4><p>
						</p>',
											4=>'<h4>Number and Algebra.</h4><p>
											</p>
						<h4>Geometry and Measurement</h4><p>
						</p>
						<h4>Statistics</h4><p>
						</p>',
											5=>'<h4>Number and Algebra.</h4><p>
											</p>
						<h4>Geometry and Measurement</h4><p>
						</p>
						<h4>Statistics</h4><p>
						</p>',
											6=>'<h4>Number and Algebra.</h4><p>
											</p>
						<h4>Geometry and Measurement</h4><p>
						</p>
						<h4>Statistics</h4><p>
						</p>',
											7=>'<h4>Number and Algebra.</h4><p>
											</p>
						<h4>Geometry and Measurement</h4><p>
						</p>
						<h4>Statistics</h4><p>
						</p>'
				),
				'reading'=>array(
					1=>'After one year at school, students will read, respond to, and think critically about fiction and non-fiction texts at the green level of Ready to Read (the core instructional series that supports reading in The New Zealand Curriculum).',
					2=>'After two years at school, students will read, respond to, and think critically about fiction and non-fiction texts at the Turquoise level of Ready to Read (the core instructional series that supports reading in the New Zealand Curriculum).',
					3=>'After three years at school, students will read, respond to, and think critically about fiction and non-fiction texts at the Gold level of Ready to Read (the core instructional series that supports reading in the New Zealand Curriculum).',
					4=>'By the end of year 4, students will read, respond to, and think critically about texts in order to meet the reading demands of the New Zealand Curriculum at level 2. Students will locate and evaluate information and ideas within texts appropriate to this level as they generate and answer questions to meet specific learning purposes across the curriculum.',
					5=>"By the end of year 5, students will read, respond to, and think critically about texts in order to meet the reading demands of The New Zealand Curriculum as they work towards level 3. Students will locate, evaluate, and integrate information and ideas within and across a small range of texts appropriate to this level as they generate and answer questions to meet specific learning purposes across the curriculum. The text and task demands of the curriculum are similar for students in year 5 and year 6. The difference in the standard for year 6 is the students increased accuracy and speed in reading a variety of texts from across the curriculum, their level of control and independence in selecting strategies for using texts to support their learning, and the range of texts they engage with. In particular, by the end of year 6, students will be required to read longer texts more quickly than students in year 5 and to be more effective in selecting different strategies for different reading purposes.",
					6=>"By the end of year 6, students will read, respond to, and think critically about texts in order to meet the reading demands of the New Zealand Curriculum at level 3. Students will locate, evaluate, and integrate information and ideas within and across a small range of texts appropriate to this level as they generate and answer questions to meet specific learning purposes across the curriculum. The text and task demands of the curriculum are similar for students in year 5 and year 6. The difference in the standard for year 6 is the students' increased accuracy and speed in reading a variety of texts from across the curriculum, their level of control and independence in selecting strategies for using texts to support their learning, and the range of texts they engage with. In particular, by the end of year 6, students will be required to read longer texts more quickly than students in year 5 and to be more effective in selecting different strategies for different reading purposes.",
					7=>"By the end of year 7, students will read, respond to, and think critically about texts in order to meet the reading demands of the New Zealand Curriculum as they work towards level 4. Students will locate, evaluate, and synthesise information and ideas within and across a range of texts appropriate to this level as they generate and answer questions to meet specific learning purposes across the curriculum. The text and task demands of the curriculum are similar for students in year 7 and year 8. The difference in the standard for year 8 is the students' increased accuracy and speed in reading a variety of texts from across the curriculum, their level of control and independence in selecting strategies for using texts to support their learning, and the range of texts they engage with. In particular, by the end of year 8, students need to be confidently and deliberately choosing the most appropriate strategies for reading in different learning areas.'"
				),
				'writing'=>array(
					1=>'After one year at school, students will create texts as they learn in a range of contexts across the New Zealand Curriculum within level 1. Students will use their writing to think about, record, and communicate experiences, ideas, and information to meet specific learning purposes across the curriculum.',
					2=>'After two years at school, students will create texts in order to meet the writing demands of the New Zealand Curriculum at level 1. Students will use their writing to think about, record, and communicate experiences, ideas, and information to meet specific learning purposes across the curriculum.',
					3=>'After three years at school, students will create texts in order to meet the writing demands of the New Zealand Curriculum as they work towards level 2. Students will use their writing to think about, record, and communicate experiences, ideas, and information to meet specific learning purposes across the curriculum.',
					4=>'By the end of year 4, students will create texts in order to meet the writing demands of the New Zealand Curriculum at level 2. Students will use their writing to think about, record, and communicate experiences, ideas, and information to meet specific learning purposes across the curriculum.',
					5=>"By the end of year 5, students will create texts in order to meet the writing demands of the New Zealand Curriculum as they work towards level 3. Students will use their writing to think about, record, and communicate experiences, ideas, and information to meet specific learning purposes across the curriculum. The text and task demands of the curriculum are similar for students in year 5 and year 6. The difference in the standard for year 6 is the students' increased accuracy and fluency in writing a variety of texts across the curriculum, their level of control and independence in selecting writing processes and strategies, and the range of texts they write. In particular, by the end of year 6, students will be required to write more complex texts than students in year 5 and to be more effective in selecting different strategies for different writing purposes.",
					6=>"By the end of year 6, students will create texts in order to meet the writing demands of the New Zealand Curriculum at level 3. Students will use their writing to think about, record, and communicate experiences, ideas, and information to meet specific learning purposes across the curriculum. The text and task demands of the curriculum are similar for students in year 5 and year 6. The difference in the standard for year 6 is the students' increased accuracy and fluency in writing a variety of texts across the curriculum, their level of control and independence in selecting writing processes and strategies, and the range of texts they write. In particular, by the end of year 6, students will be required to write more complex texts than students in year 5 and to be more effective in selecting different strategies for different writing purposes.",
					7=>"By the end of year 7, students will create texts in order to meet the writing demands of The New Zealand Curriculum as they work towards level 4. Students will use their writing to think about, record, and communicate experiences, ideas, and information to meet specific learning purposes across the curriculum. The text and task demands of the curriculum are similar for students in year 7 and year 8. The difference in the standard for year 8 is the students' increased accuracy and fluency in writing a variety of texts across the curriculum, their level of control and independence in selecting writing processes and strategies, and the range of texts they write. In particular, by the end of year 8, students need to be confidently and deliberately choosing the most appropriate processes and strategies for writing in different learning areas."
				)

			);
			
	
	return $descArray[$this->subject][$yearLevel];
	
	
	
}
public function get_subject_data_array(){

global $wpdb;
$assessDataSQL =$wpdb->get_results($wpdb->prepare("SELECT assessment_description, assessment_value from wp_assessment_terms where assessment_subject = %s order by assessment_value asc", $this->subject ));
	$i=0;
	foreach ($assessDataSQL as $assessData):
	$i++;
	$yArray[] = "'".$assessData->assessment_description."'";
	endforeach;
	
return $yArray;		
	
}

function showStandardsTable($name, $yearLevel, $image){
	
global $wpdb;	
$currentLevel = $this->currentDataNumber(true);
$levels =$wpdb->get_results("SELECT wp_assessment_terms.ID, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value,
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description, assessment_link
	FROM wp_assessment_terms
	WHERE  wp_assessment_terms.assessment_subject = '$this->subject'");
	
echo "<div class='spacer'></div>";
if ($this->subject =="reading"){
echo "<p>Children work their way through the reading colour whell before moving on to the curriculum levels for reading.The levels highlighted in blue are the where the National Standards sit. The National Standards are not fixed points in the curriculum but are broad and at some year levels the National Standard spans two sub-levels.</p>";	
}
else if ($this->subject =="writing"){
echo "<p>Children work their way through the curriculum levels for writing. The levels highlighted in blue are the where the National Standards sit. The National Standards are not fixed points in the curriculum but are broad and at some year levels the National Standard spans two sub-levels. </p>";	
}
else if ($this->subject =="maths"){
echo "<p>Children work their way through the maths Stages for number, this includes addition, subtraction, mulitiplication and division.The National Standards are not fixed points in the curriculum but are broad and at some year levels the National Standard spans two sub-levels. </p>";	
}	
echo "<ul data-role='listview' data-inset='true'>";

foreach ($levels as $level){
	
	$value = $level->assessment_value;
	$theme = $this->setThemeByLevel($value, $yearLevel);
	if ($theme == "d"){
	echo "<li data-theme='a'";	
	}
	else {
		echo "<li data-theme='b'";
	}
		

if ($currentLevel == $value){
echo " data-icon='false' ";
}
else {
	echo " data-icon='false' ";
}
echo ">";

echo "<a href='#'>";
if ($currentLevel == $value){
echo $image;
}
echo "<h3>";
if ($this->subject == "maths"){
echo "Stage ";
}
else if ($this->subject == "writing"){
echo "Level ";
}
echo $level->assessment_description;
echo "</h3><span class='ui-li-desc'>";
if ($currentLevel == $value){
echo $name." is currently working at this level.";

}
if ($theme == "d"){
	if ($yearLevel == 1 ){
	$statement = $yearLevel." year at school";
	}
	else if ($yearLevel == 2 || $yearLevel == 3){
	$statement = $yearLevel." years at school";
	}
	else {
	$statement = "the end of year".$yearLevel;
	}
echo "<b>The National Standard for ".$statement." is here.</b>";	
	
}
echo "<span>";
echo "</a></li>";


}
echo "</ul>";


	
	
}
	
function get_individual_chart(){

global $wpdb;

$person = new Person($this->id);


	$assessDataSQL =$wpdb->get_results($wpdb->prepare("SELECT assessment_description, assessment_value from wp_assessment_terms where assessment_subject = %s order by ID", $this->subject));
	$i=0;
	foreach ($assessDataSQL as $assessData):
	$i++;
	$yArray[] = "'".$i."':'".$assessData->assessment_description."'";
	endforeach;

if ($this->user_level<7){
$query = " and YEAR(wp_assessment_data.date) > 2011";
}
//Fetch an area of descriptors for the selected chart type (eg levels for writing).

	$personSQL = $wpdb->get_results($wpdb->prepare("SELECT wp_cycles.Cycle, 
	wp_cycles.Year, 
	wp_cycles.cycleid, 
	wp_cycles.cycle AS Cycle, 
	wp_assessment_data.assessment_value, 
	wp_assessment_terms.assessment_description, 
	wp_assessment_data.date
FROM wp_assessment_data RIGHT OUTER JOIN wp_cycles ON wp_assessment_data.cycle = wp_cycles.cycleid
	 INNER JOIN wp_assessment_terms ON wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject AND wp_assessment_terms.assessment_value = wp_assessment_data.assessment_value
WHERE (  wp_assessment_data.person_id = %d  AND wp_assessment_data.area = 'OTJ'  AND wp_assessment_data.assessment_subject = %s AND wp_assessment_data.cycle >12 ) $query
ORDER BY wp_cycles.cycleid asc

 ", $this->id, $this->subject) );
	

foreach ($personSQL as $individual):

$dataArray[]=$individual->assessment_value;

$chartArray[] = array('cycleid' =>$individual->cycleid, 'cycle' =>$individual->Cycle, 'date' => $individual->date, 'value'=>$individual->assessment_value, 'desc'=>$individual->assessment_description);
	
endforeach;

$startCycle = $chartArray[0]['cycleid'];
$cycleyear = date('Y', strtotime($chartArray[0]['date']));
$cycleArray = get_previous_cycle_dates($startCycle);
$startCycle = $cycleArray['id'];
$startCycleNumber = $cycleArray['name'];
$startDate = $cycleArray['start'];

$topOfArray = count($personSQL)-1;
$endCycle = $chartArray[$topOfArray]['cycleid'];
$endcycleyear = date('Y', strtotime($chartArray[$topOfArray]['date']));
$endcycleArray = get_next_cycle_dates($endCycle);
$endCycle = $endcycleArray['id'];
$endCycleNumber = $endcycleArray['name'];
$endDate = $endcycleArray['start'];





array_unshift($chartArray, array('cycleid' =>$startCycle, 'cycle' =>$startCycleNumber, 'date' => $startDate, 'value'=>null, 'desc'=>''));

array_push($chartArray, array('cycleid' =>$endCycle, 'cycle' =>$endCycleNumber, 'date' => $endDate, 'value'=>null, 'desc'=>''));


$max = max($dataArray)+2;



 ?>

<script>
  google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Year');
		data.addColumn('number', 'Below expectation');
		data.addColumn('number', 'End of year expectation');
		data.addColumn('number', 'Above expectation');
		data.addColumn('number', '<?php $person->showFirstName();?>');
		data.addColumn({type:'string', role:'annotation'}); 
     
        data.addRows([
		<?php 
		$numItems = count($personSQL)+2;
		$i = 0;

		foreach ($chartArray as $chart):

	
	$currentYear = date('Y');
			$Year = date('Y', strtotime($chart['date']));
			$offset = $currentYear-$Year;
			$currentYearLevel = $person->showCurrenYearLevelforNatStandards();
			$band = $this->fetchStandardBand( $chart['cycle'], $offset, $currentYearLevel, $this->subject);
			$bandSize = $band['step'];
			$topBandSize = ($max - $bandSize) ;
			$date =  date('F Y', strtotime($chart['date']));
	 if($i+1 == $numItems) {
    echo "[' ".$date."', ".$band['low'].",  ".$bandSize.", ".$topBandSize.", ".$chart['value'].", '".$chart['desc']."']";
  }
  else {
	 echo "[' ".$date."', ".$band['low'].",  ".$bandSize.", ".$topBandSize.", ".$chart['value'].", '".$chart['desc']."'],";
	  
  }

  $i++;
	
endforeach;?>
         
        ]);
		
		var screenWidth = jQuery('#chart_div_<?php echo $this->subject;?>').width();
		var chartWdith = screenWidth/100 *80;
	
        var options = {
          width: chartWdith, height: 400,
          title: "<?php echo $person->returnFirstName();?>'s <?php echo ucfirst($this->subject);?> Progress",
		  'backgroundColor': 'transparent',
		   vAxis: {maxValue: <?php echo $max;?>, minValue: 0, textPosition: 'none'}, 
		   colors:['#FDFCDC', '#3db855', '#6495ED', '#000'],
		   seriesType: "area",
		   isStacked: 'true',
           series: {3: {type: "line", pointSize: 5}},
		  tooltip: {trigger: 'none'},
			
		   
		   legend: {position: 'top'}
		   
        };
	
		

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div_<?php echo $this->subject;?>'));
        chart.draw(data, options);
		
      }
</script>

<?php }

public function get_group_chart($type){

global $wpdb;
$cycleArray = sibson_get_current_cycle(); // Based on today's date build an array of the current cycle and the previous 3 cycles.
$idArray = $this->get_id_array(); // Get an array of ids for all the people in this group.

$cycle = $cycleArray[0]['currentId'];
$cycle2 = $cycleArray[1]['currentId'];
$cycle3 = $cycleArray[2]['currentId'];
$cycle4 = $cycleArray[3]['currentId'];

$thisYear= $cycleArray[0]['currentYear'];
$Year2= $cycleArray[1]['currentYear'];
$Year3 = $cycleArray[2]['currentYear'];
$Year4 = $cycleArray[3]['currentYear'];
$thisCycle = $cycleArray[0]['currentName'];
$CycleName2 =  $cycleArray[1]['currentName'];
$CycleName3 = $cycleArray[2]['currentName'];
$CycleName4 = $cycleArray[3]['currentName'];

$minMaxData =  $this->fetch_min_max_data($idArray, $type);
$startValue = $minMaxData['low'];
$endValue = $minMaxData['high'];

$assessDataSQL =$wpdb->get_results($wpdb->prepare("SELECT assessment_description, assessment_value from wp_assessment_terms where assessment_subject = %s and assessment_value between $startValue and $endValue order by ID", $type));


foreach ($assessDataSQL as $assessData):
	$dataArray[$assessData->assessment_value]=0;
	$catArray[$assessData->assessment_value] = "'".$assessData->assessment_description."'";
	endforeach;

	

$dataArray1 = $this->fetch_chart_data($dataArray, $idArray, $type, $cycle);
$dataArray2 =  $this->fetch_chart_data($dataArray, $idArray, $type, $cycle2);
$dataArray3 =  $this->fetch_chart_data($dataArray, $idArray, $type, $cycle3);

 ?>


<script>
  google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Year');
		data.addColumn('number', 'Below Expectation');
		data.addColumn('number', 'At expectation');
		data.addColumn('number', 'Above expectation');
		data.addColumn('number', '');
		data.addColumn({type:'string', role:'annotation'}); 
     
        data.addRows([
		<?php 
		$numItems = count($personSQL);
		$i = 0;

		foreach ($personSQL as $individual):
			$currentYear = date('Y');
			$Year = date('Y', strtotime($individual->date));
			$offset = $currentYear-$Year;
			$band = $person->fetchStandardBand( $individual->Cycle, $offset, $currentYearLevel, $this->subject);
			$bandSize = $band['step'];
			$topBandSize = ($max - $bandSize) ;
			$date =  date('F Y', strtotime($individual->date));

	
	
	 if($i+1 == $numItems) {
    echo "[' ".$date."', ".$band['low'].",  ".$bandSize.", ".$topBandSize.", ".$individual->assessment_value.", '".$individual->assessment_description."']";
  }
  else {
	 echo "[' ".$date."', ".$band['low'].",  ".$bandSize.", ".$topBandSize.", ".$individual->assessment_value.", '".$individual->assessment_description."'], "; 
	  
  }
  $i++;
	
endforeach;?>
         
        ]);
		

        var options = {
          width: 800, height: 400,
          title: '<?php echo ucfirst($this->subject);?> Progress',
		  'backgroundColor': 'transparent',
		   vAxis: {maxValue: <?php echo $max;?>}, 
		   colors:['#E29994', '#65ac72', '#AF7672', '#296232'],
		   seriesType: "area",
		   isStacked: 'true',
           series: {3: {type: "line", pointSize: 5}},
		    vAxis:{textPosition:'none'},
			tooltip: {trigger: 'none'}
		   
		   
        };
	
		

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div_<?php echo $this->subject;?>'));
        chart.draw(data, options);
		
      }
</script>

<?php 

}

public function get_indicatorbuttons($currentLevel){
	global $wpdb;
	$search = $this->searchSubject;
	
	
if  ($this->type=="individual"){
	
	
	$assessDataSQL =$wpdb->get_results($wpdb->prepare("SELECT sum(wp_assessment_terms.assessment_weighting) as personTotal, wp_assessment_terms.assessment_value, wp_assessment_terms.assessment_measure, wp_assessment_data.area
FROM wp_assessment_terms INNER JOIN wp_assessment_data ON wp_assessment_terms.ID = wp_assessment_data.assessment_value AND wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject
where  wp_assessment_data.person_id = %d and wp_assessment_data.assessment_subject = '$search' and wp_assessment_data.area = 'secure' Group by wp_assessment_terms.assessment_value order by  wp_assessment_terms.assessment_value  ", $this->id ));

	$levelTotals =$wpdb->get_results("SELECT sum(wp_assessment_terms.assessment_weighting) as Total, wp_assessment_terms.assessment_type, wp_assessment_terms.assessment_value, wp_assessment_terms.assessment_short,  wp_assessment_terms.assessment_measure
FROM wp_assessment_terms
where wp_assessment_terms.assessment_subject = '$search'
group by wp_assessment_terms.assessment_value

");

foreach ($assessDataSQL as $assessData){
	
	$dataArray[$assessData->assessment_value] = $assessData->personTotal;
	
}
	echo "<div class='spacer'>&nbsp;</div>";
echo "<div data-role='controlgroup' data-type='horizontal' data-theme='b' >"; 
foreach ($levelTotals as $total){
	
	$completed = $dataArray[$total->assessment_value];
	$levelTotal = $total->Total;
	$percentComplete = round(($completed/$levelTotal)*100, 0);
	
	echo "<a href='#' class='loadIndicatorsButton' data-theme='b' data-icon='arrow-d' data-role='button' data-inline='true' data-action='ajax_get_indicator_list' data-subject='".$this->subject."' data-id='".$this->id."' data-level='".$total->assessment_value."' >";
	if ($this->subject=='reading'){
	echo $total->assessment_type;
	}
	else if ($this->subject=='maths'){
	echo $total->assessment_measure." ".$total->assessment_value." - ".$percentComplete."%";	
	}
	else{
	echo $total->assessment_measure." ".$total->assessment_short;	
	}
	
	
	echo "</a>";

}
echo '<p>You can reduce scrolling by selecting an area below:</p>';
sibson_fetch_filter_list($this->subject);



echo "</div>";
	echo "<div class='spacer'>&nbsp;</div>";
	echo  '<div id="custom_'.$this->subject.'">';
	
	 $this->get_indicatorlist($currentLevel);
	
	echo '</div>';
	
	}


else if ($this->type=="group"){
	
	$levelTotals =$wpdb->get_results("SELECT sum(wp_assessment_terms.assessment_weighting) as Total, wp_assessment_terms.assessment_type, wp_assessment_terms.assessment_value, wp_assessment_terms.assessment_short,  wp_assessment_terms.assessment_measure
FROM wp_assessment_terms
where wp_assessment_terms.assessment_subject = '$search'
group by wp_assessment_terms.assessment_value
");

	echo "<div class='spacer'>&nbsp;</div>";
echo "<div data-role='controlgroup' data-type='horizontal' data-theme='b' >"; 

foreach ($levelTotals as $total){
	echo "<a href='#' class='loadIndicatorsButton button-secondary' data-icon='arrow-d' data-theme='b' data-role='button' data-inline='true' data-action='ajax_get_group_indicator_list' data-subject='".$this->subject."' data-id='".$this->id."' data-level='".$total->assessment_value."' >";
	if ($this->subject=='reading'){
	echo $total->assessment_type;
	}
	else if ($this->subject=='maths'){
	echo $total->assessment_measure." ".$total->assessment_value." - ".$percentComplete."%";	
	}
	else{
	echo $total->assessment_measure." ".$total->assessment_short;	
	}
	
	echo "</a>";
	


}

echo "</div>";echo "<div class='spacer'>&nbsp;</div>";
	echo  '<div id="custom_'.$this->subject.'">';
	echo "</div>";
	echo "<div class='spacer'>&nbsp;</div>";
}
else if ($this->type=="staffgroup"){
	
	
echo "<div class='spacer'>&nbsp;</div>";
	echo  '<div id="custom_'.$this->subject.'">';
	 $this->get_staff_group_indicatorlist($currentLevel);
	
	echo '</div>';
	echo "<div class='spacer'>&nbsp;</div>";
}
	
}

public function showAssessmentData($dob){
	
	global $wpdb;
	$individualData =$wpdb->get_results($wpdb->prepare("SELECT  count(wp_assessment_data.ID) as count, 
	wp_assessment_data.date, 
	wp_assessment_data.user_id, 
	wp_assessment_data.cycle, 
	wp_assessment_data.yeargroup, 
	wp_assessment_data.area, 
sum(wp_assessment_data.area) as sum, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_terms.assessment_value = wp_assessment_data.assessment_value AND wp_assessment_data.assessment_subject = wp_assessment_terms.assessment_subject
WHERE wp_assessment_data.person_id = %d AND wp_assessment_data.assessment_subject NOT IN ( 'mathsdesc' , 'maths' , 'writingdesc' , 'writing' , 'readingdesc' , 'reading' )
group by wp_assessment_data.assessment_subject, wp_assessment_data.date order by date desc", $this->id ));

foreach ($individualData as $data){
	
	$assess_id = $data->ID;
	$date = date('F j, Y', strtotime($data->date));
	$user_person_id = get_user_meta($data->user_id, 'person_id', true); 
	
	$user_person = new Person($user_person_id);
	if($data->assessment_subject=="ESOL Listening" || $data->assessment_subject=="ESOL Speaking" || $data->assessment_subject=="ESOL Writing" || $data->assessment_subject=="ESOL Reading"){
		
		$count = 3*$data->count;
		$content =  "Score of ".$data->sum." out of ".$count;
		
		$content = "<a href='?accessId=".$this->id."&fullscreen=true&pageType=ESOL_AF'  data-role='button' data-inline='true' data-theme='b' data- data-dialogtype='Printout' data-id='".$this->id."' data-title='Printout' data-ajax='false'>";
	$content .= "Printout";									
	$content .= "</a>";	
	}
	
	
	else if($data->assessment_subject=="6 year net" || $data->assessment_subject=="5 year net" ){
		
			$typeData =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_data.person_id, 
				wp_assessment_data.date, 
				wp_assessment_data.area,
				wp_assessment_data.assessment_value,
			wp_assessment_terms.assessment_type
			FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_subject = wp_assessment_terms.assessment_subject AND wp_assessment_data.assessment_value = wp_assessment_terms.assessment_value
			where wp_assessment_terms.assessment_subject = '6 year net' and person_id = %d", $this->id  ));
			foreach ($typeData as $type){
				$Area = $type->assessment_value; 
				
				$date1 = new DateTime($type->date);
				$date2 = new DateTime($dob);
				$interval = $date1->diff($date2);
				$age =$interval->y .".". $interval->m;

				$Score = $type->area;
				$stanine = $wpdb->get_var("select stanine from wp_stanines where ($age between LowAge and HighAge) and $Score >= LowScore and $Score <= HighScore and AreaId = $Area");
				$content .= "<p><strong>".$type->assessment_type."</strong></p>";
				$content .=  "<p>Raw Score of ".$type->area."</p>";
				$content .=	"<p><strong>Stanine: ".$stanine."</strong></p>";
			}
	}
	else {
	$content = "Assessed as working at ".$data->assessment_type;
	}
	$assessmentArray[$assess_id] = array(
										'id' => $assess_id,
										'title'  => $date,
										'show_icon'=>true,
										'icon_image' => $data->assessment_subject,
										'icon_name' =>$data->assessment_subject,
										'icon_desc' =>$data->assessment_subject,
										'the_content' =>$content,
										'badge'=>$user_person->returnBadge(true, false),
										'classlist' => '', 
										'status_message' => '',
										'link' => '',
										'buttons' => $buttons,
										);
										
							
											 
		basic_display_template ($assessmentArray[$assess_id]);
	
}
	
	
}

// Get indictar list for an individual.
public function get_indicatorlist($area, $type){

	global $wpdb;
	
	$indicatorlistSQL =$wpdb->get_results("SELECT wp_assessment_terms.ID, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value,
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description,
	wp_assessment_terms.assessment_target, assessment_link
	FROM wp_assessment_terms
	WHERE wp_assessment_terms.assessment_value = $area AND wp_assessment_terms.assessment_subject = '$this->searchSubject' order by assessment_type desc");


foreach ($indicatorlistSQL as $indicatorList){

$idArray[] = $indicatorList->ID;

$indicators[] = array('ID'=>$indicatorList->ID, 'desc'=>$indicatorList->assessment_description, 'type' =>$indicatorList->assessment_type, 'target' =>$indicatorList->assessment_target, 'link' =>$indicatorList->assessment_link);
	
}



	$assessDataSQL =$wpdb->get_results("SELECT wp_assessment_data.ID,
	wp_assessment_data.person_id, 
	wp_assessment_data.assessment_subject, 
	wp_assessment_data.assessment_value,
	DATE_FORMAT(wp_assessment_data.date, '%M') As month,
	DATE_FORMAT(wp_assessment_data.date, '%d') As day, 
	wp_assessment_data.user_id,
	wp_assessment_data.area
FROM wp_assessment_data
where wp_assessment_data.person_id = $this->id and
	wp_assessment_data.assessment_subject = '$this->searchSubject'
 and wp_assessment_data.assessment_value in (".implode(',',$idArray).") ");

	
	foreach ($assessDataSQL as $data){
		$userFirst = get_user_meta($data->user_id, 'first_name', true);
		$userLast = get_user_meta($data->user_id, 'last_name', true);
		$userName = $userFirst." ".$userLast;
		$dataArray[$data->assessment_value]= array('area' =>$data->area, 'ID'=> $data->ID, 'the_date' => array('month'=> $data->month, 'day'=>$data->day), 'user' => $userName);
		
	}
	echo "<div class='spacer'>&nbsp;</div>";
	
	if ($this->subject == "teamgoals" || $this->subject == "knowinggoals" || $this->subject == "expectationsgoals" || $this->subject == "learnersgoals" || $this->subject == "creatinggoals" || $this->subject == "environmentgoals" || $this->subject == "reading" || $this->subject == "writing" ){
		
		
	}
	
	else {
	
		$securePercent = $this->currentPercent($area, 'secure');
		$developingPercent  = $this->currentPercent($area, 'developing');
		$notAssessedPercent = 100 - $developingPercent - $securePercent;
		
		echo "<div class='progress'>";
		if ($securePercent>0){
			$secureWidth = $securePercent-1;
		echo "<span class='secure ui-btn-up-d ui-btn-corner-left ui-shadow' style='width: {$secureWidth}%'>{$securePercent}%</span>";
		}
		if ($developingPercent>0){
			$developingWidth = $developingPercent-1;
		echo "<span class='developing ui-btn-up-f ui-shadow' style='width: {$developingWidth}%'>{$developingPercent}%</span>";
		}
		if ($notAssessedPercent>0){
			$notAssessedWidth = $notAssessedPercent-1;
		echo "<span class='noyetassessed ui-btn-up-b ui-shadow ui-btn-corner-right ' style='width: {$notAssessedWidth}%'>{$notAssessedPercent}%</span>";
		}
		
		echo "</div>";
		
	}
	echo    "<dl id='_post_list' class='post_list'>";
for ($i=0; $i< count($indicators); $i++){ // start for loop indicators.
	
	$type = $indicators[$i]['type'];
	$link =  $indicators[$i]['link'];
	$class = $dataArray[$indicators[$i]['ID']]['area'];
	
	$dateUpdated = $dataArray[$indicators[$i]['ID']]['the_date'];
	
	$userUpdated = $dataArray[$indicators[$i]['ID']]['user'];
	$theme = "a";
			if ($class==''){
			$class = 'notassessed';	
			$checked="";
			$theme = "d";
			}
			else if ($class=="secure"){
	
			$checked = "checked='checked'";
			$theme = "b";
			}
			else if ($class=="developing"){
	
			$checked = "";
			$theme = "e";
			}
	$indicatorId = $indicators[$i]['ID'];
	
	$dataId = $dataArray[$indicators[$i]['ID']]['ID'];
	
				if ($indicatorId==''){
					
				$indicatorId = $indicators[$i]['ID'];	
				}
			if ($this->subject == "teamgoals" || $this->subject == "knowinggoals" || $this->subject == "expectationsgoals" || $this->subject == "learnersgoals" || $this->subject == "creatinggoals" || $this->subject == "environmentgoals" ){
					
				$contentText = ucfirst($indicators[$i]['desc']);
				
				
				$button ='<fieldset data-role="controlgroup" data-type="horizontal" data-theme="b" >';
									
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-1" class="radio" value="na" ';
					if($class == "na"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-1">Not applicable to me</label>';	
				
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-2" class="radio" value="pd" ';
					if($class == "pd"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-2">Need PD.</label>';	
				
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-3" class="radio" value="developing" ';
					if($class == "developing"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-3">Goal.</label>';	
				
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-4" class="radio" value="secure" ';
					if($class == "secure"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-4">All good.</label>';					
										
				$button .= '</fieldset>';
				
				$button .= "<a href='#dialog' class='loaddialog' data-icon='arrow-u'  data-role='button' data-rel='dialog' data-theme='b' data-title='".$contentText."' data-dialogtype='post' data-inline='true' data-indicatortype='".$this->searchSubject."' data-postid='".$link."'>Read more...</a>";
			
		
				
			}
			else {
				
				$contentText = ucfirst($indicators[$i]['desc']);	
				
				$button ='<fieldset data-role="controlgroup" data-type="horizontal" data-theme="b" >';
									
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-1" class="radio" value="notassessed" ';
					if($class == "notassessed"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-1">Not yet assessed.</label>';	
				
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-2" class="radio" value="developing" ';
					if($class == "developing"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-2">Goal.</label>';	
				
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-3" class="radio" value="secure" ';
					if($class == "secure"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-3">Secure.</label>';					
										
				$button .= '</fieldset>';
				$button .= '<div data-role="controlgroup" data-type="horizontal" data-theme="b">';
				$button .= "<a href='?accessId=".$this->id."&p=".$link."' data-ajax='false' data-icon='arrow-u' data-role='button' data-rel='dialog' data-theme='b' data-title='".$contentText."' data-dialogtype='post' data-inline='true' data-indicatortype='".$this->searchSubject."' data-postid='".$link."'>Parent help page...</a>";
					
				$button .= "<a href='?accessId=".$this->id."&teachingId=".$indicatorId."&pageType=teaching' data-ajax='false' data-icon='arrow-u' data-role='button' data-rel='dialog' data-theme='b' data-title='".$contentText."' data-dialogtype='post' data-inline='true' data-indicatortype='".$this->searchSubject."' data-postid='".$link."'>Teaching ideas</a>";	
			$button .= '</div>';
			
				
			
		
			}
	
	$content = array(
										'id' => $indicatorId,
										'title'  => '',
										'show_icon' => 'true',
										'icon_image' => $type,
										'icon_name' => $type,
										'icon_desc' => '',
										'the_content' => $contentText,
										'badge'=> '',
										'classlist' => $type,
										'status_message' => '',
										'link' => '', 
										'buttons'=>	$button	
		
		
		
		);
			basic_display_template ($content);
		
}// end for loop indicators

	

		

										
	
	
	echo "<div class='spacer'>&nbsp;</div>";
	

}

// Get indictar list for a group.
public function get_group_indicatorlist($level){

	global $wpdb;

	$indicatorlistSQL =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_terms.ID, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value,
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description, 
	assessment_link
	FROM wp_assessment_terms
	WHERE wp_assessment_terms.assessment_value = %s AND wp_assessment_terms.assessment_subject = '$this->searchSubject' order by assessment_type desc", $level));

foreach ($indicatorlistSQL as $indicatorList){

$indicators[] = array('ID'=>$indicatorList->ID, 'desc'=>$indicatorList->assessment_description, 'type' =>$indicatorList->assessment_type, 'link' =>$indicatorList->assessment_link);


}


$group = new Group($this->id);
$idArray = $group->get_id_array();
$size = count($idArray);
	$developingDataSQL =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_terms.ID, 
	count(wp_assessment_data.area) AS count, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value,
	wp_assessment_data.area
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.ID
WHERE wp_assessment_data.person_id IN (".implode(',', $idArray).") AND (wp_assessment_terms.assessment_value = %s and wp_assessment_terms.assessment_subject ='$this->searchSubject' and (wp_assessment_data.area = 'developing' or wp_assessment_data.area = 'secure'))
GROUP BY wp_assessment_data.assessment_value,  wp_assessment_data.area ", $level));

	
	foreach ($developingDataSQL as $develop){
		
		if($develop->area =="developing"){
		$developingArray[$develop->ID]= $develop->count;
		}
		else {
		$secureArray[$develop->ID]= $develop->count;
		}
	}

	echo "<div class='spacer'>&nbsp;</div>";
echo    "<dl id='_post_list' class='post_list'>";
	for ($i=0; $i< count($indicators); $i++){
	
	$type = $indicators[$i]['type'];
	$link =  $indicators[$i]['link'];
		
	$indicatorId = $indicators[$i]['ID'];
	if ($secureArray[$indicatorId]){
	$secureNumber = $secureArray[$indicatorId];
	}
	else {
		$secureNumber = 0;
	}
	if ($developingArray[$indicatorId]){
	$developingNumber = $developingArray[$indicatorId];
	}
	else {
		$developingNumber = 0;
	}
	
	$notassessedNumber = $size - $secureNumber - $developingNumber;
	
	$securePercent = round($secureNumber/$size*100, 0);
	$developingPercent = round($developingNumber/$size*100, 0);
	$notAssessedPercent=  round($notassessedNumber/$size*100, 0);
	 $contentText =	$indicators[$i]['desc'];

	
	
	$buttons =	"<div class='progress'>";
		if ($securePercent>0){
			$secureWidth = $securePercent-1;
			$buttons .=  "<span class='secureGroup ui-btn-up-d ui-btn-corner-left ui-shadow' style='width: {$secureWidth}%'>{$securePercent}%</span>";
		}
		if ($developingPercent>0){
			$developingWidth = $developingPercent-1;
			$buttons .=  "<span class='developingGroup ui-btn-up-f ui-shadow' style='width: {$developingWidth}%'>{$developingPercent}%</span>";
		}
		if ($notAssessedPercent>0){
			$notAssessedWidth = $notAssessedPercent-1;
			$buttons .=  "<span class='noyetassessedGroup ui-btn-up-b ui-shadow ui-btn-corner-right ' style='width: {$notAssessedWidth}%'>{$notAssessedPercent}%</span>";
		}
		
		$buttons .= "</div><div class='spacer'>&nbsp;</div>";
		 	$buttons .=  '<div data-role="controlgroup" data-type="horizontal" data-theme="b"><a href="#dialog" data-role="button" data-inline="true" data-theme="b" data-id="'.$this->id.'" data-indicatorid="'.$indicatorId.'" data-rel="dialog"  data-icon="arrow-u" class="indicator_group_detail">Show the children</a>';
	$buttons .= "<a href='#dialog' data-role='button' data-inline='true' data-theme='b'  data-id='{$this->id}'  data-postid='{$link}'  data-indicatorid='{$indicatorId}'  data-title='{$contentText}' data-dialogtype='post' data-rel='dialog' class='loaddialog'>Read more</a></div>";
	
	
		$content = array(
										'id' => $indicatorId,
										'title'  => '',
										'show_icon' => true,
										'icon_image' => $type,
										'icon_name' => $type,
										'icon_desc' => '',
										'the_content' => $contentText,
										'badge'=> '',
										'classlist' => '',
										'status_message' => '',
										'link' => '', 
										'buttons'=>	$buttons	
		
		
		
		);
	
	
	

			basic_display_template ($content);
	
		
	}

	echo "<div class='spacer'>&nbsp;</div>";

}

// Get indictar list for a staff group.
public function get_staff_group_indicatorlist($level){

	global $wpdb;

	$indicatorlistSQL =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_terms.ID, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value,
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description, 
	assessment_link
	FROM wp_assessment_terms
	WHERE wp_assessment_terms.assessment_value = %s AND wp_assessment_terms.assessment_subject = '$this->searchSubject' order by assessment_type desc", $level));

foreach ($indicatorlistSQL as $indicatorList){

$indicators[] = array('ID'=>$indicatorList->ID, 'desc'=>$indicatorList->assessment_description, 'type' =>$indicatorList->assessment_type, 'link' =>$indicatorList->assessment_link);


}


$group = new Group($this->id);
$idArray = $group->get_id_array();
$size = count($idArray);
	
	$developingDataSQL =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_terms.ID, 
	count(wp_assessment_data.area) AS count, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value,
	wp_assessment_data.area
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.ID
WHERE wp_assessment_data.person_id IN (".implode(',', $idArray).") AND (wp_assessment_terms.assessment_value = %s and wp_assessment_terms.assessment_subject ='$this->searchSubject' and (wp_assessment_data.area = 'developing' or wp_assessment_data.area = 'secure' or wp_assessment_data.area = 'na' or wp_assessment_data.area = 'pd'))
GROUP BY wp_assessment_data.assessment_value,  wp_assessment_data.area ", $level));

	foreach ($developingDataSQL as $develop){
		
		if($develop->area =="developing"){
		$developingArray[$develop->ID]= $develop->count;
		}
		else if ($develop->area =="pd"){
			$pdArray[$develop->ID]= $develop->count;
		}
		else if ($develop->area =="na"){
			$naArray[$develop->ID]= $develop->count;
		}
		
		else {
		$secureArray[$develop->ID]= $develop->count;
		}
	}

	echo "<div class='spacer'>&nbsp;</div>";
echo    "<dl id='_post_list' class='post_list'>";
	for ($i=0; $i< count($indicators); $i++){
	
	$type = $indicators[$i]['type'];
	$link =  $indicators[$i]['link'];
		
	$indicatorId = $indicators[$i]['ID'];
	if ($secureArray[$indicatorId]){
	$secureNumber = $secureArray[$indicatorId];
	}
	else {
		$secureNumber = 0;
	}
	if ($developingArray[$indicatorId]){
	$developingNumber = $developingArray[$indicatorId];
	}
	else {
		$developingNumber = 0;
	}
	if ($pdArray[$indicatorId]){
	$pdNumber = $pdArray[$indicatorId];
	}
	else {
		$pdNumber = 0;
	}
	if ($naArray[$indicatorId]){
	$naNumber = $naArray[$indicatorId];
	}
	else {
		$naNumber = 0;
	}
	
	$notassessedNumber = $size - $secureNumber - $developingNumber-$pdNumber -$naNumber;

	$securePercent = round($secureNumber/$size*100, 0);
	$developingPercent = round($developingNumber/$size*100, 0);
	$naPercent = round($naNumber/$size*100, 0);
	$pdPercent = round($pdNumber/$size*100, 0);
	$notAssessedPercent=  round($notassessedNumber/$size*100, 0);
	 $contentText =	$indicators[$i]['desc'];
	$buttons =  "<a href='#dialog' data-role='button' data-inline='true' data-theme='b'  data-id='{$this->id}' data-indicatorid='{$indicatorId}' data-rel='dialog' class='indicator_group_detail'>Show the people</a>";
	$buttons .=	"<div class='progress'>";
		if ($securePercent>0){
			$secureWidth = $securePercent-1;
			$buttons .=  "<span class='secureGroup ui-btn-up-d ui-btn-corner-left ui-shadow' style='width: {$secureWidth}%'>{$securePercent}%</span>";
		}
		if ($developingPercent>0){
			$developingWidth = $developingPercent-1;
			$buttons .=  "<span class='developingGroup ui-btn-up-f ui-shadow' style='width: {$developingWidth}%'>{$developingPercent}%</span>";
		}
		if ($naPercent>0){
			$naWidth = $naPercent-1;
			$buttons .=  "<span class='naGroup ui-btn-up-b ui-shadow' style='width: {$naWidth}%'>{$naPercent}%</span>";
		}
		if ($pdPercent>0){
			$pdWidth = $pdPercent-1;
			$buttons .=  "<span class='pdGroup ui-btn-up-e ui-shadow' style='width: {$pdWidth}%'>{$pdPercent}%</span>";
		}
		if ($notAssessedPercent>0){
			$notAssessedWidth = $notAssessedPercent-1;
			$buttons .=  "<span class='noyetassessedGroup ui-btn-up-b ui-shadow ui-btn-corner-right ' style='width: {$notAssessedWidth}%'>{$notAssessedPercent}%</span>";
		}
		
		$buttons .= "</div><div class='spacer'>&nbsp;</div>";
		 
	
		$content = array(
										'id' => $indicatorId,
										'title'  => '',
										'show_icon' => true,
										'icon_image' => $type,
										'icon_name' => $type,
										'icon_desc' => '',
										'the_content' => $contentText,
										'badge'=> '',
										'classlist' => '',
										'status_message' => '',
										'link' => '', 
										'buttons'=>	$buttons	
		
		
		
		);
	
	
	

			basic_display_template ($content);
	
		
	}

	echo "<div class='spacer'>&nbsp;</div>";

}
public function showmeasure(){

if ($this->subject =="maths"){
echo "Stage ";	
}
else {
echo "Level ";
	
}
	
}

public function return_years_data($yearLevel, $name, $pronoun){
	
	$year = date(Y);
		global $wpdb;
			$Data=$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_data.ID, wp_assessment_data.date, wp_assessment_terms.assessment_short as Level, wp_assessment_terms.assessment_description as description, wp_assessment_terms.assessment_type as type, wp_assessment_data.assessment_value as value, wp_assessment_data.user_id
			FROM wp_assessment_terms left JOIN wp_assessment_data ON wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject AND wp_assessment_terms.assessment_value = wp_assessment_data.assessment_value where wp_assessment_terms.assessment_subject = '$this->subject' and person_id = %d and wp_assessment_data.area = 'OTJ' and YEAR(wp_assessment_data.date) = %d", $this->id, $year));
		
		$contentArray = array();
	foreach ($Data as $d){
		$user = $d->user_id;
		$user_person_id = get_the_author_meta('person_id', $user);
		$user_person = new Person($user_person_id);
		$value = $d->assessment_value;
		if ($this->subject=="maths"){
		$levelType = 'stage';
		}
		else {
		$levelType = 'level';
		}
		$the_content =  'Assessed as working at '.$levelType." ".$d->description.' of the curriuculum for '.$this->subject.'.'.$this->shortStandardStatement($yearLevel, $value, $name, $pronoun, $group = false);
		$content = array (	
					'date' =>$d->date,
							'id' => $d->ID,	
								'title'  => date("F d, Y", strtotime($d->date)),
										'show_icon'=>true,
										'icon_image' =>$this->subject,
										'icon_name' =>$this->subject,
										'icon_desc' =>$this->subject,
										'the_content' =>$the_content,
										'badge'=>$user_person->returnBadge(true, false),
										'classlist' => '', 
										'status_message' => '',
										'link' => '',
										'buttons' => '',
										);
										
		
		array_push($contentArray, $content);
		
	}
	
	
	return $contentArray;
	
}

public function count_years_goals(){
	
		global $wpdb;
		$year = date(Y);
		$Goals =$wpdb->get_var($wpdb->prepare("SELECT count(wp_assessment_data.ID)
	
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.ID
WHERE wp_assessment_data.person_id = %d AND YEAR(wp_assessment_data.date) = $year and wp_assessment_terms.assessment_subject = '$this->searchSubject' AND wp_assessment_data.area = 'developing' 
group by wp_assessment_terms.assessment_subject", $this->id));

if ($Goals == 1){
return "<a href='#dialog' data-rel='dialog' class='loaddialog' data-id='".$this->id."' data-pagetype='".$this->subject."' data-dialogtype='showgoals' data-role='button' data-theme='b'>".$Goals." current goal</a>";
}
else if ($Goals >1){
	
return "<a href='#dialog' data-rel='dialog' class='loaddialog' data-id='".$this->id."' data-pagetype='".$this->subject."' data-dialogtype='showgoals' data-role='button' data-theme='b'>".$Goals." current goals</a>";
}
else {
return "No current goals";
	
}
	
	
}

public function return_years_goals($name){
	
		global $wpdb;
		$year = date(Y);
		$Goals =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_data.ID, 
	wp_assessment_data.person_id, 
	wp_assessment_data.date, 
	wp_assessment_data.user_id, 
	wp_assessment_terms.ID as termId,
	wp_assessment_terms.assessment_target,
	wp_assessment_terms.assessment_subject,
	wp_assessment_terms.assessment_link, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description, 
	wp_assessment_terms.assessment_value
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.ID
WHERE wp_assessment_data.person_id = %d AND YEAR(wp_assessment_data.date) = $year and wp_assessment_terms.assessment_subject = '$this->searchSubject' AND wp_assessment_data.area = 'developing'", $this->id));
	$goalList = "In order to progress further in ".$this->subject.", ".$name." will:";
	$goalList .= "<ul>";
	
 	foreach ($Goals as $Goal){
		$user = $Goal->user_id;
		$user_person_id = get_the_author_meta('person_id', $user);
		$user_person = new Person($user_person_id);
		if ($this->user_level>7){
				$secureId = $this->id;
			}
			else {
				$secureId = salt_n_pepper($this->id);
			}
		$link = check_content_of_page($Goal->assessment_link);
			
				$goalList .= '<li>'.$Goal->assessment_target;
				if ($link == true){
				$goalList .= '<a href="?accessId='.$secureId.'&p='.$Goal->assessment_link.'" data-rel="dialog"  data-icon="up-arrow" data-id="'.$secureId.'" rel="external" data-theme="b" data-inline="true" data-role="button">Read More</a>';
				}
				if ($this->user_level>7){
				$goalList .= '<a href="?accessId='.$secureId.'&teachingId='.$Goal->termId.'&pageType=teaching" data-rel="dialog"  data-icon="up-arrow" data-id="'.$secureId.'" rel="external" data-theme="b" data-inline="true" data-role="button">Teaching Ideas</a>';
				}
				$goalList .= '</li>';				
			
	
	}
$goalList .= "</ul>";
	
	$content = array (	
					'date' =>'',
							'id' => '',	
								'title'  => "Current ".ucfirst($this->subject).' Goals.',
										'show_icon'=>true,
										'icon_image' =>$this->subject,
										'icon_name' =>$this->subject,
										'icon_desc' =>$this->subject,
										'the_content' =>$goalList,
										'badge'=> '',
										'classlist' => '', 
										'status_message' => '',
										'link' => '',
										'buttons' => '',
										);
	
	
	
	echo return_basic_display_template($content);
	


	
}

// GOALS SPREADSHEET

public function groupGoalsSpreadsheet($personidArray){
	
	global $wpdb;
	
	


sibson_show_indicator_key();

$cycleArray = sibson_get_current_cycle();

$score = $this->minimumScore($personidArray, $cycleArray[1]['currentId']);
		
		echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
		
					if($this->subject=="maths"){ $mtheme = "f";} else { $mtheme = "b";};
					echo '<a href="?type=Group&pageType=mathsgoalSpread&fullscreen=true&accessId='.$this->id.'" data-ajax="false"  data-theme="'.$mtheme.'" data-role="button">Maths</a>';
					if($this->subject=="reading"){ $rtheme = "f";} else { $rtheme = "b";};
					echo '<a href="?type=Group&pageType=readinggoalSpread&fullscreen=true&accessId='.$this->id.'" data-ajax="false"  data-role="button" data-theme="'.$rtheme.'">Reading</a>';
					if($this->subject=="writing"){ $wtheme = "f";} else { $wtheme = "b";};
					echo '<a href="?type=Group&pageType=writinggoalSpread&fullscreen=true&accessId='.$this->id.'" data-ajax="false"  data-role="button" data-theme="'.$wtheme.'">Writing</a>';
					echo "</div>";



if ($this->subject=="maths"){


$low = round($score->min/3,0);
$high = round($score->max/3,0);

for ($count = $low; $count<=$high;$count++){
	$levelArray[] = $count;
	
}



	$levelList = array(
	
	1=>array('level'=>1, 'type' =>'Stage 1', 'current'=>''),
	2=>array('level'=>2, 'type' =>'Stage 2', 'current'=>''),
	3=>array('level'=>3, 'type' =>'Stage 3', 'current'=>''),
	4=>array('level'=>4, 'type' =>'Stage 4', 'current'=>''),
	5=>array('level'=>5, 'type' =>'Stage 5', 'current'=>''),
	6=>array('level'=>6, 'type' =>'Stage 6', 'current'=>''),
	7=>array('level'=>7, 'type' =>'Stage 7', 'current'=>''),
	8=>array('level'=>8, 'type' =>'Stage 8', 'current'=>'')
	
	);
	
		
}
else if ($this->subject=="writing"){	
	
$low = round($score->min/2,0);
$high = round($score->max/2,0);



for ($count = $low; $count<=$high;$count++){
	$levelArray[] = $count;
	
}


	$levelList = array(
	
	1=>array('level'=>1, 'type' =>'Level 1b', 'current'=>''),
	2=>array('level'=>2, 'type' =>'Level 1p', 'current'=>''),
	3=>array('level'=>3, 'type' =>'Level 1a', 'current'=>''),
	4=>array('level'=>4, 'type' =>'Level 2', 'current'=>''),
	5=>array('level'=>5, 'type' =>'Level 3', 'current'=>''),
	6=>array('level'=>6, 'type' =>'Level 4', 'current'=>''),
	
	);
	
	
}

else if ($this->subject=="reading"){	
	


$low = round($score->min,0);
$high = round($score->max,0);

if ($low >9){

$low = round(($low/3)+7, 0);	
}
if ($high >9){

$high = round(($high/3)+7, 0);	
}



for ($count = $low; $count<=$high;$count++){
	$levelArray[] = $count;
	
}


	$levelList = array(
	
	1=>array('level'=>1, 'type' =>'Magenta', 'current'=>''), 
	2=>array('level'=>2, 'type' =>'Red', 'current'=>''),
	3=>array('level'=>3, 'type' =>'Yellow', 'current'=>''),
	4=>array('level'=>4, 'type' =>'Dark Blue', 'current'=>''),
	5=>array('level'=>5, 'type' =>'Green', 'current'=>''),
	6=>array('level'=>6, 'type' =>'Orange', 'current'=>''),
	7=>array('level'=>7, 'type' =>'Light Blue', 'current'=>''),
	8=>array('level'=>8, 'type' =>'Purple', 'current'=>''),
	9=>array('level'=>9, 'type' =>'Gold', 'current'=>''),
	10=>array('level'=>10, 'type' =>'Level 2', 'current'=>''),
	11=>array('level'=>11, 'type' =>'Level 3', 'current'=>''),
	12=>array('level'=>12, 'type' =>'Level 4', 'current'=>''),
	
	
	);
	
	
	
}

	
	$indicatorlistSQL =$wpdb->get_results("SELECT wp_assessment_terms.ID, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value,
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description,
	wp_assessment_terms.assessment_target, assessment_link
	FROM wp_assessment_terms
	WHERE wp_assessment_terms.assessment_subject = '$this->searchSubject' and wp_assessment_terms.assessment_value between $low and $high  order by assessment_value desc");
	$lowCount =0;
	$currentCount =0;
	$highCount=0;
	
	foreach ($indicatorlistSQL as $indicatorList){
	
	if ($indicatorList->assessment_value == $low){
	$lowCount ++;
	}
	if ($indicatorList->assessment_value == $low+1){
	$currentCount ++;
	}
	if ($indicatorList->assessment_value == $low+2){
	$highCount ++;
	}
	
	
	$idArray[] = $indicatorList->ID;
	
	$indicators[$indicatorList->assessment_value][] = array('ID'=>$indicatorList->ID, 'desc'=>$indicatorList->assessment_description, 'type' =>$indicatorList->assessment_type, 'target' =>$indicatorList->assessment_target, 'link' =>$indicatorList->assessment_link);
		
	}

	
	$max = max($lowCount, $currentCount, $highCount);

	$assessDataSQL =$wpdb->get_results("SELECT wp_assessment_data.ID,
	count(case when area='secure' then 1 else NULL end) as secure_count, 
	count(case when area='developing' then 1 else NULL end) as developing_count, 
	wp_assessment_data.assessment_subject, 
	wp_assessment_data.assessment_value,
	DATE_FORMAT(wp_assessment_data.date, '%M') As month,
	DATE_FORMAT(wp_assessment_data.date, '%d') As day, 
	wp_assessment_data.user_id
FROM wp_assessment_data
where wp_assessment_data.person_id in (". implode (",",$personidArray).")  and
	wp_assessment_data.assessment_subject = '$this->searchSubject' and area in ('developing', 'secure')
 and wp_assessment_data.assessment_value in (".implode(',',$idArray).") group by wp_assessment_data.assessment_value ");

	
	foreach ($assessDataSQL as $data){
		
		$dataArray[$data->assessment_value]= array('area' =>$data->area, 'ID'=> $data->ID, 'developing_count' =>  $data->developing_count, 'secure_count'=> $data->secure_count);
		
	}
	
	$groupTotal = count($personidArray);
	
	echo "<table>";
	
	echo "<thead class='labels'>";
	echo "<tr>";	
	
		foreach ($levelList as $l){
			if ($l['level']<$low){
				
				
			}
			else if ($l['level']>$high){
				
				
			}
			else{ 
			echo "<td>";
			
			echo "<div class='".$l['current']."'>";
			echo "<span>";
			echo $l['type'];
			
			echo "</span>";
			echo "</div>";
			echo "</td>";
			}
		}
	
	echo "</tr>";
	echo "</thead>";
	
	echo "<tfoot>";
	echo "<tr>";
	foreach ($levelList as $l){
			if ($l['level']<$low){
				
				
			}
			else if ($l['level']>$high){
				
				
			}
			else{ 
			echo "<td>";
			echo "<div class='".$l['current']."'>";
			echo "<span>";
			echo $l['type'];
			echo "</span>";
			echo "</div>";
			echo "</td>";
			}
		}

	echo "</tr>";
	echo "</tfoot>";
	
	
	echo "<tbody>";
	for ($i=0; $i<$max; $i++){ 
	
	echo "<tr >";
	
	
		for ($c=$low; $c<=$high;$c++){
			
			if ($indicators[$c][$i]['ID']>0){
					echo "<td>";
					echo '<a href="#dialog" data-id="'.$this->id.'" data-indicatorid="'.$indicators[$c][$i]['ID'].'" data-rel="dialog" class="indicator_group_detail">';
					$devPercent = round($dataArray[$indicators[$c][$i]['ID']]['developing_count']/$groupTotal*100,0);
					$securePercent = round($dataArray[$indicators[$c][$i]['ID']]['secure_count']/$groupTotal*100,0);
					$devPercentEnd = $devPercent+10;
					$securePercentEnd = $securePercent+10;
					echo "<div style='";
					echo "background-image: -webkit-linear-gradient(top left, rgba(244,231,191,1) ".$devPercent."%, rgba(238,238,238,0) ".$devPercentEnd."% );
	text-align:left;
	 -moz-border-radius: 10px;
 -webkit-border-radius: 10px; 
 border-radius: 10px;";
					echo "'>";
					
					echo "<div style='";
					echo "background-image: -webkit-linear-gradient(bottom right,  rgba(61,184,85,1) ".$securePercent."%, rgba(238,238,238,0) ".$securePercentEnd."% );

	 -moz-border-radius: 10px;
 -webkit-border-radius: 10px; 
 border-radius: 10px;";
					echo "'>";
					echo "<span class=' ";
							
							
							
					echo "' style=";
					
					echo " data-personid='".$this->id."' data-id='".$indicators[$c][$i]['ID']."'>";
					echo $indicators[$c][$i]['desc'];
					echo "<p><div style='float: left'>".$devPercent."%</div>";
					echo "<div style='float: right'>".$securePercent."%</div></p>";
					echo "</span>";		
					echo "</div>";
					echo "</div>";
					echo "</a>";
					echo "</td>";
					
			}
			else {
				echo "<td>";
				echo "</td>";	
			}
		}
	echo "</tr>";
	
	}
		echo "</tbody>";
		echo "</table>";
	
	
}

public function goalsSpreadsheet(){
	
	global $wpdb;
	
	$currentData = $this->currentDataNumber(true, true);
	$current = $currentData['value'];
	$cycle = sibson_get_cycle_detail_from_id($currentData['cycle']);
	$cycleName=$cycle['name'];
	$cycleYear=$cycle['year'];
	$low = $current-1;
		if ($low<1){
		$low=0;	
		}

echo "<a href='?accessId=".$this->id."' data-ajax='false' >Home</a>";
echo "<p>";

echo "Click on a goal to change the colour." ;

	echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b" class="page_buttons">';
		
					if($this->subject=="maths"){ $mtheme = "f";} else { $mtheme = "b";};
					echo '<a href="?pageType=mathsgoalSpread&fullscreen=true&accessId='.$this->id.'" data-ajax="false"  data-theme="'.$mtheme.'" data-role="button">Maths</a>';
					if($this->subject=="reading"){ $rtheme = "f";} else { $rtheme = "b";};
					echo '<a href="?pageType=readinggoalSpread&fullscreen=true&accessId='.$this->id.'" data-ajax="false"  data-role="button" data-theme="'.$rtheme.'">Reading</a>';
					if($this->subject=="writing"){ $wtheme = "f";} else { $wtheme = "b";};
					echo '<a href="?pageType=writinggoalSpread&fullscreen=true&accessId='.$this->id.'" data-ajax="false"  data-role="button" data-theme="'.$wtheme.'">Writing</a>';
					echo "</div>";

sibson_show_indicator_key();

echo "</p>";
	


if ($this->subject=="maths"){
$current = round($currentData['value']/3,0);	

	$low = $current-1;
		if ($low<1){
		$low=0;	
		}	
$levelArray = array($low, $current, $current+1);// Set and array of levels to query the db. Limit this to four based on the low and high above.

	$levelList = array(
	
	1=>array('level'=>1, 'type' =>'Stage 1', 'current'=>''),
	2=>array('level'=>2, 'type' =>'Stage 2', 'current'=>''),
	3=>array('level'=>3, 'type' =>'Stage 3', 'current'=>''),
	4=>array('level'=>4, 'type' =>'Stage 4', 'current'=>''),
	5=>array('level'=>5, 'type' =>'Stage 5', 'current'=>''),
	6=>array('level'=>6, 'type' =>'Stage 6', 'current'=>''),
	7=>array('level'=>7, 'type' =>'Stage 7', 'current'=>''),
	8=>array('level'=>8, 'type' =>'Stage 8', 'current'=>'')
	
	);
	$high = $low+3;
	
$levelList[$current]['current']= "Current Stage"; 	
}
else if ($this->subject=="writing"){	
	
	if ($current>3){
		$current = round($currentData['value']/3,0)+2;		
	}


	$low = $current-1;
		if ($low<1){
		$low=1;	
		}	
		
	if ($current ==1){
		$levelArray = array($current, $current+1, $current+2);// Set and array of levels to query the db. Limit this to four based on the low and high above.
	}
	else if($current>3){	
	$levelArray = array($current-1, $current, $current+1);// Set and array of levels to query the db. Limit this to four based on the low and high above.
	}
	else {
		$levelArray = array($low, $current, $current+1);// Set and array of levels to query the db. Limit this to four based on the low and high above.
	}
	$levelList = array(
	
	1=>array('level'=>1, 'type' =>'Level 1b', 'current'=>''),
	2=>array('level'=>2, 'type' =>'Level 1p', 'current'=>''),
	3=>array('level'=>3, 'type' =>'Level 1a', 'current'=>''),
	4=>array('level'=>4, 'type' =>'Level 2', 'current'=>''),
	5=>array('level'=>5, 'type' =>'Level 3', 'current'=>''),
	6=>array('level'=>6, 'type' =>'Level 4', 'current'=>''),
	
	);
	
	$high = $low+3;
	
	$levelList[$current]['current']= "Current Level"; 	
	
}

else if ($this->subject=="reading"){	
	
	
	if($current>3){	
		if ($current>9){
			$current = round(($currentData['value']-9)/3, 0)+9;	
		
			$low = $current-1;
				if ($low<1){
				$low=1;	
				}	
			$levelArray = array($low, $current, $current+1);// Set and array of levels to query the db. Limit this to four based on the low and high above.	
			}
			
			else {
			$levelArray = array($low, $current, $current+1);// Set and array of levels to query the db. Limit this to four based on the low and high above.
			}
	}
	else {
	$levelArray = array($low, $current, $current+1);// Set and array of levels to query the db. Limit this to four based on the low and high above.
	}
	$levelList = array(
	
	1=>array('level'=>1, 'type' =>'Magenta', 'current'=>''), 
	2=>array('level'=>2, 'type' =>'Red', 'current'=>''),
	3=>array('level'=>3, 'type' =>'Yellow', 'current'=>''),
	4=>array('level'=>4, 'type' =>'Dark Blue', 'current'=>''),
	5=>array('level'=>5, 'type' =>'Green', 'current'=>''),
	6=>array('level'=>6, 'type' =>'Orange', 'current'=>''),
	7=>array('level'=>7, 'type' =>'Light Blue', 'current'=>''),
	8=>array('level'=>8, 'type' =>'Purple', 'current'=>''),
	9=>array('level'=>9, 'type' =>'Gold', 'current'=>''),
	10=>array('level'=>10, 'type' =>'Level 2', 'current'=>''),
	11=>array('level'=>11, 'type' =>'Level 3', 'current'=>''),
	12=>array('level'=>12, 'type' =>'Level 4', 'current'=>''),
	
	
	);
	
	
	$start = $low-1;
	if ($start<0){
	$start=0;	
	}
$high = $low+3;

$levelList[$current]['current']= "Current Level"; 	
}


	
	$indicatorlistSQL =$wpdb->get_results("SELECT wp_assessment_terms.ID, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value,
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description,
	wp_assessment_terms.assessment_target, assessment_link
	FROM wp_assessment_terms
	WHERE wp_assessment_terms.assessment_subject = '$this->searchSubject' and wp_assessment_terms.assessment_value in (".implode (",",$levelArray).") order by assessment_value desc");
	$lowCount =0;
	$currentCount =0;
	$highCount=0;
	
	foreach ($indicatorlistSQL as $indicatorList){
	
	if ($indicatorList->assessment_value == $low){
	$lowCount ++;
	}
	if ($indicatorList->assessment_value == $current){
	$currentCount ++;
	}
	if ($indicatorList->assessment_value == $current+1){
	$highCount ++;
	}
	
	
	$idArray[] = $indicatorList->ID;
	
	$indicators[$indicatorList->assessment_value][] = array('ID'=>$indicatorList->ID, 'desc'=>$indicatorList->assessment_description, 'type' =>$indicatorList->assessment_type, 'target' =>$indicatorList->assessment_target, 'link' =>$indicatorList->assessment_link);
		
	}
	
	$max = max($lowCount, $currentCount, $highCount);

	$assessDataSQL =$wpdb->get_results("SELECT wp_assessment_data.ID,
	wp_assessment_data.person_id, 
	wp_assessment_data.assessment_subject, 
	wp_assessment_data.assessment_value,
	DATE_FORMAT(wp_assessment_data.date, '%M') As month,
	DATE_FORMAT(wp_assessment_data.date, '%d') As day, 
	wp_assessment_data.user_id,
	wp_assessment_data.area
FROM wp_assessment_data
where wp_assessment_data.person_id = $this->id and
	wp_assessment_data.assessment_subject = '$this->searchSubject'
 and wp_assessment_data.assessment_value in (".implode(',',$idArray).") ");

	
	foreach ($assessDataSQL as $data){
		
		$dataArray[$data->assessment_value]= array('area' =>$data->area, 'ID'=> $data->ID, 'the_date' => array('month'=> $data->month, 'day'=>$data->day), 'user' => $userName);
		
	}
	
	
	echo "<table>";
	
	echo "<thead class='labels'>";
	echo "<tr>";	
	
		foreach ($levelList as $l){
			if ($l['level']<$low){
				
				
			}
			else if ($l['level']>$low+2){
				
				
			}
			else{ 
			echo "<td>";
			
			echo "<div class='".$l['current']."'>";
			echo "<span>";
			echo $l['type'];
			
			if ( $l['current']=="Current Level" || $l['current']=="Current Stage"){
			echo " (".$l['current'].", Cycle ".$cycleName.", ".$cycleYear.")";
			}
			echo "</span>";
			echo "</div>";
			echo "</td>";
			}
		}
	
	echo "</tr>";
	echo "</thead>";
	
	echo "<tfoot>";
	echo "<tr>";
	foreach ($levelList as $l){
			if ($l['level']<$low){
				
				
			}
			else if ($l['level']>$low+2){
				
				
			}
			else{ 
			echo "<td>";
			echo "<div class='".$l['current']."'>";
			echo "<span>";
			echo $l['type'];
			echo "</span>";
			echo "</div>";
			echo "</td>";
			}
		}

	echo "</tr>";
	echo "</tfoot>";
	
	
	echo "<tbody>";
	for ($i=0; $i<$max; $i++){ 
	if ($i % 2){
	$class = "light";	
	}
	else {
	$class = "even";	
	}
	
	
	echo "<tr >";
	
	
		for ($c=$low; $c<$high;$c++){
			
			if ($indicators[$c][$i]['ID']>0){
					echo "<td>";
					echo "<div class='".$levelList[$c]['current']."'>";
					echo "<span class='".$class." ";
							if ($dataArray[$indicators[$c][$i]['ID']]['area']=="developing"){
							echo "ui-btn-up-f ";
							echo $dataArray[$indicators[$c][$i]['ID']]['area'];
							}
					
							else if ($dataArray[$indicators[$c][$i]['ID']]['area']=="secure"){
							echo "ui-btn-up-d ";
							echo $dataArray[$indicators[$c][$i]['ID']]['area'];
							}
							else {
							echo "notassessed ui-btn-up-b";	
							};
					echo "' data-personid='".$this->id."' data-id='".$indicators[$c][$i]['ID']."'>";
					echo $indicators[$c][$i]['desc'];		
					echo "</span>";		
					echo "</div>";
					echo "</td>";
			}
			else {
				echo "<td>";
				echo "</td>";	
			}
		}
	echo "</tr>";
	
	}
		echo "</tbody>";
		echo "</table>";
	
	
}

//CURRENT DATA. 

public function minimumScore($idArray, $cycle){

global $wpdb;
	
	$data = $wpdb->get_row("select min(assessment_value) as min, max(assessment_value) as max from wp_assessment_data where wp_assessment_data.person_id in (".implode(",",$idArray).") and assessment_subject= '$this->subject' and cycle =$cycle ");
	
	return $data;
	
}

public function currentData($return){
			global $wpdb;
			$Data=$wpdb->get_row($wpdb->prepare("SELECT wp_assessment_terms.assessment_short as Level, wp_assessment_terms.assessment_description as description, wp_assessment_terms.assessment_type as type, wp_assessment_data.assessment_value as value
			FROM wp_assessment_terms left JOIN wp_assessment_data ON wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject AND wp_assessment_terms.assessment_value = wp_assessment_data.assessment_value where wp_assessment_terms.assessment_subject = '$this->subject' and person_id = %d and wp_assessment_data.area = 'OTJ' order by cycle desc", $this->id));
		
	if ($Data){	
		if ($return == true){
		return  "<span class='assessment' id='update_".$this->id."'>".$Data->type."</span>";
		}
		else {
			echo  "<span class='assessment' id='update_".$this->id."'>".$Data->description."</span>";
		}
	}
	else {
		echo  "<span class='assessment' id='update_".$this->id."'></span>";
	}
		
	}
	
public function returnCurrentData(){
			global $wpdb;
			$Data=$wpdb->get_row($wpdb->prepare("SELECT wp_assessment_terms.assessment_short as Level, wp_assessment_terms.assessment_description as description, wp_assessment_terms.assessment_type as type, wp_assessment_data.assessment_value as value
			FROM wp_assessment_terms left JOIN wp_assessment_data ON wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject AND wp_assessment_terms.assessment_value = wp_assessment_data.assessment_value where wp_assessment_terms.assessment_subject = '$this->subject' and person_id = %d and wp_assessment_data.area = 'OTJ' order by cycle desc", $this->id));
		
	
		return  $Data->description;
		
		
	}	

public function currentPlainData(){
			global $wpdb;
			$Data=$wpdb->get_row($wpdb->prepare("SELECT wp_assessment_terms.assessment_short as Level, wp_assessment_terms.assessment_description as description, wp_assessment_terms.assessment_type as type, wp_assessment_data.assessment_value as value
			FROM wp_assessment_terms left JOIN wp_assessment_data ON wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject AND wp_assessment_terms.assessment_value = wp_assessment_data.assessment_value where wp_assessment_terms.assessment_subject = '$this->subject' and person_id = %d and wp_assessment_data.area = 'OTJ' order by cycle desc", $this->id));
		
	
		return  $Data->description;
		
		
	}	
	
	
	public function fetchDataByCycle($cycle){
		
		global $wpdb;
				$Data=$wpdb->get_row($wpdb->prepare("SELECT wp_assessment_terms.assessment_short as Level, wp_assessment_terms.assessment_description as description, wp_assessment_terms.assessment_type as type, wp_assessment_data.assessment_value as value
			FROM wp_assessment_terms left JOIN wp_assessment_data ON wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject AND wp_assessment_terms.assessment_value = wp_assessment_data.assessment_value where wp_assessment_terms.assessment_subject = '$this->subject' and person_id = %d and wp_assessment_data.area = 'OTJ' and cycle = $cycle", $this->id));
		
	
	$dataArray = array('value'=>$Data->value , 'desc'=>$Data->description);
		return  $dataArray;
		
		
	}
	
	public function fetchGoalsByCycle($cycle){
		
		global $wpdb;
			$Data=$wpdb->get_var($wpdb->prepare("SELECT ID
			FROM wp_assessment_data where assessment_subject = '$this->subject' and person_id = %d and wp_assessment_data.area = 'developing' and cycle = $cycle", $this->id));
	

	return $Data;
		
		
	}
	
	public function findCycleLastYear(){
		
	global $wpdb;	
		$currentYear = date('Y');
		$lastYear = $currentYear-1;
		
		$cycle =$wpdb->get_var("SELECT cycleid from wp_cycles where Cycle =3 and Year = $lastYear");
		
		return $cycle;
		
	}
	
	// TARGET SETTING
	
	public function returnTargetStatement($yearLevel){
		
		$target = $this->showTarget($yearLevel);
		$lastYear =date('Y')-1;
		$cycle = sibson_get_current_cycle();
		
		$cycleName = $cycle[0]['currentName'];
		if ($target['lastYearData']=="no"){
			echo "There is no OTJ for the end of ".$lastYear." so no target has been set.";
		}
		else {
			echo "My target for the end of this year ";
			if ($cycleName == 3){
			echo "was ";
				
			}
			else {
			echo "is ";	
			}
			
			echo $target['targetDesc'];
			
			echo " (This target is based on the OTJ made at the end of ".$lastYear.")";
		}
		
	}
	
	public function annualReport($yearLevel){
	
		$cycle =$this->findCycleLastYear();
		
		$data = $this->fetchDataByCycle($cycle);
		
		$target =  $data['value'];
		$targetDesc = $this->fetchDescription($target);
		$targetCycle = $cycle;
		$standardBand = $this->fetchStandardBand(3, 0, $yearLevel-1, $this->subject);
		
	if ($data['value']>0){
			
		if ($target>0 && $standardBand['low']>0){
			$minimum = ceil($standardBand['low']);
			if ($target< $standardBand['low']){
				if ($target < $standardBand['low']-3){
				$result = "wellbelow";
				
				
				}
				else {
			
				$result = "below";
			
				}
			}
			else if ($target>=$standardBand['low'] && $target<= ($standardBand['low']+$standardBand['step'])){
				$result = "at";	
				
			}
			else if ( $target> ($standardBand['low']+$standardBand['step'])){
						if ( $target> ($standardBand['low']+$standardBand['step']+2)){
						$result = "well above";	
						
					}
					else {
						$result = "above";	
						
					}
			}
			 
		}
		}
		else {
		$lastYearData ="no";	
		}
	
		$targetArray = array (
		'result'=>$result,
		'lastYearValue'=> $data['value']
		
		);
		
		return $targetArray;
		
	}
	
	public function showTarget($yearLevel){
		
		$cycle =$this->findCycleLastYear();
		
		$data = $this->fetchDataByCycle($cycle);
		
	if ($data['value']>0){
		$target =  $data['value']+2;
		$targetDesc = $this->fetchDescription($target);
		$targetCycle = $cycle+3;
		$standardBand = $this->fetchStandardBand(3, 0, $yearLevel, $this->subject);
		$currentValue = $this->currentDataNumber(true);
		
		$targetMeetsStandard = "no";
		
		if ($target>0 && $standardBand['low']>0){
			$minimum = ceil($standardBand['low']);
			if ($target< $standardBand['low']){
				if ($target < $standardBand['low']-3){
				$result = "wellbelow";
				
				$gap = $minimum- $currentValue;
				}
				else {
			
				$result = "below";
				$gap = $minimum- $currentValue;	
				}
			}
			else if ($target>=$standardBand['low'] && $target<= ($standardBand['low']+$standardBand['step'])){
				$result = "at";	
				$targetMeetsStandard = "yes";
			}
			else if ( $target> ($standardBand['low']+$standardBand['step'])){
						if ( $target> ($standardBand['low']+$standardBand['step']+2)){
						$result = "well above";	
						$targetMeetsStandard = "yes";
					}
					else {
						$result = "above";	
						$targetMeetsStandard = "yes";
					}
			}
			 
		}
		}
		else {
		$lastYearData ="no";	
		}
	
		$targetArray = array (
		'lastYearData' =>$lastYearData,
		'lastYearCycle' => $cycle,
		'lastYearValue'=> $data['value'],
		'lastYearDesc'=> $data['desc'],
		'targetValue'  =>$target,
		'targetDesc' => $targetDesc, 
		'targetMeetsStandard' =>$targetMeetsStandard,
		'targetStandard' =>$result,
		'gap'=>$gap
		
		);
		
		return $targetArray;
		
		
	}
	
	public function fetchDescription($target){
		
		global $wpdb;
				$Data=$wpdb->get_var($wpdb->prepare("SELECT wp_assessment_terms.assessment_description
			FROM wp_assessment_terms where wp_assessment_terms.assessment_subject = '$this->subject' and assessment_value = $target"));
			
	return $Data;
		
	}
	
	
	public function progressRate($yearGroup){
	
	// Depending on the subject, set a variable for the target for the end of year six.
		
	switch ($this->subject)	{
	
	case "reading";
	$target = 14;	// Equates to level 3P.
	break;
	case "writing";
	$target = 8;	// Equates to level 3P.
	break;
	case "maths";
	$target = 18;	// Equates to Stage 6A.
	break;
	
	}
	
	// Now find the current data for this person.
	
	$dataArray = $this->currentDataNumber(true, true);
	$lastDataCycle = $dataArray['cycle'];
	$cycle = sibson_get_cycle_from_id($lastDataCycle);
	$value = $dataArray['value'];
	$cyclesLeftThisYear = 3-$cycle;
	$cyclesLeftbyYearGroup = (6-$yearGroup)*3; // number of years left at the school is 6 minus the current year level. Multipled by the number of cycles in a year which is 3.
	$subLevelsToTarget = $target-$value;
	$totalCyclesRemaining = $cyclesLeftbyYearGroup+$cyclesLeftThisYear;
	$progressRate = $subLevelsToTarget/ $totalCyclesRemaining;
	
	return $progressRate;
	
	
	
		
	}
	
	
	
	// INDICATORS
	
public function indicatorProgressBar($indicatorType){
	
	global $wpdb;
			$counts=$wpdb->get_results($wpdb->prepare("select count(ID) as count, area from wp_assessment_data where person_id = %d and assessment_subject = '$indicatorType' group by area", $this->id));
			
	if ($counts){
			
			foreach ($counts as $count){
				
				
				$progressArray[$count->area] = $count->count;
				
			
			}
		$total = $progressArray['developing']+$progressArray['secure']+$progressArray['pd']+$progressArray['na'];
	
	$progress =	"<div class='progress'>";	
	if	($progressArray['na']>0){
			$na = round(100*($progressArray['na']/$total)-1, 0);
			$progress .=  "<span class='secureGroup ui-btn-up-b ui-shadow ui-btn-corner-left' style='width: {$na}%'><a href='#dialog' class='loaddialog' data-classtype='".$indicatorType."' data-dialogtype='staffgoals' data-pagetype='na' data-title='Not applicable to me.' data-id='".$this->id."' data-classtype='Person' data-rel='dialog'>{$na}%</a></span>";
	}
	
	if	($progressArray['pd']>0){
			$pd = round(100*($progressArray['pd']/$total)-1, 0);
			
			if (!$progressArray['na']){
				$corner ='ui-btn-corner-left';
			}
			$progress .=  "<span class='secureGroup ui-btn-up-e ui-shadow ".$corner."' style='width: {$pd}%'><a href='#dialog' class='loaddialog' data-dialogtype='staffgoals'  data-classtype='".$indicatorType."' data-pagetype='pd' data-title='My PD requests' data-id='".$this->id."' data-classtype='Person' data-rel='dialog'>{$pd}%</a></span>";
	}
	if	($progressArray['developing']>0){
			$developing = round(100*($progressArray['developing']/$total)-1, 0);
			
			if (!$progressArray['na'] && !$progressArray['pd']){
				$corner2 ='ui-btn-corner-left';
			}
			$progress .=  "<span class='secureGroup ui-btn-up-f ui-shadow ".$corner2." ' style='width: {$developing}%'><a href='#dialog' class='loaddialog' data-dialogtype='staffgoals'  data-classtype='".$indicatorType."' data-pagetype='developing' data-title='My goals' data-id='".$this->id."' data-classtype='Person' data-rel='dialog'>{$developing}%</a></span>";
	}

	if	($progressArray['secure']>0){
			$secure = round(100*($progressArray['secure']/$total)-1, 0);
			$progress .=  "<span class='secureGroup ui-btn-up-d ui-shadow ui-btn-corner-right' style='width: {$secure}%'><a href='#dialog' class='loaddialog' data-dialogtype='staffgoals'  data-classtype='".$indicatorType."' data-pagetype='secure' data-title='All good.' data-id='".$this->id."' data-classtype='Person' data-rel='dialog'>{$secure}%</a></span>";
	}

		$progress .= "</div><div class='spacer'>&nbsp;</div>";	
	
	return $progress;

	}
}
	

public function currentDataNumber($return, $array=false){
			global $wpdb;
			$Data=$wpdb->get_row($wpdb->prepare("SELECT wp_assessment_terms.assessment_short as Level, wp_assessment_terms.assessment_description as description, wp_assessment_terms.assessment_type as type, wp_assessment_data.assessment_value as value, wp_assessment_data.cycle as cycle
			FROM wp_assessment_terms left JOIN wp_assessment_data ON wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject AND wp_assessment_terms.assessment_value = wp_assessment_data.assessment_value where wp_assessment_terms.assessment_subject = '$this->subject' and person_id = %d and wp_assessment_data.area = 'OTJ' order by cycle desc", $this->id));
		if ($array == true){
			$dataArray = array('value'=>$Data->value, 'cycle'=>$Data->cycle, 'level' =>$Data->type);
			return $dataArray;
		}else {
			if ($return == true){
			return  $Data->value;
			}
			else {
				echo  $Data->value;
			}
		}
	}
		
		
	
	public function currentGoalsForm(){
		
		global $wpdb;
			
		 echo "<form data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$this->id."&pageType=".$this->subject."&formType=goal_setting' id='goal_setting' method='post' >";		
									  sibson_form_nonce('goal_setting');	
									 echo '<input type="hidden" id="personId" name="personId" value="'.$this->id.'" />';
									  echo '<input type="hidden" id="assessment_subject" name="assessment_subject" value="'.$this->subject.'" />';
									 $year = date('Y');
								$Goals =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_data.ID, 
								wp_assessment_data.person_id, 
								wp_assessment_data.date, 
								wp_assessment_data.user_id, 
								wp_assessment_data.area, 
								wp_assessment_terms.ID as indicatorId,
								wp_assessment_terms.assessment_target,
								wp_assessment_terms.assessment_subject,
								wp_assessment_terms.assessment_link, 
								wp_assessment_terms.assessment_type, 
								wp_assessment_terms.assessment_description, 
								wp_assessment_terms.assessment_value
							FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.ID
							WHERE wp_assessment_data.person_id = %d AND YEAR(wp_assessment_data.date) = $year and wp_assessment_terms.assessment_subject = '$this->searchSubject' AND wp_assessment_data.area = 'developing'", $this->id));
							
							
								foreach ($Goals as $Goal){
									
								$contentText = ucfirst($Goal->assessment_description);	
								$class = $Goal->area;
								$indicatorId =  $Goal->indicatorId;
								$type = $this->subject;
								
				$button ='<fieldset data-role="controlgroup" data-type="horizontal" data-theme="b" >';
									
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-1" class="radio" value="notassessed" ';
					if($class == "notassessed"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-1">Not yet assessed.</label>';	
				
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-2" class="radio" value="developing" ';
					if($class == "developing"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-2">Goal.</label>';	
				
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$indicatorId.'" id="radio-indicator-'.$indicatorId.'-3" class="radio" value="secure" ';
					if($class == "secure"){
				$button .= 'checked="checked" '; 
						}
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$indicatorId.'-3">Secure.</label>';					
										
				$button .= '</fieldset>';
			
	
	$content = array(
										'id' => $indicatorId,
										'title'  => '',
										'show_icon' => 'true',
										'icon_image' => $type,
										'icon_name' => $type,
										'icon_desc' => '',
										'the_content' => $contentText,
										'badge'=> '',
										'classlist' => $type,
										'status_message' => '',
										'link' => '', 
										'buttons'=>	$button	
		
		
		
		);
			basic_display_template ($content);
			
		
								
								}
									 
									   echo '<input type="submit" value="Save Changes" data-theme="b" data-inline="true" />';
									  
									   echo '</form>';
		
		
	}

	public function currentGoals($colour, $name){
			global $wpdb;
			
		$Goals =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_data.ID, 
	wp_assessment_data.person_id, 
	DATE_FORMAT(wp_assessment_data.date, '%M %D %Y') AS the_date, 
	wp_assessment_data.user_id, 
	wp_assessment_terms.assessment_target,
	wp_assessment_terms.assessment_subject,
	wp_assessment_terms.assessment_link, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description, 
	wp_assessment_terms.assessment_value
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_value = wp_assessment_terms.ID
WHERE wp_assessment_data.person_id = %d AND wp_assessment_terms.assessment_subject = '$this->searchSubject' AND wp_assessment_data.area = 'developing' LIMIT 6", $this->id));

	foreach ($Goals as $Goal){
		
		
		$this->goals[]=array('link'=>$Goal->assessment_link, 'value'=>$Goal->assessment_type, 'goal' => $Goal->assessment_target);
	}
		
		if ($this->user_level>7){
				$secureId = $this->id;
			}
			else {
				$secureId = salt_n_pepper($this->id);
			}
		
		if (count($this->goals)>0){
				
				echo "<ul data-role='listview' data-inset='true' data-theme='b' data-dividertheme='e'>";
				echo "<li data-role='list-divider' class='".$colour."'>".ucfirst($this->subject)." goals for ".$name."</li>";
				
				for ($i=0; $i<count($this->goals); $i++){
					echo "<li ><a href='?accessId=".$secureId."&p=";
					 echo $this->goals[$i]['link'];
					 echo "' rel='external' ><span class='ui-li-desc'>";
					echo ucfirst($this->goals[$i]['goal']);
					echo "</span></a></li>";
				}
				
			
				echo "</ul>";
		}
	}
	
	
public function  get_updated_level_data(){
	
	global $wpdb;
	
	//Seach the database for the record that shows the highest level the child is working on for this level.
	
	$assessDataSQL =$wpdb->get_row($wpdb->prepare("SELECT sum(wp_assessment_terms.assessment_weighting) as personTotal, wp_assessment_terms.assessment_value, wp_assessment_terms.assessment_measure, wp_assessment_data.area
FROM wp_assessment_terms INNER JOIN wp_assessment_data ON wp_assessment_terms.ID = wp_assessment_data.assessment_value AND wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject
where  wp_assessment_data.person_id = %d and wp_assessment_data.assessment_subject = '$this->searchSubject' and wp_assessment_data.area = 'secure' Group by wp_assessment_terms.assessment_value order by  wp_assessment_terms.assessment_value desc limit 1 ", $this->id ));

//Assign the value of the level to a variable (value).

$value = $assessDataSQL->assessment_value;


// Calculate the total weighting for this subject at the selected level

	$levelTotals =$wpdb->get_row("SELECT sum(wp_assessment_terms.assessment_weighting) as Total, wp_assessment_terms.assessment_type, wp_assessment_terms.assessment_value, wp_assessment_terms.assessment_measure
FROM wp_assessment_terms
where wp_assessment_terms.assessment_subject = '$this->searchSubject' and  wp_assessment_terms.assessment_value = $value
group by wp_assessment_terms.assessment_value

");



	$completed = $assessDataSQL->personTotal;
	$levelTotal = $levelTotals->Total;
	$percentComplete = round(($completed/$levelTotal)*100, 0);
	
	if ($percentComplete < 25){
	$newValue = ($value*3)-2;	
	// Need to include a section here that checks to see if they have more than 80% on the previous level before setting their current level to this one.
	}
	else if ($percentComplete < 75){
	$newValue = ($value*3)-1;	
	}
	else if ($percentComplete > 75){
		$checkNext = $this->currentPercent($value+1, 'secure'); // this will call a function that passes the current level + 1 to see the current percent of the level above.
			if ($checkNext>25){
				$newValue = ($value*3)+1;	
			}
			else {
				$newValue = ($value*3);
			}
	}
	
	return $newValue;
	

}

public function currentPercent($currentData, $state){
	
		global $wpdb;
	
	//Seach the database for the record that shows the highest level the child is working on for this level.
	
	$assessDataSQL =$wpdb->get_row($wpdb->prepare("SELECT sum(wp_assessment_terms.assessment_weighting) as personTotal, wp_assessment_terms.assessment_value, wp_assessment_terms.assessment_measure, wp_assessment_data.area
FROM wp_assessment_terms INNER JOIN wp_assessment_data ON wp_assessment_terms.ID = wp_assessment_data.assessment_value AND wp_assessment_terms.assessment_subject = wp_assessment_data.assessment_subject
where  wp_assessment_data.person_id = %d and wp_assessment_data.assessment_subject = '$this->searchSubject' and wp_assessment_data.area = '$state' and wp_assessment_terms.assessment_value = $currentData ",  $this->id));

//Assign the value of the level to a variable (value).

$value = $assessDataSQL->assessment_value;


// Calculate the total weighting for this subject at the selected level

	$levelTotals =$wpdb->get_row("SELECT sum(wp_assessment_terms.assessment_weighting) as Total, wp_assessment_terms.assessment_type, wp_assessment_terms.assessment_value, wp_assessment_terms.assessment_measure
FROM wp_assessment_terms
where wp_assessment_terms.assessment_subject = '$this->searchSubject' and  wp_assessment_terms.assessment_value = $currentData
group by wp_assessment_terms.assessment_value
");



	$completed = $assessDataSQL->personTotal;
	$levelTotal = $levelTotals->Total;
	$percentComplete = round(($completed/$levelTotal)*100, 0);

	
	return $percentComplete;
	
	
}

public function get_people_workingon_indicator($indicatorId){
	
	global $wpdb;
	$group = new Group($this->id);
	$idArray=$group->get_id_array();
	
	$peopleListSQL =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_data.ID, wp_assessment_data.area, wp_assessment_data.person_id, wp_assessment_data.assessment_value,  wp_assessment_data.date As the_date, DATE_FORMAT(wp_assessment_data.date, '%M') As month,
	DATE_FORMAT(wp_assessment_data.date, '%d') As day,  wp_assessment_data.user_id
FROM wp_assessment_data
WHERE wp_assessment_data.person_id IN (".implode(',', $idArray).") and wp_assessment_data.assessment_value = %d", $indicatorId));

	
	echo "<ul class='indicatorList'>";
	foreach($peopleListSQL as $p){
	//Check to see if an image has been set for this person and then echo the image if it exists.
	
	$person_id = $p->person_id;	
	$person = new Person($person_id);	
	$area = $p->area;
	$dataId = $p->ID;
	$day = $p->day;
	$month = $p->month;
	$indicatorId=$p->assessment_value;
	


	
	echo "<li >";
	echo "<input type='checkbox' $checked value='".$indicatorId."' id='input-{$indicatorId}'/>";
	echo "<span class='check' id='check-{$dataId}'>";
	 if ($area =="secure"){
		echo '<span class="state">';	 
		echo 'Secure';
		echo '</span>';
		echo '<span class="day">';
		echo $day;
		echo '</span>';
		echo '<span class="month">';	 
		echo $month;
		echo '</span>';
		 }
		else if ($area =="developing"){
		
		echo '<span class="goal">';
		echo "<img src='".SIBSON_IMAGES."/13-target.png' /><br />Target";
		echo '</span>';
		 } 
	echo "</span>";
	echo "<a class='{$area}' data-indicatorid='{$dataId}' data-hiddenid='{$indicatorId}' data-personid='{$person_id}' data-subject='{$this->subject}' href='#'><span class='li-detail'>".$person->returnName()."</span>";
	
	echo "</a>";
	echo "</li>";
		
	}
	echo "</ul>";
	echo "<div class='spacer'>&nbsp;</div>";
	$area="";


	
	
}

public function show_indicator_detail($indicatorId){
	
	global $wpdb;
	
	$indicator =$wpdb->get_row($wpdb->prepare("SELECT wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description, 
	wp_assessment_terms.assessment_value, 
	wp_assessment_terms.assessment_weighting, 
	wp_assessment_terms.assessment_measure
FROM wp_assessment_terms
where wp_assessment_terms.ID = %d", $indicatorId));
	
	echo "<h2>";
	echo $indicator->assessment_description;
	echo "</h2>";
}

public function setTheme($yearLevel){
	
	$valueArray = $this->currentDataNumber('', true);
	$value = $valueArray['value'];
	$dataCycle = $valueArray['cycle'];
	$cycle = sibson_get_cycle_from_id($dataCycle);
	$valueString = $this->currentData(true);
	$levelArray = $this->get_subject_data_array();

	$standardBand = $this->fetchStandardBand($cycle, 0, $yearLevel, $this->subject );
	
	if ($value>0 && $standardBand['low']>0){
			if ($value< $standardBand['low']){
				
				$theme = "e";	
			}
			else if ($value>=$standardBand['low'] && $value<= ($standardBand['low']+$standardBand['step'])){
				$theme = "d";	
			}
			else if ( $value> ($standardBand['low']+$standardBand['step'])){
				$theme = "c";	
			}
	}
	else {
	$theme = "b";	
	}	
	
	return $theme;
	
}
public function setThemeByLevel($value, $yearLevel){
	
	$valueArray = $this->currentDataNumber('', true);

	$dataCycle = $valueArray['cycle'];
	$cycle = sibson_get_cycle_from_id($dataCycle);
	$valueString = $this->currentData(true);
	$levelArray = $this->get_subject_data_array();

	$standardBand = $this->fetchStandardBand($cycle, 0, $yearLevel, $this->subject );
	
	if ($value>0 && $standardBand['low']>0){
			if ($value< $standardBand['low']){
				
				$theme = "f";	
			}
			else if ($value>=$standardBand['low'] && $value<= ($standardBand['low']+$standardBand['step'])){
				$theme = "d";	
			}
			else if ( $value> ($standardBand['low']+$standardBand['step'])){
				$theme = "c";	
			}
	}
	else {
	$theme = "b";	
	}	
	
	return $theme;
	
}

public function getNationalStandard( $yearLevel){
	
	$valueArray = $this->currentDataNumber('', true);

	$dataCycle = $valueArray['cycle'];
	$cycle = sibson_get_cycle_from_id($dataCycle);
	
	$value = $valueArray['value'];
	
	$standardBand = $this->fetchStandardBand($cycle, 0, $yearLevel, $this->subject );
	
	if ($value>0 && $standardBand['low']>0){
			if ($value< $standardBand['low']){
				if ($value < $standardBand['low']-3){
				$result = "wellbelow";
				}
				else {
			
				$result = "below";	
				}
			}
			else if ($value>=$standardBand['low'] && $value<= ($standardBand['low']+$standardBand['step'])){
				$result = "at";	
			}
			else if ( $value> ($standardBand['low']+$standardBand['step'])){
				$result = "above";	
			}
	}
	
	
	return $result;
	
}

public function register($type, $period, $dateId){
	global $wpdb;
	
	$check =$wpdb->get_var($wpdb->prepare("SELECT code FROM wp_attendance_register WHERE dateId = $dateId and person_id = %d and time_period= '$period'", $this->id));
	
	
echo '<div data-role="fieldcontain">';
echo   '<fieldset data-role="controlgroup" data-type="horizontal" data-theme="b">';
echo '<legend>'.strtoupper($period).':</legend>';
echo    '<input type="radio" name="radiochoice-'.$period.'-'.$dateId.'-'.$this->id.'" id="radiochoice-'.$this->id.'-1" value="P" data-theme="b"';
if ($check == "P"){
	echo ' checked="checked" />';
}
else {
echo 	'/>';
}
echo    '<label for="radiochoice-'.$this->id.'-1">P</label>';
echo    '<input type="radio" name="radiochoice-'.$period.'-'.$dateId.'-'.$this->id.'" id="radiochoice-'.$this->id.'-2" value="L" data-theme="b" ';
if ($check == "L"){
	echo ' checked="checked" />';
}
else {
echo 	'/>';
}
echo    '<label for="radiochoice-'.$this->id.'-2">L</label>';
echo    '<input type="radio" name="radiochoice-'.$period.'-'.$dateId.'-'.$this->id.'" id="radiochoice-'.$this->id.'-3" value="U"  data-theme="b"';
if ($check == "U"){
	echo ' checked="checked" />';
}
else {
echo 	'/>';
}
echo    '<label for="radiochoice-'.$this->id.'-3">U</label>';
echo    '<input type="radio" name="radiochoice-'.$period.'-'.$dateId.'-'.$this->id.'" id="radiochoice-'.$this->id.'-4" value="J"  data-theme="b"';
if ($check == "J"){
	echo ' checked="checked" />';
}
else {
echo 	'/>';
}
echo    '<label for="radiochoice-'.$this->id.'-4">J</label>';
echo    '<input type="radio" name="radiochoice-'.$period.'-'.$dateId.'-'.$this->id.'" id="radiochoice-'.$this->id.'-5" value="O"  data-theme="b"';
if ($check == "O"){
	echo ' checked="checked" />';
}
else {
echo 	'/>';
}
echo    '<label for="radiochoice-'.$this->id.'-5">O</label>';
echo    '</fieldset>';
echo    '</div>';	
	
}

public function shortStandardStatement($yearLevel, $value, $name, $pronoun, $group = false){
	
	
	$cycle = sibson_get_current_cycle();
	$thisCycle = $cycle[0]['currentName'];
	
	$yearAsAWord = convert_year_to_text($yearLevel);
	$standardBand = $this->fetchStandardBand($thisCycle, 0, $yearLevel, $this->subject );

if ($yearLevel ==1){
	
	$yearDesc = "for ".$yearAsAWord." year at school. (".ucfirst($name)."'s fifth birthday is used to calculate years at school.)</p>";
}
else if ($yearLevel== 2|| $yearLevel == 3){
	
	$yearDesc = "for ".$yearAsAWord." years at school. (".ucfirst($name)."'s fifth birthday is used to calculate years at school.)</p>";
}
else {
	
	$yearDesc = "for the end of Year ".ucfirst($yearAsAWord).".</p>";
	
}
	if ($value< $standardBand['low']){
		
		$statement = "<p>This means that ".$name." is <strong>working towards</strong> the National Standard ".$yearDesc ;
		
	}
	else if ($value>=$standardBand['low'] && $value<= ($standardBand['low']+$standardBand['step'])){
		$statement = "This means that ".$name." is <strong>working at</strong> the National Standard ".$yearDesc ;
		
	}
	else if ( $value> ($standardBand['low']+$standardBand['step'])){
		if ( $value> ($standardBand['low']+$standardBand['step']+2)){
		$statement = "This means that ".$name." is <strong>working well above</strong> the National Standard ".$yearDesc ;
		
	}
	else {
		$statement = "This means that ".$name." is <strong>working above</strong> the National Standard ".$yearDesc ;
	}
	}
	
	else if ($value==0){
		$statement = "This means that ".$name." is <strong>working towards</strong> the National Standard ".$yearDesc ;
		
	}
	
	
	
	return $statement;
	}
	
	
public function standardStatement($yearLevel, $value, $name, $pronoun, $group = false){
	
	$cycle = sibson_get_current_cycle();
	$thisCycle = $cycle[0]['currentName'];
	
	
	
	$standardBand = $this->fetchStandardBand($thisCycle, 0, $yearLevel, $this->subject );

	
	if ($group == true){
	$statement1 = "are";
	$statement2 = "</p>";	
	}
	else {
	$statement1 = "is";
	$statement2 = "<p>To reach this judgment you should use a variety of information sources such as 'e-asTTle', 'PAT', observations, work books, peer assessments, conferencing, interviewing and questioning.</p> <p>Are you sure that this is correct?</p>";		
	}
if ($standardBand['low']){	
	if ($value< $standardBand['low']){
		
		$statement = "</p>This means that ".$name." ".$statement1." <strong>working towards</strong> the National Standard and <strong>cannot</strong> do the following yet:</p> ".$this->standardDescription($yearLevel, $aab).$statement2;
		$aab = "below";	
	}
	else if ($value>=$standardBand['low'] && $value<= ($standardBand['low']+$standardBand['step'])){
		$statement = "This means that ".$name." ".$statement1." <strong>working at</strong> the National Standard and you are confident that ".$pronoun." <strong>can</strong> do the following:</p> ".$this->standardDescription($yearLevel, $aab).$statement2;
		$aab = "at";	
	}
	else if ( $value> ($standardBand['low']+$standardBand['step'])){
		$statement = "This means that ".$name." ".$statement1." <strong>working above</strong> the National Standard and you are confident that ".$pronoun." <strong>can</strong> do the following and more:</p> ".$this->standardDescription($yearLevel, $aab).$statement2;
		$aab = "above";	
	}
	else if ($value==0){
		$statement = "This means that ".$name." ".$statement1." <strong>working towards</strong> the National Standard and <strong>cannot</strong> do the following yet:</p> ".$this->standardDescription($yearLevel, $aab).$statement2;
		$aab = "below";	
	}
}
	
	echo $statement;
	
	
}


public function showAssessmentsList(){
	global $wpdb;
	if ($this->type == "group"){
		
	$group = new Group ($this->id);
	$name = $group->returnName(); 
	
	$assessments =$wpdb->get_results("SELECT * from wp_assessment_terms where assessment_subject not in ('creatinggoals', 'environmentgoals', 'expectationsgoals', 'knowinggoals', 'learnersgoals', 'maths', 'mathsdesc', 'reading', 'readingdesc', 'staff', 'teamgoals', 'writing', 'writingdesc', 'class_observation') group by assessment_subject");
	
				echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b">';
	foreach ($assessments as $assessment){
	
	echo "<a href='#' class='load_page_content' data-action='ajax_load_assessments' data-title='".$assessment->assessment_subject." for ".$name."' data-groupid='".$this->id."' data-pagetype='".$assessment->assessment_subject."' data-role='button' data-inline='true' data-theme='b'>";
	
	
	echo $assessment->assessment_subject;
	echo "</a>";
		
	}
	echo "</div>";
		
	}
	else {
	
	
	$person = new Person ($this->id);
	$name = $person->returnFirstName(); 
	
	$assessments =$wpdb->get_results("SELECT * from wp_assessment_terms where assessment_subject not in ('creatinggoals', 'environmentgoals', 'expectationsgoals', 'knowinggoals', 'learnersgoals', 'maths', 'mathsdesc', 'reading', 'readingdesc', 'staff', 'teamgoals', 'writing', 'writingdesc') group by assessment_subject");
	
				echo '<div data-role="controlgroup" data-type="horizontal" data-theme="b">';
	foreach ($assessments as $assessment){
	
	echo "<a href='#dialog' class='loaddialog' data-icon='arrow-u'data-title='".$assessment->assessment_subject." for ".$name."' data-dialogtype='assessment' data-id='".$this->id."' data-pagetype='".$assessment->assessment_subject."' data-rel='dialog' data-role='button' data-inline='true' data-theme='b'>";
	
	echo $assessment->assessment_subject;
	echo "</a>";
		
	}
	echo "</div>";
	}
	
}


public function spreadsheetGoalCell(){
	
	
	
 $td =  '<td>';

 $td .= $this->count_years_goals();

 $td .= '</td>';
	
	return $td;
	
}

public function spreadsheetCell(){
	
	$valueArray = $this->currentDataNumber('', true);
	
	$value = $valueArray['value'];
	$dataCycle = $valueArray['cycle'];
	$cycle = sibson_get_cycle_from_id($dataCycle);
$valueString = $this->currentPlainData(true);
	$levelArray = $this->get_subject_data_array();
	
	
	
	switch ($this->subject){
	case "reading";
	$max = 24;
	$standard = "yes";
	break;
	case "writing";
	$standard = "yes";
	$max = 17;
	break;
	case "Spelling";
	$standard = "no";
	$max = 17;
	break;
	case "maths";
	$standard = "yes";
	$max = 24;
	break;
	
	}
	
	if ($standard =="yes"){
	$standardBand = $this->fetchStandardBand($cycle, 0, $yearLevel, $this->subject );
	
	}
	if ($value< $standardBand['low']){
		
		$theme = "e";	
	}
	else if ($value>=$standardBand['low'] && $value<= ($standardBand['low']+$standardBand['step'])){
		$theme = "d";	
	}
	else if ( $value> ($standardBand['low']+$standardBand['step'])){
		$theme = "c";	
	}
	else if ($value==0){
	$theme = "b";	
	}
	
	if ($type == "group"){
	$name = "cell-".$this->id;
	}
	
	else {
	$name = "cell";
	}
	$valueAdjusted = $value-1; // We have to adjust the value by subtracting one as the slider is working on a zero based array.
	if ($valueAdjusted ==-1){
			$valueAdjusted  =0;
	}
	
 $td =  '<td>';
 $td .= '<input type="text" class="cell '.$theme.'" name="cell_'.$this->id.'_'.$this->subject.'" id="cell_'.$this->id.'_'.$this->subject.'" data-subject="'.$this->subject.'" data-id="'.$this->id.'"  data-theme="'.$theme.'" value="'; 
 $td .= $valueString.'" />';
 $td .= '<div id="'.$this->id.'_subjectAssessments"></div>';
 $td .= '</td>';
	
	return $td;
	
}

public function returnAssesmentRows($type){
	
	global $wpdb;
	
	$individualData =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_terms.ID,
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description,
	wp_assessment_terms.assessment_target
FROM wp_assessment_terms where wp_assessment_terms.assessment_subject =%s order by wp_assessment_terms.ID ", $type));

foreach ($individualData as $key=>$data){
	

	$dataArray[] = array( 'ID'=>$data->ID, 'description'=>$data->assessment_description, 'target' => $data->assessment_target );
	
}
	return $dataArray;
}
public function returnAssesmentData($type){
	
	global $wpdb;
	
	$individualData =$wpdb->get_results($wpdb->prepare("SELECT wp_assessment_data.ID, 
	wp_assessment_terms.ID as termId,
	wp_assessment_data.date, 
	wp_assessment_data.user_id, 
	wp_assessment_data.cycle, 
	wp_assessment_data.yeargroup, 
	wp_assessment_data.area, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_description,
	wp_assessment_terms.assessment_target
FROM wp_assessment_data INNER JOIN wp_assessment_terms ON wp_assessment_terms.assessment_value = wp_assessment_data.assessment_value AND wp_assessment_data.assessment_subject = wp_assessment_terms.assessment_subject
WHERE wp_assessment_data.person_id = %d AND wp_assessment_data.assessment_subject = '$type' 
group by date, wp_assessment_data.assessment_value
 ", $this->id));

$total = 0;
foreach ($individualData as $key=> $data){
	
$date = date('d/m/y', strtotime($data->date));
$year = date('Y', strtotime($data->date));


	$dataArray[$data->termId][] = array('date' =>$date, 'year'=>$year,'score'=> $data->area, 'description'=>$data->assessment_description, 'target' => $data->assessment_target, 'total' => $total, 'termId' =>$data->termId );
 
}
	return $dataArray;
}


public function slider($yearLevel, $type=''){

	
	$valueArray = $this->currentDataNumber('', true);
	
	$value = $valueArray['value'];
	$dataCycle = $valueArray['cycle'];
	$cycle = sibson_get_cycle_from_id($dataCycle);
	$valueString = $this->currentData(true);
	$levelArray = $this->get_subject_data_array();
	
	
	switch ($this->subject){
	case "reading";
	$max = 24;
	$standard = "yes";
	break;
	case "writing";
	$standard = "yes";
	$max = 17;
	break;
	case "Spelling";
	$standard = "no";
	$max = 17;
	break;
	case "maths";
	$standard = "yes";
	$max = 24;
	break;
	
	}
	
	if ($standard =="yes"){
	$standardBand = $this->fetchStandardBand($cycle, 0, $yearLevel, $this->subject );
	
	}
	
	
	if ($value< $standardBand['low']){
		
		$theme = "e";	
	}
	else if ($value>=$standardBand['low'] && $value<= ($standardBand['low']+$standardBand['step'])){
		$theme = "d";	
	}
	else if ( $value> ($standardBand['low']+$standardBand['step'])){
		$theme = "c";	
	}
	else if ($value==0){
	$theme = "b";	
	}
	
	if ($type == "group"){
	$name = "slider-".$this->id;
	}
	
	else {
	$name = "slider";
	}
	$valueAdjusted = $value-1; // We have to adjust the value by subtracting one as the slider is working on a zero based array.
	if ($valueAdjusted ==-1){
			$valueAdjusted  =0;
	}
	
 echo   '<input type="range" name="'.$name.'" id="slider_'.$this->id.'" class="slider" data-id="'.$this->id.'" value="'.$valueAdjusted.'" min="0" max="'.$max.'" data-theme="'.$theme.'" data-track-theme="b"  />';

$jsonArray = json_encode($levelArray);

	?>
<script>

jQuery(document).ready(function(){

var stringArray = <?php echo $jsonArray;?>;

    jQuery( ".slider" ).live( "change", function(event, ui) {
  var id = jQuery(this).data("id");

  jQuery("#update_"+id).html(stringArray[jQuery('#slider_'+id).val()]);
  
  	
});
    
})
</script>	
    <?php 
	
}

public function score($scale, $id){
$i=1;
$scaleArray = array();
for ($i;$i<$scale;$i++){
	
	
	$scaleArray[$i] = array ('name'=>'radio-'.$id,
											'id'=>$i,
											'value'=>$i,
											'existing'=> '',
											'title'=>$i
											);
	
}
	
	sibson_radio_list(
									$scaleArray	,
											 'horizontal');
											 



}

public function observationForm(){
	
global $wpdb;

echo "You can use this tool to graph the data collected from observations in your classroom. Please use this tool if it will help you to set your goals.<br/>"; 

$this->observation_chart();



 echo "<form data-ajax='false' action='".get_bloginfo('url')."/?accessId=".$this->id."&pageType=baseline&formType=observation' id='observation' method='post' >";		
									  sibson_form_nonce('observation');	
									 echo '<input type="hidden" id="personId" name="personId" value="'.$this->id.'" />';
									
$elements = $wpdb->get_results("Select * from wp_assessment_terms where assessment_subject = 'class_observation' order by ID asc");



foreach ($elements as $element){
	
			
		 	$button ='<fieldset data-role="controlgroup" data-type="horizontal" data-theme="b" >';
									
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$element->ID.'" id="radio-indicator-'.$element->ID.'-1" class="radio" value="1" ';
		
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$element->ID.'-1">Little</label>';	
				
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$element->ID.'" id="radio-indicator-'.$element->ID.'-2" class="radio" value="2" ';
					
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$element->ID.'-2">Some</label>';	
				
				$button .= '<input data-theme="b" type="radio" name="radio-indicator-'.$element->ID.'" id="radio-indicator-'.$element->ID.'-3" class="radio" value="3" ';
				
				$button .= '/>';
				$button .= '<label for="radio-indicator-'.$element->ID.'-3">Lots</label>';					
										
				$button .= '</fieldset>';
			

		$content = array(	'id' => $element->ID,
										'title'  => '',
										'show_icon' => '',
										'icon_image' => '',
										'icon_name' =>  '',
										'icon_desc' => '',
										'the_content' => $element->assessment_description,
										'badge'=> '',
										'classlist' => '',
										'status_message' => '',
										'link' => '', 
										'buttons' => $button
												 );
						


	basic_display_template ($content);
	
}
	
	echo "<input type='submit' value='Save' data-theme='b' data-inline='true' 	/>";	
	echo "</form>";
	
}

public function observation_chart(){

global $wpdb; 

echo "<div id='observation_chart'>";
echo "</div>";




$assessDataSQL =$wpdb->get_results($wpdb->prepare("SELECT ID, assessment_description, assessment_target, assessment_value from wp_assessment_terms where assessment_subject = 'class_observation' order by ID"));

	foreach ($assessDataSQL as $assessData):
	
	$chartArray[$assessData->ID]= array( 'element' => $assessData->assessment_target
	);
	$idArray[]= $assessData->ID;	
	endforeach;
	$dataArray = array();
	foreach($chartArray as $key =>$chart){
			
	$dataArray[$key] = 0;
	
	
	}
	
	$idList = implode(",", $idArray);

	
	$data = $wpdb->get_results("SELECT sum(wp_assessment_data.area) as total, 
	wp_assessment_data.assessment_value, 
	wp_school_dates.term
FROM wp_assessment_data INNER JOIN wp_school_dates ON date_format(wp_assessment_data.date, '%Y %M %d') = date_format(wp_school_dates.date, '%Y %M %d')
WHERE wp_assessment_data.person_id = $this->id and wp_assessment_data.assessment_value in ($idList)
GROUP BY wp_assessment_data.assessment_value, wp_school_dates.term order by wp_assessment_data.assessment_value");

if ($data){

foreach ($data as $d){


$dataArray[$d->assessment_value] = $d->total;
	
}

?>
<script>
  google.load("visualization", "1", {packages:["corechart"]});
       google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Element', 'Total'],
         <?php 
		 $numItems = count($chartArray);
		 $i = 1;
		 foreach($chartArray as $key =>$chart){
			 
			 if ($i==$numItems){
				echo "['".$chart['element']."', ".$dataArray[$key]."]";
			 }
			 else {
			 echo "['".$chart['element']."', ".$dataArray[$key]."],";
			 }
			 $i++;
		 }
		 ?>
        ]);

        var options = {
          title: 'Observation Totals',
		  backgroundColor: 'none'
        };

        var chart = new google.visualization.LineChart(document.getElementById('observation_chart'));
        chart.draw(data, options);
      }
</script>


<?php 

	
}
}

public function compare_spelling_data($wholeSchool, $div){
	
global $wpdb;

$group = new Group ($this->id);
$idArray = $group->get_id_array();
$idList = implode (",", $idArray);



$assessDataSQL =$wpdb->get_results($wpdb->prepare("SELECT assessment_short, assessment_value from wp_assessment_terms where assessment_subject = 'spelling' and assessment_value <16 order by assessment_value asc"));

	foreach ($assessDataSQL as $assessData):
	
	$chartArray[$assessData->assessment_value]= array( 'level' => $assessData->assessment_short
	);
		
	endforeach;
	$dataArray = array();
	
	foreach($chartArray as $key =>$chart){
			
	$dataArray[$key] = 0;
	$otjArray[$key]=0;
	
	}
	
	if ($wholeSchool == true){
	$spellingData = $wpdb->get_results("SELECT count(assessment_value) as total, assessment_value from wp_assessment_data  where (cycle = 16 or cycle = 17) and assessment_subject = 'spelling' group by assessment_value");
	
}
else {

$spellingData = $wpdb->get_results("SELECT count(assessment_value) as total, assessment_value from wp_assessment_data where  (cycle = 16 or cycle = 17) and person_id in ($idList)  and assessment_subject = 'spelling' group by assessment_value");
	
	
}


	
foreach ($spellingData as $d){


$dataArray[$d->assessment_value] = $d->total;
	
}

if ($wholeSchool == true){
$otjData = $wpdb->get_results("SELECT count(assessment_value) as total, assessment_value from wp_assessment_data where cycle = 16 and assessment_subject = 'writing' group by assessment_value");
$title = "Compare Spelling with Writing OTJ for the Whole School.";	
}
else {

$otjData = $wpdb->get_results("SELECT count(assessment_value) as total, assessment_value from wp_assessment_data  where cycle = 16 and person_id in ($idList)  and assessment_subject = 'writing' group by assessment_value");
	
$title = "Compare Spelling with Writing OTJ for ".$group->returnName().".";		
}

	
	
foreach ($otjData as $otj){


$otjArray[$otj->assessment_value] = $otj->total;
	
}



echo "<div id='".$div."'><img src='".SIBSON_IMAGES."/ajax-loader.png' /></div>";
	


?>
<script>
  google.load("visualization", "1", {packages:["corechart"]});
       google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Level', 'Spelling', 'Writing OTJ'],
         <?php 
		 $numItems = count($chartArray);
		 $i = 1;
		 foreach($chartArray as $key =>$chart){
			 
			 if ($i==$numItems){
				echo "['".$chart['level']."', ".$dataArray[$key].", ".$otjArray[$key]."]";
			 }
			 else {
			 echo "['".$chart['level']."', ".$dataArray[$key].", ".$otjArray[$key]."],";
			 }
			 $i++;
		 }
		 ?>
        ]);

        var options = {
          title: '<?php  echo $title;?>',
		  backgroundColor: 'none',
		  height: "300"
        };

        var chart = new google.visualization.LineChart(document.getElementById('<?php echo $div;?>'));
        chart.draw(data, options);
      }
</script>


<?php 

}

public function progress_towards_goals($wholeSchool, $div){
	
global $wpdb;

$group = new Group ($this->id);
$idArray = $group->get_id_array();
$idList = implode (",", $idArray);



$assessDataSQL =$wpdb->get_results($wpdb->prepare("SELECT assessment_short, assessment_value from wp_assessment_terms where assessment_subject = 'writing' order by assessment_value asc"));

	foreach ($assessDataSQL as $assessData):
	
	$chartArray[$assessData->assessment_value]= array( 'level' => $assessData->assessment_short
	);
		
	endforeach;
	$dataArray = array();
	
	foreach($chartArray as $key =>$chart){
			
	$dataArray[$key] = 0;
	$otjArray[$key]=0;
	
	}
	


$lastYearData = $wpdb->get_results("SELECT count(assessment_value) as total, assessment_value from wp_assessment_data where person_id in ($idList) and cycle = 16 and assessment_subject = 'writing' group by assessment_value");
	
	



	
foreach ($spellingData as $d){


$dataArray[$d->assessment_value] = $d->total;
	
}



$otjData = $wpdb->get_results("SELECT count(assessment_value) as total, assessment_value from wp_assessment_data where cycle=15 and person_id in ($idList) and assessment_subject = 'writing'  group by assessment_value");
	
$title = "Progress towards target ".$group->returnName().".";		

	
	
foreach ($otjData as $otj){


$otjArray[$otj->assessment_value] = $otj->total;
	
}



echo "<div id='".$div."'><img src='".SIBSON_IMAGES."/ajax-loader.png' /></div>";
	


?>
<script>
  google.load("visualization", "1", {packages:["corechart"]});
       google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Level', 'Current', 'Last Year'],
         <?php 
		 $numItems = count($chartArray);
		 $i = 1;
		 foreach($chartArray as $key =>$chart){
			 
			 if ($i==$numItems){
				echo "['".$chart['level']."', ".$dataArray[$key].", ".$otjArray[$key]."]";
			 }
			 else {
			 echo "['".$chart['level']."', ".$dataArray[$key].", ".$otjArray[$key]."],";
			 }
			 $i++;
		 }
		 ?>
        ]);

        var options = {
          title: '<?php  echo $title;?>',
		  backgroundColor: 'none',
		  height: "300"
        };

        var chart = new google.visualization.LineChart(document.getElementById('<?php echo $div;?>'));
        chart.draw(data, options);
      }
</script>


<?php 

}
}

	
?>