$(function(){

$("#pluploadUploader").plupload({

filters: {
  mime_types : [
    { title : "Text Files", extensions : "txt" }
  ],
  max_file_size: "1mb",
  prevent_duplicates: true
}



});



});