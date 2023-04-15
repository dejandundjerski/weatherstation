<?php

$conn = new mysqli("localhost","root",trim(file_get_contents("pwd")),"weather");

if ($conn->query("DELETE FROM data WHERE time < now() - INTERVAL 3 day;"))
{
    printf("data records older than 8 days deleted successfully.");
}

if ($conn->errno)
{
    printf("Could not delete records from table [data]: %s.", $conn->errno);
}

?>
