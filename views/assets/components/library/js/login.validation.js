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
	 console.log("Inside password modal");
	});
	$("#modalForgotPasswordForm").submit(function(e) {
	  console.log("Prevent Default");
	  e.preventDefault();
	});
	$("#forgotpasswordsubmit").click(function(e) {
		console.log("Inside password submit");
		//e.preventDefault();
		var email = $("#passwordemailid").val();
		$.ajax({
				url: "forgotpassword.php",
				type: "GET",
				data: "mailId="+email,
				success: function(data){
							//alert("Password Reset");
							$("#closeforgotpasswordmodal").click();
							//console.log("Success");
							//console.log(data);
							alert(data);
							//location.reload(true);
							//console.log("getAjax.php?function=transaction&iban="+iban+"&bic="+bic+"&tan="+tan+"&amount="+amount+"&emailId="+emailId+"&password="+tranPasswordhash);
						},
				error: function(){
							//console.log("failed");
							//console.log("getAjax.php?function=transaction&iban="+iban+"&bic="+bic+"&tan="+tan+"&amount="+amount+"&emailId="+emailId+"&password="+tranPasswordhash);
							$("#closeforgotpasswordmodal").click();
							alert("There was an error, please try again!");
						}
			
			
			});
	});
	

});