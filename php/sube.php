<?php
include 'insertarVersist.php';

$nombre=$_FILES['xml']['name'];
$guardado=$_FILES['xml']['tmp_name'];

if(!file_exists('archivos')){
	mkdir('archivos',0777,true);
	if(file_exists('archivos')){
		if(move_uploaded_file($guardado, 'archivos/'.$nombre)){
			//echo "Archivo guardado con exito <a href='.$nombre.'>";
			$ruta = 'archivos/'.$nombre;
			//echo $nombre;
			almacenarDatos($ruta);

		}else{
			echo "Archivo no se pudo guardar";
		}
	}
}else{
	if(move_uploaded_file($guardado, 'archivos/'.$nombre)){
		/*echo "Archivo guardado con exito <a href='.$nombre.'>";echo $ruta;*/
		$ruta = 'archivos/'.$nombre;
		almacenarDatos($ruta);
	}else{
		echo "Archivo no se pudo guardar";
	}
}

?>
