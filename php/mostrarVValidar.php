<?php
//
header("Content-Type: text/json");
header("Access-Control-Allow-Origin:*");

include 'conectar.php';

try {
$sentencia = $connection->prepare("SELECT * FROM resultado_versist where accion = 'validar'");
$sentencia->execute();
$result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$datos = array();

  if (!empty($result)){
    foreach ($result as $row) {
      
      $datos[]=$row;
    }
  }else{
    $datos['message']="empty";
  }

} catch (PDOException $e) {
  echo "Ocurrió un problema al mostrar " . $e->getMessage();
}

$ajson = json_encode($datos);
echo $_GET["jsoncallback"].'('.$ajson.');';

 ?>
