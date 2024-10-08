<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>IULI PMB</title>
        <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>assets/img/iuli-owl.png">
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
            var base_url = '<?= base_url()?>';
	    </script>

        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/registration_style.css" rel="stylesheet" type="text/css" />
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
                background-color: #e4e7ea;
                /* text-color: red; */
                border: 1px solid #e4e7ea;
                color: red;
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
        <script>
            // var _paq = window._paq = window._paq || [];
            // /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
            // _paq.push(['trackPageView']);
            // _paq.push(['enableLinkTracking']);
            // (function() {
            //     var u="//trac.iuli.ac.id/";
            //     _paq.push(['setTrackerUrl', u+'matomo.php']);
            //     _paq.push(['setSiteId', '1']);
            //     var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            //     g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
            // })();
        </script>

<?php
if ($pages == 'signup_gii') {
?>
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
        <!-- Event snippet for Registration at GII conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
        <!-- <script> function gtag_report_conversion(url) { var callback = function () { if (typeof(url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': 'AW-640179922/DEN-CPOdk_QBENK9obEC', 'event_callback': callback }); return false; } </script>  -->
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
                                <!-- <div class="flag-form float-left w-10">
                                    <div class="gii flag-black"></div>
                                    <div class="gii flag-red"></div>
                                    <div class="gii flag-yellow"></div>
                                </div>
                                <strong class="title_header">GERMAN INTERNATIONAL INSTITUTE</strong>
                                <div class="sub_title_header">Registration Form</div> -->
                            </div>
                            <hr>
                            <div class="col-lg-3 my-auto text-center">
                                <img src="<?= base_url()?>assets/img/iuli.png" class="img-fluid logo-registrasi"/>
                            </div>
                        </div>
<?php
        break;

    case 'scholarship_sml':
?>
                        <div class="row">
                            <div class="col-lg-9">
                                <!-- <div class="flag-form float-left w-10">
                                    <div class="gii flag-black"></div>
                                    <div class="gii flag-red"></div>
                                    <div class="gii flag-yellow"></div>
                                </div> -->
                                <strong class="title_header">Sinarmas Land</strong>
                                <div class="sub_title_header">Scholarship Registration Form</div>
                            </div>
                            <hr>
                            <div class="col-lg-3 my-auto text-center">
                                <img src="<?= base_url()?>assets/img/iuli.png" class="img-fluid logo-registrasi"/>
                            </div>
                        </div>
<?php
        break;
    case 'scholarship_prestasi':
?>
                        <div class="row">
                            <div class="col-lg-9">
                                <!-- <div class="flag-form float-left w-10">
                                    <div class="gii flag-black"></div>
                                    <div class="gii flag-red"></div>
                                    <div class="gii flag-yellow"></div>
                                </div> -->
                                <strong class="title_header">Beasiswa IULI Berprestasi untuk Bangsa</strong>
                                <div class="sub_title_header">Scholarship Registration Form</div>
                            </div>
                            <hr>
                            <div class="col-lg-3 my-auto text-center">
                                <img src="<?= base_url()?>assets/img/iuli.png" class="img-fluid logo-registrasi"/>
                            </div>
                        </div>
<?php
        break;

    case 'scholarship_daad':
?>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="flag-form float-left w-10">
                                    <div class="gii flag-black"></div>
                                    <div class="gii flag-red"></div>
                                    <div class="gii flag-yellow"></div>
                                </div>
                                <strong class="title_header">DAAD</strong>
                                <div class="sub_title_header">Scholarship Registration Form</div>
                            </div>
                            <hr>
                            <div class="col-lg-3 my-auto text-center">
                                <img src="<?= base_url()?>assets/img/iuli.png" class="img-fluid logo-registrasi"/>
                            </div>
                        </div>
<?php
        break;

    case 'scholarship_daad_existing_student':
?>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="flag-form float-left w-10">
                                    <div class="gii flag-black"></div>
                                    <div class="gii flag-red"></div>
                                    <div class="gii flag-yellow"></div>
                                </div>
                                <strong class="title_header">DAAD</strong>
                                <div class="sub_title_header">Scholarship Registration Form</div>
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
                    <div class="card-footer" style="background-color: #001489 !important;">
                        <div class="row pt-2">
                            <div class="col-lg-3 text-center text-white">
                                <i class="fas fa-university fa-4x"></i>
                                <p class="text-white">ADDRESS</p>
                                <strong>ASSOCIATE TOWER 7TH FL. INTERMARK, JL LINGKAR TIMUR BSD, SERPONG , TANGERANG SELATAN 15310</strong>
                            </div>
                            <div class="col-lg-6 text-center text-white mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fas fa-phone fa-2x"></i>
                                        <p class="text-white">HOTLINE NUMBER</p>
                                        <a href="tel:+6285212318000" target="_blank" class="text-white"><STRONG>+62 852 1231 8000</STRONG></a>
                                    </div>
                                    <div class="col-4">
                                        <i class="fas fa-envelope fa-2x"></i>
                                        <p class="text-white">E-MAIL</p>
                                        <a href="mailto:info@iuli.ac.id" target="_blank" class="text-white"><STRONG>info@iuli.ac.id</STRONG></a>
                                    </div>
                                    <div class="col-4">
                                        <i class="fab fa-whatsapp fa-2x"></i>
                                        <p class="text-white">WHATSAPP CHAT</p>
                                        <a href="https://wa.me/+628176904091" target="_blank" class="text-white"><STRONG>Click here to Start a Chat</STRONG></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 text-center text-white">
                                <i class="fas fa-external-link-alt fa-3x"></i>
                                <p class="text-white">SHORTCUTS</p>
                                <div class="list-group">
                                    <a href="https://www.iuli.ac.id/" target="_blank" class="text-white p-1">
                                        <!-- <i class="fas fa-hand-point-right"></i>  -->
                                        IULI Site
                                    </a>
                                    <a href="https://news.iuli.ac.id/" target="_blank" class="text-white p-1">
                                        <!-- <i class="fas fa-hand-point-right"></i> -->
                                        IULI News
                                    </a>
                                    <a href="https://portal.iuli.ac.id/timetable/active/" target="_blank" class="text-white p-1">
                                        <!-- <i class="fas fa-hand-point-right"></i>  -->
                                        Timetable
                                    </a>
                                    <a href="https://mail.stud.iuli.ac.id/" target="_blank" class="text-white p-1">
                                        <!-- <i class="fas fa-hand-point-right"></i>  -->
                                        Webmail
                                    </a>
                                    <a href="https://portal.iuli.ac.id/" target="_blank" class="text-white p-1">
                                        <!-- <i class="fas fa-hand-point-right"></i>  -->
                                        Student &amp; Alumnae Portal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>