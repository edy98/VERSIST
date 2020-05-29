document.getElementById('datosV').style.display = 'none';

//Función para mostrar los datos obtenidos del archivo mostrar.php
function btnMostrar(){
  $.ajax({
    url: '../php/mostrar.php',
    type: "GET",
    dataType: "jsonp",
    jsonp: "jsoncallback",
    crossDomain: true,
    success:function(data){
      $.each(data, function(key, value){
        var tr = document.createElement('tr');
        //Se dan los valores a las etiquetas
        tr.innerHTML = "<td>" + value.clave + "</td>"
        + "<td>" + value.tipo_incidencia + "</td>"
        + "<td>" + value.estatus + "</td>"
        + "<td>" + value.componentes + "</td>"
        + "<td>" + value.incidencias + "</td>"
        + "<td>" + value.namefile + "</td>";

        //Se anexan los nodos hijos al nodo padre de la tabla
      document.getElementById("date").appendChild(tr);
      });
    },
    error: function(textStatus, errorMessage){
      console.log(textStatus);
    }
  });

  document.getElementById('validar').style.display = 'block';
  document.getElementById('Generar').disabled = true;
}

//Se muestran los datos de acuerdo a su validación
function validarResultadoVersist(){
  document.getElementById('datosV').style.display = 'block';
  document.getElementById('datos').style.display = 'none';
  $.ajax({
    url: '../php/mostrarVResultado.php',
    type: "GET",
    dataType: "jsonp",
    jsonp: "jsoncallback",
    crossDomain: true,
    success:function(data){
      $.each(data, function(key, value){
        var tr = document.createElement('tr');
        tr.innerHTML = "<td>" + value.clave + "</td>"
        + "<td>" + value.accion + "</td>"
        + "<td>" + value.estado + "</td>"
        + "<td>" + value.tipo_incidencia + "</td>"
        + "<td>" + value.incidencias_enlazadas + "</td>"
        + "<td>" + value.archivos_adjuntos + "</td>";

      document.getElementById("dateV").appendChild(tr);
      });
    },
    error: function(textStatus, errorMessage){
      console.log(textStatus);
    }
  });
  document.getElementById('validar').style.display = 'none';
  document.getElementById('generarReporte').style.display = 'block';
  document.getElementById('Vcancelar').style.display = 'block';
  document.getElementById('Vvalidar').style.display = 'block';
  document.getElementById('resultado').style.display = 'none';
}

//Se muestran los datos de los versist de acuerdo a la acción
function cancelarVersist(){
  document.getElementById('datosV').style.display = 'block';
  document.getElementById('datos').style.display = 'none';
   var tabla = document.getElementById('dateV');
  while(tabla.hasChildNodes()){
    tabla.removeChild(tabla.firstChild);

  }

  $.ajax({
    url: '../php/mostrarVCancelar.php',
    type: "POST",
    dataType: "jsonp",
    jsonp: "jsoncallback",
    crossDomain: true,
    success:function(data){
      if (data.message == "empty") {
        var pa=document.createElement('p');
        pa.innerHTML="No hay contenido disponible";
        pa.style.textAlign="center";
        pa.classList.add("top");
        document.getElementById('dateV').appendChild(pa);
        document.getElementById('generarListaC').disabled=true;
      }else{
        $.each(data, function(key, value){
          var tr = document.createElement('tr');
          tr.innerHTML = "<td>" + value.clave + "</td>"
          + "<td>" + value.accion + "</td>"
          + "<td>" + value.estado + "</td>"
          + "<td>" + value.tipo_incidencia + "</td>"
          + "<td>" + value.incidencias_enlazadas + "</td>"
          + "<td>" + value.archivos_adjuntos + "</td>";

        document.getElementById("dateV").appendChild(tr);
        });
      }
    },

  });

  document.getElementById('versistCancelar').style.display = 'block';
  document.getElementById('versistValidar').style.display = 'none';
  document.getElementById('generarListaC').style.display = 'block';
  document.getElementById('generarListaV').style.display = 'none';
  document.getElementById('generarReporte').style.display = 'none';
}

function validarVersist(){
  document.getElementById('datosV').style.display = 'block';
  document.getElementById('datos').style.display = 'none';
  var tabla = document.getElementById('dateV');
  while(tabla.hasChildNodes()){
    tabla.removeChild(tabla.firstChild);
  }

  $.ajax({
    url: '../php/mostrarVValidar.php',
    type: "GET",
    dataType: "jsonp",
    jsonp: "jsoncallback",
    crossDomain: true,
    success:function(data){
        if (data.message == "empty") {
        var pa=document.createElement('p');
        pa.innerHTML="No hay contenido disponible";
        pa.style.textAlign="center";
        pa.classList.add("top");
        document.getElementById('dateV').appendChild(pa);
        document.getElementById('generarListaV').disabled=true;
      }else{
        $.each(data, function(key, value){
          var tr = document.createElement('tr');
          tr.innerHTML = "<td>" + value.clave + "</td>"
          + "<td>" + value.accion + "</td>"
          + "<td>" + value.estado + "</td>"
          + "<td>" + value.tipo_incidencia + "</td>"
          + "<td>" + value.incidencias_enlazadas + "</td>"
          + "<td>" + value.archivos_adjuntos + "</td>";

        document.getElementById("dateV").appendChild(tr);
        });
      }
    },

  });
  document.getElementById('versistValidar').style.display = 'block';
  document.getElementById('versistCancelar').style.display = 'none';
  document.getElementById('generarListaV').style.display = 'block';
  document.getElementById('generarListaC').style.display = 'none';
  document.getElementById('generarReporte').style.display = 'none';
}

//Se crean las listas de acuerdo a la información proporcionada por el archivo de la url
function generarListaC(){
  var lista = document.getElementById('listaC');
  while(lista.hasChildNodes()){
    lista.removeChild(lista.firstChild);
  }
  $.ajax({
    url: '../php/mostrarVCancelar.php',
    type: "GET",
    dataType: "jsonp",
    jsonp: "jsoncallback",
    crossDomain: true,
    success:function(data){
        $.each(data, function(key, value){
          var li = document.createElement('li');
          li.innerHTML =  value.clave + ",";

        document.getElementById("listaC").appendChild(li);
        });
    },

  });
}

function generarListaV(){
  var lista = document.getElementById('listaV');
  while(lista.hasChildNodes()){
    lista.removeChild(lista.firstChild);
  }
  $.ajax({
    url: '../php/mostrarListaValidar.php',
    type: "GET",
    dataType: "jsonp",
    jsonp: "jsoncallback",
    crossDomain: true,
    success:function(data){
        $.each(data, function(key, value){
          var li = document.createElement('li');

          li.innerHTML =  value.name_issuelink + ",";

        document.getElementById("listaV").appendChild(li);
        });
    },

  });
}

function btnMostrarR(){
  $.ajax({
    url: '../php/mostrarRpn.php',
    type: "GET",
    dataType: "jsonp",
    jsonp: "jsoncallback",
    crossDomain: true,
    success:function(data){
      $.each(data, function(key, value){
        var tr = document.createElement('tr');
        //Se dan los valores a las etiquetas
        tr.innerHTML = "<td>" + value.versist_clave + "</td>"
        + "<td>" + value.clave_rpn + "</td>"
        + "<td>" + value.tipo_incidencia + "</td>"
        + "<td>" + value.estatus + "</td>"
        + "<td>" + value.incidencias + "</td>"
        + "<td>" + value.namefile + "</td>";

        //Se anexan los nodos hijos al nodo padre de la tabla
      document.getElementById("dateR").appendChild(tr);
      });
    },
    error: function(textStatus, errorMessage){
      console.log(textStatus);
    }
  });

  document.getElementById('validarR').style.display = 'block';
  document.getElementById('GenerarR').disabled = true;
}
