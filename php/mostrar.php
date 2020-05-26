<?php
header("Content-Type: text/json");
header("Access-Control-Allow-Origin:*");

include "conectar.php";

//Se prepara y ejecuta la sentencia para mostrar en la tabla-versist.html
try {
$sentencia = $connection->prepare("SELECT versist.*, GROUP_CONCAT(versistissuelinks.name_issuelink) as incidencias, versistattachment.namefile FROM versist
  LEFT JOIN versistissuelinks ON versistissuelinks.clave = versist.clave
  LEFT JOIN versistattachment ON versistattachment.clave = versist.clave
  GROUP BY versist.clave");
$sentencia->execute();
$result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$datos = array();

//Se verifica que el resultado de la sentencia sql contenga los datos
if (!empty($result)){
  //Se recorren los registros
  foreach ($result as $row) {
    //Se almacenan en el arreglo a enviar a la función btnMostrar() del arhivo funcionescrud.js
    $datos[]=$row;
  }
}

} catch (PDOException $e) {
  echo "Ocurrió un problema al mostrar " . $e->getMessage();
}

//Conversión de los datos a formato json
$ajson = json_encode($datos);
echo $_GET["jsoncallback"].'('.$ajson.');';

?>
