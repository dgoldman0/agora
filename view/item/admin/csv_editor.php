<?
require_once 'data.php';

function javascripts()
{
	?>
		<javascript type="text/javascript" src = "//cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"/>
	<?
}
?>

<input type="file" id="files" name="files[]" multiple />
<output id="list"></output>

<script>
  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    if (files.length > 0)
    {
		var file = files[0];
	
	  // Only process image files.
	  var reader = new FileReader();
	
	  // Closure to capture the file information.
	  reader.onload = (function(theFile) {
	    return function(e) {
	      // Render thumbnail.
	      var span = document.createElement('span');
	      span.innerHTML = ['<img class="thumb" src="', e.target.result,
	                        '" title="', escape(theFile.name), '"/>'].join('');
	      document.getElementById('list').insertBefore(span, null);
	    };
	  })(file);
	
	  // Read in the image file as a data URL.
	  reader.readAsDataURL(f);
	}
  }

  $('files').addEventListener('change', handleFileSelect, false);
</script>