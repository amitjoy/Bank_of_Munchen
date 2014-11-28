// java script for registration form validation routine  


  // initialize the switch
  var invalid = 0;
 
  function validateFields() {
	invalid = 0;
 	length = document.getElementById("password").value.length;
	var alphaExp = /^[a-zA-Z]+$/;	
	var passcheck=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
	var error = "";

	//First name of the user - blank, non-alphabet
	if (document.getElementById("firstName").value.length == 0) {
	    error += "You must type in a first name" + "\n";
	    invalid += 1;
	}
	else if(!document.getElementById("firstName").value.match(alphaExp)){
	error += "Invalid first name" + "\n";
	    invalid += 1;
	}
	else {
            error += "";		
	}


	//Middle name of the user - not alphabet
	if(!document.getElementById("middleName").value.match(alphaExp) && document.getElementById("middleName").value.length != 0){
	    error +=  "Invalid middle name" + "\n";
	    invalid += 1;
	}
	else {
            error +=  "";

	}

	//Last name of the user - blank, non-alphabet
	if (document.getElementById("lastName").value.length == 0) {
	    error +=  "You must type in a last name" + "\n";
	    invalid += 1;
	}
	else if(!document.getElementById("lastName").value.match(alphaExp)){
	error +=  "Invalid last name" + "\n";
	    invalid += 1;
	}
	else {
            error +=  "";		
	}

	//Email Id of the user - blank
	if (document.getElementById("emailId").value == "") {
	    error +=  "Email id field can not be blank" + "\n";
	    invalid += 1;
	}
	else {
            error += "";		
	}

	//Mobile number of the user - blank or non-numeric or not 10 digits
	if (document.getElementById("mobileNo").value == "") {
	    error +=  "Mobile number field can not be blank" + "\n";
	    invalid += 1;
	}
	else if (isNaN(document.getElementById("mobileNo").value)) {
	    error +=  "Mobile number should be in numeric" + "\n";
	    invalid += 1;
	}
	else if (document.getElementById("mobileNo").value.length != 11) {
	    error += "Mobile number should be 11 digits" + "\n";
	    invalid += 1;
	}
	else {
            error += "";		
	}

	
	//Password of the user - criteria: 8-15 characters, must include atleast one uppercase, one lowercase, one numeric and one special character
	if (document.getElementById("password").value == "") {
	   error += "You must type in a password" + "\n";
	   invalid += 1;
	}
	else if (!document.getElementById("password").value.match(passcheck)) {
	    error +=  "Entered password should have uppercase, lowercase, numeric and special chars" + "\n";
	    invalid += 1;
	}
	else {
            error +=  "";		
	}

	//Retype password of the user - blank or entered passwords are different
	if (document.getElementById("retypePassword").value == "") {
	    error +=  "You must confirm the password" + "\n";
	    invalid += 1;
	}
	else if (document.getElementById("retypePassword").value != document.getElementById("password").value) {
	    error +=  "Your passwords do not match" + "\n";
	    invalid += 1;
	}
	else {
            error += "";		
	}

	//var form = document.getElementByName("registration");

	//Final check
	if (invalid != 0) {
		alert (error);
	    return false;
	}
	else {

	    var form = document.getElementById("registrationForm");

        var password = document.getElementById("password").value;
	var retypePassword = document.getElementById("retypePassword").value;
	var retypeHash = CryptoJS.SHA512(retypePassword);
        var hash = CryptoJS.SHA512(password);
        document.getElementById("password").value = hash;
	document.getElementById("retypePassword").value = retypeHash;

        //submit the form
        form.submit();
        return true;
	}
  }

  

