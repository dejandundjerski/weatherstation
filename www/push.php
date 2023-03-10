<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$json = file_get_contents('php://input');
	$_POST = json_decode($json, true);
        if ($_POST['model'] == 'Cotech-367959' && $_POST['id'] = 152)
	{
		$query = "INSERT INTO data (time, battery_ok, temperature_C, humidity, rain_mm, wind_dir_deg, wind_avg_m_s, wind_max_m_s) VALUES ('" . $_POST['time'] . "'," . $_POST['battery_ok'] . ", '" . $_POST['temperature_C'] . "'," . $_POST['humidity'] . ",'" . $_POST['rain_mm'] . "'," . $_POST['wind_dir_deg'] . ",'" . $_POST['wind_avg_m_s'] . "','" . $_POST['wind_max_m_s'] . "' );";
	}
	else
	{
		$query = "INSERT INTO rawdata (time, jsondata) VALUES ('" . $_POST['time'] . "','" . json_encode($_POST) . "');";
	}
	
	$conn = new mysqli("localhost","root",trim(file_get_contents("pwd")),"weather");
        $stmt = $conn->prepare($query); 
	$stmt->execute();	
}

?>
