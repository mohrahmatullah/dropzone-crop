<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JavaScript Image Cropping with DropzoneJS</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://unpkg.com/dropzone/dist/dropzone.css" rel="stylesheet"/>
  <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
</head>
<body>
  <div class="dropzone" id="myDropzone"></div>
  <script src="https://unpkg.com/dropzone"></script>
  <script src="https://unpkg.com/cropperjs"></script>
  <script>
  	window.Laravel = {!! json_encode([
	    'csrfToken' => csrf_token(),
	]) !!};
	Dropzone.options.myDropzone = {
	 url: "/upload/product-related-image",
	 paramName: "cover_picture",
	 acceptedFiles:  "image/*", 
     uploadMultiple:false, 
     maxFiles:1, 
     autoProcessQueue: true, 
     parallelUploads: 100, 
     addRemoveLinks: true, 
     maxFilesize: 1,
     dataType:  'json',
	 headers: {
        'X-CSRF-TOKEN': Laravel.csrfToken
    },	
	 	transformFile: function(file, done) {
		  // Create Dropzone reference for use in confirm button click handler
		  var myDropZone = this;
		  // Create the image editor overlay
		  var editor = document.createElement('div');
		  editor.style.position = 'fixed';
		  editor.style.left = 0;
		  editor.style.right = 0;
		  editor.style.top = 0;
		  editor.style.bottom = 0;
		  editor.style.zIndex = 9999;
		  editor.style.backgroundColor = '#000';
		  document.body.appendChild(editor);
		  // Create confirm button at the top left of the viewport
		  var buttonConfirm = document.createElement('button');
		  buttonConfirm.style.position = 'absolute';
		  buttonConfirm.style.left = '10px';
		  buttonConfirm.style.top = '10px';
		  buttonConfirm.style.zIndex = 9999;
		  buttonConfirm.textContent = 'Confirm';
		  editor.appendChild(buttonConfirm);
		  buttonConfirm.addEventListener('click', function() {
		    // Get the canvas with image data from Cropper.js
		    var canvas = cropper.getCroppedCanvas({
		      width: 256,
		      height: 256
		    });
		    // Turn the canvas into a Blob (file object without a name)
		    canvas.toBlob(function(blob) {
		      // Create a new Dropzone file thumbnail
		      myDropZone.createThumbnail(
		        blob,
		        myDropZone.options.thumbnailWidth,
		        myDropZone.options.thumbnailHeight,
		        myDropZone.options.thumbnailMethod,
		        false, 
		        function(dataURL) {
		          
		          // Update the Dropzone file thumbnail
		          myDropZone.emit('thumbnail', file, dataURL);
		          // Return the file to Dropzone
		          done(blob);
		      });
		    });
		    // Remove the editor from the view
		    document.body.removeChild(editor);
		  });
		  // Create an image node for Cropper.js
		  var image = new Image();
		  image.src = URL.createObjectURL(file);
		  editor.appendChild(image);
		  
		  // Create Cropper.js
		  var cropper = new Cropper(image, { aspectRatio: 1 });
		}
	};
	</script>
</body>
</html>