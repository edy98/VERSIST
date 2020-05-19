<?php
//header("Content-Type: text/json");
header("Access-Control-Allow-Origin:*");

include "conectar.php";

try {
$sentencia = $connection->prepare("SELECT versist.*, GROUP_CONCAT(versistissuelinks.name_issuelink) as incidencias, versistattachment.namefile FROM versist
  LEFT JOIN versistissuelinks ON versistissuelinks.clave = versist.clave
  LEFT JOIN versistattachment ON versistattachment.clave = versist.clave
  GROUP BY versist.clave");
$sentencia->execute();
$result = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$datos = array();

if (!empty($result)){
  foreach ($result as $row) {
    //echo $row['clave'] . " " . $row['tipo_incidencia'];
    $datos[]=$row;
  }
}

} catch (PDOException $e) {
  echo "Ocurrió un problema al mostrar " . $e->getMessage();
}

$ajson = json_encode($datos);
echo $_GET["jsoncallback"].'('.$ajson.');';
//$xml = simplexml_load_file($ruta);
/*function obtenerDatos($ruta){
//read entire file into string
   $xmlfile = file_get_contents($ruta);

                //convert xml string into an object
    $xml = simplexml_load_string($xmlfile);

                //convert into json
    $json  = json_encode($xml);

    $items=json_decode($json,true);
                        //lista de items a recorrer
    $listaItems = $items["channel"]["item"];


             //bucle para recorrer los elementos del array
            for ($i = 0; $i<count($listaItems); $i++){

               echo $listaItems[$i]["key"];
               echo $listaItems[$i]["type"];
               echo $listaItems[$i]["status"];

             echo $listaItems[$i]["component"];

            echo $listaItems[$i]['issuelinks'][$i]['issulinktype'][$i]['outwardlinks'][$i]['issuelink'][$i]['issuekey'];
             echo $listaItems[$i]['attachments']['attachment'][$i]['name'];

            }

      }*/
      /*
      $servername = "localhost1";
      $username = "root";
      $password = "";
      $dbname = "appinbur";

      $mysqli= new mysqli($servername, $username, $password, $dbname) or die(mysqli_error());
*/


   /*function almacenarDatos($ruta){
      include 'conectar.php';


        $xml = file_get_contents($ruta);
         $DOM = new DOMDocument('1.0','utf-8');

         $DOM->loadXML($xml);

           $factura_xml = $DOM->getElementsByTagName('rss');
        $i = 0;
           foreach($factura_xml as $item){
              $item2 = $item->getElementsByTagName('item');
              $key = $item->getElementsByTagName('key')->item($i)->nodeValue;
              $type = $item->getElementsByTagName('type')->item($i)->nodeValue;
              $status = $item->getElementsByTagName('status')->item($i)->nodeValue;
              $component = $item->getElementsByTagName('component')->item($i)->nodeValue;

              $comandoSQL = "INSERT INTO versist(clave,  tipo_incidencia, estatus, componentes) values ('$key','$type','$status','$component');";
               $resultado1 = $mysqli->query($comandoSQL);

              foreach($item2 as $hijo1){
                 $issuelinks = $hijo1->getElementsByTagName('issuelinks');

                  foreach($issuelinks as $hijo2){
                    $outwardlinks= $hijo2->getElementsByTagName('outwardlinks');

                      foreach ($outwardlinks as $hijo3) {
                        # code...
                        $issuelink= $hijo3->getElementsByTagName('issuelink');

                          //$j=0;
                           foreach ($issuelink as $hijo4) {
                          # code...
                            $issuekey = $hijo4->getElementsByTagName('issuekey')->item(0)->nodeValue;

                            $comandoSQLissue = "INSERT INTO versistissuelinks(clave, name_issuelink) values ('$key','$issuekey');";
                             $resultado2 = $mysqli->query($comandoSQLissue);
                             //$j++;
                          }


                      }
                  }

                  $attachments = $hijo1->getElementsByTagName('attachments');
                  foreach ($attachments as $hijo21) {
                    # code...
                    $attachment = $hijo21->getElementsByTagName('attachment');
                    foreach ($attachment as $valueAtri) {
                      # code...
                      $attachname= $valueAtri->getAttribute('name');
                      $comandoSQLattach = "INSERT INTO versistattachment(clave, namefile) values ('$key','$attachname');";
                      $resultado3 = $mysqli->query($comandoSQLattach);
                    }

                  }
              }
              $i++;
           }
       }*/
?>
