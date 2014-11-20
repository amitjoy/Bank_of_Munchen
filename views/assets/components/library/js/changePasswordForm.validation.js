var invalid = 0;

function validateChangePasswordForm() {

	var form = document.getElementById("changePasswordForm");

	var currentpassword = document.getElementById("currentpassword").value;
	var newPassword = document.getElementById("newpassword").value;
	var confirmnewPassword = document.getElementById("confirmnewpassword").value;

	if (newPassword != confirmnewPassword) {
		alert ("Confirm Password Wrong");
		return false;
	}

	var currentpasswordHash = CryptoJS.SHA512(currentpassword);
    var newpasswordHash = CryptoJS.SHA512(newPassword);
    var confirmnewpasswordHash = CryptoJS.SHA512(confirmnewPassword);
    
    document.getElementById("currentpassword").value = currentpasswordHash;
	document.getElementById("newpassword").value = newpasswordHash;
	document.getElementById("newpassword").value = confirmnewpasswordHash;

	form.submit();

    return true;
}