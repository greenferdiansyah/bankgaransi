var select_tenant = function() {
	var tenant = $("#tenant_id").val();
	if (tenant != "") {
		toastr.info("Loading . . ", {
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
		document.location.href = base_url + "login/" + tenant;
	} else {
		toastr.warning("Please Choose Tenant", "Failed", {
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
};
