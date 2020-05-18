<?php

include 'conectar.php';
include 'mostrar.php';

//obtener datos
/*
try {
$sentencia = $connection->prepare("SELECT versist.*, GROUP_CONCAT(versistissuelinks.name_issuelink) as incidencias, versistattachment.namefile FROM versist
  LEFT JOIN versistissuelinks ON versistissuelinks.clave = versist.clave
  LEFT JOIN versistattachment ON versistattachment.clave = versist.clave
  GROUP BY versist.clave");
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
}*/

//Validar estado del versist
foreach ($result as $row) {
  validarEstado($row);
  validarTipo($row);
  validarIncidencias($row);
  validarArchivos($row);
}

function validarEstado($row){
  /*$id = $row['clave'];
  $nombreCampo = 'estado';
  $nombreTabla = 'versistv_estado';*/
  if ('Documentación Completa' == $row['estatus']) {
    echo $row['clave'] . " " .  $row['estatus'] . " Esta bien ";
    $valorCampo = 1;
    //insertarResultado($id,$nombreCampo,$nombreTabla,$valorCampo);
    //return - > aquí pondras el arreglo y asignarle lo que corresponde
  }else{
    echo $row['clave'] . " " . $row['estatus']. " Esta mal ";
    $valorCampo = 0;
    //insertarResultado($id,$nombreCampo,$nombreTabla,$valorCampo);*/
    //return - > aquí pondras el arreglo y asignarle lo que corresponde
  }
}

function validarTipo($row){
  /*$id = $row['clave'];
  $nombreCampo = 'tipoincidencia';
  $nombreTabla = 'versistv_tincindecia';*/
  if ($row['tipo_incidencia'] == 'Creación de Versión') {
    echo $row['tipo_incidencia'] . " Esta bien ";
    $valorCampo = 1;
    //insertarResultado($id,$nombreCampo,$nombreTabla,$valorCampo);
    //return - > aquí pondras el arreglo y asignarle lo que corresponde
  }else{
    echo $row['tipo_incidencia']. " Esta mal ";
    $valorCampo = 0;
    //insertarResultado($id,$nombreCampo,$nombreTabla,$valorCampo);
    //return - > aquí pondras el arreglo y asignarle lo que corresponde
  }
}

function validarIncidencias($row){
  /*$id = $row['clave'];
  $nombreCampo = 'incidenciaenlazada';
  $nombreTabla = 'versistv_incidenciae';*/
  if (preg_match("/RPN/" , $row['incidencias'])) {
    echo " Tiene RPN ";
    $valorCampo = 1;
    //insertarResultado($id,$nombreCampo,$nombreTabla,$valorCampo);
    if (preg_match("/SP/" , $row['incidencias']) || preg_match("/SOPORTEPROD/" , $row['incidencias']) || preg_match("/ARQCONF/" , $row['incidencias']) || preg_match("/UNIXYRESPALDOS/" , $row['incidencias']) || preg_match("/BDPROD/" , $row['incidencias'])) {
      echo "Si tiene OA ";

    }else{
      echo "No tiene OA ";
    }
  }else{
    echo $row['clave'] . " No hay RPN ";
    $valorCampo = 0;
    //insertarResultado($id,$nombreCampo,$nombreTabla,$valorCampo);
  }
}

function validarArchivos($row){
  /*$id = $row['clave'];
  $nombreCampo = 'attachment';
  $nombreTabla = 'versistv_attachment';*/
if (preg_match("/FormatoLiberacion/" , $row['namefile']) || preg_match("/Matriz/" , $row['namefile']) || preg_match("/^VERSIST/" , $row['namefile'])) {
    echo " Si tiene AA ";
    $valorCampo = 1;
    //insertarResultado($id,$nombreCampo,$nombreTabla,$valorCampo);
  }else{
    echo " No tiene AA ";
    $valorCampo = 0;
    //insertarResultado($id,$nombreCampo,$nombreTabla,$valorCampo);
  }
}

//function insertarResultado($id,$nombreCampo,$nombreTabla,$valorCampo){
  try {
    //$USER = 'root';
  	//$PASS = '';
    //$connection = new PDO('mysql:host=localhost;dbname=appinbur;charset=utf8' , $USER, $PASS);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Se prepara las sentencia a ejecutar
    $queryVersist = $connection->prepare("INSERT INTO resultado_versistv(clave, estado, tipo_incidencia, archivos_adjuntos, incidencias_enlazadas)
                  VALUES (:claveV, :type)");
                    $queryVersist->bindParam(':clave', $id);
                    $queryVersist->bindParam(':estado', $estadov);
                    $queryVersist->bindParam(':tipo_incidencia', $incidencav);
                    $queryVersist->bindParam(':archivos_adjuntos', $adjuntosv);
                    $queryVersist->bindParam(':incidencias_enlazadas', $enlazadav);
                    return $queryVersist->execute();

    } catch (PDOException $e) {
                  echo "<br>1 Ocurrió un problema con la inserción " . $e->getMessage();
  }
//}


 ?>
