$(function(){

$(".btn-success").click(function(){
var url =$(this).attr("url");
 $("#initaliseamountsubmit").attr("href",url)
 $("#initialiseamountmodal").click();
});




});