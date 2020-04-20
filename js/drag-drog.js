(function() {
	function Init() {
		var fileSelect = document.getElementById('file-upload'),
			fileDrag = document.getElementById('file-drag'),
			submitButton = document.getElementById('submit-button');

		fileSelect.addEventListener('change', fileSelectHandler, false);

		// Is XHR2 available?
		var xhr = new XMLHttpRequest();
		if (xhr.upload) {
			// File Drop
			fileDrag.addEventListener('dragover', fileDragHover, false);
			fileDrag.addEventListener('dragleave', fileDragHover, false);
			fileDrag.addEventListener('drop', fileSelectHandler, false);
		}
	}

	function fileDragHover(e) {
		var fileDrag = document.getElementById('file-drag');
		var modal = document.getElementById('myModal');

		e.stopPropagation();
		e.preventDefault();
    //e.target.className = (e.type == "dragover" ? "hover" :"myModal file-upload" );
		fileDrag.className = (e.type === 'dragover' ? 'hover' : '');
		modal.className = (e.type === 'dragover' ? 'hover' : '');
		//document.getElementById('myModal').showModal();
	}


	//mantiene el archivo
	function fileSelectHandler(e) {
		// Fetch FileList object
		var files = e.target.files || e.dataTransfer.files;

		// Cancel event and hover styling
		fileDragHover(e);

		// Process all File objects
		for (var i = 0, f; f = files[i]; i++) {
			//parseFile(f);
			uploadFile(f);
		}
	}

	//se manda el mensaje al div de messages
	/*function output(msg) {
		var m = document.getElementById('messages');
		m.innerHTML = msg;
	}
	//devuelve los datos del archivo
	function parseFile(file) {
		output(
			'<ul>'
			+	'<li>Name: <strong>' + encodeURI(file.name) + '</strong></li>'
			+	'<li>Type: <strong>' + file.type + '</strong></li>'
			+	'<li>Size: <strong>' + (file.size / (1024 * 1024)).toFixed(2) + ' MB</strong></li>'
			+ '</ul>'
		);
	}

	function setProgressMaxValue(e) {
		var pBar = document.getElementById('file-progress');

		if (e.lengthComputable) {
			pBar.max = e.total;
		}
	}

	function updateFileProgress(e) {
		var pBar = document.getElementById('file-progress');

		if (e.lengthComputable) {
			pBar.value = e.loaded;
		}
	}*/

	function uploadFile(file) {
		var xhr = new XMLHttpRequest();
		fileSizeLimit = 1024;
		if (xhr.upload && file.size <= fileSizeLimit * 1024 * 1024) {
			if (file.type == "text/xml") {
				$("#modal_error").modal('hide');
			//ProgressBar
			//var o = document.getElementById('progress')//$id("");

			//Create element with class
			//var p = document.createElement("p");
			//p.setAttribute('class', 'uploadProgressBar');
			//p.classList.add("uploadProgressBar");
			//var node = document.createTextNode("p");
			//End
		//	var progress = o.appendChild(document.createElement("p"));
		//	progress.appendChild(document.createTextNode(file.name));
		$("#modal_id").modal('show');
		xhr.upload.addEventListener("progress",function(evt){
			if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
				percentComplete = parseInt(percentComplete * 100);
				$('.uploadProgressBar').attr('aria-valuenow',percentComplete).css('width', percentComplete + '%').text(percentComplete + '%');

				if (percentComplete == 100) {
					//$("#modal_id").modal('hide');
					location.href="php/sube.php";
				}
			}
		}, false);

		//progressbar

				/*xhr.upload.addEventListener("progress", function(e){
					var pc = parseInt(e.loaded / e.total * 100);
					progress.style.backgroundPosition = pc + "% 0";
				}, false);
					// file received/failed
				xhr.onreadystatechange = function(e) {
					if (xhr.readyState == 4) {
						progress.className = (xhr.status == 200 ? "success" : "failure");
						$("#modal_id").modal('hide');
						//document.location.reload(true);
					}
				};*/

				//Start upload
				var formData = new FormData();
				formData.append("xml", file);


				xhr.open('POST', "php/sube.php");
				xhr.setRequestHeader('Content-Type', 'multipart/form-data');
				xhr.send(formData);


				/*xhr.open("POST", document.getElementById('file-upload-form').action, true);
				xhr.setRequestHeader("X-File-Name", file.name);
				xhr.send(file);*/
				//var fileSelect = document.getElementById('file-upload');
				/*
				// Is XHR2 available?
				var xmlhttp = new XMLHttpRequest();

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
*/

			} else {
				$("#modal_error").modal('show');
			}
		}
	}

	// Check for the various File API support.
	if (window.File && window.FileList && window.FileReader) {
		Init();
	} else {
		document.getElementById('file-drag').style.display = 'none';
	}
})();
