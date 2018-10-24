<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">{title}</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Administration</li>
            <li class="breadcrumb-item">Tenant</li>
            <li class="breadcrumb-item active">{title}</li>
        </ol>
    </div>
    <div></div>
</div>

<div class="container-fluid">

    <div class="row">
       <div class="col-lg-12">
            <div class="card card-outline-success">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Form {title}</h4>
                </div>
                <div class="card-body">
                    <form id="form-participant" name="form-participant" method="POST" class="p-20">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none"> 
                        <input type="hidden" name="action" value="{action}" style="display: none"> 
                        <input type="hidden" name="id_participant" value="{id_participant}" style="display: none"> 
                        <div class="form-body">
                            <h3 class="card-title"><i class="fa fa-indent"></i>&nbsp;General</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Nomor Peserta</small></label>
                                       <input  class="form-control error" type="text" value="{no_participant}" id="no_participant" name="no_participant"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="Nomor Peserta Tidak Boleh Kosong !">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Nomor Rekening</small></label>
                                       <input  class="form-control error" type="text" value="{bank_acc}" id="bank_acc" name="bank_acc"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="Nomor Rekening Tidak Boleh Kosong !">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Nama Peserta</small></label>
                                       <input  class="form-control error" type="text" value="{nm_participant}" id="nm_participant" name="nm_participant"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="Nama Peserta Tidak Boleh Kosong !">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Alamat Peserta</small></label>
                                       <input  class="form-control error" type="text" value="{address_participant}" id="address_participant" name="address_participant"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="Alamat Peserta Tidak Boleh Kosong !">
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Tanggal Dokumen</small></label>
                                       <input  class="form-control error" type="text" value="{date_participant_doc}" id="date_participant_doc" name="date_participant_doc"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="Tanggal Dokumen Tidak Boleh Kosong !">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Profesi</small></label>
                                       <select class="select2 form-control" style="width: 100%;" 
                                                 data-validation="[NOTEMPTY]"
                                                 id="profession_id" 
                                                 name="profession_id">
                                            <option value="">Select Profesi</option>
                                            {list_profession}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Status</small></label>
                                       <select class="select2 form-control" style="width: 100%;" 
                                                 data-validation="[NOTEMPTY]"
                                                 id="status" 
                                                 name="status">
                                            <option value="">Select Status</option>
                                            {list_status}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-success" id="submit">Submit</button>
                                    <button type="button" onclick="goBack()" class="btn btn-inverse">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{base_url}assets/master/script/master_template.js"></script>

<script> 
    var base_url    = '{base_url}'; 
    var page        = '{page}'

    jQuery(document).ready(function() {

	Master.init();
	
	$("#form-participant").validate({
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
					ajaxFormSubmit("form-participant", "/form_submit");
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
	}).done(function(data) {
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
				document.location.href = base_url + "main#"+page;
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
		}).fail(function() {
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

var goBack = function (){
	Master.goBack();
}
</script>

<!-- <script src="{base_url}assets/master/script/admin_tenant.js"></script> -->