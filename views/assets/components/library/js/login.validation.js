function validation() {
	
	var form = document.getElementById("loginForm");

	
	var password = document.getElementById("password").value;
	var hash = CryptoJS.SHA512(password);
	document.getElementById("password").value = hash;
	
	form.submit();
	
	return true;
  }

  

