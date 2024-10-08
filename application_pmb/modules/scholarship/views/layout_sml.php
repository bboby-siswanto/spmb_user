<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>IULI PMB</title>
        <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>assets/img/iuli-owl.png">
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
            var base_url = '<?= base_url()?>';
	    </script>

        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/fontawesome/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/sweetalertmaster/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/jquery-ui/jquery-ui.bundle.css" rel="stylesheet" type="text/css" />
        <style>
            .flag-form {
                width: 6%;
                height: 120%;
                margin-top: -12px;
                margin-left: -20px;
                margin-right: 12px;
            }
            .gii {
                height: 33%;
            }
            .ni {
                height: 50%;
            }
            .flag-black{
                background-color:black;
            }
            .flag-red{
                background-color:red;
            }
            .flag-yellow{
                background-color:yellow;
            }
            .flag-white{
                background-color:white;
            }
            .title_header {
                font-size: 20px;
                color: #fff;
            }
            .sub_title_header{
                font-size: 16px;
                color: #fff;
            }
            .logo-registrasi {
                max-width: 70%;
            }
            .text-info-header {
                background-color: red;
                color: #fff;
                padding-top: 3px;
                padding-bottom: 3px;
            }
            @media (min-width: 544px) {
                .title_header {
                    font-size: 25px;
                }
                .sub_title_header {
                    font-size: 19px;
                }
                .logo-registrasi {
                    max-width: 50%;
                }
            }
            @media (min-width: 768px) {
                .title_header {
                    font-size: 28px;
                }
                .sub_title_header {
                    font-size: 21px;
                }
                .logo-registrasi {
                    max-width: 50%;
                }
            }
            @media (min-width: 992px) {
                .title_header {
                    font-size: 33px;
                }
                .sub_title_header {
                    font-size: 22px;
                }
                .logo-registrasi {
                    max-width: 100%;
                }
            }
        </style>

        <script src="<?=base_url()?>assets/vendors/jquery/js/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/popper.js/js/popper.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/pace-progress/js/pace.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/@coreui/coreui/js/coreui.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/sweetalertmaster/sweetalert2.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/jquery/js/jquery.blockUI.js"></script>
        <script src="<?=base_url()?>assets/vendors/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>

<?php
if ($pages == 'signup_gii') {
?>
        <!-- Global site tag (gtag.js) - Google Ads: 640179922 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-640179922"></script>
        <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-640179922'); </script> 
        <!-- Event snippet for Registration at GII conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
        <script> function gtag_report_conversion(url) { var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': 'AW-640179922/DEN-CPOdk_QBENK9obEC', 'event_callback': callback }); return false; } </script> 
<?php
}else if ($pages == 'signup_ni') {
?>
        <!-- Global site tag (gtag.js) - Google Ads: 640179922 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-640179922"></script>
        <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-640179922'); </script> 
        <!-- Event snippet for Registration at NI conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
        <script> function gtag_report_conversion(url) { var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': 'AW-640179922/uWu_CMzBk_QBENK9obEC', 'event_callback': callback }); return false; } </script>
<?php
}
?>
        
        <!-- Matomo -->
		<!-- <script type="text/javascript">
		  var _paq = window._paq || [];
		  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
		  _paq.push(['trackPageView']);
		  _paq.push(['enableLinkTracking']);
		  (function() {
		    var u="//www.iuli.ac.id/piwik/";
		    _paq.push(['setTrackerUrl', u+'matomo.php']);
		    _paq.push(['setSiteId', '2']);
		    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
		  })();
		</script> -->
		<!-- End Matomo Code -->
    </head>
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <div class="container pt-5">
            <div class="animated fadeIn">
                <div class="card">
                    <div class="card-header" style="background-color: #001489 !important;">
<?php
switch ($pages) {
    case 'signup_gii':
?>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="flag-form float-left w-10">
                                    <div class="gii flag-black"></div>
                                    <div class="gii flag-red"></div>
                                    <div class="gii flag-yellow"></div>
                                </div>
                                <strong class="title_header">GERMAN INTERNATIONAL INSTITUTE</strong>
                                <div class="sub_title_header">Registration Form</div>
                            </div>
                            <hr>
                            <div class="col-lg-3 my-auto text-center">
                                <img src="<?= base_url()?>assets/img/iuli.png" class="img-fluid logo-registrasi"/>
                            </div>
                        </div>
<?php
        break;

    case 'signup_ni':
?>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="flag-form float-left w-10">
                                    <div class="ni flag-red"></div>
                                    <div class="ni flag-white"></div>
                                </div>
                                <strong class="title_header">NATIONAL INSTITUTE</strong>
                                <div class="sub_title_header">Registration Form</div>
                            </div>
                            <div class="col-lg-3 my-auto text-center">
                                <img src="<?= base_url()?>assets/img/iuli.png" class="img-fluid logo-registrasi"/>
                            </div>
                        </div>
<?php
        break;
    
    default:
?>
                        <div class="row">
                            <div class="col-lg-3 my-auto text-center">
                                <img src="<?= base_url()?>assets/img/iuli.png" class="img-fluid"/>
                            </div>
                        </div>
<?php
        break;
}
?>
                    </div>
                    <div class="card-body">
                        <?php
                            if(isset($pages)) {
                                $this->load->view($pages);
                            }
                        ?>
                    </div>
                    <div class="card-footer" style="background-color: #001489 !important;"></div>
                </div>
            </div>
        </div>
    </body>
</html>