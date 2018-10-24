jQuery(document).ready(function() {
	$("#login-form").submit(function(e) {
		e.preventDefault();
		var dataForm = $(this).serialize();
		$.ajax({
				url: "Login/check_login",
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
				}
			})
			.done(function(data) {
				toastr.clear();
				if (data.status == "success") {
					toastr.success(data.reason, data.title, {
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
					document.location.href = data.route;
				} else {
					toastr.warning(data.reason, data.title, {
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
			})
			.fail(function() {
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
			});
	});
});
