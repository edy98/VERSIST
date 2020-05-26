<?php
header("Content-Type: text/json");
header("Access-Control-Allow-Origin:*");

include 'conectar.php';

//Se obtiene la información de la consulta
try {
$sentencia = $connection->prepare("SELECT name_issuelink FROM versistissuelinks WHERE name_issuelink LIKE 'RPN%' AND clave IN(SELECT clave from resultado_versist where accion = 'validar')");
$sentencia->execute();
$result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$datos = array();

  if (!empty($result)){
  	//Se recorre la información
    foreach ($result as $row) {
      //se almacena en el arreglo
      $datos[]=$row;
    }
  }else{
  	//En caso de que no se obtenga nada, se manda el mensaje
    $datos['message']="empty";
  }

} catch (PDOException $e) {
  echo "Ocurrió un problema al mostrar " . $e->getMessage();
}

//conversión de los datos a json
$ajson = json_encode($datos);
echo $_GET["jsoncallback"].'('.$ajson.');';

 ?>
