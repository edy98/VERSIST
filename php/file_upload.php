<?php 
// Incluimos el fichero de conexion con el servidor
include_once("db_connect.php");
if(!empty($_FILES)){     
    $upload_dir = "uploads/";
    $fileName = $_FILES['file']['name'];
    $uploaded_file = $upload_dir.$fileName;    
    if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
        //Insertamos la informacion en la tabla
        $mysql_insert = "INSERT INTO uploads (file_name, upload_time)VALUES('".$fileName."','".date("Y-m-d H:i:s")."')";
        mysqli_query($conn, $mysql_insert) or die("database error:". mysqli_error($conn));
    }   
}
?>