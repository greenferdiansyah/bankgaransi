<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">{title}</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Administration</li>
            <li class="breadcrumb-item">Vendor</li>
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
                    <form id="form-vendor" name="form-vendor" method="POST" class="p-20">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none"> 
                        <input type="hidden" name="action" value="{action}" style="display: none"> 
                        <input type="hidden" name="company_id" value="{company_id}" style="display: none"> 
                        <input type="hidden" name="vendor_id" value="{vendor_id}" style="display: none"> 
                        <div class="form-body">
                            <h3 class="card-title"><i class="fa fa-indent"></i>&nbsp;General</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Name</small></label>
                                       <input  class="form-control error" type="text" value="{company_name}" id="company_name" name="company_name"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="Company Name are required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label"><small>Nickname</small></label>
                                       <input  class="form-control error" type="text" value="{company_nickname}" id="company_nickname" name="company_nickname"  
                                                data-validation="[NOTEMPTY]"
                                                data-validation-message="Company Nickname are required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label"><small>Stream</small></label>
                                       <select class="select2 form-control" style="width: 100%;" 
                                                 data-validation="[NOTEMPTY]"
                                                 id="vendor_stream" 
                                                 name="vendor_stream">
                                            <option value="">Select Stream</option>
                                            {list_stream}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h3 class="card-title"><i class="fa fa-map-marker"></i>&nbsp;Location</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Address</small></label>
                                       <input class="form-control" type="text" value="{address}" id="address" name="address">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label"><small>City</small></label>
                                       <input class="form-control" type="text" value="{city}" id="city" name="city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label"><small>Zip Code</small></label>
                                       <input class="form-control" type="text" value="{zip_code}" id="zip_code" name="zip_code">
                                    </div>
                                </div>
                            </div>
                            <h3 class="card-title"><i class=" fa fa-phone"></i>&nbsp;Contact</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label"><small>Email</small></label>
                                       <input class="form-control" type="text" value="{email_support}" id="email_support" name="email_support">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label"><small>Phone</small></label>
                                       <input class="form-control" type="text" value="{phone_support}" id="phone_support" name="phone_support">
                                    </div>
                                </div>
                            </div>
                            <h3 class="card-title"><i class="fa fa-bookmark"></i>&nbsp;Others</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label"><small>Site URL</small></label>
                                       <input class="form-control" type="text" value="{site_url}" id="site_url" name="site_url">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="control-label"><small>Logo</small></label>
                                       <input class="form-control" type="file" value="{logo}" id="logo" name="logo">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label class="control-label"><small>Description</small></label>
                                       <input class="form-control" type="text" value="{company_description}" id="company_description" name="company_description">
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

<script> 
    var base_url    = '{base_url}'; 
    var page        = '{page}'
</script>
<script src="{base_url}assets/master/script/master_template.js"></script>
<script src="{base_url}assets/master/script/admin_vendor.js"></script>