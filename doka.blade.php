<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JavaScript Image Cropping with DropzoneJS</title>
  <link href="https://unpkg.com/dropzone/dist/dropzone.css" rel="stylesheet"/>
  <link href="doka.min.css" rel="stylesheet"/>
</head>
<body>
  <div class="dropzone" id="myDropzone"></div>
  <script src="https://unpkg.com/dropzone"></script>
  <script src="doka.min.js"></script>
  <script>
	// Create our Doka image editor
	var doka = Doka.create({
	  cropAspectRatio: 1
	});
	// Configure Dropzone
	Dropzone.options.myDropzone = {
	  url: '/post',
	  transformFile: function(file, done) {
	  	// Shortcut to this dropzone
		  var myDropZone = this;
		  // Edit the file and wait for confirm
		  doka.edit(file).then(function(output) {
		    // Get blob from Doka output object
		    var blob = output.file;
		    
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
		        // Tell Dropzone of the new file
		        done(blob);
		     });
		  });
	  }
	};
	</script>
</body>
</html>