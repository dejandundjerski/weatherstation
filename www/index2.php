<?php
$conn = new mysqli("localhost","root",trim(file_get_contents("pwd")),"weather");

if ($_SERVER['REQUEST_METHOD'] === 'GET')
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
			$batteryOk = $row['battery_ok'];

			if (strtotime($row['time']) > strtotime('-24 hour'))
			{
				$windDir1D[] = $row['wind_dir_deg'];
				$windAvg1D[] = $row['wind_avg_m_s'];
				if (strtotime($row['time']) > strtotime('-1 hour'))
				{
					$windDir1h[] = $row['wind_dir_deg'];
					$windAvg1h[] = $row['wind_avg_m_s'];
				}
			}
		}
	}

	if (!$output) {
		print_r(json_encode($array));
	}
	else {
		$uptime = exec('uptime');
		?>

		<html>
		<head>
       			<script src="https://cdn.plot.ly/plotly-2.18.2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>	
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>	
	</head>
		<body>
		<div class="container">
			<div id="srvinfo" class="row>
				<div class=".col-xs-4 .col-md-4">Server @<?php echo $uptime; ?></div>
				<div class=".col-xs-4 .col-md-4"></div>
				<div class=".col-xs-4 .col-md-4">Battery life: <?php if ($batteryOk == 1) { echo 'OK'; } else { echo 'Error'; } ?></div>
			</div>
		<div id="windrose" class="row">
			<div class=".col-xs-4 .col-md-4"><div id="windrose1h" class="responsive-plot"></div></div>
		        <div class=".col-xs-4 .col-md-4"><div id="windrose1d" class="responsive-plot"></div></div>
		        <div class=".col-xs-4 .col-md-4"><div id="windrose7d" class="responsive-plot"></div></div>
		
		</div>
		<div id="data" class="row">
			<div id="ws"></div>
		</div>
		
		</div></body>

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
var windDir = {
  x:  <?php print_r(json_encode($ts)); ?> ,
  y: <?php print_r(json_encode($windDir)); ?>,
  xaxis: 'x4',
  yaxis: 'y4',
  type: 'scatter'
};

var rain = {
  x:  <?php print_r(json_encode($ts)); ?> ,
  y: <?php print_r(json_encode($rain)); ?>,
  type: 'scatter',
    xaxis: 'x5',
  yaxis: 'y5',
};

var barplot = {
  r:  <?php print_r(json_encode($windAvg)); ?> ,
  theta: <?php print_r(json_encode($windDir)); ?>,
  name: 'test',
  type: 'barpolar'
};

var barplot1d = {
  r:  <?php print_r(json_encode($windAvg1D)); ?> ,
  theta: <?php print_r(json_encode($windDir1D)); ?>,
  name: 'test',
  type: 'barpolar'
};

var barplot1h = {
  r:  <?php print_r(json_encode($windAvg1h)); ?> ,
  theta: <?php print_r(json_encode($windDir1h)); ?>,
  name: 'test',
  type: 'barpolar'
};
		 var data = [temp, hum, windAvg, windMax, windDir, rain];
		 var dataBP7d = [barplot,barplot];
                 var dataBP1d = [barplot1d,barplot1d];
                 var dataBP1h = [barplot1h];

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
		var config = {responsive: true};
                 Plotly.newPlot( 'windrose7d' , dataBP7d, layout,config);
                 Plotly.newPlot( 'windrose1d' , dataBP1d, layout,config);
                 Plotly.newPlot( 'windrose1h' , dataBP1h, layout,config);





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
var axis3 = {domain: [0.0, 0.95], anchor: 'y5'}
var axis9 = {domain: [0.0, 0.95], anchor: 'y4', showticklabels: false}
var axis7 = {domain: [0.0, 0.95], anchor: 'y3', showticklabels: false}
var axis4 = {domain: [0.40, 0.59], anchor: 'x3' }
var axis5 = {domain: [0.60, 0.79], anchor: 'x2' }
var axis6 = {domain: [0.20, 0.39], anchor: 'x4' }
var axis8 = {domain: [0.80, 0.99], anchor: 'x1' }
var axis10 ={domain: [0.00, 0.19], anchor: 'x5' } 

var layout2 = {
	title: "JK Zemun - Meteo stanica",
	showlegend: false,
	xaxis1: Object.assign(axis1,axis),
	xaxis2: Object.assign(axis2,axis),
	xaxis3: Object.assign(axis7,axis),
	yaxis1: Object.assign(axis8,axis),
	yaxis2: Object.assign(axis5,axis),
	yaxis3: Object.assign(axis4,axis),
	xaxis4: Object.assign(axis9,axis),
 	yaxis4: Object.assign(axis6,axis),
	xaxis5: Object.assign(axis3,axis),
	yaxis5: Object.assign(axis10,axis),
}



  Plotly.newPlot('ws', data, layout2,config);

(function() {
  var d3 = Plotly.d3;
  var WIDTH_IN_PERCENT_OF_PARENT = 100,
      HEIGHT_IN_PERCENT_OF_PARENT = 90;
  
  var gd3 = d3.selectAll(".responsive-plot")
      .style({
        width: WIDTH_IN_PERCENT_OF_PARENT + '%',
        'margin-left': (100 - WIDTH_IN_PERCENT_OF_PARENT) / 2 + '%',
        
        height: HEIGHT_IN_PERCENT_OF_PARENT + 'vh',
        'margin-top': (100 - HEIGHT_IN_PERCENT_OF_PARENT) / 2 + 'vh'
      });

  var nodes_to_resize = gd3[0]; //not sure why but the goods are within a nested array
  window.onresize = function() {
    for (var i = 0; i < nodes_to_resize.length; i++) {
      Plotly.Plots.resize(nodes_to_resize[i]);
    }
  };
  
}());

</script>
</html>
<?php 

}}

?>
