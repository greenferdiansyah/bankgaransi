<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">{page_title}</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Administration</li>
            <li class="breadcrumb-item active">{page_title} Management</li>
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
                    <small>
                        <table class="table table-hover table-bordered" id="myTable" style="width:100%">   
                            <thead>
                                <tr>
                                    <th class='no-sort'>No</th>
                                    <th>Company Name</th>
                                    <th>Site URL</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>City</th>
                                    <th>Zip Code</th>
                                    <th width="70">Status</th>
                                    <th>Updated</th>
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


<script> 
    var base_url        = '{base_url}';
    var page            = '{page}'
    var parent_page     = '{parent_page}';
</script>
<script src="{base_url}assets/master/script/master_template.js"></script>
<script src="{base_url}assets/master/script/admin_tenant.js"></script>
