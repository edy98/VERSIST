<?php
	echo "<pre>";
	/* Creamos una matriz general para almacenar los datos
	que recuperemos del XML en un formato procesabledesde PHP
	(para una base de datos, una renderización en pantalla o
	lo que sea necesario). */
	$matrizDeObras = array();

	/* Creamos un objeto de la clase SimpleXMLElement para
	almacenar en el el contenido del archivo XML en una
	estructura de objeto procesable. */
	$contenidoXML = new SimpleXMLElement("obras_3.xml", 0, true);

	/* con el nombre de los nodos creamos unas variables
	(una por nodo) que podemos reorrer para trabajar sobre ellas. */
	foreach ($contenidoXML->obra as $obra) {
		$elementoObra = array(); // Elemento que contendrá datos de cada nodo.
		$elementoObra["obra"] = trim((string)$obra); // Se agrega el contenido del nodo como cadena.

		/* Obtenemos los atributos del nodo con el método attributes().*/
		$atributosDeNodoObra = $obra->attributes();
		/* Recorremos todos los atributos asignándolos a la matriz
		del nodo actual. */
		$elementoObra["fecha_de_inicio"] = (string)$atributosDeNodoObra->inicio;
		$elementoObra["fecha_de_finalizacion"] = (string)$atributosDeNodoObra->final;
		$elementoObra["contratista"] = (string)$atributosDeNodoObra->contratista;

		/* Obtenemos la propiedad personal_tecnico del nodo en curso, que contiene
		todos los datos del nodo anidado con este nombre. A partir de esa propiedad
		aplicamos el método attributes() para obtener los atributos del sub nodo,
		(en este ejemplo, sólo uno). */
		$miembros_tecnicos = $obra->personal_tecnico;
		$atributosDePersonal = $miembros_tecnicos->attributes();
		/* Recuperamos el valor del atributo "miembros", del sub-nodo "personal_tecnico"
		como una cadena, igual que hacemos con los atributos del nodo obra (el "padre"). */
		$elementoObra["miembros_tecnicos"] = (string)$atributosDePersonal->miembros;

		/* Debemos recuperar el contenido de los sub-sub-nodos miembro en una mini matriz secundaria. */
		$elementoObra["personal_tecnico"] = array();
		foreach ($miembros_tecnicos->miembro as $directivo){
			$elementoObra["personal_tecnico"][(string)$directivo->attributes()["cargo"]] = trim((string)$directivo);
		}

		$elementoObra["presupuesto"] = (string)$atributosDeNodoObra->presupuesto;
		$matrizDeObras[] = $elementoObra; // El elemento de cada nod es agregado a la matriz general.
		unset($elementoObra); // El contenido de un elemento nodo se recreará en cada iteración.
	}
	var_dump ($matrizDeObras);
?>
------------------------
/* Obtenemos los valores de los subnodos de item.*/
        $elementoItem["key"] = trim((string)$key);
        $elementoItem["type"] = trim((string)$type);
        $elementoItem["status"] = trim((string)$status);
        $elementoItem["component"] = trim((string)$component);

        /*Recorreremos los subnodos del nodo issuelinks para obtener el valor del subnodo issuekey */

        $issuelinks = $item->issuelinks;
        foreach ($issuelinks->issuelinktype as $issuelinktype) {
            # code...
            foreach ($issuelinktype->outwardlinks as $outwardlinks) {
                # code...
                    foreach ($outwardlinks->issuelink as $issuelink) {
                     # code...
                        foreach ($issuelink->issuekey as $issuekey) {
                        # code...
                            $elementoItem["issuekey"] = trim((string)$issuekey);
                        }
                 }

             }
        }
---------------------

<? php
function obtenerDatos($ruta){
//read entire file into string
   $xmlfile = file_get_contents($ruta);

                //convert xml string into an object
    $xml = simplexml_load_string($xmlfile);

                //convert into json
    $json  = json_encode($xml);

    $items=json_decode($json,true);
                        //lista de items a recorrer
    $listaItems = $items["channel"]["item"];

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Versist Extraídos</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark" >
      <!--
      <a class="navbar-brand bienvenido col-5" href="#">Bienvenido</a>-->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="#navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarToggle">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>
        </ul>
      </div>
      </nav>

      <div class="container">
        <p class="archivo-correcto">Resultado de la extracción</p>

        <!--input type="submit" class="btn btn-lg btn-primary submit-button" value="Generar"/-->
      </div>


      <div class="container">
        <?php
             //bucle para recorrer los elementos del array
            for ($i = 0; $i<count($listaItems); $i++){
        ?>
        <table class="table">
          <tr>
            <td>Clave</td>
            <td>Tipo</td>
            <td>Estado</td>
            <td>Componente</td>
            <td>Inicidencias Enlazadas</td>
            <td>Archivos adjuntos</td>
          </tr>
          <tr>
            <td> <?php echo $listaItems[$i]["key"]; ?> </td>
            <td><?php echo $listaItems[$i]["type"]; ?></td>
            <td><?php echo $listaItems[$i]["status"]; ?></td>
            <td><?php echo $listaItems[$i]["component"]; ?></td>
            <td>
              <?php echo $items['channel']['item'][$i]['issuelinks']['issulinktype']['outwardlinks']['issuelink'][$i]['issuekey'] . '/>'; ?>
            </td>
            <td>
              <?php echo $items['channel']['item'][$i]['attachments']['attachment'][$i]['name'] . '/>'; ?>
            </td>
          </tr>
        </table>
        <?php
      }
        ?>
      </div>



			<!DOCTYPE html>
			<html lang="en" dir="ltr">
			  <head>
			    <meta charset="utf-8">
			    <title>RPN Extraídos</title>
			    <link rel="stylesheet" href="../css/estilos.css">
			    <link rel="stylesheet" href="../css/bootstrap.min.css">
			  </head>
			  <body>
			    <nav class="navbar navbar-expand-lg navbar-dark" >
			      <!--
			      <a class="navbar-brand bienvenido col-5" href="#">Bienvenido</a>-->
			      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="#navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
			        <span class="navbar-toggler-icon"></span>
			      </button>
			      <div class="collapse navbar-collapse" id="navbarToggle">
			        <ul class="navbar-nav mr-auto">
			          <li class="nav-item active">
			            <a class="nav-link" href="#">Inicio
			              <span class="sr-only">(current)</span>
			            </a>
			          </li>
			        </ul>
			      </div>
			      </nav>

			      <div class="container">
			        <p class="archivo-correcto">Resultado de la extracción</p>
			      </div>

			      <div class="container">
			        <?php
			             //bucle para recorrer los elementos del array
			            for ($i = 0; $i<count($listaItems); $i++){
			        ?>
			        <table class="table">
			          <tr>
			            <td>VERSIST</td>
			            <td>RPN</td>
			            <td>Tipo de Incidencia</td>
			            <td>Estado</td>
			            <td>Incidencias Enlazadas</td>
			            <td>Archivos adjuntos</td>
			          </tr>
			          <tr>
			            <td> <?php echo $listaIt[$i]["key"]; ?> </td>
			            <td><?php echo $listaIt[$i]["type"]; ?></td>
			            <td><?php echo $listaIt[$i]["status"]; ?></td>
			            <td>
			              <?php echo $items['channel']['item'][$i]['issuelinks']['issulinktype']['inwardlinks']['issuelink'][$i]['issuekey'] . '/>'; ?>
			            </td>
			            <td>
			              <?php echo $items['channel']['item'][$i]['attachments']['attachment'][$i]['name'] . '/>'; ?>
			            </td>
			          </tr>
			        </table>
			        <?php
			      }
			        ?>
			      </div>








      <script src="../js/jquery-3.4.1.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
