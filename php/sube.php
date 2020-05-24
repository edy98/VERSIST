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

		}else{
			echo "Archivo no se pudo guardar";
		}
	}
}else{
	if (esVersist($nombre) == true) {
		echo "Tu archivo es un versist";
		$ruta = guardarArchivo($guardado, $nombre);
		almacenarDatosV($ruta);
	}else{
		if (esRPN($nombre) == true) {
			echo "Tu archivo es un RPN";
			guardarArchivo($guardado, $nombre);
		}else{
			echo "No se pudo guardar el archivo";
		}
	}
}

function guardarArchivo($guardado, $nombre){
	if(move_uploaded_file($guardado, 'archivos/'.$nombre)){
		/*echo "Archivo guardado con exito <a href='.$nombre.'>";echo $ruta;*/
		return $ruta = 'archivos/'.$nombre;

	}else{
		echo "Archivo no se pudo guardar";
	}
}

function esVersist($nombre){
	if (preg_match("/^v/i", $nombre)) {
		//echo "Es un Versist";
		return true;
	}else{
		//echo "Nombre Incorrecto";
		return false;
	}
}

function esRPN($nombre){
	if (preg_match("/^r/i", $nombre)) {
	//	echo "Es un RPN";
		return true;
	}else{
		//echo "Nombre Incorrecto";
		return false;
	}
}
?>
