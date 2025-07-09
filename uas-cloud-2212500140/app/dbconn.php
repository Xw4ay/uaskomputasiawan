<?php
$servername = "mysql"; //or you could use hostname (service name if using docker-compose)
$username = "root";
$password = "root";
$dbname = "uas_cloud2212500140";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


