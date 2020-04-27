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
        + "<td>" + value.incidencias_enlazadas + "</td>";

      document.getElementById("datos").appendChild(tr);
      });
    },
    error: function(textStatus, errorMessage){
      console.log(textStatus);
    }
  });
}

function hide(){
  
}
