document.addEventListener("DOMContentLoaded", function(){
		
	document.getElementById('flArquivo').addEventListener('change', handleFileSelect, false);
		
	function handleFileSelect(evt) {
		
	document.getElementById('list').innerHTML = "";
	var files = evt.target.files; // FileList object
	for (var i = 0, f; f = files[i]; i++) {

		if (!f.type.match('image.*')) {
			continue;
		}

		var reader = new FileReader();

		// Closure to capture the file information.
		reader.onload = (function (theFile) {
			return function (e) {
				// Render thumbnail.
				var span = document.createElement('span');
				span.innerHTML = ['<img style="max-width:250px; width: 100%;" data-caption="Imagem de pré visualização" class="thumb responsive-img materialboxed" src="', e.target.result,
					'" title="', escape(theFile.name), '"/>'].join('');
				document.getElementById('list').insertBefore(span, null);
			};
		})(f);

		// Read in the image file as a data URL.
		reader.readAsDataURL(f);
	}
}

}, false);