<?php
function almacenarDatos($ruta){
	include 'conectar.php';

	$rss = new DOMDocument();
	$rss->load($ruta);
	$xpath = new DOMXPath($rss);
	$feed = array();

	//Extrayendo ..
foreach ($rss->getElementsByTagName('item') as $node) {
		$itemRSS = array(
			'key' => $node->getElementsByTagName('key')->item(0)->nodeValue,
			'type' => $node->getElementsByTagName('type')->item(0)->nodeValue,
			'status' => $node->getElementsByTagName('status')->item(0)->nodeValue,
			'component' => $node->getElementsByTagName('component')->item(0)->nodeValue,
			//'issuelinks' => $node->getElementsByTagName('issuelinks')->item(0)->nodeValue,
			//'attachments' => $node->getElementsByTagName('attachments')->item(0)->nodeValue,

		);
		array_push($feed, $itemRSS);
	}

	//Mostrar el arreglo con el contenido extraído
//foreach ($feed as $itemRSS => $value) {
	//	echo " " . $value['key'] . " " . $value['type'] . " " . $value['status'] . " " . $value['component'];
		//Insertando datos a la bd
		/*try {
			$sentencia = $connection->prepare("INSERT INTO versist(clave, tipo_incidencia, estatus, componentes)
			VALUES (:key, :type, :status, :component)");
			$sentencia->bindParam(':key', $value['key']);
			$sentencia->bindParam(':type', $value['type']);
			$sentencia->bindParam(':status', $value['status']);
			$sentencia->bindParam(':component', $value['component']);
			//$sentencia->bindParam(':issuelinks', $value['issuelinks']);
			$sentencia->execute();
		} catch (PDOException $e) {
			echo "Ocurrió un problema con la conexión " . $e->getMessage();
		}*/
	//}


	//Esto es lo que pretendi implementar, pero aún no he probado si funciona
	/*foreach ($rss->getElementsByTagName('item') as $node2) {
		# code...
		$issuelinks = $node2->getElementsByTagName('issuelinks')->item(0)->nodeValue;
		foreach ($issuelinks->getElementById('10000') as $value) {
					# code...
				$itemRSS2 = array(
					//'issuelink' => $value->getElementsByTagName('issuelink')->item(0)->nodeValue,
					'issuelink' => $value->nodeValue,
				);

				array_push($feed, $itemRSS2);
		}

	}*/
	foreach ($rss->getElementsByTagName('item') as $node0) {
		$issuelinks = $node0->getElementsByTagName('issuelinks');
		foreach ($issuelinks as $node1) {
			$issuelinktype = $node1->getElementsByTagName('issuelinktype');
			foreach ($issuelinktype as $node2) {
				$id = $node2->getAttribute('id');
				if ($id == '10000') {
					$outwardlinks = $node2->getElementsByTagName('outwardlinks');
					foreach ($outwardlinks as $node3) {
						$issuelink = $node3->getElementsByTagName('issuelink');
						foreach ($issuelink as $node4) {
							$itemRSS2 = array(
								'issuekeys' => $node4->getElementsByTagName('issuekey')->item(0)->nodeValue,
								//'issuelink' => $xpath->query('//outwardlinks/issuelink/issuekey', $node2)->item(0)->textContent,
							);
							array_push($feed, $itemRSS2);
						}
					}
				}
			}
		}
	}



//foreach ($feed as $itemRSS => $value) {
	//echo  " " . $value['key'] . " " . $value['type'] . " " . $value['status'] . " " . $value['component'] . " Incidencias enlazadas " . " "  . $value['issuekeys'];
	/*try {
		$sentencia = $connection->prepare("INSERT INTO versistissuelinks(name_issuelink)
		VALUES (:key)");
		$sentencia->bindParam(':key', $val['issuekeys']);
		//$sentencia->bindParam(':issuelinks', $value['issuelinks']);
		$sentencia->execute();
	} catch (PDOException $e) {
		echo "Ocurrió un problema con la conexión " . $e->getMessage();
	}*/
//}

}
 ?>
