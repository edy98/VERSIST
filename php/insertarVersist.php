<?php
function almacenarDatosV($ruta){
	include 'conectar.php';

	$rss = new DOMDocument();
	//Se obtiene la ruta del archivo en el servidor
	$rss->load($ruta);

	//Se recorre el archivo para encontrar los item.
	foreach ($rss->getElementsByTagName('item') as $node) {
		//Se obtienen los datos de las funciones
		insertarDatos($node);
		insertarIssue($node);
		insertarAtt($node);

	}

	//Se hace uso del archivo para validar e insertar los datos
	include 'validarV.php';

}

function id($node){
	//se obtiene y devuelve la clave del versist
	$key= $node->getElementsByTagName('key')->item(0)->nodeValue;
	return $key;
}

function insertarDatos($node){
	include 'conectar.php';
	//Recorre el archivo para obtener los datos
	$keys = id($node);
	$type= $node->getElementsByTagName('type')->item(0)->nodeValue;
	$status= $node->getElementsByTagName('status')->item(0)->nodeValue;
	$component= $node->getElementsByTagName('component')->item(0)->nodeValue;


	try {
		//Se prepara las sentencia a ejecutar
		$queryVersist = $connection->prepare("INSERT INTO versist(clave, tipo_incidencia, estatus, componentes)
									VALUES (:key, :type, :status, :component)");
										$queryVersist->bindParam(':key', $keys);
										$queryVersist->bindParam(':type', $type);
										$queryVersist->bindParam(':status', $status);
										$queryVersist->bindParam(':component', $component);

									//la sentencia es ejecutada
									$queryVersist->execute();

		} catch (PDOException $e) {
									echo "<br>1 Ocurrió un problema con la conexión " . $e->getMessage();
	}
}

function insertarIssue($node){
	//se accede a las etiquetas y subetiquetas del archivo
	$issuelinks = $node->getElementsByTagName('issuelinks');
	foreach ($issuelinks as $node1) {
			$issuelinktype = $node1->getElementsByTagName('issuelinktype');
			foreach ($issuelinktype as $node2) {
				$id = $node2->getAttribute('id'); //se obtiene el atributo 'id' de la etiqueta issuelinktype
				if ($id == '10000') {
					//se acceden a los demás nodos de la etiqueta padre
					$outwardlinks = $node2->getElementsByTagName('outwardlinks');
					foreach ($outwardlinks as $node3) {
						$issuelink = $node3->getElementsByTagName('issuelink');
						//se recorre el último nodo para obtener la información.
						foreach ($issuelink as $node4) {
							$issuekeys= $node4->getElementsByTagName('issuekey')->item(0)->nodeValue;
							//se obtienen los datos para hacer la inserción en la bd
							$keys = id($node);
							$valorCampo = $issuekeys;
							$nombreTabla = 'versistissuelinks';
							$nombreCampo = 'name_issuelink';
							//se llama a la función para insertar en la bd
							insertIssueAttBd($keys, $valorCampo, $nombreTabla, $nombreCampo);
						}
					}
				}
			}
		}
	}

function insertarAtt($node){
	//se accede a las etiquetas y subetiquetas del archivo
	$attachments = $node->getElementsByTagName('attachments');
	foreach ($attachments as $nodeA1){
		$attachment = $nodeA1->getElementsByTagName('attachment');
		foreach ($attachment as $nameAtt) {
			$attachment = $nameAtt->getAttribute('name');
			//se obtienen los datos para hacer la inserción en la bd
			$keys = id($node);
			$valorCampo = $attachment;
			$nombreTabla = 'versistattachment';
			$nombreCampo = 'namefile';
			//se llama a la función para insertar en la bd
			insertIssueAttBd($keys, $valorCampo, $nombreTabla, $nombreCampo);
		}
	}
}

function insertIssueAttBd($keys, $valorCampo, $nombreTabla, $nombreCampo){
	//se incluye el archivo para realizar la conexión con la bd
	include 'conectar.php';
	try {
		//Se prepara las sentencia a ejecutar
		$queryVersist = $connection->prepare("INSERT INTO $nombreTabla(clave, $nombreCampo)
									VALUES (:key, :valorCampo)");
										$queryVersist->bindParam(':key', $keys);
										$queryVersist->bindParam(':valorCampo', $valorCampo);
										//se ejecuta la sentencia
										$queryVersist->execute();

		} catch (PDOException $e) {
									echo "<br>1 Ocurrió un problema con la conexión " . $e->getMessage();
	}

}

?>
