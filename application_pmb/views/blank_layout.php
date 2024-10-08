<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="IULI PMB">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <meta name="facebook-domain-verification" content="ua21qk4c6udte2595ldns71lxlucst" />

        <title>IULI PMB</title>
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
        
        <link rel="shortcut icon" href="<?=base_url()?>assets/img/ico/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?=base_url()?>assets/img/ico/favicon.ico" type="image/x-icon">

        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/registration_style.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/fontawesome/css/all.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/sweetalertmaster/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/vendors/animate/animate.min.css" rel="stylesheet">
        <link href="<?=base_url()?>assets/vendors/jquery-ui/jquery-ui.bundle.css" rel="stylesheet" type="text/css" />
        <style>
            .required_text::after {
                content: " *";
                color: red;
            }
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
            .btn-contact {
                width: 65px !important;
                height: 65px !important;
                position: fixed;
                bottom: 20px;
                right: 20px;
                box-shadow: 2px 2px 3px #999;
            }
            .btn-circle {
                max-width: 100px;
                max-height: 100px;
                border-radius: 50px;
                text-align: center;
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
            // ads fb
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
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11073688644"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'AW-11073688644');
        </script> 
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KRDFRB2');</script>
        <!-- End Google Tag Manager -->

        <?= (isset($header_script)) ? $header_script : '';?>
        <script>
            const animateCanvas = (elementhide, elementshow) =>
                // We create a Promise and return it
                new Promise((resolve, reject) => {
                    const animationHideName = 'animate__flipOutY';
                    const animationShowName = 'animate__flipInY';
                    const nodehide = document.querySelector(elementhide);
                    const nodeshow = document.querySelector(elementshow);
                    
                    nodehide.classList.add('animate__animated', animationHideName);

                    // When the animation ends, we clean the classes and resolve the Promise
                    function handleAnimationEnd(event) {
                        event.stopPropagation();
                        nodehide.classList.remove('animate__animated', animationHideName);
                        
                        resolve('Animation ended');

                        nodeshow.classList.remove('d-none');
                        nodeshow.classList.add('animate__animated', animationShowName);

                        nodehide.classList.add('d-none');
                        // nodeshow.classList.remove('animate__animated', animationShowName);
                        nodeshow.addEventListener('animationend', function(event) {
                            nodeshow.classList.remove('animate__animated', animationShowName);
                        }, {once: true});
                    }

                    nodehide.addEventListener('animationend', handleAnimationEnd, {once: true});
                });
        </script>
        <script>
            gtag('event', 'conversion', {'send_to': 'AW-11073688644/BetLCPnJkYkYEMSorKAp'});
        </script>
    </head>
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KRDFRB2"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <div class="container pt-3 pt-md-5">
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
        <div class="modal animated" tabindex="-1" role="dialog" id="modal_contact">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Let me know your question..</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnclosemodal">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form url="<?=base_url()?>registration/user_message" onsubmit="return false" id="form_contact">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-4 mb-3">
                                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Full Name">
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <input type="email" name="user_email" id="user_email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <input type="text" name="user_phone" id="user_phone" class="form-control" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <input type="text" name="user_topic" id="user_topic" class="form-control" placeholder="Subject Question">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <!-- <textarea name="" id="" cols="30" rows="10"></textarea> -->
                                        <textarea name="user_message" id="user_message" rows="8" class="form-control" placeholder="Explain your question.."></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="send_message_contact" class="btn btn-primary">Send Message</button>
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-circle btn-contact btn-primary" id="contact-button" type="button" data-toggle="modal" data-target="#modal_contact">
            <h4><i class="fa-solid fa-message"></i></h4>
        </button>
        <script>
            let fadein = 'animate__fadeInDown';
            let fadeout = 'animate__fadeOutDown';
            
            $('#modal_contact').on('show.bs.modal', function (e) {
                $(this).removeClass(fadeout);
                $(this).addClass(fadein);
            });

            $('#modal_contact').on('hide.bs.modal', function (e) {
                let $this = $(this);

                if ($this.hasClass(fadein)) {
                    $this.removeClass(fadein);
                    $this.addClass(fadeout);
                    e.preventDefault();

                    setTimeout(function () {
                        $this.modal('hide');
                    }, 500);
                }
            });

            $('#send_message_contact').on('click', function(e) {
                e.preventDefault();

                let form = $('#form_contact');
                let data = form.serialize();
                let url = form.attr('url');

                $.post(url, data, function(result) {
                    if (result.code == 0) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thank You.',
                            text: 'Your message has been sent, We will contact you as soon as possible via the email you have entered.',
                            showConfirmButton: false
                        });
                    }
                    else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Ooopss..',
                            html: result.message,
                            showConfirmButton: false
                        });
                    }
                }, 'json').fail(function(params) {
                    Swal.fire('Warning', 'Sorry, your message is not send! Please try again later!','warning');
                });
            })
        </script>
    </body>
</html>