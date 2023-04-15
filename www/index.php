<?php
$output = true;

if (isset($_GET['output']) && $_GET['output'] == 'json')
{
	$output = false;
	$onlyLast = false;
	if (isset($_GET['period']) && $_GET['period'] == "current")
	{
		$query = "SELECT * FROM data ORDER BY id DESC LIMIT 1;";
	}
}

$range = "7 day";
if (isset($_GET['range']))
{
	if ($_GET['range'] == "3d")
	{
		$range = "3 day";
	}
	else if ($_GET['range'] == "1d")
	{
		$range = "1 day";
	}
	else if ($_GET['range'] == "1h")
	{
		$range = "1 hour";
	}
}

$query = "SELECT * FROM data WHERE time > now() - INTERVAL " . $range . ";";
$conn = new mysqli("localhost","root",trim(file_get_contents("pwd")),"weather");
$res = $conn->query($query);

while ($row = $res->fetch_assoc()) {
	$lastRow = $row;
	if (!$output)
	{
		$array[] = $row;
	}
	else
	{
		$ts[] = $row['time'];
		$temp[] = $row['temperature_C'];
		$pressure[] = $row['pressure'];
		$hum[] = $row['humidity'];
		$rain[] = $row['rain_mm'];
		$windDir[] = $row['wind_dir_deg'];
		$windAvg[] = $row['wind_avg_m_s'];
		$windMax[] = $row['wind_max_m_s'];

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
	<div id="lastmeasure" class="row">
		<div class="col-xs-12 col-md-6">
			<table class="table">
				<tr><td colspan="2" align="center"></td></tr>
				<tr><td colspan="2" align="center">
					<a class="btn btn-primary btn-sm" href="index.php" role="button">Last 7 days</a>
					<a class="btn btn-primary btn-sm" href="index.php?range=3d" role="button">Last 3 days</a>
					<a class="btn btn-primary btn-sm" href="index.php?range=1d" role="button">Last day</a>
					<a class="btn btn-primary btn-sm" href="index.php?range=1h" role="button">Last hour</a>
				</td></tr>
				<tr><th scope="row">Vreme merenja</th><td><?php echo $lastRow['time']; ?></td></tr>
				<tr><th scope="row">Baterija</th><td><?php if ($lastRow['battery_ok'] == 1) { echo 'OK'; } else { echo 'End of life'; } ?></td></tr>
				<tr><th scope="row">Temp*C</th><td><?php echo $lastRow['temperature_C']; ?></td></tr>
				<tr><th scope="row">Pritisak(hPa)</th><td><?php echo $lastRow['pressure']; ?></td></tr>
				<tr><th scope="row">Vlaznost(%)</th><td><?php echo $lastRow['humidity']; ?></td></tr>
				<tr><th scope="row">Vetar AVG(m/s)</th><td><?php echo $lastRow['wind_avg_m_s']; ?></td></tr>
				<tr><th scope="row">Vetar MAX(m/s)</th><td><?php echo $lastRow['wind_max_m_s']; ?></td></tr>
				<tr><th scope="row">Pravac Vetra</th><td><?php echo $lastRow['wind_dir_deg']; ?></td></tr>
			</table>
		</div>
		<div class="col-xs-12 col-md-6"><div id="windrose1h" class="responsive-plot"></div></div>
	</div>
	<!--
	<div id="windrose" class="row">
		<div class="col-xs-12 col-md-6"><div id="windrose1h" class="responsive-plot"></div></div>
		<div class="col-xs-12 col-md-6"><div id="windrose1d" class="responsive-plot"></div></div>  
	</div>-->
	<div id="data" class="row">
		<div id="ws"></div>
	</div>
</div>
</body>

<script>
var temp = {
	x: <?php print_r(json_encode($ts)); ?>,
 	y: <?php print_r(json_encode($temp)); ?>,
	xaxis: 'x1',
	yaxis: 'y1',
	name: 'Temp*C',
	type: 'scatter'
};

var hum = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($hum)); ?>,
	xaxis: 'x2',
	yaxis: 'y2',
	name: 'Vlaznost(%)',
	type: 'scatter'
};
	
var pressure = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($pressure)); ?>,
	xaxis: 'x3',
	yaxis: 'y3',
	name: 'Pritisak (hPa)',
	type: 'scatter'
};

var windAvg = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($windAvg)); ?>,
	xaxis: 'x4',
	yaxis: 'y4',
	name: 'Vetar AVG(m/s)',
	type: 'scatter'
};

var windMax = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($windMax)); ?>,
	xaxis: 'x4',
	yaxis: 'y4',
	name: 'Vetar MAX(m/s)',
	type: 'scatter'
};

var windDir = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($windDir)); ?>,
	xaxis: 'x5',
	yaxis: 'y5',
	name: 'Pravac vetra',
	type: 'scatter'
};

var rain = {
	x: <?php print_r(json_encode($ts)); ?>,
	y: <?php print_r(json_encode($rain)); ?>,
	xaxis: 'x6',
	yaxis: 'y6',
	name: 'Kisa (mm)',
	type: 'scatter'
};

var barplot0h = {
	r: <?php print_r(json_encode($windAvg1H0)); ?>,
	theta: <?php print_r(json_encode($windDir1H0)); ?>,
	name: '<0.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot1h = {
	r: <?php print_r(json_encode($windAvg1H1)); ?>,
	theta: <?php print_r(json_encode($windDir1H1)); ?>,
	name: '0.5-1.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot2h = {
	r: <?php print_r(json_encode($windAvg1H2)); ?>,
	theta: <?php print_r(json_encode($windDir1H2)); ?>,
	name: '1.5-3m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot3h = {
	r: <?php print_r(json_encode($windAvg1H3)); ?>,
	theta: <?php print_r(json_encode($windDir1H3)); ?>,
	name: '3-5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot4h = {
	r: <?php print_r(json_encode($windAvg1H4)); ?>,
	theta: <?php print_r(json_encode($windDir1H4)); ?>,
	name: '5-8m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot5h = {
	r: <?php print_r(json_encode($windAvg1H5)); ?>,
	theta: <?php print_r(json_encode($windDir1H5)); ?>,
	name: '8-10.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
}

var barplot6h = {
	r: <?php print_r(json_encode($windAvg1H6)); ?>,
	theta: <?php print_r(json_encode($windDir1H6)); ?>,
	name: '10.5-13.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};
			    
var barplot7h = {
	r: <?php print_r(json_encode($windAvg1H7)); ?>,
	theta: <?php print_r(json_encode($windDir1H7)); ?>,
	name: '13.5-16.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot8h = {
	r: <?php print_r(json_encode($windAvg1H8)); ?>,
	theta: <?php print_r(json_encode($windDir1H8)); ?>,
	name: '16.5-20m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot9h = {
	r: <?php print_r(json_encode($windAvg1H9)); ?>,
	theta: <?php print_r(json_encode($windDir1H9)); ?>,
	name: '>20m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot0d = {
	r: <?php print_r(json_encode($windAvg1D0)); ?>,
	theta: <?php print_r(json_encode($windDir1D0)); ?>,
	name: '<0.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot1d = {
	r: <?php print_r(json_encode($windAvg1D1)); ?>,
	theta: <?php print_r(json_encode($windDir1D1)); ?>,
	name: '0.5-1.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot2d = {
	r: <?php print_r(json_encode($windAvg1D2)); ?>,
	theta: <?php print_r(json_encode($windDir1D2)); ?>,
	name: '1.5-3m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot3d = {
	r: <?php print_r(json_encode($windAvg1D3)); ?>,
	theta: <?php print_r(json_encode($windDir1D3)); ?>,
	name: '3-5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot4d = {
	r: <?php print_r(json_encode($windAvg1D4)); ?>,
	theta: <?php print_r(json_encode($windDir1D4)); ?>,
	name: '5-8m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot5d = {
	r: <?php print_r(json_encode($windAvg1D5)); ?>,
	theta: <?php print_r(json_encode($windDir1D5)); ?>,
	name: '8-10.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};
			    
var barplot6d = {
	r: <?php print_r(json_encode($windAvg1D6)); ?>,
	theta: <?php print_r(json_encode($windDir1D6)); ?>,
	name: '10.5-13.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};
			    
var barplot7d = {
	r: <?php print_r(json_encode($windAvg1D7)); ?>,
	theta: <?php print_r(json_encode($windDir1D7)); ?>,
	name: '13.5-16.5m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot8d = {
	r: <?php print_r(json_encode($windAvg1D8)); ?>,
	theta: <?php print_r(json_encode($windDir1D8)); ?>,
	name: '16.5-20m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var barplot9d = {
	r: <?php print_r(json_encode($windAvg1D9)); ?>,
	theta: <?php print_r(json_encode($windDir1D9)); ?>,
	name: '>20m/s',
	type: 'scatterpolar',
        mode: 'markers+text'
};

var dataBP1d = [barplot1d,barplot2d,barplot3d,barplot4d,barplot5d,barplot6d,barplot7d,barplot8d,barplot9d];
var dataBP1h = [barplot1h,barplot2h,barplot3h,barplot4h,barplot5h,barplot6h,barplot7h,barplot8h,barplot9h];
	
var layout1d = {
	title: "JKZ - Ruza vetrova - 24 sata",
	polar: {
		barmode: "overlay",
		bargap: 0,
		radialaxis: {ticksuffix: "m/s", angle: 0, dtick: 1},
		angularaxis: {direction: "clockwise"}
	},
	grid: {rows: 1, columns: 1, pattern: 'independent'},
};
	
var layout1h = {
	title: "JKZ - Ruza vetrova - poslednji sat",
	polar: {
		barmode: "overlay",
		bargap: 0,
		radialaxis: {ticksuffix: "m/s", angle: 0, dtick: 1},
		angularaxis: {direction: "clockwise"}
	},
	grid: {rows: 1, columns: 1, pattern: 'independent'},
};

var config = {responsive: true};
//Plotly.newPlot( 'windrose1d' , dataBP1d, layout1d, config);
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
var axis11 = {domain: [0.0, 0.95], anchor: 'y6', showticklabels: false}
var axis4 = {domain: [0.49, 0.65], anchor: 'x3' }
var axis5 = {domain: [0.66, 0.82], anchor: 'x2' }
var axis6 = {domain: [0.33, 0.48], anchor: 'x4' }
var axis8 = {domain: [0.83, 0.99], anchor: 'x1' }
var axis10 ={domain: [0.16, 0.32], anchor: 'x5' } 
var axis12 ={domain: [0.00, 0.15], anchor: 'x6' } 

var layoutChart = {
	title: "JK Zemun - Meteo stanica",
	showlegend: true,
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
	xaxis6: Object.assign(axis11,axis),
	yaxis6: Object.assign(axis12,axis),
}

var data = [temp, hum, pressure, windAvg, windMax, windDir, rain];
Plotly.newPlot('ws', data, layoutChart, config);

</script>
</html>
<?php 

}

?>
