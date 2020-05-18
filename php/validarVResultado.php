<?php
header("Content-Type: text/json");
header("Access-Control-Allow-Origin:*");

include 'conectar.php';
/*
try {
$sentencia = $connection->prepare("SELECT versistv_estado.claveV, sum(versistv_estado.estado+versistv_incidenciae.incidenciaenlazada+versistv_tincindecia.tipoincidencia+versistv_attachment.attachment) as resultado
FROM versistv_estado LEFT JOIN versistv_incidenciae ON versistv_incidenciae.claveV = versistv_estado.claveV
LEFT JOIN versistv_tincindecia ON versistv_tincindecia.claveV = versistv_estado.claveV
LEFT JOIN versistv_attachment ON versistv_attachment.claveV = versistv_estado.claveV
GROUP by versistv_estado.claveV");
$sentencia->execute();
$result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)){
  foreach ($result as $row) {
    if ($row['resultado'] == 4) {
      echo $row['claveV'] . "  " . "Validar";
      $id = $row['claveV'];
      $valorCampo = 'Validar';
      insertarResultadoV($id,$valorCampo);
    }else{
      echo "<br>";
      echo $row['claveV'] . "  " . "Cancelar";
      $id = $row['claveV'];
      $valorCampo = 'Cancelar';
      insertarResultadoV($id,$valorCampo);
    }
    echo "<br>";
    echo $row['claveV'] . "  " . $row['resultado'];
    //$datos[]=$row;
  }
}

} catch (PDOException $e) {
  echo "Ocurrió un problema al mostrar " . $e->getMessage();
}


function insertarResultadoV($id,$valorCampo){
  try {
    $USER = 'root';
  	$PASS = '';
    $connection = new PDO('mysql:host=localhost;dbname=appinbur;charset=utf8' , $USER, $PASS);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Se prepara las sentencia a ejecutar
    $queryVersist = $connection->prepare("INSERT INTO versistv_resultado(claveV, accion)
                  VALUES (:claveV, :type)");
                    $queryVersist->bindParam(':claveV', $id);
                    $queryVersist->bindParam(':type', $valorCampo);
                    return $queryVersist->execute();

    } catch (PDOException $e) {
                  echo "<br>1 Ocurrió un problema con la inserción " . $e->getMessage();
  }
}
*/
//Código para

try {
$sentencia = $connection->prepare("SELECT versistv_estado.claveV, versistv_resultado.accion, versistv_estado.estado, versistv_tincindecia.tipoincidencia, versistv_incidenciae.incidenciaenlazada, versistv_attachment.attachment
  FROM versistv_estado
  LEFT JOIN versistv_resultado ON versistv_resultado.claveV = versistv_estado.claveV
  LEFT JOIN versistv_incidenciae ON versistv_incidenciae.claveV = versistv_estado.claveV
  LEFT JOIN versistv_tincindecia ON versistv_tincindecia.claveV = versistv_estado.claveV
  LEFT JOIN versistv_attachment ON versistv_attachment.claveV = versistv_estado.claveV");
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
