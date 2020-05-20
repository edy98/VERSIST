<?php
header("Content-Type: text/json");
header("Access-Control-Allow-Origin:*");

include 'conectar.php';

try {
$sentencia = $connection->prepare("SELECT * FROM resultado_versist");
$sentencia->execute();
$result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$datos = array();

if (!empty($result)){
  foreach ($result as $row) {
    //echo $row['clave'] . " " . $row['tipo_incidencia'];
    $datos[]=$row;
  }
}

} catch (PDOException $e) {
  echo "Ocurrió un problema al mostrar " . $e->getMessage();
}

$ajson = json_encode($datos);
echo $_GET["jsoncallback"].'('.$ajson.');';

 ?>
