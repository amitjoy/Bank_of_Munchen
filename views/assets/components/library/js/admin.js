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
	if (isNaN($("#inputTitle").value)) {
		error =  "The amount should be numeric" + "\n";
		//invalid += 1;
		alert (error);
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