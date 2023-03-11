<?php

$conn = new mysqli("localhost","root",trim(file_get_contents("pwd")),"weather");
$res = $conn->query("SELECT now() - max(time) AS 'last_snapshot_in_sec' FROM data;");

while ($row = $res->fetch_assoc())
{
    if ($row['last_snapshot_in_sec'] > 300)
    {
        exec('sudo reboot');
    }
}

?>
