$(function(){

$("#changepasswordrest").click(function(){

$("#currentpassword").val("");
$("#newpassword").val("");
$("#confirmnewpassword").val("");


});

$("#changepasswordsubmit").click(function(){

	if(!$('#currentpassword').val() || !$('#newpassword').val()|| !$('#confirmnewpassword').val()) {
		alert('Please enter values in all mandatory fields!');
		return false;
	}


});


});