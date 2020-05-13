<?php

include "mostrar.php";
$validar= array(key,type,status,component,issuelinks,attachments);

function validacion()
if ($validar == $datos) {
    echo "Los datos estan correctos";
  }
  else{
    echo "Los datos son incorrectos";

  }
}
?>
