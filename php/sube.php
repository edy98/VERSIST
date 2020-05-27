<?php
header("Content-Type: text/json");
header("Access-Control-Allow-Origin:*");

include 'insertarVersist.php';

$nombre=$_FILES['xml']['name'];
$guardado=$_FILES['xml']['tmp_name'];
$datos = array();
//1ra condición para ver si existe la carpeta archivos
if(!file_exists('archivos')){

	mkdir('archivos',0777,true);
	if(file_exists('archivos')){

		//comprobarArchivo($nombre,$guardado);
		echo "Nueva carpeta";
	}
}else{
	//comprobarArchivo($nombre,$guardado);
	if (esVersist($nombre) == true) {
		//echo "Tu archivo es un versist";
		$ruta = guardarArchivo($guardado, $nombre);
		almacenarDatosV($ruta);

	}else{
		if (esRPN($nombre) == true) {
			//echo "Tu archivo es un RPN";
			guardarArchivo($guardado, $nombre);
		}else{
			//echo "El archivo no es ni versist ni RPN";
			$datos['message']="error";


		}
	}

}

function guardarArchivo($guardado, $nombre){

	if(move_uploaded_file($guardado, 'archivos/'.$nombre)){
		/*echo "Archivo guardado con exito <a href='.$nombre.'>";echo $ruta;*/
		$ruta = 'archivos/'.$nombre;
		return $ruta;

	}else{
		$datos['message']="error";
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

echo json_encode($datos);


?>
