function validation() {
	
	var form = document.getElementById("loginForm");

	
	var password = document.getElementById("password").value;
	var hash = CryptoJS.SHA512(password);
	document.getElementById("password").value = hash;
	
	form.submit();
	
	return true;
  }

  

$(function(){

$("#forgotpasswordbutton").click(function(e) {
	 $("#forgotpasswordmodal").click();
	});

	$("#forgotpasswordsubmit").click(function(e) {
	    console.log("Inside password modal");
	});
	$("#modalForgotPasswordForm").submit(function(e) {
	  e.preventDefault();
	});

});