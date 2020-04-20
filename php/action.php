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
