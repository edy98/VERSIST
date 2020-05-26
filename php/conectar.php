<?php

	$USER = 'root';
	$PASS = '';

	try {
		$connection = new PDO('mysql:host=localhost;dbname=appinbur;charset=utf8' , $USER, $PASS);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Ocurrió un problema con la conexión " . $e->getMessage();
	}



?>
