<?php
header("Content-Type: text/json");
header("Access-Control-Allow-Origin:*");

include "conectar.php";

//Se prepara y ejecuta la sentencia para mostrar en la tabla-Rpn.html
try {
$sentencia = $connection->prepare("SELECT rpn.*, GROUP_CONCAT(rpnissuelinks.name_issuelink	) as incidencias, rpnattachment.namefile FROM rpn
  LEFT JOIN rpnissuelinks ON rpnissuelinks.clave_rpn = rpn.clave_rpn
  LEFT JOIN rpnattachment ON rpnattachment.clave_rpn = rpn.clave_rpn
  GROUP BY rpn.clave_rpn");
$sentencia->execute();
$resultt = $sentencia->fetchAll(PDO::FETCH_ASSOC);

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
