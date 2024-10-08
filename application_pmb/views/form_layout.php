<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>IULI PMB</title>
        <meta name="description" content="IULI PMB">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

        
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

        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url()?>assets/img/iuli-owl.png">
        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/fontawesome/css/all.min.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?=base_url()?>assets/vendors/sweetalertmaster/sweetalert2.min.css" rel="stylesheet" type="text/css" /> -->
        <link href="<?=base_url()?>assets/vendors/jquery-ui/jquery-ui.bundle.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?=base_url()?>assets/vendors/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> -->
        <!-- <link href="<?=base_url()?>assets/vendors/select2/css/select2.min.css" rel="stylesheet"> -->
		<link href="<?=base_url()?>assets/vendors/select2/css/select2-bootstrap.min.css" rel="stylesheet">
        <link href="<?=base_url()?>assets/css/iuli.css" rel="stylesheet">
        
        <script src="<?=base_url()?>assets/vendors/jquery/js/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/popper.js/js/popper.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bootstrap/js/bootstrap.min.js"></script>
        <!-- <script src="<?=base_url()?>assets/vendors/pace-progress/js/pace.min.js"></script> -->
        <!-- <script src="<?=base_url()?>assets/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js"></script> -->
        <script src="<?=base_url()?>assets/vendors/@coreui/coreui/js/coreui.min.js"></script>
        <!-- <script src="<?=base_url()?>assets/vendors/sweetalertmaster/sweetalert2.min.js"></script> -->
        <script src="<?=base_url()?>assets/vendors/jquery/js/jquery.blockUI.js"></script>
        <script src="<?=base_url()?>assets/vendors/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>
        <!-- <script src="<?=base_url()?>assets/vendors/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js" type="text/javascript"></script> -->
        <!-- <script src="<?=base_url()?>assets/vendors/select2/js/select2.min.js"></script> -->
    </head>
    <body class="bg-white" id="body-frame">
        <?=$body ?>
    </body>
</html>