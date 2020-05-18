<?php

include "mostrar.php";

$clave='VERSIST-';
$tipoIncidencia='Creación de versión';
$estado='Documentación Completa';
$IncidenciaEn='RPN y ARCONF';
$Archivos='Liberación y Formato';
$datos[]=$row;

if (preg_match(' /^VERSIST-/i ',$clave,$datos)){
   echo "Existe la palabra VERSIST";
 }else {
      echo "No existe la palabra VERSIST";
}

if (preg_match(' /\bCreación/i',$tipoIncidencia,$datos)){
   echo " El tipo de incidencia es correcto";
 }else {
      echo " El tipo de incidencia es incorrecto";
}

if (preg_match('/\bDocumentación/i',$estado,$datos)){
   echo " El estado es correcto";
 }else {
      echo " El estado es incorrecto";
}

if (preg_match('/\bRPN|ARQCONF/',$IncidenciaEn,$datos)){
   echo " Si cumple con al menos un RPN y ARQCONF";
 }else {
      echo "No cumple con un RPN Y ARCONF";
}

if (preg_match('/\bLiberación|Formato/',$Archivos,$datos)){
   echo " Si cumple con el Formato de liberación";
 }else {
      echo " No cumple con el Formato de liberación";
}
?>
