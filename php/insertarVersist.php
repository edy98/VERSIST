<?php
function almacenarDatos($ruta){
	include 'conectar.php';

	$rss = new DOMDocument();
	$rss->load($ruta);

//Intento de extraer los datos y almacenarlos en la bd directamente (sin arreglos)
	foreach ($rss->getElementsByTagName('item') as $node) {

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
					}
				}


	}

	include 'validarV.php';

}

?>
