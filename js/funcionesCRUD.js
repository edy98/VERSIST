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
  document.getElementById('validar').style.display = 'none';
  document.getElementById('generarReporte').style.display = 'block';
  document.getElementById('Vcancelar').style.display = 'block';
  document.getElementById('Vvalidar').style.display = 'block';
  document.getElementById('resultado').style.display = 'none';
}

function cancelarVersist(){
  document.getElementById('versistCancelar').style.display = 'block';
  document.getElementById('versistValidar').style.display = 'none';
  document.getElementById('generarListaC').style.display = 'block';
  document.getElementById('generarListaV').style.display = 'none';
  document.getElementById('generarReporte').style.display = 'none';
}

function validarVersist(){
  document.getElementById('versistValidar').style.display = 'block';
  document.getElementById('versistCancelar').style.display = 'none';
  document.getElementById('generarListaV').style.display = 'block';
  document.getElementById('generarListaC').style.display = 'none';
  document.getElementById('generarReporte').style.display = 'none';
}
