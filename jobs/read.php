<?php

function sendToUrl($url, $data)
{
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$headers = array(
		"Accept: application/json",
		"Content-Type: application/json",
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	$resp = curl_exec($curl);
	curl_close($curl);
	var_dump($resp);
}

function readPressure()
{
	return 0;
}

$oldLine = "";

$pressure = readPressure();

while (FALSE !== ($line = fgets(STDIN)))
{
	if ($oldLine != $line)
	{
		$jsonLine = json_decode($line, true);
		$jsonLine['pressure'] = $pressure;
		$line = json_encode($jsonLine);
		
		sendToUrl('http://localhost/push.php', $line);
		sendToUrl('http://ddwwwhost.cloudapp.net/push.php', $line);
		$oldLine = $line;
	}
}

?>
