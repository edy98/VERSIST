document.getElementById('datosV').style.display = 'none';
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
        tr.innerHTML = "<td>" + value.clave + "</td>"
        + "<td>" + value.tipo_incidencia + "</td>"
        + "<td>" + value.estatus + "</td>"
        + "<td>" + value.componentes + "</td>"
        + "<td>" + value.incidencias + "</td>"
        + "<td>" + value.namefile + "</td>";

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

function cancelarVersist(){
  document.getElementById('datosV').style.display = 'block';
  document.getElementById('datos').style.display = 'none';
   var tabla = document.getElementById('dateV');
  while(tabla.hasChildNodes()){
    tabla.removeChild(tabla.firstChild);

  }

  $.ajax({
    url: '../php/mostrarVCancelar.php',
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
    url: '../php/mostrarVValidar.php',
    type: "GET",
    dataType: "jsonp",
    jsonp: "jsoncallback",
    crossDomain: true,
    success:function(data){
        $.each(data, function(key, value){
          var li = document.createElement('li');

          li.innerHTML =  value.clave + ",";

        document.getElementById("listaV").appendChild(li);
        });
    },

  });
}

/*function copiarPortaVc(){
  var codeCopiar = document.getElementById('copiar');
//  var text = document.querySelector('.data');
  var range = document.createRange();
  //range.selectNode(codeCopiar);
  range.selectNodeContents(codeCopiar);
  //Antes de añadir el intervalo de selección a la selección actual, elimino otros que pudieran existir (sino no funciona en Edge)
  window.getSelection().removeAllRanges();
  window.getSelection().addRange(range);
  try {
    // intentar copiar el contenido seleccionado
    var resultado = document.execCommand('copy');
    alert(resultado ? 'Información copiada' : 'No se pudo copiar la información');
  } catch(err) {
    console.log('ERROR al intentar copiar' + err);
  }
}*/
