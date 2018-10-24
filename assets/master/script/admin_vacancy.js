jQuery(document).ready(function() {
	listDataTable;
	$("#form-user").validate({
		submit: {
			settings: {
				inputContainer: ".form-group",
				errorListClass: "help-block",
				errorClass: "has-danger"
			},
			callback: {
				onBeforeSubmit: function(node) {
					NProgress.start();
					toastr.clear();
					toastr.info("Submiting data", "Loading . . ", {
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
				onSubmit: function(node) {
					ajaxFormSubmit("form-user", "/form_submit");
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

	rowReorder: true,
	columnDefs: [
		{ width: "2%", targets: 0 },
		{ className: "text-center", targets: [5] }
	],
	dom: "Brftip",
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
				document.location.href = base_url + "main#admin_users";
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

var confirm_change_status = (treg_id, status_applicant) => {
	swal(
		{
			title: "Apa Anda yakin ?",
			text: " Kandidat yang anda pilih akan diubah status kelulusannya !",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Ya, ubah data!",
			cancelButtonText: "Tidak, batalkan!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				//alert(status);

				$.ajax({
					url: "<?php echo $base_url;?>admin/adm_final/set_status_applicant",
					method: "post",
					data: {
						treg_id: treg_id,
						status_applicant: status_applicant,
						"<?php echo $this->security->get_csrf_token_name(); ?>":
							"<?php echo $this->security->get_csrf_hash(); ?>"
					},
					dataType: "json",
					//beforeSend: function(){ $('#save-form-delete').button('loading'); },
					success: function(data) {
						if (data.status == "success") {
							swal(
								"Berhasil !",
								"Status Kandidat sudah di ubah dan dipindahkan directory nya",
								"success"
							);
							listDataTable;
						} else {
							swal("Terjadi Kesalahan", " " + data.reason + "", "error");
						}

						//},complete:function(){	$('#save-form-delete').button('reset');
					},
					error: function() {
						swal("Terjadi Kesalahan", " ERROR ", "error");
					}
				});
			} else {
				swal("Di batalkan", "Status kandidat masih disimpan default", "error");
			}
		}
	);
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
					url: base_url + "admin_users/delete",
					type: "POST",
					dataType: "json",
					data: { id: id },
					success: function(data) {
						if (data.status == "SUCCESS") {
							swal({
								title: "Deleted!",
								text: "Your item has been deleted.",
								type: "success",
								confirmButtonClass: "btn-success"
							});
							list_data.ajax.reload();
						} else {
							swal({
								title: "Error",
								text: "Your item is safe. Fail deleted item",
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
