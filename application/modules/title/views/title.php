<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">{page_title}</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Administration</li>
            <li class="breadcrumb-item active">{page_title}</li>
        </ol>
    </div>
    <div></div>
</div>
<!-- Main content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-2">
                    </div>
                    {barcode}
                    <small>
                        <table class="table table-hover table-bordered" id="myTable" style="width:100%">   
                            <thead>
                                <tr>
                                    <th class='no-sort'>No</th>
                                    <th>Barkode</th>
                                    <th>Nama jabatan</th>
                                    <th>Kode Jabatan</th>
                                    <th>Status</th>
                                    <th>Di Buat oleh</th>
                                    <th>Waktu Pembuatan</th>
                                    <th>Di Update Oleh</th>
                                    <th>Waktu Update</th>
                                    <th class='no-sort' width="60" align="center">
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="advanced_filter_modal" tabindex="-1" role="dialog" aria-labelledby="advanced_filter_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="advanced_filter_modal">Advanced Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="form-filter" name="form-filter" method="POST" class="m-t-20">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none"> 
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">Fullname <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input  class="form-control error" type="text" value="{fullname}" id="fullname" name="fullname"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="Name are required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">Residence ID <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input  class="form-control error" type="text" value="{no_ktp}" id="no_ktp" name="no_ktp"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="No ID are required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">Email <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input  class="form-control" type="email" value="{email}" id="email" name="email"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="Email are required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">User Level</label>
                                    <div class="col-md-8">
                                    <select class="select2 form-control" style="width: 100%;"
                                            data-validation="[NOTEMPTY]"
                                            id="userlevel" 
                                            name="userlevel">
                                            <option value="">Select User Level</option>
                                        {list_userlevel}
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">Tenant</label>
                                    <div class="col-md-8">
                                    <select class="select2 form-control" style="width: 100%;" 
                                            data-validation="[NOTEMPTY]"
                                            id="tenant" 
                                            name="tenant">
                                            <option value="">Select Tenant</option>
                                            {list_tenant}
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">Position</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" value="{position}" id="position" name="position">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">Phone</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" value="{phone}" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">Address</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" value="{address}" id="address" name="address">
                                    </div>
                                </div>
                    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger"  id="submit_filter">Filter List</button>
      </div>
    </div>
  </div>
</div>

<script src="{base_url}assets/master/script/master_template.js"></script>

<script> 
    var base_url        = '{base_url}';
    var page            = '{page}'
    var parent_page     = '{parent_page}';

jQuery(document).ready(function() {

Master.init();
listDataTable;

});

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
		{ className: "text-center", targets: [8] }
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
		url: base_url + parent_page+"/json_list",
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
                alert(page);
				$.ajax({
					url: base_url + parent_page +"/delete",
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

</script>


