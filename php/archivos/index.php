<!DOCTYPE html>
<header>
    <meta charset="utf-8">
    <title>lector de RSS</title>
 
    <style>
    h1, h2 {margin-bottom:0px;}
    .link {font-size:0.8em}
    .desc {}
    </style>
 
    <script>
    function getRSS(param)
    {
        var xmlhttp;
        xmlhttp=new XMLHttpRequest();
 
        // El archivo xml tiene que estar en el mismo servidor que el código javascript.
        // Por temas de seguridad, no se permite acceder desde javascript a archivos
        // alojados en otro servidor
       xmlhttp.open("GET","versist.xml",false); // tambien puedes poner http://localhost/miCodigo.xml
        xmlhttp.send();
        xmlDoc=xmlhttp.responseXML;
 
        var strBuffer= "";
 
        // obtenemos los datos genericos del RSS
        title=xmlDoc.getElementsByTagName("title")[0].innerHTML;
        link=xmlDoc.getElementsByTagName("link")[0].innerHTML;
        desc=xmlDoc.getElementsByTagName("description")[0].innerHTML;
 
        strBuffer=strBuffer+"<h1>"+title+"</h1>";
        strBuffer = strBuffer +"<div class='link'><a href='"+link+"' target='_blank'>"+link+"</a></div>";
        strBuffer = strBuffer +"<div class='desc'>"+desc+"</div><hr>";
 
        // Recorremos todos los <item> del RSS
        var x=xmlDoc.getElementsByTagName("item");
        for (i=0;i<x.length;i++)
        {
            key=x[i].getElementsByTagName("key")[0].childNodes[0].nodeValue;
            type=x[i].getElementsByTagName("type")[0].childNodes[0].nodeValue;
            status=x[i].getElementsByTagName("status")[0].childNodes[0].nodeValue;
            issue=x[i].getElementsByTagName("issuelinks")[0].childNodes[0].nodeValue;
            component=x[i].getElementsByTagName("component")[0].childNodes[0].nodeValue;
            file=x[i].getElementsByTagName("attachments")[0].childNodes[0].nodeValue;
 
            strBuffer = strBuffer +"<h2>"+key+"</h2>";
            strBuffer = strBuffer +"<div class='type'>"+type+"</div>";
            strBuffer = strBuffer +"<div class='status'>"+status+"</div>";
            strBuffer = strBuffer +"<div class='status'>"+issue+"</div>";
            strBuffer = strBuffer +"<div class='status'>"+component+"</div>";
            strBuffer = strBuffer +"<div class='status'>"+file+"</div>";

            if(i==10){
                break;
            }
        }
        document.getElementById(param).innerHTML =strBuffer;
    }
    </script>
</header>
 
<body onload ="getRSS('contenidoRSS');">
    <div id="contenidoRSS"></div>
</body>
</html>