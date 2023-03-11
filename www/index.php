<?php
$conn = new mysqli("localhost","root",trim(file_get_contents("pwd")),"weather");
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
		$windAvg[] = $row['wind_avg_m_s'];
		
		if ($row['wind_avg_m_s'] <= 0.5)
		{
			// 0 --- Calm	< 0.5 m/s
			$windAvg0[] = $row['wind_avg_m_s'];
			$windDir0[] = $row['wind_dir_deg'];
		}
		else if ($row['wind_avg_m_s'] > 0.5 && $row['wind_avg_m_s'] <= 1.5)
		{
			// 1 --- Light air	0.5-1.5 m/s
			$windAvg1[] = $row['wind_avg_m_s'];
			$windDir1[] = $row['wind_dir_deg'];
		}
		else if ($row['wind_avg_m_s'] > 1.5 && $row['wind_avg_m_s'] <= 3)
		{
			// 2 --- Light breeze 2-3 m/s
			$windAvg2[] = $row['wind_avg_m_s'];
			$windDir2[] = $row['wind_dir_deg'];
		}
		else if ($row['wind_avg_m_s'] > 3 && $row['wind_avg_m_s'] <= 5)
		{
			// 3 --- Gentle breeze 3.5-5 m/s
			$windAvg3[] = $row['wind_avg_m_s'];
			$windDir3[] = $row['wind_dir_deg'];
		}
		else if ($row['wind_avg_m_s'] > 5 && $row['wind_avg_m_s'] <= 8)
		{
			// 4 --- Moderate breeze 5.5-8 m/s
			$windAvg4[] = $row['wind_avg_m_s'];
			$windDir4[] = $row['wind_dir_deg'];
		}
		else if ($row['wind_avg_m_s'] > 8 && $row['wind_avg_m_s'] <= 10.5)
		{
			// 5 --- Fresh breeze 8.5-10.5 m/s
			$windAvg5[] = $row['wind_avg_m_s'];
			$windDir5[] = $row['wind_dir_deg'];
		}
		else if ($row['wind_avg_m_s'] > 10.5 && $row['wind_avg_m_s'] <= 13.5)
		{
			// 6 --- Strong breeze 11-13.5 m/s
			$windAvg6[] = $row['wind_avg_m_s'];
			$windDir6[] = $row['wind_dir_deg'];
		}
		else if ($row['wind_avg_m_s'] > 13.5 && $row['wind_avg_m_s'] <= 16.5)
		{
			// 7 --- Moderate gale 14-16.5 m/s
			$windAvg7[] = $row['wind_avg_m_s'];
			$windDir7[] = $row['wind_dir_deg'];
		}
		else if ($row['wind_avg_m_s'] > 16.5 && $row['wind_avg_m_s'] <= 20)
		{
			// 8 --- Fresh gale 17-20 m/s
			$windAvg8[] = $row['wind_avg_m_s'];
			$windDir8[] = $row['wind_dir_deg'];
		}
		else if ($row['wind_avg_m_s'] > 20)
		{
			$windAvg9[] = $row['wind_avg_m_s'];
			$windDir9[] = $row['wind_dir_deg'];
			// 9 --- Strong gale 20.5-23.5 m/s
			// 10 -- Whole gale 24-27.5 m/s
			// 11 -- Storm 28-31.5 m/s
			// 12 -- Hurricane  32 m/s
		}
		
		$windMax[] = $row['wind_max_m_s'];
		$batteryOk = $row['battery_ok'];

		if (strtotime($row['time']) > strtotime('-24 hour'))
		{
			if ($row['wind_avg_m_s'] <= 0.5)
			{
				// 0 --- Calm	< 0.5 m/s
				$windAvg1D0[] = $row['wind_avg_m_s'];
				$windDir1D0[] = $row['wind_dir_deg'];
			}
			else if ($row['wind_avg_m_s'] > 0.5 && $row['wind_avg_m_s'] <= 1.5)
			{
				// 1 --- Light air	0.5-1.5 m/s
				$windAvg1D1[] = $row['wind_avg_m_s'];
				$windDir1D1[] = $row['wind_dir_deg'];
			}
			else if ($row['wind_avg_m_s'] > 1.5 && $row['wind_avg_m_s'] <= 3)
			{
				// 2 --- Light breeze 2-3 m/s
				$windAvg1D2[] = $row['wind_avg_m_s'];
				$windDir1D2[] = $row['wind_dir_deg'];
			}
			else if ($row['wind_avg_m_s'] > 3 && $row['wind_avg_m_s'] <= 5)
			{
				// 3 --- Gentle breeze 3.5-5 m/s
				$windAvg1D3[] = $row['wind_avg_m_s'];
				$windDir1D3[] = $row['wind_dir_deg'];
			}
			else if ($row['wind_avg_m_s'] > 5 && $row['wind_avg_m_s'] <= 8)
			{
				// 4 --- Moderate breeze 5.5-8 m/s
				$windAvg1D4[] = $row['wind_avg_m_s'];
				$windDir1D4[] = $row['wind_dir_deg'];
			}
			else if ($row['wind_avg_m_s'] > 8 && $row['wind_avg_m_s'] <= 10.5)
			{
				// 5 --- Fresh breeze 8.5-10.5 m/s
				$windAvg1D5[] = $row['wind_avg_m_s'];
				$windDir1D5[] = $row['wind_dir_deg'];
			}
			else if ($row['wind_avg_m_s'] > 10.5 && $row['wind_avg_m_s'] <= 13.5)
			{
				// 6 --- Strong breeze 11-13.5 m/s
				$windAvg1D6[] = $row['wind_avg_m_s'];
				$windDir1D6[] = $row['wind_dir_deg'];
			}
			else if ($row['wind_avg_m_s'] > 13.5 && $row['wind_avg_m_s'] <= 16.5)
			{
				// 7 --- Moderate gale 14-16.5 m/s
				$windAvg1D7[] = $row['wind_avg_m_s'];
				$windDir1D7[] = $row['wind_dir_deg'];
			}
			else if ($row['wind_avg_m_s'] > 16.5 && $row['wind_avg_m_s'] <= 20)
			{
				// 8 --- Fresh gale 17-20 m/s
				$windAvg1D8[] = $row['wind_avg_m_s'];
				$windDir1D8[] = $row['wind_dir_deg'];
			}
			else if ($row['wind_avg_m_s'] > 20)
			{
				$windAvg1D9[] = $row['wind_avg_m_s'];
				$windDir1D9[] = $row['wind_dir_deg'];
				// 9 --- Strong gale 20.5-23.5 m/s
				// 10 -- Whole gale 24-27.5 m/s
				// 11 -- Storm 28-31.5 m/s
				// 12 -- Hurricane  32 m/s
			}

			if (strtotime($row['time']) > strtotime('-1 hour'))
			{
				if ($row['wind_avg_m_s'] <= 0.5)
				{
					// 0 --- Calm	< 0.5 m/s
					$windAvg1H0[] = $row['wind_avg_m_s'];
					$windDir1H0[] = $row['wind_dir_deg'];
				}
				else if ($row['wind_avg_m_s'] > 0.5 && $row['wind_avg_m_s'] <= 1.5)
				{
					// 1 --- Light air	0.5-1.5 m/s
					$windAvg1H1[] = $row['wind_avg_m_s'];
					$windDir1H1[] = $row['wind_dir_deg'];
				}
				else if ($row['wind_avg_m_s'] > 1.5 && $row['wind_avg_m_s'] <= 3)
				{
					// 2 --- Light breeze 2-3 m/s
					$windAvg1H2[] = $row['wind_avg_m_s'];
					$windDir1H2[] = $row['wind_dir_deg'];
				}
				else if ($row['wind_avg_m_s'] > 3 && $row['wind_avg_m_s'] <= 5)
				{
					// 3 --- Gentle breeze 3.5-5 m/s
					$windAvg1H3[] = $row['wind_avg_m_s'];
					$windDir1H3[] = $row['wind_dir_deg'];
				}
				else if ($row['wind_avg_m_s'] > 5 && $row['wind_avg_m_s'] <= 8)
				{
					// 4 --- Moderate breeze 5.5-8 m/s
					$windAvg1H4[] = $row['wind_avg_m_s'];
					$windDir1H4[] = $row['wind_dir_deg'];
				}
				else if ($row['wind_avg_m_s'] > 8 && $row['wind_avg_m_s'] <= 10.5)
				{
					// 5 --- Fresh breeze 8.5-10.5 m/s
					$windAvg1H5[] = $row['wind_avg_m_s'];
					$windDir1H5[] = $row['wind_dir_deg'];
				}
				else if ($row['wind_avg_m_s'] > 10.5 && $row['wind_avg_m_s'] <= 13.5)
				{
					// 6 --- Strong breeze 11-13.5 m/s
					$windAvg1H6[] = $row['wind_avg_m_s'];
					$windDir1H6[] = $row['wind_dir_deg'];
				}
				else if ($row['wind_avg_m_s'] > 13.5 && $row['wind_avg_m_s'] <= 16.5)
				{
					// 7 --- Moderate gale 14-16.5 m/s
					$windAvg1H7[] = $row['wind_avg_m_s'];
					$windDir1H7[] = $row['wind_dir_deg'];
				}
				else if ($row['wind_avg_m_s'] > 16.5 && $row['wind_avg_m_s'] <= 20)
				{
					// 8 --- Fresh gale 17-20 m/s
					$windAvg1H8[] = $row['wind_avg_m_s'];
					$windDir1H8[] = $row['wind_dir_deg'];
				}
				else if ($row['wind_avg_m_s'] > 20)
				{
					$windAvg1H9[] = $row['wind_avg_m_s'];
					$windDir1H9[] = $row['wind_dir_deg'];
					// 9 --- Strong gale 20.5-23.5 m/s
					// 10 -- Whole gale 24-27.5 m/s
					// 11 -- Storm 28-31.5 m/s
					// 12 -- Hurricane  32 m/s
				}
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
	<div id="srvinfo" class="row">
		<div class="col-xs-8 col-md-8">Server @<?php echo $uptime; ?></div>
		<div class="col-xs-4 col-md-4">Weather station battery life: <?php if ($batteryOk == 1) { echo 'OK'; } else { echo 'Error'; } ?></div>
	</div>
	<div id="windrose" class="row">
		<div class="col-xs-12 col-md-4"><div id="windrose1h" class="responsive-plot"></div></div>
	        <div class="col-xs-12 col-md-4"><div id="windrose1d" class="responsive-plot"></div></div>
	        <div class="col-xs-12 col-md-4"><div id="windrose7d" class="responsive-plot"></div></div>
	</div>
	<div id="data" class="row">
		<div id="ws" class="col-xs-12 col-md-12"></div>
	</div>
</div>
</body>

<script>
var temp = {
	x: <?php print_r(json_encode($ts)); ?>,
 	y: <?php print_r(json_encode($temp)); ?>,
	xaxis: 'x1',
	yaxis: 'y1',
	type: 'scatter'
};

var hum = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($hum)); ?>,
	xaxis: 'x2',
	yaxis: 'y2',
	type: 'scatter'
};

var windAvg = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($windAvg)); ?>,
	xaxis: 'x3',
	yaxis: 'y3',
	type: 'scatter'
};

var windMax = {
	  x: <?php print_r(json_encode($ts)); ?>,
	  y: <?php print_r(json_encode($windMax)); ?>,
	  xaxis: 'x3',
	  yaxis: 'y3',
	  type: 'scatter'
};

var windDir = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($windDir)); ?>,
	xaxis: 'x4',
	yaxis: 'y4',
	type: 'scatter'
};

var rain = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($rain)); ?>,
	xaxis: 'x5',
	yaxis: 'y5',
	type: 'scatter'
};

var barplot0 = {
	r: <?php print_r(json_encode($windAvg0)); ?>,
	theta: <?php print_r(json_encode($windDir0)); ?>,
	name: '<0.5m/s',
	type: 'scatterpolar'
};
			    
var barplot1 = {
	r: <?php print_r(json_encode($windAvg1)); ?>,
	theta: <?php print_r(json_encode($windDir1)); ?>,
	name: '0.5-1.5m/s',
	type: 'scatterpolar'
};

var barplot2 = {
	r: <?php print_r(json_encode($windAvg2)); ?>,
	theta: <?php print_r(json_encode($windDir2)); ?>,
	name: '1.5-3m/s',
	type: 'scatterpolar'
};

var barplot3 = {
	r: <?php print_r(json_encode($windAvg3)); ?>,
	theta: <?php print_r(json_encode($windDir3)); ?>,
	name: '3-5m/s',
	type: 'scatterpolar'
};

var barplot4 = {
	r: <?php print_r(json_encode($windAvg4)); ?>,
	theta: <?php print_r(json_encode($windDir4)); ?>,
	name: '5-8m/s',
	type: 'scatterpolar'
};

var barplot5 = {
	r: <?php print_r(json_encode($windAvg5)); ?>,
	theta: <?php print_r(json_encode($windDir5)); ?>,
	name: '8-10.5m/s',
	type: 'scatterpolar'
};
			    
var barplot6 = {
	r: <?php print_r(json_encode($windAvg6)); ?>,
	theta: <?php print_r(json_encode($windDir6)); ?>,
	name: '10.5-13.5m/s',
	type: 'scatterpolar'
};
			    
var barplot7 = {
	r: <?php print_r(json_encode($windAvg7)); ?>,
	theta: <?php print_r(json_encode($windDir7)); ?>,
	name: '13.5-16.5m/s',
	type: 'scatterpolar'
};

var barplot8 = {
	r: <?php print_r(json_encode($windAvg8)); ?>,
	theta: <?php print_r(json_encode($windDir8)); ?>,
	name: '16.5-20m/s',
	type: 'scatterpolar'
};

var barplot9 = {
	r: <?php print_r(json_encode($windAvg9)); ?>,
	theta: <?php print_r(json_encode($windDir9)); ?>,
	name: '>20m/s',
	type: 'scatterpolar'
};

var barplot0h = {
	r: <?php print_r(json_encode($windAvg1H0)); ?>,
	theta: <?php print_r(json_encode($windDir1H0)); ?>,
	name: '<0.5m/s',
	type: 'scatterpolar'
};

var barplot1h = {
	r: <?php print_r(json_encode($windAvg1H1)); ?>,
	theta: <?php print_r(json_encode($windDir1H1)); ?>,
	name: '0.5-1.5m/s',
	type: 'scatterpolar'
};

var barplot2h = {
	r: <?php print_r(json_encode($windAvg1H2)); ?>,
	theta: <?php print_r(json_encode($windDir1H2)); ?>,
	name: '1.5-3m/s',
	type: 'scatterpolar'
};

var barplot3h = {
	r: <?php print_r(json_encode($windAvg1H3)); ?>,
	theta: <?php print_r(json_encode($windDir1H3)); ?>,
	name: '3-5m/s',
	type: 'scatterpolar'
};

var barplot4h = {
	r: <?php print_r(json_encode($windAvg1H4)); ?>,
	theta: <?php print_r(json_encode($windDir1H4)); ?>,
	name: '5-8m/s',
	type: 'scatterpolar'
};

var barplot5h = {
	r: <?php print_r(json_encode($windAvg1H5)); ?>,
	theta: <?php print_r(json_encode($windDir1H5)); ?>,
	name: '8-10.5m/s',
	type: 'scatterpolar'
};
			    
var barplot6h = {
	r: <?php print_r(json_encode($windAvg1H6)); ?>,
	theta: <?php print_r(json_encode($windDir1H6)); ?>,
	name: '10.5-13.5m/s',
	type: 'scatterpolar'
};
			    
var barplot7h = {
	r: <?php print_r(json_encode($windAvg1H7)); ?>,
	theta: <?php print_r(json_encode($windDir1H7)); ?>,
	name: '13.5-16.5m/s',
	type: 'scatterpolar'
};

var barplot8h = {
	r: <?php print_r(json_encode($windAvg1H8)); ?>,
	theta: <?php print_r(json_encode($windDir1H8)); ?>,
	name: '16.5-20m/s',
	type: 'scatterpolar'
};

var barplot9h = {
	r: <?php print_r(json_encode($windAvg1H9)); ?>,
	theta: <?php print_r(json_encode($windDir1H9)); ?>,
	name: '>20m/s',
	type: 'scatterpolar'
};

var barplot0d = {
	r: <?php print_r(json_encode($windAvg1D0)); ?>,
	theta: <?php print_r(json_encode($windDir1D0)); ?>,
	name: '<0.5m/s',
	type: 'scatterpolar'
};

var barplot1d = {
	r: <?php print_r(json_encode($windAvg1D1)); ?>,
	theta: <?php print_r(json_encode($windDir1D1)); ?>,
	name: '0.5-1.5m/s',
	type: 'scatterpolar'
};

var barplot2d = {
	r: <?php print_r(json_encode($windAvg1D2)); ?>,
	theta: <?php print_r(json_encode($windDir1D2)); ?>,
	name: '1.5-3m/s',
	type: 'scatterpolar'
};

var barplot3d = {
	r: <?php print_r(json_encode($windAvg1D3)); ?>,
	theta: <?php print_r(json_encode($windDir1D3)); ?>,
	name: '3-5m/s',
	type: 'scatterpolar'
};

var barplot4d = {
	r: <?php print_r(json_encode($windAvg1D4)); ?>,
	theta: <?php print_r(json_encode($windDir1D4)); ?>,
	name: '5-8m/s',
	type: 'scatterpolar'
};

var barplot5d = {
	r: <?php print_r(json_encode($windAvg1D5)); ?>,
	theta: <?php print_r(json_encode($windDir1D5)); ?>,
	name: '8-10.5m/s',
	type: 'scatterpolar'
};
			    
var barplot6d = {
	r: <?php print_r(json_encode($windAvg1D6)); ?>,
	theta: <?php print_r(json_encode($windDir1D6)); ?>,
	name: '10.5-13.5m/s',
	type: 'scatterpolar'
};
			    
var barplot7d = {
	r: <?php print_r(json_encode($windAvg1D7)); ?>,
	theta: <?php print_r(json_encode($windDir1D7)); ?>,
	name: '13.5-16.5m/s',
	type: 'scatterpolar'
};

var barplot8d = {
	r: <?php print_r(json_encode($windAvg1D8)); ?>,
	theta: <?php print_r(json_encode($windDir1D8)); ?>,
	name: '16.5-20m/s',
	type: 'scatterpolar'
};

var barplot9d = {
	r: <?php print_r(json_encode($windAvg1D9)); ?>,
	theta: <?php print_r(json_encode($windDir1D9)); ?>,
	name: '>20m/s',
	type: 'scatterpolar'
};

var dataBP7d = [barplot1,barplot2,barplot3,barplot4,barplot5,barplot6,barplot7,barplot8,barplot9];
var dataBP1d = [barplot1d,barplot2d,barplot3d,barplot4d,barplot5d,barplot6d,barplot7d,barplot8d,barplot9d];
var dataBP1h = [barplot1h,barplot2h,barplot3h,barplot4h,barplot5h,barplot6h,barplot7h,barplot8h,barplot9h];

var layout7d = {
	title: "JK Zemun - Meteo stanica - 7 dana",
	polar: {
		barmode: "overlay",
		bargap: 0,
		radialaxis: {ticksuffix: "m/s", angle: 0, dtick: 1},
		angularaxis: {direction: "clockwise"}
	},
	grid: {rows: 1, columns: 1, pattern: 'independent'},
};
	
var layout1d = {
	title: "JK Zemun - Meteo stanica - 24 sata",
	polar: {
		barmode: "overlay",
		bargap: 0,
		radialaxis: {ticksuffix: "m/s", angle: 0, dtick: 1},
		angularaxis: {direction: "clockwise"}
	},
	grid: {rows: 1, columns: 1, pattern: 'independent'},
};
	
var layout1h = {
	title: "JK Zemun - Meteo stanica - poslednji sat",
	polar: {
		barmode: "overlay",
		bargap: 0,
		radialaxis: {ticksuffix: "m/s", angle: 0, dtick: 1},
		angularaxis: {direction: "clockwise"}
	},
	grid: {rows: 1, columns: 1, pattern: 'independent'},
};

var config = {responsive: true};
Plotly.newPlot( 'windrose7d' , dataBP7d, layout7d, config);
Plotly.newPlot( 'windrose1d' , dataBP1d, layout1d, config);
Plotly.newPlot( 'windrose1h' , dataBP1h, layout1h, config);

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

var layoutChart = {
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

var data = [temp, hum, windAvg, windMax, windDir, rain];
Plotly.newPlot('ws', data, layoutChart, config);

</script>
</html>
<?php 

}

?>
