<?php

class chart{
	
	private $id="";
	private $subject="";
	private $xCats ="";
	
	
	public function __construct($ID, $subject){
		
	$this->id=$ID;
	$this->subject= $subject;
	
	
				
	
	}
	
function sibson_get_individual_chart(){

global $wpdb;


	$assessDataSQL =$wpdb->get_results("SELECT assessment_description, assessment_value from wp_assessment_terms where assessment_subject = '$this->subject' order by ID");
	$i=0;
	foreach ($assessDataSQL as $assessData):
	$i++;
	$yArray[] = "'".$i."':'".$assessData->assessment_description."'";
	endforeach;


//Fetch an area of descriptors for the selected chart type (eg levels for writing).

	$personSQL = $wpdb->get_results("SELECT wp_assessment_terms.assessment_description, 
	wp_people.first_name, 
	wp_people.last_name, 
	wp_people.gender, 
	max(wp_assessment_data.date), 
	wp_assessment_data.cycle, 
	wp_assessment_data.area, 
	wp_assessment_terms.assessment_type, 
	wp_assessment_terms.assessment_subject, 
	wp_assessment_terms.assessment_value, 
	wp_cycles.Cycle, 
	wp_cycles.Year
FROM wp_people INNER JOIN wp_assessment_data ON wp_people.wp_person_id = wp_assessment_data.person_id
	 INNER JOIN wp_cycles ON wp_cycles.cycleid = wp_assessment_data.cycle
	 INNER JOIN wp_assessment_terms ON wp_assessment_data.assessment_subject = wp_assessment_terms.assessment_subject AND wp_assessment_data.assessment_value = wp_assessment_terms.assessment_value
WHERE ( ( wp_assessment_data.person_id = $this->id ) AND ( wp_assessment_data.area = 'OTJ' ) AND wp_assessment_data.assessment_subject = '$this->subject' )
GROUP BY wp_assessment_data.cycle
ORDER BY `wp_assessment_data`.`cycle` ASC

 ");
	
foreach ($personSQL as $individual):
	$count = $individual->assessment_value;
	$cycle = 'Cycle '.$individual->Cycle.', '.$individual->Year.'';

		
	$xArray[] = "'".$cycle."'";
	$dataArray[]=$count;	
	
endforeach;
$max = max ($dataArray);
$min = min ($dataArray);
 ?>

<script>

var categoryLinks = {<?php echo implode(",", $yArray);?>
};
chart = new Highcharts.Chart({
      chart: {
         renderTo: '<?php echo $this->subject;?>_chart_<?php echo $this->id;?>',
         defaultSeriesType: 'area',
		 margin: [ 50, 50, 100, 80], width:800
      },
	  
      title: {
         text: '<?php echo ucfirst($this->subject);?> Chart'
      },
     
      xAxis: {
         categories: [<?php echo implode(",", $xArray);?>], labels: {
            rotation: -45,
            align: 'right',
            style: {
                font: 'normal 13px Verdana, sans-serif'
            }
         }
      },
      yAxis: { categories: [0,1,2,3,4,5,6,7,8],
		 labels: {
            formatter: function() {
                return  categoryLinks[this.value] ;
            }
        },
         min: <?php echo $min-1;?>,
		 max: <?php echo $max+3;?>,
		
         title: {  margin: 80
         }
      },
      legend: {
         enabled: false
      },
      tooltip: {
         formatter: function() {
            return categoryLinks[this.y];
         }
      },
     
           series: [{
         
         data: [<?php echo implode(",", $dataArray);?>]
   
      }]
   });
    
	   
</script>

<?php }
}

?>