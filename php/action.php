<!--?php

$conn = mysqli_connect("localhost", "root", "","appinbur");

$affectedRow = 0;

$xml = simplexml_load_file() or die("Error: Cannot create object");

foreach ($xml->children() as $row) {
    $key = $row->key;
    $type = $row->type;
    $status = $row->status;
    $issue = $row->issuekey;
    $component = $row->component;
    $attachment = $row->attachment;
    
    $sql = "INSERT INTO versist(clave,tipo_incidencia,estatus,componentes,incidencias_enlazadas,archivos_adjuntos) VALUES ('" . $key . "','" . $type . "','" . $status . "','" . $issue . "','" . $component . "','" . $attachment . "')";
    
    $result = mysqli_query($conn, $sql);
    
    if (! empty($result)) {
        $affectedRow ++;
    } else {
        $error_message = mysqli_error($conn) . "n";
    }
}
?>
<h2>Insert XML Data to MySql Table Output</h2>
<!?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
} else {
    $message = "No records inserted";
}

?-->
<?php
function obtenerDatos($ruta){

    /*
$xml = simplexml_load_file($ruta);

    //mandar a la interfaz tabla-versist.html los datos - header('Location: /carpeta/mipagina.php');
        
                echo "<table>
                <tr>
                    <td>Clave</td>
                    <td>Tipo</td>
                    <td>Estado</td>
                    <td>Componente</td>
                    
                </tr>";


                foreach ($xml->channel->item as $elemento) {
                    # code...

                    echo"<tr>
                        <td>".$elemento->key."</td>
                        <td>".$elemento->type."</td>
                        <td>".$elemento->status."</td>
                        <td>".$elemento->component."</td>
                        </tr>";

                }

        */
                            //xml file path
            
                //read entire file into string
                $xmlfile = file_get_contents($ruta);

                //convert xml string into an object
                $xml = simplexml_load_string($xmlfile);

                //convert into json
                $json  = json_encode($xml);

                //convert into associative array
               //$xmlArr = json_decode($json, true);
               //print_r($json);
            /*Muestra los arrays del archivo
            foreach ($xmlArr as $item) {
                
                echo '<pre>';
                print_r($item);
                echo '</pre>';
                

            }*/
                $items=json_decode($json,true);
                        //lista de items a recorrer
                $listaItems = $items["channel"]["item"];
            
             ?>
            <html>
            <h1>Playas de Gijón</h1>
             
            <?php
             //bucle para recorrer los elementos del array
             for ($i = 0; $i<count($listaItems); $i++){
            ?>
             <table border="1">
              <tr>
               <td> Clave: </td>
               <td>
                <?php echo $listaItems[$i]["key"]; ?> 
               </td>
              </tr>
              <tr>
               <td>Tipo: </td>
               <td>
                <?php echo $listaItems[$i]["type"]; ?>
               </td>
              </tr>
              <tr>
               <td>Estado: </td>
               <td>
                <?php echo $listaItems[$i]["status"]; ?>
               </td>
              </tr>
              <tr>
               <td>Componente: </td>
               <td>
                <?php echo $listaItems[$i]["component"]; ?>
               </td>
              </tr>
              <tr>
               <td>Inicidencias Enlazadas: </td>
               <td>
                <?php echo $items['channel']['item'][$i]['issuelinks']['issulinktype']['outwardlinks']['issuelink'][$i]['issuekey'] . '/>'; ?>
               </td>
              </tr>
              <tr>
               <td>Archivos adjuntos: </td>
               <td>
                <?php echo $items['channel']['item'][$i]['attachments']['attachment'][$i]['name'] . '/>'; ?>
               </td>
              </tr>
             </table><br />
            <?php 
             } //cerramos bucle
            ?>
    }

?>