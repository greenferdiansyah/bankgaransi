jQuery(document).ready(function() {

	$('#policy').slimScroll({height: '482px'});

	$("#registration-form").submit(function(e) {
		e.preventDefault();
		
		var validatePolicy 	= $('input[id="checkbox-policy"]').prop('checked');
		var confirm 		= $('#retype_password').val();
		var password		= $('#password').val();	
		
		if(validatePolicy){
				if(password === confirm){
					var dataForm = $(this).serialize();
					$.ajax({
						url:"Registration/submit_register",
						type: "POST",
						data: dataForm,
						dataType: "json",
						beforeSend: function() {
							toastr.clear();
							toastr.info("Checking authentification", "Loading . . ", {
								closeButton: true,
								progressBar: true,
								debug: false,
								positionClass: "toast-top-right",
								onclick: null,
								showDuration: "0",
								hideDuration: "0",
								timeOut: "0",
								extendedTimeOut: "0",
								showEasing: "swing",
								hideEasing: "linear",
								showMethod: "fadeIn",
								hideMethod: "fadeOut"
							});
						},
						success: function(data) {
							toastr.clear();
							if (data.status) {
																
									swal({
										imageUrl: base_url+'assets/images/logo-icon.png',
										imageHeight: 30,
										imageAlt: 'A tall image',
										title: "Request Submited !",
										text: "Please check your email for activation Account !",
										confirmButtonClass: "btn-danger",
										confirmButtonColor: '#f62d51',
										confirmButtonText: "Close"
									});
									
								//document.location.href = data.route;
							} else {
								swal({
									title: "FAILED REGISTER !",
									text: "Email or ID has already registered!",
									confirmButtonClass: "btn-danger",
									confirmButtonColor: '#f62d51',
									confirmButtonText: "Close"
								});
							}
						},
						error: function(error, reason) {
							toastr.clear();
							toastr.error("Reason : " + reason, "Error " + error.status, {
								closeButton: true,
								debug: false,
								positionClass: "toast-top-right",
								onclick: null,
								showDuration: "1000",
								hideDuration: "1000",
								timeOut: "5000",
								extendedTimeOut: "1000",
								showEasing: "swing",
								hideEasing: "linear",
								showMethod: "fadeIn",
								hideMethod: "fadeOut"
							});
						}
					});
			}else{
				alert("RETYPE PASSWORD NOT MATCH");
			}
			
		}else{

			alert("VERIFY POLICY");

		}

	});
});



	

