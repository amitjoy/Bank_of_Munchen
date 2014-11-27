$(function(){

$(".btn-success").click(function(){
 var url =$(this).attr("url");
 console.log(url);
 $("#initaliseamountsubmit").attr("href",url)
 $("#initialiseamountmodal").click();
});

/*$("#initaliseamountsubmit").click(function(){
 var url =$(this).attr("href");
 var initialamount = $("#initialiseamount").val();
 var newurl = url+initialamount;
 console.log(newurl);
 $("#initaliseamountsubmit").attr("href",newurl)


});*/

$("#initialiseamount").change(function(){

 var amount = $("#initialiseamount").val();
 var url =$("#initaliseamountsubmit").attr("href");
 var newurl = url+amount;
 //console.log(newurl);
 $("#initaliseamountsubmit").attr("href",newurl)
});

});