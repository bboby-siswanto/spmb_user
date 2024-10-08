<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>IULI PMB</title>
        <meta name="description" content="IULI PMB">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <meta name="facebook-domain-verification" content="ua21qk4c6udte2595ldns71lxlucst" />

        
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	    <script>
	        WebFont.load({
	            google: {
	                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
	            },
	            active: function() {
	                sessionStorage.fonts = true;
	            }
	        });
	    </script>

        <link rel="shortcut icon" href="<?=base_url()?>assets/img/ico/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?=base_url()?>assets/img/ico/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="<?=base_url()?>assets/pmb/fonts/themify-icons/themify-icons.css">

        <link href="<?=base_url()?>assets/pmb/css/style.css" rel="stylesheet" type="text/css" />

        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/fontawesome/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/sweetalertmaster/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/jquery-ui/jquery-ui.bundle.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/select2/css/select2.min.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/vendors/select2/css/select2-bootstrap.min.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/vendors/animate/animate.min.css" rel="stylesheet">
        <link href="<?=base_url()?>assets/css/iuli.css" rel="stylesheet">
        
        <script src="<?=base_url()?>assets/vendors/jquery/js/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/popper.js/js/popper.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/pace-progress/js/pace.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/@coreui/coreui/js/coreui.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/sweetalertmaster/sweetalert2.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/jquery/js/jquery.blockUI.js"></script>
        <script src="<?=base_url()?>assets/vendors/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>
        <script src="<?=base_url()?>assets/vendors/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?=base_url()?>assets/vendors/select2/js/select2.min.js"></script>
    </head>
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <div class="container pt-3 pt-md-3">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header" style="background-color: #001489 !important;">
                        <?=(isset($header_page)) ? $header_page : '';?>
                    </div>
                    <div class="card-body">
                        <?=(isset($pages)) ? $pages : '';?>
                    </div>
                    <div class="card-footer" style="background-color: #001489 !important;">
                        <?=(isset($footer_page)) ? $footer_page : '';?>
                    </div>
                </div>
            </div>
        </div>
        <?=modules::run('load_questionnaire_modal')?>
    </body>
</html>