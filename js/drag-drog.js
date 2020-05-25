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
			fileDrag.addEventListener('dragleave', fileDragLeave, false);
			fileDrag.addEventListener('drop', fileDragDrop, false);
		}
	}

	function fileDragHover(e) {
		var fileDrag = document.getElementById('file-drag');
		var modal = document.getElementById('myModal2');

		e.stopPropagation();
		e.preventDefault();
    //e.target.className = (e.type == "dragover" ? "hover" :"myModal file-upload" );
		fileDrag.className = (e.type === 'dragover' ? 'hover' : '');
		modal.className = (e.type === 'dragover' ? 'hover' : '');
		//document.getElementById('myModal').showModal();

	}

	function fileDragLeave(e) {
		fileDragHover(e);
	}

	function fileDragDrop(e){
		fileDragHover(e);

		var files = e.target.files || e.dataTransfer.files;
		//var file = e.originalEvent.dataTransfer.files;
		var fd = new FormData();
		if (files[0].type == "text/xml") {
			fd.append('xml', files[0]);

			uploadFile(fd);
		}else{
			$("#modal_error").modal('show');
		}

	}

	function fileSelectHandler(e){
		var fd = new FormData();

		var fileInput = document.getElementById('file-upload');

		var files = fileInput.files[0];

		if (files.type == "text/xml") {
			fd.append('xml',files);

			uploadFile(fd);
		}else{
			$("#modal_error").modal('show');
		}

	}

	function uploadFile(formData) {
		$.ajax({
			xhr : function(){
				var xhrobj = $.ajaxSettings.xhr();
				if (xhrobj.upload) {
					$("#modal_id").modal('show');
					xhrobj.upload.addEventListener("progress", function(evt){
						if (evt.lengthComputable) {
							var percentComplete = evt.loaded / evt.total;
							percentComplete = parseInt(percentComplete * 100);
							$('.uploadProgressBar').attr('aria-valuenow',percentComplete).css('width', percentComplete + '%').text(percentComplete + '%');

							if (percentComplete == 100) {
							}
						}
					}, false);
				}
				return xhrobj;
			},
			url: 'php/sube.php',
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success:function(response) {
			if (response.message == "error") {
				//console.log('Archivo erroneo');
				$("#modal_errorT").modal('show');
			}else{
				console.log('Archivo correcto');
				location.href="html/tabla-versist.html";
			}
		  },
		});
	}


	// Check for the various File API support.
	if (window.File && window.FileList && window.FileReader) {
		Init();
	} else {
		document.getElementById('file-drag').style.display = 'none';
	}
})();
