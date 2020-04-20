<?php

/* Declaramos las variables de conexion al servidor MySQL */
$servername = "localhost1";
$username = "root";
$password = "";
$dbname = "appinbur";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_error()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>