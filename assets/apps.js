
/* 16. Handle Ajax Page Load - added in V1.5
------------------------------------------------ */

var default_content = '<br><div class="container-fluid">\
                        <div class="row">\
                                <div class="col-lg-12 col-md-12 col-xlg-12 col-xs-12">\
                                    <div class="ribbon-wrapper card">\
                                        <div class="ribbon ribbon-warning ribbon-left"><i class="fa fa-danger"></i> Warning</div>\
                                        <p class="ribbon-content text-center"><b>This page is not actived !</b> This page is still under construction !</p>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>';

var failed_content = '<br><div class="container-fluid">\
                        <div class="row">\
                            <div class="col-lg-12 col-md-12 col-xlg-12 col-xs-12">\
                                <div class="ribbon-wrapper card">\
                                    <div class="ribbon ribbon-danger ribbon-left"><i class="fa fa-warning"></i>&nbsp;&nbsp;404 ERROR</div>\
                                    <p class="ribbon-content text-center"><b>Fail generate request !</b></p><br>\
                                    <p class="ribbon-content text-center">Unable to load page. Please check your page URL !</p> <br><br>\
                                </div>\
                            </div>\
                        </div>\
                    </div>';

var handleLoadPage = function(hash,callback) {
    
    var targetUrl = hash.replace('#','');
  
    if(targetUrl.toString()!='' && targetUrl.toString()!='#'){
        $.ajax({
            type        : 'POST',
            url         : targetUrl, //with the page number as a parameter
            dataType    : 'html',   //expect html to be returned
            beforeSend  : function(){    
                        
                            $('#ajax-content').html('<br><center><button class="btn btn-sm btn-danger btn-rounded"><i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;loading</button></center>');            
                            if (typeof table_reload !== 'undefined') {
                            clearInterval(table_reload);
                            }
                            if (typeof dashboard_reload !== 'undefined') {
                            clearInterval(dashboard_reload);
                            }

                            NProgress.configure({ showSpinner: false });
                            NProgress.start();
                        },
            success: function(data) {
                            if(data != ''){
                                $('#ajax-content').html(data);
                            }else{
                                $('#ajax-content').html(failed_content);
                            }
                           
                            $('html, body').animate({
                                scrollTop: $("body").offset().top
                            }, 250);
                            if (callback) {
                                callback();
                            }

                            NProgress.done();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#ajax-content').html(default_content);
            
                NProgress.done();
            }
            
        });
    }else{
        $('#ajax-content').html(failed_content);
    }    
};


var setLoadActiveMenu = function(){
    var hash = location.hash;
    var uri = hash.toString().split('/');
    $('#sidebarnav a').removeClass('active');
    $('#sidebarnav a').parent('li').removeClass('active');
    $('a[href="'+uri[0]+'"]').parent('li').addClass('active');
    $('a[href="'+uri[0]+'"]').parent('li').parent('ul').parent('li').addClass('active');
    $('a[href="'+uri[0]+'"]').parent('li').parent('ul').attr('aria-expanded', 'true');
    $('a[href="'+uri[0]+'"]').addClass('active');

}
/* 17. Handle Ajax Page Load Url - added in V1.5
------------------------------------------------ */
var handleCheckPageLoadUrl = function(hash,callback) {
    hash = (hash) ? hash : '#';
    
    if (hash === '') {
        $('#ajax-content').html(failed_content);
    } else {
       // $('.sidebar [href="'+hash+'"][data-toggle=ajax]').trigger('click');
        handleLoadPage(hash,callback);
        setLoadActiveMenu();
        
    }
};

/* 19. Handle Url Hash Change - added in V1.5
------------------------------------------------ */
var handleHashChange = function(callback) {
    $(window).hashchange(function() {
        if (window.location.hash) {
            
            handleLoadPage(window.location.hash,callback);
            $('#page-container').removeClass('page-sidebar-toggled');
        }
    });
};

var globalCallback;


/* Application Controller
------------------------------------------------ */
var Apps = function () {
    "use strict";
    
    return {
        //main function
        init: function (callback) {
            this.initAjaxFunction(callback);
        },
        initAjaxFunction: function(callback) {
            var hash = window.location.hash;

          // handleSidebarAjaxClick();
            handleCheckPageLoadUrl(window.location.hash,callback);
            handleHashChange(callback);
            
            globalCallback = callback;

            // ajax cache setup
            $.ajaxSetup({
                cache: true
            });
        }
    };
}();