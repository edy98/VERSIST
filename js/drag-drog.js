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
		console.log("arrastart")
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

		var file = e.target.files || e.dataTransfer.files;
		var fd = new FormData();

		fd.append('xml', file[0]);

		uploadFile(fd);
	}

	function fileSelectHandler(e){
		var fd = new FormData();

		var fileInput = document.getElementById('file-upload');

		var files = fileInput.files[0];

		validateFile(files);

		fd.append('xml',files);

		uploadFile(fd);
	}
	///mantiene el archivo
	/*function fileSelectHandler(e) {
		var fd = new FormData();
		// Fetch FileList object
		var files = e.target.files || e.dataTransfer.files;

		// Cancel event and hover styling
		fileDragHover(e);

		// Process all File objects
		for (var i = 0, f; f = files[i]; i++) {
			//parseFile(f);
			uploadFile(f);
		}
	}*/


	function validateFile(file){
		var xhr = new XMLHttpRequest();
		fileSizeLimit = 1024;
		if (xhr.upload && file.size <= fileSizeLimit * 1024 * 1024) {
			if (file.type == "text/xml") {
				$("#modal_error").modal('hide');

				$("#modal_id").modal('show');
				xhr.upload.addEventListener("progress",function(evt){
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						percentComplete = parseInt(percentComplete * 100);
						$('.uploadProgressBar').attr('aria-valuenow',percentComplete).css('width', percentComplete + '%').text(percentComplete + '%');

						if (percentComplete == 100) {
							//$("#modal_id").modal('hide');
						//location.href="php/sube.php";
						}
					}
				}, false);

				xhr.onload = function () {
					if (xhr.status === 200) {
					} else {
						alert("File upload failed!" + xhr.status);
					}
				};

				xhr.onreadystatechange = function() { // Call a function when the state changes.
					if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        // Request finished. Do processing here.
				console.log(xhr	.statusText);
    }
	}

			} else {
				$("#modal_error").modal('show');
			}
		}

	}

	function uploadFile(formData) {
		$.ajax({
	 url: 'http://localhost/VERSIST-APP/php/sube.php',
	 type: "POST",
	 data: formData,
	 processData: false,
	 contentType: false,

	 success: function(response) {
			 //location.href="php/sube.php"
	 },
	 error: function(jqXHR, textStatus, errorMessage) {
			 console.log(errorMessage); // Optional
		 	 }
		 });
}

	// Check for the various File API support.
	if (window.File && window.FileList && window.FileReader) {
		Init();
	} else {
		document.getElementById('file-drag').style.display = 'none';
	}
})();
