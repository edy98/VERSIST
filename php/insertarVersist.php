<?php
function almacenarDatosV($ruta){
	include 'conectar.php';

	$rss = new DOMDocument();
	$rss->load($ruta);

//Intento de extraer los datos y almacenarlos en la bd directamente (sin arreglos)
	foreach ($rss->getElementsByTagName('item') as $node) {

		insertarDatos($node);
		insertarIssue($node);
		insertarAtt($node);

	}

	include 'validarV.php';

}

function id($node){
	$key= $node->getElementsByTagName('key')->item(0)->nodeValue;
	return $key;
}

function insertarDatos($node){
	include 'conectar.php';
	//$key= $node->getElementsByTagName('key')->item(0)->nodeValue;
	$keys = id($node);
	$type= $node->getElementsByTagName('type')->item(0)->nodeValue;
	$status= $node->getElementsByTagName('status')->item(0)->nodeValue;
	$component= $node->getElementsByTagName('component')->item(0)->nodeValue;

	//echo " " . $key . " " . $type . " " . $status . " " . $component;

	try {
		//Se prepara las sentencia a ejecutar
		$queryVersist = $connection->prepare("INSERT INTO versist(clave, tipo_incidencia, estatus, componentes)
									VALUES (:key, :type, :status, :component)");
										$queryVersist->bindParam(':key', $keys);
										$queryVersist->bindParam(':type', $type);
										$queryVersist->bindParam(':status', $status);
										$queryVersist->bindParam(':component', $component);
									$queryVersist->execute();

		} catch (PDOException $e) {
									echo "<br>1 Ocurrió un problema con la conexión " . $e->getMessage();
	}
}

function insertarIssue($node){
	$issuelinks = $node->getElementsByTagName('issuelinks');
	foreach ($issuelinks as $node1) {
			$issuelinktype = $node1->getElementsByTagName('issuelinktype');
			foreach ($issuelinktype as $node2) {
				$id = $node2->getAttribute('id');
				if ($id == '10000') {
					$outwardlinks = $node2->getElementsByTagName('outwardlinks');
					foreach ($outwardlinks as $node3) {
						$issuelink = $node3->getElementsByTagName('issuelink');

						foreach ($issuelink as $node4) {
							$issuekeys= $node4->getElementsByTagName('issuekey')->item(0)->nodeValue;
							//echo " " . $issuekeys;
							$keys = id($node);
							$valorCampo = $issuekeys;
							$nombreTabla = 'versistissuelinks';
							$nombreCampo = 'name_issuelink';
							insertIssueAttBd($keys, $valorCampo, $nombreTabla, $nombreCampo);
						}
					}
				}
			}
		}
	}

function insertarAtt($node){
	$attachments = $node->getElementsByTagName('attachments');
	foreach ($attachments as $nodeA1){
		$attachment = $nodeA1->getElementsByTagName('attachment');
		foreach ($attachment as $nameAtt) {
			$attachment = $nameAtt->getAttribute('name');
			//echo " " . $attachment;
			$keys = id($node);
			$valorCampo = $attachment;
			$nombreTabla = 'versistattachment';
			$nombreCampo = 'namefile';
			insertIssueAttBd($keys, $valorCampo, $nombreTabla, $nombreCampo);
		}
	}
}

function insertIssueAttBd($keys, $valorCampo, $nombreTabla, $nombreCampo){
	include 'conectar.php';
	try {
		//Se prepara las sentencia a ejecutar
		$queryVersist = $connection->prepare("INSERT INTO $nombreTabla(clave, $nombreCampo)
									VALUES (:key, :valorCampo)");
										$queryVersist->bindParam(':key', $keys);
										$queryVersist->bindParam(':valorCampo', $valorCampo);
										$queryVersist->execute();

		} catch (PDOException $e) {
									echo "<br>1 Ocurrió un problema con la conexión " . $e->getMessage();
	}

}

/*
function insertarDatos($node){
	include 'conectar.php';
		$key= $node->getElementsByTagName('key')->item(0)->nodeValue;
		$type= $node->getElementsByTagName('type')->item(0)->nodeValue;
		$status= $node->getElementsByTagName('status')->item(0)->nodeValue;
		$component= $node->getElementsByTagName('component')->item(0)->nodeValue;

		//Se realiza la inserción de los datos
		try {
			//Se prepara las sentencia a ejecutar
			$queryVersist = $connection->prepare("INSERT INTO versist(clave, tipo_incidencia, estatus, componentes)
										VALUES (:key, :type, :status, :component)");
											$queryVersist->bindParam(':key', $key);
											$queryVersist->bindParam(':type', $type);
											$queryVersist->bindParam(':status', $status);
											$queryVersist->bindParam(':component', $component);
										$queryVersist->execute();

			} catch (PDOException $e) {
										echo "<br>1 Ocurrió un problema con la conexión " . $e->getMessage();
		}
}

function insertarIssue($node){
	include 'conectar.php';
	$key= $node->getElementsByTagName('key')->item(0)->nodeValue;
	//Se extrae la información de los issuekeys y se almacena en la bd
			$issuelinks = $node->getElementsByTagName('issuelinks');
			foreach ($issuelinks as $node1) {
				$issuelinktype = $node1->getElementsByTagName('issuelinktype');
				foreach ($issuelinktype as $node2) {
					$id = $node2->getAttribute('id');
					if ($id == '10000') {
						$outwardlinks = $node2->getElementsByTagName('outwardlinks');
						foreach ($outwardlinks as $node3) {
							$issuelink = $node3->getElementsByTagName('issuelink');

							foreach ($issuelink as $node4) {
								$issuekeys= $node4->getElementsByTagName('issuekey')->item(0)->nodeValue;
								//echo $key. " ".$type ." ".$status." ".$component." ".$issuekeys."<br> ";

								try {
										//Insertar en versistissuelinks

										$queryVersistIssue = $connection->prepare("INSERT INTO
											versistissuelinks(clave, name_issuelink)
											VALUES (:key, :issuekeys)");
											$queryVersistIssue->bindParam(':key', $key);
											$queryVersistIssue->bindParam(':issuekeys', $issuekeys);
										$queryVersistIssue->execute();

									} catch (PDOException $e) {
										echo "<br> 2 Ocurrió un problema con la conexión " . $e->getMessage();
									}

							}
						}
					}
				}
			}
}

function insertarAtt($node){
	include 'conectar.php';

	$key= $node->getElementsByTagName('key')->item(0)->nodeValue;
	//Se extrae la información de los attachments y se almacena en la bd

				# code...
				$attachments = $node->getElementsByTagName('attachments');
				foreach ($attachments as $nodeA1){
					# code...
					$attachment = $nodeA1->getElementsByTagName('attachment');
					foreach ($attachment as $nameAtt) {
						# code...
						$attachment = $nameAtt->getAttribute('name');

						try {
							//Insertar en versistisattachment
							$queryVersistAtt = $connection->prepare("INSERT INTO
											versistattachment(clave, namefile)
											VALUES (:key, :attachments)");
											$queryVersistAtt->bindParam(':key', $key);
											$queryVersistAtt->bindParam(':attachments', $attachment);
										$queryVersistAtt->execute();

							} catch (PDOException $e) {
										echo "<br> 3 Ocurrió un problema con la conexión " . $e->getMessage();
							}
							/*$tabla = 'versistattachment';
							$campo2 = 'namefile';
							insertarIssAtt($tabla, $key, $campo2, $attachment);
					}
				}

}

function insertarIssAtt($tabla, $key, $campo2, $value){
		include 'conectar.php';
	try {
							//Insertar en versistisattachment
							$query = $connection->prepare("INSERT INTO
											$tabla (clave, :campo2)
											VALUES (:key, :value)");
											//$query->bindParam(':tabla', $tabla);
											$query->bindParam(':campo2', $campo2);
											$query->bindParam(':key', $key);
											$query->bindParam(':value', $value);
										$queryVersistAtt->execute();

		} catch (PDOException $e) {
										echo "<br> 3 Ocurrió un problema con la conexión " . $e->getMessage();
		}
}*/

?>
