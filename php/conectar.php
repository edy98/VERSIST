<?php

$servername = "localhost1";
$username = "root";
$password = "";
$dbname = "appinbur";

$mysqli= new mysqli($servername, $username, $password, $dbname) or die(mysqli_error());
if ($mysqli->connect_errno) {
	# code...
	echo "Falló conexión". $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>