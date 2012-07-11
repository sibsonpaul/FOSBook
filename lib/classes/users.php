<?php

class userAnalysis{
	
	private $username="";
	private $id="";
	private $type="";
	
	public function __construct($username, $id, $type=''){ // username, id and type are passed.
		
		$this->username=$username; // This is the username to base the search on. For example could be the mum's username.
		$this->id = $id; // Id of the visitor.
		$this->type = $type; // type of person eg parent or staff
		
	}
	
public function totalVisits(){
	
	global $wpdb;
	$user = $this->username;
	if ($this->type == "staff"){
	$accessId =$this->id;
	$length = strlen($this->id);
	}
	else {
	$accessId = salt_n_pepper($this->id);
	$length = 32;
	}
$wassup = $wpdb->get_results("Select DATE( FROM_UNIXTIME( `timestamp` ) ) AS pDate, count(DATE( FROM_UNIXTIME( `timestamp` ) )) as count from wp_wassup where username = '$user' and SUBSTRING(urlrequested,12,$length) = '$accessId'  group by DATE( FROM_UNIXTIME( `timestamp` ) )");
	return count($wassup);
	
}

public function fetch_staff_visitors(){
	
	global $wpdb;
	
	$accessId =$this->id;
	$length = strlen($this->id);
	
	$wassup = $wpdb->get_results("Select count(id) as count, username from wp_wassup where SUBSTRING(urlrequested,12,$length) = '$accessId' group by  username");
	
	return $wassup;
	
}
	
public function pie_chart($type){
	
	global $wpdb;
	$user = $this->username;
	if ($this->type == "staff"){
	$accessId =$this->id;
	$length = strlen($this->id);
	}
	else {
	$accessId = salt_n_pepper($this->id);
	$length = 32;
	}
	echo "The user with the username ".$user." has visited this report a total of ".$this->totalVisits()." times.";
	
	$wassup = $wpdb->get_results("Select count(id) as count, urlrequested from wp_wassup where username = '$user' and SUBSTRING(urlrequested,12,$length) = '$accessId' group by urlrequested, SUBSTRING(urlrequested,12,$length)");
			$dataArray['home']=0;
           $dataArray['sparkle']=0;
       $dataArray['general']=0;
       $dataArray['thinker']=0;
		$dataArray['communicator']=0;
		 $dataArray['dream']=0;       
		 $dataArray['team']=0;
		 $dataArray['reading']=0;
		$dataArray['writing']=0;
		$dataArray['maths']=0;         
		 $maths=0;
			foreach ($wassup as $was){
			
				$explode = explode("pageType=", $was->urlrequested);
				if ($explode[1]==""){
				$dataArray['home']=	$was->count;
				}
				else {
				 $dataArray[$explode[1]]=$was->count;
				}
				
			}
	
	echo "<div id='".$type."_chart_div'></div>";
	?>

 <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Page', 'Visits'],
          ['Home',  <?php echo $dataArray['home'];?>],
          ['Sparkle', <?php echo $dataArray['sparkle'];?>],
          ['General',  <?php echo $dataArray['general'];?>],
          ['Thinker', <?php echo $dataArray['thinker'];?>],
		  ['Communicator',  <?php echo $dataArray['communicator'];?>],
			['Dream Maker', <?php echo $dataArray['dream'];?>],         
		  ['Team Player', <?php echo $dataArray['team'];?>],
		   ['Reading',  <?php echo $dataArray['reading'];?>],
			['Writing', <?php echo $dataArray['writing'];?>],         
		  ['Maths', <?php echo $dataArray['maths'];?>]
        ]);

        var options = {
          title: 'Vists by <?php echo $user;?>.',
		  backgroundColor: "none",
		  height: "300"
		  
        };

        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $type;?>_chart_div'));
        chart.draw(data, options);
      }
    </script>
<?php

}

// Group Based stats

public function totalVisitsByGroup(){
	
	global $wpdb;
	
$wassup = $wpdb->get_results("Select DATE( FROM_UNIXTIME( `timestamp` ) ) AS pDate, count(DATE( FROM_UNIXTIME( `timestamp` ) )) as count, SUBSTRING(urlrequested,12,32) as id from wp_wassup group by DATE( FROM_UNIXTIME( `timestamp` ) ), SUBSTRING(urlrequested,12,32) order by count desc");
$count =0;
	foreach ($wassup as $w){
		
	if (preg_match('/^[a-f0-9]{32}$/', $w->id)){	
		
		$accessId = $this->decryptID($w->id);
		
		$person = new Person($accessId);
		echo $person->returnName();
		echo "(".$w->pDate.")";
		echo "<br />";
		$count ++;
	}
	
	}
	echo $count;
}

public function decryptID($id){
	
	
	for ($i; $i<3000; $i++){
			
			$saltNpepper = salt_n_pepper($i);
	
			if ($id == $saltNpepper){
			
			return $i;
			break;	
			}
	
	}
	
	
}

}

?>