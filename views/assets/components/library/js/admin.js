$(function(){

$(".btn-success").click(function(){
 var url =$(this).attr("url");
 console.log(url);
 $("#initaliseamountsubmit").attr("href",url)
 $("#initialiseamountmodal").click();
});

$("#initaliseamountsubmit").click(function(){
	
	if(!$("#initialiseamount").val()){
		alert('Please enter the amount');
		return false;
	}
	
	
});

$("#initialiseamount").change(function(){

 var amount = $("#initialiseamount").val();
 var url =$("#initaliseamountsubmit").attr("href");
 var newurl = url+amount;
 //console.log(newurl);
 $("#initaliseamountsubmit").attr("href",newurl)
});

});