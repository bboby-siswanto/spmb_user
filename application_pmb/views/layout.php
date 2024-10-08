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

        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/fontawesome/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/sweetalertmaster/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/jquery-ui/jquery-ui.bundle.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/select2/css/select2.min.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/vendors/select2/css/select2-bootstrap.min.css" rel="stylesheet">
        <link href="<?=base_url()?>assets/css/iuli.css" rel="stylesheet">
        <style>
        .required_text::after {
            content: " *";
            color: red;
        }
        .close_flow_modal {
            position: absolute;
            right: 20px;
            top: 10px;
            color: #fff;
        }
        .image-modal-show {
            overflow: auto !important;
        }
        .image-modal-show .modal {
            overflow: hidden !important;
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
        <script src="<?=base_url()?>assets/vendors/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?=base_url()?>assets/vendors/select2/js/select2.min.js"></script>

        <!-- Event snippet for Registration at NI conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
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

        <!-- Global site tag (gtag.js) - Google Ads: 640179922 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-640179922"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'AW-640179922');
        </script> 
        <!-- Facebook Pixel Code HEADER FOR ALL PAGES OF THE PORTAL -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '328100755166423');
            fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=328100755166423&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
    </head>
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <header class="app-header navbar">
            <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img class="navbar-brand-full" src="<?= base_url()?>assets/img/iuli.png" height="100%" alt="IULI">
                <img class="navbar-brand-minimized" src="<?= base_url()?>assets/img/iuli.png" height="100%" alt="IULI">
            </a>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header text-center">
                            <strong>Account</strong>
                        </div>
                        <a class="dropdown-item" href="<?= base_url()?>candidate/profile">
                            <i class="fa fa-user"></i> My Profile
                        </a>
                        <a class="dropdown-item" href="mailto:pmb@iuli.ac.id?subject=[HELP] I need assistance on my pmb data">
                            <i class="fa fa-envelope"></i> Support
                        </a>
                        <a class="dropdown-item" href="<?= base_url()?>candidate/profile/logout">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </header>
        <div class="app-body">
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <ul class="nav">
                        <!-- <li class="nav-title">Student</li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url()?>candidate/profile">
                                <i class="nav-icon fa fa-user-tie"></i> Personal Data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url()?>candidate/parent_data">
                                <i class="nav-icon fa fa-user-friends"></i> Parent Data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url()?>candidate/education">
                                <i class="nav-icon fa fa-book"></i> Academic History
                            </a>
                        </li>
                <?php
                if ($this->session->userdata('class_type') == 'karyawan') {
                ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url()?>candidate/employment">
                                <i class="nav-icon fa fa-globe-asia"></i> Employment Data
                            </a>
                        </li>
                <?php
                }
                ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url()?>candidate/supporting_document">
                                <i class="nav-icon fa fa-file-contract"></i> Supporting Document
                            </a>
                        </li>
                <?php
                if ($this->session->userdata('name') == 'SISWANTO BUDI') {
                ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url()?>exam/entrance_test/check_in">
                                <i class="nav-icon fa fa-sticky-note"></i> Online Entrance Test
                            </a>
                        </li>
                <?php
                }
                ?>
                    </ul>
                </nav>
            </div>
            <main class="main">
                <ol class="breadcrumb">
                    <h6><?= $pageTitle ?></h6>
                </ol>
    <?php
    if (($this->session->has_userdata('confirm_email')) AND ($this->session->userdata('confirm_email') == false)) {
    ?>
                <div class="container-fluid">
                    <div class="alert alert-danger alert-dismissible fade show bg-red text-white text-center" role="alert" style="margin-top: -10px; padding-top:4px !important; padding-bottom:6px !important;">
                        Please check your email to confirm your email address.
                    </div>
                </div>
    <?php
    }
    ?>
                <div class="container-fluid">
                    <div class="alert alert-warning alert-dismissible fade show bg-warning text-white text-center" role="alert" style="margin-top: -10px; padding-top:4px !important; padding-bottom:6px !important;">
                    Please complete the following data to proceed to the next process
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="animated fadeIn">
                        <?=$body ?>
                    </div>
                </div>
            </main>
        </div>
        <?=modules::run('load_questionnaire_modal')?>
        <div class="modal" tabindex="-1" role="dialog" id="modal_flow_inner" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <button type="button" class="close close_flow_modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <img src="<?=base_url()?>assets/img/banner/popup_info/admission-flow.jpeg" alt="" class="img-fluid w-100 d-sm-none">
                    <img src="<?=base_url()?>assets/img/banner/popup_info/admission-flow-md.jpeg" alt="" class="img-fluid w-100 d-none d-sm-block">
                </div>
            </div>
        </div>
<script>
$(function() {
    $('#modal_flow_inner').on('show.bs.modal', function (e) {
        $('body').addClass('image-modal-show');
    });
    $('#modal_flow_inner').on('hide.bs.modal', function (e) {
        $('body').removeClass('image-modal-show');
    });
<?php
// if ($_SERVER['REMOTE_ADDR'] == '202.93.225.254') {
    if (!$this->session->has_userdata('has_show_flow_inner')) {
        $this->session->set_userdata('has_show_flow_inner', true);
    ?>
        $('#modal_flow_inner').modal('show');
    <?php
    }
// }
?>
})
</script>
    </body>
</html>