<?php
function almacenarDatosR($ruta){
	include 'conectar.php';

	$rss = new DOMDocument();
	$rss->load($ruta);

//Intento de extraer los datos y almacenarlos en la bd directamente (sin arreglos)
	foreach ($rss->getElementsByTagName('item') as $node) {

		insertarDatosR($node);
		insertarIssueR($node);
		insertarAttR($node);

	}



}

function insertarDatosR($node){
	include 'conectar.php';
		$key= $node->getElementsByTagName('key')->item(0)->nodeValue;
		$type= $node->getElementsByTagName('type')->item(0)->nodeValue;
		$status= $node->getElementsByTagName('status')->item(0)->nodeValue;

		//Se realiza la inserción de los datos
		try {
			//Se prepara las sentencia a ejecutar
			$queryRpn = $connection->prepare("INSERT INTO rpn(clave_rpn, tipo_incidencia, estatus)
										VALUES (:key, :type, :status)");
											$queryRpn->bindParam(':key', $key);
											$queryRpn->bindParam(':type', $type);
											$queryRpn->bindParam(':status', $status);
										$queryRpn->execute();

			} catch (PDOException $e) {
										echo "<br>1 Ocurrió un problema con la conexión " . $e->getMessage();
		}
}

function insertarIssueR($node){
	include 'conectar.php';
	$key= $node->getElementsByTagName('key')->item(0)->nodeValue;
	//Se extrae la información de los issuekeys y se almacena en la bd
			$issuelinks = $node->getElementsByTagName('issuelinks');
			foreach ($issuelinks as $node1) {
				$issuelinktype = $node1->getElementsByTagName('issuelinktype');
				foreach ($issuelinktype as $node2) {
					$id = $node2->getAttribute('id');
					if ($id == '10000') {
						$inwardlinks = $node2->getElementsByTagName('inwardlinks');
						foreach ($inwardlinks as $node3) {
							$issuelink = $node3->getElementsByTagName('issuelink');

							foreach ($issuelink as $node4) {
								$issuekeys= $node4->getElementsByTagName('issuekey')->item(0)->nodeValue;
								//echo $key. " ".$type ." ".$status." ".$component." ".$issuekeys."<br> ";

								try {
										//Insertar en rpnissuelinks

										$queryRpnIssue = $connection->prepare("INSERT INTO
										rpnissuelinks(clave_rpn, name_issuelink)
											VALUES (:key, :issuekeys)");
											$queryRpnIssue->bindParam(':key', $key);
											$queryRpnIssue->bindParam(':issuekeys', $issuekeys);
										$queryRpnIssue->execute();

									} catch (PDOException $e) {
										echo "<br> 2 Ocurrió un problema con la conexión " . $e->getMessage();
									}

							}
						}
					}
				}
			}
}

function insertarAttR($node){
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
							//Insertar en rpnattachment
							$queryRpnAtt = $connection->prepare("INSERT INTO
											rpnattachment(clave_rpn, namefile)
											VALUES (:key, :attachments)");
											$queryRpnAtt->bindParam(':key', $key);
											$queryRpnAtt->bindParam(':attachments', $attachment);
										$queryRpnAtt->execute();

							} catch (PDOException $e) {
										echo "<br> 3 Ocurrió un problema con la conexión " . $e->getMessage();
							}
					}
				}

}

function insertarIssAttR($tabla, $key, $campo2, $value){
		include 'conectar.php';
	try {
							//Insertar en rpnattachment
							$query = $connection->prepare("INSERT INTO
											$tabla (clave_rpn, :campo2)
											VALUES (:key, :value)");
											//$query->bindParam(':tabla', $tabla);
											$query->bindParam(':campo2', $campo2);
											$query->bindParam(':key', $key);
											$query->bindParam(':value', $value);
										$queryRpnAtt->execute();

		} catch (PDOException $e) {
										echo "<br> 3 Ocurrió un problema con la conexión " . $e->getMessage();
		}
}

?>
