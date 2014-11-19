$(function() 
{
	/* Plupload */
	$("#pluploadUploader").pluploadQueue({
		// General settings
		runtimes : 'gears,browserplus,html5',
		url : 'upload.php',
		max_file_size : '1mb',
		chunk_size : '1mb',
		unique_names : true,
		multi_selection: false,

		// Resize images on clientside if we can
		resize : {width : 320, height : 240, quality : 90},

		// Specify what files to browse for
		filters : [
			{title : "text", extensions : "txt"}
		],

		// Flash settings
		flash_swf_url : 'plupload.flash.swf',

		// Silverlight settings
		silverlight_xap_url : 'plupload.silverlight.xap'
		
	});
	
	
	$(".plupload_start").click(

		function(){
			var uploader = $('#pluploadUploader').pluploadQueue();

			uploader.bind('QueueChanged', function(up) {
				if ( up.files.length > 0 && uploader.state != 2) {
					uploader.start();
				}
			});
		
		}
		
	)
});