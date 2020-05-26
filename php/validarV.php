<?php

include 'conectar.php';

//Se prepara y ejecuta la sentencia para mostrar 

try {
$sentencia = $connection->prepare("SELECT versist.*, GROUP_CONCAT(versistissuelinks.name_issuelink) as incidencias, versistattachment.namefile FROM versist
  LEFT JOIN versistissuelinks ON versistissuelinks.clave = versist.clave
  LEFT JOIN versistattachment ON versistattachment.clave = versist.clave
  GROUP BY versist.clave");
$sentencia->execute();
//Se obtiene el resultado de la consulta y se almacena en variable para recorrerse por el foreach
$result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo "Ocurrió un problema al mostrar " . $e->getMessage();
}

foreach ($result as $row) { //se recorren los registros através del foreach
  //se ejecutan las validaciones y se obtiene los resultados
  $id = obtenerID($row);
  $estado = validarEstado($row);
  $tipo = validarTipo($row);
  $incidenciaEn = validarIncidencias($row);
  $archivos = validarArchivos($row);
  //El resultado final se incluye en el campo acción.
  $accion = validarSuma($estado, $tipo, $incidenciaEn, $archivos);

  //Se insertan los datos en la tabla correspondiente.
    try {
       $queryVersist = $connection->prepare("INSERT INTO resultado_versist(clave, accion, estado, tipo_incidencia,incidencias_enlazadas,archivos_adjuntos)
                     VALUES (:clave, :accion, :estado, :tipo_incidencia, :incidencias_enlazadas, :archivos_adjuntos )");
                       $queryVersist->bindParam(':clave', $id);
                       $queryVersist->bindParam(':accion', $accion);
                       $queryVersist->bindParam(':estado', $estado);
                       $queryVersist->bindParam(':tipo_incidencia', $tipo);
                       $queryVersist->bindParam(':incidencias_enlazadas', $incidenciaEn);
                       $queryVersist->bindParam(':archivos_adjuntos', $archivos);
                       $queryVersist->execute();

       } catch (PDOException $e) {
                     echo "<br>1 Ocurrió un problema con la inserción " . $e->getMessage();
     }
}

//Obtiene el resultado final que proporciona la acción a ejecutar.
function validarSuma($v1, $v2, $v3, $v4){
  $resultado = $v1 + $v2 + $v3 + $v4;

  $validar = '';
  //Condiciones para obtener el valor de la acción
  if ($resultado == 4) {
    $validar = 'Validar';
    return $validar;
  }else{
    $validar = 'Cancelar';
    return $validar;
  }
}

//se obtiene la clave de los registros obtenidos en la consulta
function obtenerID($row){

  $id =  $row['clave'];
  return $id;
}

//Se realiza la validación del campo estado
function validarEstado($row){
  if ('Documentación Completa' == $row['estatus']) {
    //echo $row['clave'] . " " .  $row['estatus'] . " Esta bien ";
    $valorEstado = 1;
    return $valorEstado;
  }else{
    //echo $row['clave'] . " " . $row['estatus']. " Esta mal ";
    $valorEstado = 0;
    return $valorEstado;
  }
}

//Se realiza la validación del campo type
function validarTipo($row){
  if ($row['tipo_incidencia'] == 'Creación de Versión') {
    //echo $row['tipo_incidencia'] . " Esta bien ";
    $valorTipo = 1;
    return $valorTipo;
  }else{
    //echo $row['tipo_incidencia']. " Esta mal ";
    $valorTipo = 0;
    return $valorTipo;
  }
}

//Se realiza la validación del campo incidencias
function validarIncidencias($row){
  //La validación incluye que debe contener un RPN
  if (preg_match("/RPN/" , $row['incidencias'])) {
    
    $valorIncidencia = 1;
    
    //Y también contener algún objeto de arquitectura
    if (preg_match("/SP|SOPORTEPROD|ARQCONF|UNIXYRESPALDOS|BDPROD/" , $row['incidencias'])) {
      //echo "Si tiene OA ";
      //$valorIncidencia = 1;
      return $valorIncidencia;
    }else{
      //echo "No tiene OA ";
      $valorIncidencia = 0;
      return $valorIncidencia;
    }
  }else{
    //echo $row['clave'] . " No hay RPN ";
    $valorIncidencia = 0;
    return $valorIncidencia;
  }
}

//Se valida el campo de archivos adjuntos que debe incluir el formato de liberación
function validarArchivos($row){
  if (preg_match("/FormatoLiberacion|Matriz|^VERSIST/" , $row['namefile'])) {
    //echo " Si tiene AA ";
    $valorArchivo = 1;
    return $valorArchivo;
  }else{
    //echo " No tiene AA ";
    $valorArchivo = 0;
    return $valorArchivo;
  }
}
 ?>
