$(function()
{
	var bWizardTabClass = '';
	var error = "";
	$('.wizard').each(function()
	{
		if ($(this).is('#rootwizard'))
			bWizardTabClass = 'bwizard-steps';
		else
			bWizardTabClass = '';

		var wiz = $(this);
		
		$(this).bootstrapWizard(
		{
			onNext: function(tab, navigation, index) 
			{	
				if(index==1)
				{
					// Make sure we entered the IBAN
					if(!wiz.find('#inputTitle').val()) {
						alert('You must enter the IBAN number');
						wiz.find('#inputTitle').focus();
						return false;
					}
					//IBAN number is non-numeric or not 10 digits
					if (isNaN(document.getElementById("inputTitle").value)) {
						error =  "IBAN number should be in numeric" + "\n";
						//invalid += 1;
						alert (error);
						return false;
					}
					
					if ($("#inputTitle").val().length != 14){
					  alert("IBAN should be of 14 digits");
					  return false;
					}
				}
				if(index==2)
				{
					// Make sure we entered the BIC
					if(!wiz.find('#inputBic').val()) {
						alert('You must enter the BIC Code');
						wiz.find('#inputBic').focus();
						return false;
					}
					//BIC code is non-numeric or not 10 digits
					if (isNaN(document.getElementById("inputBic").value)) {
						error =  "BIC should be in numeric" + "\n";
						//invalid += 1;
						alert (error);
						return false;
					}
					if ($("#inputBic").val().length != 6){
					  alert("BIC should be having 6 digits");
					  return false;
					}
				}
				if(index==3)
				{
					// Make sure we entered the amount
					if(!wiz.find('#amount').val()) {
						alert('You must enter the Amount');
						wiz.find('#amount').focus();
						return false;
					}
					//Amount is non-numeric or not 10 digits
					if (isNaN(document.getElementById("amount").value)) {
						error =  "Amount should be in numeric" + "\n";
						//invalid += 1;
						alert (error);
						return false;
					}
					
				}
				if(index==4)
				{
					// Make sure we entered the amount
					if(!wiz.find('#tan').val()) {
						alert('You must enter the TAN');
						wiz.find('#tan').focus();
						return false;
					}
					//TAN is non-numeric or not 10 digits
					if (isNaN(document.getElementById("tan").value)) {
						error =  "TAN should be in numeric" + "\n";
						//invalid += 1;
						alert (error);
						return false;
					}
					if ($("#tan").val().length != 15){
					  alert("TAN should be  of 15 digits");
					  return false
					}
					$("#confirmiban").empty();
					$("#confirmbic").empty();
					$("#confirmamount").empty();
					$("#confirmiban").append($("#inputTitle").val());
					$("#confirmbic").append($("#inputBic").val());
					$("#confirmamount").append($("#amount").val());
				}
				
			}, 
			onLast: function(tab, navigation, index) 
			{
				//if(index==1)
				{
					// Make sure we entered the IBAN
					if(!wiz.find('#inputTitle').val()) {
						alert('You must enter the IBAN number');
						wiz.find('#inputTitle').focus();
						return false;
					}
				}
				//if(index==2)
				{
					// Make sure we entered the BIC
					if(!wiz.find('#inputBic').val()) {
						alert('You must enter the BIC Code');
						wiz.find('#inputBic').focus();
						return false;
					}
				}
				//if(index==3)
				{
					// Make sure we entered the amount
					if(!wiz.find('#amount').val()) {
						alert('You must enter the Amount');
						wiz.find('#amount').focus();
						return false;
					}
				}
				//if(index==4)
				{
					// Make sure we entered the amount
					if(!wiz.find('#tan').val()) {
						alert('You must enter the Amount');
						wiz.find('#tan').focus();
						return false;
					}
				}

			}, 
			onTabClick: function(tab, navigation, index) 
			{
				if(index==0)
				{
					// Make sure we entered the IBAN
					if(!wiz.find('#inputTitle').val()) {
						alert('You must enter the IBAN number');
						wiz.find('#inputTitle').focus();
						return false;
					}
					//IBAN number is non-numeric or not 10 digits
					if (isNaN(document.getElementById("inputTitle").value)) {
						error =  "IBAN number should be in numeric" + "\n";
						//invalid += 1;
						alert (error);
						return false;
					}
				}
				if(index==1)
				{
					// Make sure we entered the BIC
					if(!wiz.find('#inputBic').val()) {
						alert('You must enter the BIC Code');
						wiz.find('#inputBic').focus();
						return false;
					}
					//BIC code is non-numeric or not 10 digits
					if (isNaN(document.getElementById("inputBic").value)) {
						error =  "BIC should be in numeric" + "\n";
						//invalid += 1;
						alert (error);
						return false;
					}
				}
				if(index==2)
				{
					// Make sure we entered the amount
					if(!wiz.find('#amount').val()) {
						alert('You must enter the Amount');
						wiz.find('#amount').focus();
						return false;
					}
					//Amount is non-numeric or not 10 digits
					if (isNaN(document.getElementById("amount").value)) {
						error =  "Amount should be in numeric" + "\n";
						//invalid += 1;
						alert (error);
						return false;
					}
					
				}
				if(index==3)
				{
					// Make sure we entered the amount
					if(!wiz.find('#tan').val()) {
						alert('You must enter the Amount');
						wiz.find('#tan').focus();
						return false;
					}
					
					//TAN is non-numeric or not 10 digits
					if (isNaN(document.getElementById("tan").value)) {
						error =  "TAN should be in numeric" + "\n";
						//invalid += 1;
						alert (error);
						return false;
					}
				}
				
				if(index == 4)
				{
					$("#confirmiban").empty();
					$("#confirmbic").empty();
					$("#confirmamount").empty();
					$("#confirmiban").append($("#inputTitle").val());
					$("#confirmbic").append($("#inputBic").val());
					$("#confirmamount").append($("#amount").val());
				}
				
			},
			onTabShow: function(tab, navigation, index) 
			{
				var $total = navigation.find('li:not(.status)').length;
				var $current = index+1;
				var $percent = ($current/$total) * 100;
				
				if (wiz.find('.progress-bar').length)
				{
					wiz.find('.progress-bar').css({width:$percent+'%'});
					wiz.find('.progress-bar')
						.find('.step-current').html($current)
						.parent().find('.steps-total').html($total)
						.parent().find('.steps-percent').html(Math.round($percent) + "%");
				}
				
				// update status
				if (wiz.find('.step-current').length) wiz.find('.step-current').html($current);
				if (wiz.find('.steps-total').length) wiz.find('.steps-total').html($total);
				if (wiz.find('.steps-complete').length) wiz.find('.steps-complete').html(($current-1));
				
				// mark all previous tabs as complete
				navigation.find('li:not(.status)').removeClass('primary');
				navigation.find('li:not(.status):lt('+($current-1)+')').addClass('primary');
	
				// If it's the last tab then hide the last button and show the finish instead
				if($current >= $total) {
					wiz.find('.pagination .next').hide();
					wiz.find('.pagination .finish').show();
					wiz.find('.pagination .finish').removeClass('disabled');
				} else {
					wiz.find('.pagination .next').show();
					wiz.find('.pagination .finish').hide();
				}
			},
			tabClass: bWizardTabClass,
			nextSelector: '.next', 
			previousSelector: '.previous',
			firstSelector: '.first', 
			lastSelector: '.last'
		});

		wiz.find('.finish').click(function() 
		{	
			$("#modalbutton").click();
			//wiz.find("a[data-toggle*='tab']:first").trigger('click');
			
			
			
		});
	});
	
	$("#modalForm").submit(function(e) {
	  e.preventDefault();
	});
	
	$( "#tranpassword" ).click(function() {

		    var emailId = $("#email").val();
			var amount = $("#amount").val();
			var iban = $("#inputTitle").val();
			var bic = $("#inputBic").val();
			var tan = $("#tan").val();
			var tranPasswordtext =$("#tranPasswordtext").val();
			var tranPasswordhash = CryptoJS.SHA512(tranPasswordtext);

			$.ajax({
				url: "getAjax.php",
				type: "POST",
				data: "function=transaction&iban="+iban+"&bic="+bic+"&tan="+tan+"&amount="+amount+"&emailId="+emailId+"&password="+tranPasswordhash,
				success: function(data){
							$("#closepasswordmodal").click();
							console.log("Success");
							console.log(data);
							alert(data);
							location.reload(true);
							console.log("getAjax.php?function=transaction&iban="+iban+"&bic="+bic+"&tan="+tan+"&amount="+amount+"&emailId="+emailId+"&password="+tranPasswordhash);
						},
				error: function(){
							console.log("failed");
							console.log("getAjax.php?function=transaction&iban="+iban+"&bic="+bic+"&tan="+tan+"&amount="+amount+"&emailId="+emailId+"&password="+tranPasswordhash);
							$("#closepasswordmodal").click();
							alert("There was an error, please try again!");
						}
			
			
			});
			
			$("#inputTitle").val('');
			$("#inputBic").val('');
			$("#amount").val('');
			$("#tan").val('');
			$("#confirmiban").empty();
			$("#confirmbic").empty();
			$("#confirmamount").empty();
			
		});
	
});