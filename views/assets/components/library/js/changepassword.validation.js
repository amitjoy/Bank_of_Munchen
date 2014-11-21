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

	if ($('#newpassword').val() != $('#confirmnewpassword').val()) {
		alert('Wrong Confirm Password!');
		return false;
	}

	var currentpasswordHash = CryptoJS.SHA512($('#currentpassword').val());
    var newpasswordHash = CryptoJS.SHA512($('#newpassword').val());
    var confirmnewpasswordHash = CryptoJS.SHA512($('#confirmnewpassword').val());

    $('#confirmnewpassword').val(confirmnewpasswordHash);
    $('#newpassword').val(newpasswordHash);
    $('#currentpassword').val(currentpasswordHash);
	


});


});