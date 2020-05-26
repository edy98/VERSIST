<?php
header("Content-Type: text/json");
header("Access-Control-Allow-Origin:*");

include 'conectar.php';

//se ejecuta la sentencia
try {
$sentencia = $connection->prepare("SELECT * FROM resultado_versist");
$sentencia->execute();
//se almacena la informacion en variable
$result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$datos = array();
//Se valida que se obtenga algo
if (!empty($result)){
	//se recorre la variable donde se alojo la información
  foreach ($result as $row) {
    //se almacena en arreglo
    $datos[]=$row;
  }
}

} catch (PDOException $e) {
  echo "Ocurrió un problema al mostrar " . $e->getMessage();
}

//se convierte a formato json
$ajson = json_encode($datos);
echo $_GET["jsoncallback"].'('.$ajson.');';

 ?>
