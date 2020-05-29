<?php
function almacenarDatosR($ruta){
	include 'conectar.php';

	$rss = new DOMDocument();
	//Se obtiene la ruta del archivo en el servidor
	$rss->load($ruta);

	//Se recorre el archivo para encontrar los item.
	foreach ($rss->getElementsByTagName('item') as $node) {
		//Se obtienen los datos de las funciones
		insertarDatosR($node);
		insertarIssueR($node);
		insertarAttR($node);

	}



}

function idr($node){
	//se obtiene y devuelve la clave del rpn
	$keyR= $node->getElementsByTagName('key')->item(0)->nodeValue;
	return $keyR;
}

function insertarDatosR($node){
	include 'conectar.php';
	//Recorre el archivo para obtener los datos
	$keysR = idr($node);
	$typeR= $node->getElementsByTagName('type')->item(0)->nodeValue;
	$statusR= $node->getElementsByTagName('status')->item(0)->nodeValue;


	try {
		//Se prepara las sentencia a ejecutar
		$queryRpn = $connection->prepare("INSERT INTO rpn(clave_rpn, tipo_incidencia, estatus)
									VALUES (:key, :type, :status)");
										$queryRpn->bindParam(':key', $keysR);
										$queryRpn->bindParam(':type', $typeR);
										$queryRpn->bindParam(':status', $statusR);

									//la sentencia es ejecutada
									$queryRpn->execute();

		} catch (PDOException $e) {
									echo "<br>1 Ocurrió un problema con la conexión " . $e->getMessage();
	}
}

function insertarIssueR($node){
	//se accede a las etiquetas y subetiquetas del archivo
	$issuelinks = $node->getElementsByTagName('issuelinks');
	foreach ($issuelinks as $node1) {
			$issuelinktype = $node1->getElementsByTagName('issuelinktype');
			foreach ($issuelinktype as $node2) {
				$idR = $node2->getAttribute('id'); //se obtiene el atributo 'id' de la etiqueta issuelinktype
				if ($idR == '10000') {
					//se acceden a los demás nodos de la etiqueta padre
					$inwardlinks  = $node2->getElementsByTagName('inwardlinks ');
					foreach ($inwardlinks  as $node3) {
						$issuelink = $node3->getElementsByTagName('issuelink');
						//se recorre el último nodo para obtener la información.
						foreach ($issuelink as $node4) {
							$issuekeys= $node4->getElementsByTagName('issuekey')->item(0)->nodeValue;
							//se obtienen los datos para hacer la inserción en la bd
							$keys = idr($node);
							$valorCampo = $issuekeys;
							$nombreTabla = 'rpnissuelinks';
							$nombreCampo = 'name_issuelink';
							//se llama a la función para insertar en la bd
							insertIssueAttBd($keys, $valorCampo, $nombreTabla, $nombreCampo);
						}
					}
				}
			}
		}
	}
	function insertarIssueClaveR($node){
		//se accede a las etiquetas y subetiquetas del archivo
				$issuelinktype = $node->getElementsByTagName('issuelinktype');
				foreach ($issuelinktype as $node1) {
					$idC = $node1->getAttribute('id'); //se obtiene el atributo 'id' de la etiqueta issuelinktype
					if ($idC == '10000') {
						//se acceden a los demás nodos de la etiqueta padre
						$inwardlinks  = $node1->getElementsByTagName('inwardlinks ');
						foreach ($inwardlinks  as $node2) {
							$issuelink = $node2->getElementsByTagName('issuelink');
							//se recorre el último nodo para obtener la información.
							foreach ($issuelink as $node3) {
								$issuekeys= $node3->getElementsByTagName('issuekey')->item(0)->nodeValue;
								//se obtienen los datos para hacer la inserción en la bd
								$keys = idr($node);
								$valorCampo = $issuekeys;
								$nombreTabla = 'rpn';
								$nombreCampo = 'versist_clave';
								//se llama a la función para insertar en la bd
								insertIssueAttBdCR($keys, $valorCampo, $nombreTabla, $nombreCampo);
							}
						}
					}
				}
			}


function insertarAttR($node){
	//se accede a las etiquetas y subetiquetas del archivo
	$attachments = $node->getElementsByTagName('attachments');
	foreach ($attachments as $nodeA1){
		$attachment = $nodeA1->getElementsByTagName('attachment');
		foreach ($attachment as $nameAtt) {
			$attachment = $nameAtt->getAttribute('name');
			//se obtienen los datos para hacer la inserción en la bd
			$keys = idr($node);
			$valorCampo = $attachment;
			$nombreTabla = 'rpnattachment';
			$nombreCampo = 'namefile';
			//se llama a la función para insertar en la bd
			insertIssueAttBdR($keys, $valorCampo, $nombreTabla, $nombreCampo);
		}
	}
}

function insertIssueAttBdR($keys, $valorCampo, $nombreTabla, $nombreCampo){
	//se incluye el archivo para realizar la conexión con la bd
	include 'conectar.php';
	try {
		//Se prepara las sentencia a ejecutar
		$queryRpn = $connection->prepare("INSERT INTO $nombreTabla(clave_rpn, $nombreCampo)
									VALUES (:key, :valorCampo)");
										$queryRpn->bindParam(':key', $keys);
										$queryRpn->bindParam(':valorCampo', $valorCampo);
										//se ejecuta la sentencia
										$queryRpn->execute();

		} catch (PDOException $e) {
									echo "<br>1 Ocurrió un problema con la conexión " . $e->getMessage();
	}

}

?>
