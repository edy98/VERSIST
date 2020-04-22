<?php


$nombre=$_FILES['xml']['name'];
$guardado=$_FILES['xml']['tmp_name'];

if(!file_exists('archivos')){
	mkdir('archivos',0777,true);
	if(file_exists('archivos')){
		if(move_uploaded_file($guardado, 'archivos/'.$nombre)){
			//echo "Archivo guardado con exito <a href='.$nombre.'>";
			$nombre = 'archivos/'.$nombre;
			//echo $nombre;


		}else{
			echo "Archivo no se pudo guardar";
		}
	}
}else{
	if(move_uploaded_file($guardado, 'archivos/'.$nombre)){
		/*echo "Archivo guardado con exito <a href='.$nombre.'>";echo $ruta;*/
		$ruta = 'archivos/'.$nombre;


				$xml = simplexml_load_file($ruta);

				print("<table>
				<tr>
					<td>Clave</td>
					<td>Tipo</td>
					<td>Estado</td>
					<td>Componente</td>
					<td>Incidencias enlazadas</td>
					<td>Archivos adjuntos</td>
				</tr>");


				foreach ($xml->channel->item as $elemento) {
					# code...

					print("<tr>
						<td>".$elemento->key."</td>
						<td>".$elemento->type."</td>
						<td>".$elemento->status."</td>
						<td>".$elemento->component."</td>
						</tr>");

				}



	}else{
		echo "Archivo no se pudo guardar";
	}
}

function RecurseXML()
				{
					$nombre=$_FILES['file-upload']['name'];
					$ruta = 'archivos/'.$nombre;
				 $xml = simplexml_load_file($ruta);

				   foreach($xml->channel->item as $nodo)
				   {

				        echo "<td>".$nodo->issuelink[2]. "</td>";

				   }


				};

?>
