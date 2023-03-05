<?php
$conn = new mysqli("localhost","root",trim(file_get_contents("pwd")),"weather");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['model'] == 'Cotech-367959' && $_POST['id'] = 152)
	{
		$query = "INSERT INTO data (time, battery_ok, temperature_C, humidity, rain_mm, wind_dir_deg, wind_avg_m_s, wind_max_m_s) VALUES ('" . $_POST['time'] . "'," . $_POST['battery_ok'] . ", '" . $_POST['temperature_C'] . "'," . $_POST['humidity'] . ",'" . $_POST['rain_mm'] . "'," . $_POST['wind_dir_deg'] . ",'" . $_POST['wind_avg_m_s'] . "','" . $_POST['wind_max_m_s'] . "' );";
	}
	else
	{
		$query = "INSERT INTO rawdata (time, jsondata) VALUES ('" . $_POST['time'] . "','" . json_encode($_POST) . "');";
	}
        $stmt = $conn->prepare($query); 
	$stmt->execute();	
}
else if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$res = $conn->query("SELECT * FROM data WHERE time > now() - INTERVAL 7 day;");

	$output = true;
	if ($_GET['output'] == 'json') 
	{
		$output = false;
	}

	while ($row = $res->fetch_assoc()) {
		if (!$output)
		{
			$array[] = $row;
		}
		else
		{
			$ts[] = $row['time'];
			$temp[] = $row['temperature_C'];
			$hum[] = $row['humidity'];
			$rain[] = $row['rain_mm'];
			$windDir[] = $row['wind_dir_deg'];
			$windAvg[] = $row['wind_avg_m_s'] + rand(1,3);
			$windMax[] = $row['wind_max_m_s'];// + rand(4,7);
		}
	}

	
	if (!$output) {
		print_r(json_encode($array));
	}
	else {
		?>

		<html>
		<head>
       			<script src="https://cdn.plot.ly/plotly-2.18.2.min.js"></script>
		</head>
		
		<body>
		<div id="tester" style="width:40%"></div>
		<div id="ws" style="width:60%"></div>
		</body>

		 <script>

var temp = {
  x:  <?php print_r(json_encode($ts)); ?> ,
  y: <?php print_r(json_encode($temp)); ?>,
    xaxis: 'x1',
    yaxis: 'y1',


  type: 'scatter'
};

var hum = {
  x:  <?php print_r(json_encode($ts)); ?> ,
  y: <?php print_r(json_encode($hum)); ?>,

  xaxis: 'x2',
  yaxis: 'y2',
  type: 'scatter'
};
var windAvg = {
  x:  <?php print_r(json_encode($ts)); ?> ,
  y: <?php print_r(json_encode($windAvg)); ?>,

    xaxis: 'x3',
  yaxis: 'y3',
  type: 'scatter'
};

var windMax = {
  x:  <?php print_r(json_encode($ts)); ?> ,
  y: <?php print_r(json_encode($windMax)); ?>,
  xaxis: 'x3',
  yaxis: 'y3',
  type: 'scatter'
};
var rain = {
  x:  <?php print_r(json_encode($ts)); ?> ,
  y: <?php print_r(json_encode($rain)); ?>,
  type: 'scatter',
    xaxis: 'x4',
  yaxis: 'y4',
};

var barplot = {
  r:  <?php print_r(json_encode($windAvg)); ?> ,
  theta: <?php print_r(json_encode($windDir)); ?>,
  name: 'test',
  type: 'barpolar'
};

		 var data = [temp, hum, windAvg, windMax, rain];
		var dataBP = [barplot,barplot,barplot];
		 var layout = {
			title: "JK Zemun - Meteo stanica",
			polar: {
      				barmode: "overlay",
      				bargap: 0,
      				radialaxis: {ticksuffix: "m/s", angle: 0, dtick: 1},
      				angularaxis: {direction: "clockwise"}
    			},
			grid: {rows: 1, columns: 1, pattern: 'independent'},
		 };

                 Plotly.newPlot( 'tester' , dataBP, layout);




  var axis = {
    showline: true,
    zeroline: false,
    showgrid: true,
    mirror:true,
    ticklen: 2,
    gridcolor: '#ffffff',
    tickfont: {size: 10},
  }

var axis1 = {domain: [0.0, 0.95], anchor: 'y1', showticklabels: false}
var axis2 = {domain: [0.0, 0.95], anchor: 'y2', showticklabels: false}
var axis3 = {domain: [0.0, 0.95], anchor: 'y4'}
var axis7 = {domain: [0.0, 0.95], anchor: 'y3', showticklabels: false}
var axis4 = {domain: [0.25, 0.49], anchor: 'x3' }
var axis5 = {domain: [0.50, 0.74], anchor: 'x2' }
var axis6 = {domain: [0.00, 0.24], anchor: 'x4' }
var axis8 = {domain: [0.75, 0.99], anchor: 'x1' }

var layout2 = {
	title: "JK Zemun - Meteo stanica",
	showlegend: false,
	xaxis1: Object.assign(axis1,axis),
	xaxis2: Object.assign(axis2,axis),
	xaxis3: Object.assign(axis7,axis),
	yaxis1: Object.assign(axis8,axis),
	yaxis2: Object.assign(axis5,axis),
	yaxis3: Object.assign(axis4,axis),
	xaxis4: Object.assign(axis3,axis),
 	yaxis4: Object.assign(axis6,axis),
}



  Plotly.newPlot('ws', data, layout2);





</script>
</html>
<?php 

}}

?>
