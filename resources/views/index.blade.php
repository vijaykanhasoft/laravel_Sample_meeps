<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Laravel - AngularJs Sample</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Laravel - AngularJs Sample. System" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="public/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="public/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="public/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="public/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="public/pages/css/login.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="public/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="public/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="public/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <link href="public/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />
        <link href="public/css/loader.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
        <!--[if lt IE 9]>
             <script src="public/global/plugins/respond.min.js"></script>
             <script src="public/global/plugins/excanvas.min.js"></script> 
             <script src="public/global/plugins/ie8.fix.min.js"></script> 
             <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="public/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="public/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="public/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <link href="public/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="public/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <script src="public/js/jquery.dataTables.min.js"></script>
        <script src="public/js/dataTables.responsive.min.js"></script>
        <link href="public/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <script src="public/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="public/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="public/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="public/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="public/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="public/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

        <script src="public/js/angular/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.5.8/angular-sanitize.min.js"></script>
        <script src="public/js/angular-datatables.bootstrap.min.js"></script>
        <script src="public/js/angular-datatables.min.js"></script>
        <script src="public/js/angular/angular-route.min.js"></script>
        <script src="public/js/angular/angular-cookies.min.js"></script>
        <script src="public/js/angular/angular-ui-router.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.0.0/ui-bootstrap-tpls.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/angular-ui-utils/0.1.1/angular-ui-utils.min.js'></script>
        <script src="public/js/angular/Controller/app.js"></script>        
        <script src="public/js/angular/Directive/directive.js"></script>
        <script src="public/js/angular/Controller/frontController.js"></script>    
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white" ng-app="myapp">
        <div class='lmask loader' loader></div>
        <div class="page-wrapper"  header>
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper" sidebar>
                <!-- BEGIN SIDEBAR -->
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div ui-view></div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer" footer>
        </div>
        <!-- END FOOTER -->
    </body>
</html>