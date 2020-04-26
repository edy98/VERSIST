<?php

/*$servername = "localhost1";
$username = "root";
$password = "";
$dbname = "appinbur";

$mysqli= new mysqli($servername, $username, $password, $dbname) or die(mysqli_error());
if ($mysqli->connect_errno) {
	# code...
	echo "Falló conexión". $mysqli->connect_errno . ") " . $mysqli->connect_error;
}*/


	$USER = 'root';
	$PASS = '';

	try {
		$connection = new PDO('mysql:host=localhost;dbname=appinbur;charset=utf8' , $USER, $PASS);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Ocurrió un problema con la conexión " . $e->getMessage();
	}



?>
