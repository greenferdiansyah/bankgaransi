jQuery(document).ready(function() {

	Master.init();
	listDataTable;
	
	$("#form-tenant").validate({
		submit: {
			settings: {
				inputContainer: ".form-group",
				errorListClass: "help-block",
				errorClass: "has-danger"
			},
			callback: {
				onBeforeSubmit: function(node) {
					NProgress.start();
					Master.handleLoadingButton($('#submit'));
				},
				onSubmit: function(node) {
					ajaxFormSubmit("form-tenant", "/form_submit");
				},
				onError: function(error) {
					toastr.clear();
					toastr.warning("Please check your input ", "Fail ", {
						closeButton: true,
						debug: false,
						positionClass: "toast-top-right",
						onclick: null,
						showDuration: "1000",
						hideDuration: "1000",
						timeOut: "3000",
						extendedTimeOut: "1000",
						showEasing: "swing",
						hideEasing: "linear",
						showMethod: "fadeIn",
						hideMethod: "fadeOut"
					});
				}
			}
		},
		debug: true
	});
});

var goBack = function (){
	Master.goBack();
}

var listDataTable = $("#myTable").DataTable({
	processing: true,
	destroy: true,
	serverSide: true,
	responsive: true,
	autoWidth: false,
	colReorder: true,
	bInfo	: false,
	columnDefs: [
		{ width: "2%", targets: 0 },
		{ className: "text-center", targets: [7] }
	],
	dom: "Brftlp",
	buttons: [
		{
			extend: "colvis",
			text: '<i class="fa fa-list"></i>',
			className: "btn-sm"
        },
        {
			text: '<i class="fa fa-filter"></i>&nbsp;Filter',
			className: "btn-sm bg-red",
			action: function(e, dt, node, config) {
                Master.showModal($('#advanced_filter_modal'));
			}
        },
		{
			extend: "excelHtml5",
			text: '<i class="fa fa-file-excel-o"></i>&nbsp;XLS',
			className: "btn-sm",
			exportOptions: {
				columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
			}
		},
		{
			extend: "csvHtml5",
			text: '<i class="fa fa-file"></i>&nbsp;CSV',
			className: "btn-sm",
			exportOptions: {
				columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
			}
		},
		{
			extend: "pdfHtml5",
			orientation: "landscape",
			pageSize: "LEGAL",
			text: '<i class="fa fa-file-pdf-o"></i>&nbsp;PDF',
			className: "btn-sm",
			exportOptions: {
				columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
			}
		},
		{
			text: '<i class="fa fa-plus"></i>&nbsp;ADD',
			className: "btn-sm bg-red",
			action: function(e, dt, node, config) {
				document.location.href = base_url + "main#"+parent_page+"/form/";
			}
        }
	],
	ajax: {
		url: base_url + "admin_tenant/json_list",
		type: "POST"
	},
	bStateSave: true,
	fnStateSave: function(oSettings, oData) {
		localStorage.setItem("offersDataTables", JSON.stringify(oData));
	},
	fnStateLoad: function(oSettings) {
		return JSON.parse(localStorage.getItem("offersDataTables"));
	}
});

var ajaxFormSubmit = function(formid, formurl) {
	var form = document.getElementById(formid);
	var formData = new FormData(form);

	$.ajax({
		url: base_url + page + formurl,
		enctype: "multipart/form-data",
		data: formData,
		processData: false,
		contentType: false,
		type: "POST",
		dataType: "json"
	})
		.done(function(data) {
			Master.resetLoadingButton($('#submit'),"Submit");
			toastr.clear();
			NProgress.done();
			if (data.status == true) {
				toastr.success(data.reason, data.title, {
					closeButton: true,
					debug: false,
					positionClass: "toast-top-right",
					onclick: null,
					showDuration: "1000",
					hideDuration: "1000",
					timeOut: "3000",
					extendedTimeOut: "1000",
					showEasing: "swing",
					hideEasing: "linear",
					showMethod: "fadeIn",
					hideMethod: "fadeOut"
				});
				document.location.href = base_url + "main#admin_tenant";
			} else {
				toastr.warning(data.reason, data.title, {
					closeButton: true,
					debug: false,
					positionClass: "toast-top-right",
					onclick: null,
					showDuration: "1000",
					hideDuration: "1000",
					timeOut: "3000",
					extendedTimeOut: "1000",
					showEasing: "swing",
					hideEasing: "linear",
					showMethod: "fadeIn",
					hideMethod: "fadeOut"
				});
			}
		})
		.fail(function() {
			Master.resetLoadingButton($('#submit'),"Submit");
			NProgress.done();
			toastr.clear();
			toastr.error("Please check your connection ", "Error ", {
				closeButton: true,
				debug: false,
				positionClass: "toast-top-right",
				onclick: null,
				showDuration: "1000",
				hideDuration: "1000",
				timeOut: "3000",
				extendedTimeOut: "1000",
				showEasing: "swing",
				hideEasing: "linear",
				showMethod: "fadeIn",
				hideMethod: "fadeOut"
			});
		});
};


var del = function(id) {
	swal(
		{
			title: "Are you sure?",
			text: "You will not be able to recover this item!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, remove it",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: base_url + "admin_tenant/delete",
					type: "POST",
					dataType: "json",
					data: { id: id },
					success: function(data) {
						if (data.status == true) {
							swal({
								title: "Deleted!",
								text: "Your item has been deleted.",
								type: "success",
								confirmButtonClass: "btn-success"
							});
							listDataTable.ajax.reload();
						} else {
							swal({
								title: "Error",
								text: data.reason,
								type: "error",
								confirmButtonClass: "btn-danger"
							});
						}
					}
				});
			} else {
				swal({
					title: "Cancelled",
					text: "Your item is safe !",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		}
	);
};
