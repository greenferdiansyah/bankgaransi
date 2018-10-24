<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
       

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{base_url}assets/images/favicon.png">
    <title>{title}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{base_url}assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="{base_url}assets/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    
        <!-- BEGIN PAGE TOP STYLES -->
     <link href="{base_url}assets/plugins/pace/themes/pace-theme-flash.css" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="{base_url}assets/horizontal/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{base_url}assets/horizontal/css/colors/red-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
   <!-- ================== BEGIN CAPTCHA GOOGLE ================== -->
   {script_captcha}
    <!-- ================== END CAPTCHA GOOGLE ================== -->

<body>

    <section id="wrapper" class="login-register login-sidebar" style="background-image:url({base_url}assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">
            <a href="javascript:void(0)" class="text-center db"><img src="{base_url}assets/images/logo-icon.png" alt="Home" /><br/><img src="{base_url}assets/images/logo-text.png" alt="Home" /></a>
            <form class="form-horizontal form-material"  id="login-form" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">                                
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="required" placeholder="Username" name="username" id ="username" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group  m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="required" placeholder="Password" name="password" id ="password" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Remember me</label>
                            </div>
                            <a href="{base_url}forgot_password" id="to-recover" class="text-danger pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password?</a> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                        <center>{captcha}</center>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-danger btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                </form>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12">
                            <p>Don't have an account? <a href="{base_url}registration" class="text-danger m-l-5"><b>Registration</b></a></p>
                        </div>
                    </div>
            </div>
        </div>
    </section>
   <script>var base_url = '{base_url}';</script>

  <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{base_url}assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{base_url}assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="{base_url}assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{base_url}assets/horizontal/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{base_url}assets/horizontal/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="{base_url}assets/horizontal/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="{base_url}assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="{base_url}assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="{base_url}assets/plugins/bootstrap-toastr/toastr.min.js"></script>
    <!--Custom JavaScript -->
    <script src="{base_url}assets/horizontal/js/custom.min.js"></script>
    <script src="{base_url}assets/master/script/login.js"></script>
    <script src="{base_url}assets/plugins/pace/pace.min.js"></script>
        <!-- END PAGE FIRST SCRIPTS -->
    <script src="{base_url}assets/master/script/master_template.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{base_url}assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    
</body>
</html>