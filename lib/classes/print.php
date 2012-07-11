<?php

class PrintPage{
	
	
	public function goal_spreadsheet($id, $subject){
		
		$person = new Person($id);
	$name =	$person->returnName();
	echo "<h3>";
	echo $name;
	echo " - ";
	echo ucfirst($subject)." Goals";
	echo "</h3>";	
	$assessment = new Assessment($id, $subject, 'individual');
	
	
	$assessment->goalsSpreadsheet();
		
		
	}
	
	
	
	public function ESOL_AF($id){
	
	$person = new Person($id);
	$assessment = new Assessment($id,'', 'individual');
	
	$subjects = array (array ('Search' =>'ESOL Listening', 'Title'=>'Listening'), array ('Search' =>'ESOL Speaking', 'Title'=>'Speaking'), array ('Search' =>'ESOL Reading', 'Title'=>'Reading'), array ('Search' =>'ESOL Writing', 'Title'=>'Writing'));

	foreach ($subjects as $s){
		
		$Rows = $assessment->returnAssesmentRows($s['Search']);
		$data = $assessment->returnAssesmentData($s['Search']);
		

	?>
    <style>
	
	table {
	border-collapse:collapse;
	font-weight:normal;
		}
	td.head {border : 0px ;
	}
	td {border: 1px solid black;	}
	td.bold { font-weight:bold;}

	</style>

<div  class="">
<div class="Child">
<?php $person->showName();?>

</div>
<div class="head_instructions">Students should be assessed in relation to the achievement levels of their cohort. The "cohort" comprises students of the same age performing at the "normed national" level.</div>
<div class="instructions">Assessment in listening (teacher to complete)
In assessing the student against acceptable national cohort
achievement levels, the student is:
<ul><li>1: Well below cohort attainment</li>
<li>2: Below cohort attainment</li>
<li>3: Close to cohort attainment</li>
</ul>
(Enter 1, 2, or 3 for each criteria item below.)</div>
<div class="title">
<h1>
<?php echo $s['Title'];?>
</h1>
</div>

<table class="head">
<tr class="measure">
<td class="head bold">Suggested Assessment Measure</td>
<td class="head bold">Criteria</td>


<?php

$outOf = count($Rows)*3;
 foreach ($Rows as $Row){
	
	$date0 = $data[$Row['ID']][0]['date'];
	$date1 = $data[$Row['ID']][1]['date'];
	$date2 = $data[$Row['ID']][2]['date'];
	$date3 = $data[$Row['ID']][3]['date'];
	$date4 = $data[$Row['ID']][4]['date'];
	
	$year0 = $data[$Row['ID']][0]['year'];
	$year1 = $data[$Row['ID']][1]['year'];
	$year2 = $data[$Row['ID']][2]['year'];
	$year3 = $data[$Row['ID']][3]['year'];
	$year4 = $data[$Row['ID']][4]['year'];
	
	
	
}?>
<td class="bold"><?php echo $date0;?></td>
<td class="bold"><?php echo $date1;?></td>
<td class="bold"><?php echo $date2;?></td>
<td class="bold"><?php echo $date3;?></td>
<td class="bold"><?php echo $date4;?></td>

</tr>


<?php 

foreach ($Rows as $Row){
echo '<tr>';
echo "<td class='criteria'>";
	echo $Row['target'];
echo "</td>";	
echo "<td class='measure' id='".$Row['ID']."'>";
	
	echo $Row['description'];
echo "</td>";



echo "<td class='date'>";
echo $data[$Row['ID']][0]['score'];

$total0 += $data[$Row['ID']][0]['score'];

$grandTotal0 += $data[$Row['ID']][0]['score'];

echo "</td>";
echo "<td class='date'>";
echo $data[$Row['ID']][1]['score'];
$total1 += $data[$Row['ID']][1]['score'];
$grandTotal1 += $data[$Row['ID']][1]['score'];


echo "</td>";
echo "<td class='date'>";
echo $data[$Row['ID']][2]['score'];
$total2 += $data[$Row['ID']][2]['score'];
$grandTotal2 += $data[$Row['ID']][2]['score'];

echo "</td>";
echo "<td class='date'>";
echo $data[$Row['ID']][3]['score'];
$total3 += $data[$Row['ID']][3]['score'];
$grandTotal3 += $data[$Row['ID']][3]['score'];

echo "</td>";
echo "<td class='date'>";
echo $data[$Row['ID']][4]['score'];
$total4 += $data[$Row['ID']][4]['score'];
$grandTotal4 += $data[$Row['ID']][4]['score'];

echo "</td>";

echo '</tr>';					
}
?>


<tr>
<td class="measure">
</td>
<td class="criteria bold">Subtotal (out of <?php echo $outOf;?>)</li>
<td  class="bold"><?php echo $total0;?></td>
<td class="bold"><?php echo $total1;?></td>
<td class="bold"><?php echo $total2;?></td>
<td class="bold"><?php echo $total3;?></td>
<td class="bold"><?php echo $total4;?></td>


</tr>

<?php if($s['Title'] =="Writing"){?>


<tr>
<td>
</td>
<td class="bold">Combined Total (out of 135)</li>
<td class="bold"><?php echo $grandTotal0;?></td>
<td class="bold"><?php echo $grandTotal1;?></td>
<td class="bold"><?php echo $grandTotal2;?></td>
<td class="bold"><?php echo $grandTotal3;?></td>
<td class="bold"><?php echo $grandTotal4;?></td>


</tr>


<?php }

else {

	
			$total0=0;
			$total1=0;
			$total2=0;
			$total3=0;
			$total4=0;
			$date0 = 0;
			$date1 =0;
			$date2 = 0;
			$date3 =0;
			$date4 =0;	
			$year0 = 0;
			$year1 =0;
			$year2 = 0;
			$year3 =0;
			$year4 =0;	
	
		
}?>

</table>

<?php 

		

	}
	?>
    
    <div  id="cumulative">
<div class="head_instructions"></div>
<div class="instructions"><img src="<?php echo SIBSON_IMAGES;?>/esol_instructions.png" style="float:right"/>
</div>
<div class="title">
Cumulative Record of Student Assessment.</div>
    <table>
    <tr>
    <td>
    Date of enrolment (dd/mm/yy)
    </td>
     <td>
   Name of School
    </td>
     <td>
   Year Level
    </td>
     <td>
    Date assessed (dd/mm/yy)
    </td>
     <td>
   Assessment details
    </td>
     <td>
   Ineligible for funding (enter data when benchmark exceeded or three years coplete)
    </td>
     <td>
   Comments or teacher's signature
    </td>
    </tr>
    
     <tr>
    <td>
   <?php echo $person->enrolDate();?>
    </td>
     <td>
  <?php echo "Fendalton Open-air (3338)";?>
    </td>
     <td>
 <?php	
	 $group = $person->returnClassInfoByDate($year0);
  echo $group['year'];?>
    </td>
     <td>
  	<?php echo $date0; ?>
    </td>
     <td>
   <?php echo $grandTotal0; ?>
    </td>
     <td>
  
    </td>
     <td>
   
    </td>
    </tr>
     <tr>
    <td>
   <?php echo $person->enrolDate();?>
    </td>
     <td>
  <?php echo "Fendalton Open-air (3338)";?>
    </td>
     <td>
 <?php	

	 $group = $person->returnClassInfoByDate($year1);
  echo $group['year'];?>
    </td>
     <td>
  	<?php echo $date1; ?>
    </td>
     <td>
   <?php echo $grandTotal1; ?>
    </td>
     <td>
  
    </td>
     <td>
   
    </td>
    </tr>
    
    </table>
    	
	<?php }
}

?>