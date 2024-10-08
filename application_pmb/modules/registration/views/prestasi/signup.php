<!-- Matomo -->
<script>
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//trac.iuli.ac.id/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '4']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
<style>
    hr {
        margin-top: 5px !important;
        margin-bottom: 5px !important;
        margin-left: 0 !important
    }
    .text-info-header {
        background-color: #001489 !important;
        color: #fff;
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>
<div id="carouselExampleIndicators" class="carousel slide mb-3" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="<?=base_url()?>assets/img/banner/Profile-Campus.jpg" alt="">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="<?=base_url()?>assets/img/banner/Beasiswa.jpg" alt="">
        </div>
        <!-- <div class="carousel-item">
            <img class="d-block w-100" src="<?=base_url()?>assets/img/banner/Beasiswa.jpg" alt="">
        </div> -->
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<div class="row align-items-center">
    <div class="col-md-6 text-center">
        <div class="my-3 pb-1">
            <i class="fas fa-award fa-3x"></i>
            <p>
                Get “IULI Prestasi” scholarship up-to <strong class="text-danger">75% scholarships</strong> for excellent students’ academic or non-academic! (Deduction start from 1 – 8 semesters)
            </p>
        </div>
        <div class="my-3 pb-1">
            <i class="far fa-money-bill-alt fa-3x"></i>
            <p>
                <!-- <strong class="text-danger">NO DEVELOPMENT FEE!</strong> -->
                No Development FEE
            </p>
        </div>
        <div class="my-3 pb-1">
            <i class="fas fa-scroll fa-3x mr-2"></i>  <i class="ml-2 mr-2 fas fa-plus fa-2x"></i> <i class="fas fa-scroll fa-3x ml-2"></i>
            <p>A Chance to get a national and <strong class="text-danger">international</strong> bachelor degree in <strong class="text-danger">only 4 years!</strong></p>
        </div>
        <div class="my-3 pb-1">
            <i class="fas fa-plane-departure fa-3x"></i>
            <p>Spend up to <strong class="text-danger">2 semesters in Germany &amp; 2 years Taiwan</strong> for studying, research, internship and writing your first bachelor thesis in Germany and get Master Degree in Taiwan!</p>
        </div>
        <div class="my-3 pb-1">
            <i class="fas fa-language fa-3x"></i>
            <p><strong class="text-danger">Learn</strong> English and German classes held by native speakers!</p>
        </div>
    </div>
    <div class="col-md-6 text-center">
        <h4 class="text-info-header">Registration Form</h4>
        <hr/>
        <?= (isset($registration_page)) ? $registration_page : ''; ?>
        
        <span>Or</span>
        <div class="mt-2">
            <div class="row">
                <div class="col">
                    <a href="<?= base_url()?>registration/sign_in" class="btn btn-block btn-success">
                        <span>Sign In if you already have your login data</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function gtag_report_conversion(url) {
        var callback = function() {
            if (typeof(url) != 'undefined') {
                window.location = url;
            }
        };
        gtag('event', 'conversion', {
            'send_to': 'AW-640179922/DEN-CPOdk_QBENK9obEC',
            'edu_pagetype': ' '
        });
        return false;
    }

    $(function() {
	    $('button#btn_register').on('click', function(e){
		    e.preventDefault();
		    submitRegform();
	    });
	    
	    function submitRegform(){
		    $.blockUI();
		    
            var data = $('form#registration_form').serialize();
            $.post('<?=base_url('registration/Student/registration_first_step')?>', data, function(result){
                $.unblockUI();
                console.log(result);
                if (result.code == 0){
                    Swal.fire({
                        title: 'Success',
                        text: 'We just send you the login data and the GII info sheet via mail. Please check your SPAM folder if you haven’t received this mail!',
                        type: 'success',
                        showCancelButton: false,
                        showConfirmButton: true,
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showCloseButton: false,
                        timer: 3000
                    }).then(res => {
                        gtag_report_conversion(result.redirect);
                    });
                }
                else{
                    var err_list = result.fields;
                    if (err_list !== undefined) {
                        $("#alert_message").removeClass('d-none').addClass('fade show');
                        
                        $('#message_text').text(result.message);
                        $.each(err_list, function(i, v) {
                            $('<small class="error-field text-danger">' + v + '</small>').insertBefore($('input[name=' + i + '], select[name=' + i + ']').closest('.input-group'));
                        });

                        setTimeout(function(){
                            $('.error-field').remove();
                            $("#alert_message").removeClass('fade show').addClass('d-none');
                        }, 5000);
                    }
                    else{
                        // Swal.fire('', result.message, 'error');
                        $("#alert_message").removeClass('d-none').addClass('fade show');
                        $('#message_text').text(result.message);
                        setTimeout(function(){
                            $("#alert_message").removeClass('fade show').addClass('d-none');
                        }, 5000);
                    }
                }
            }, 'json').fail(function(xhr, txtStatus, errThrown) {
                $.unblockUI();
                swal.fire('Warning', 'Sorry, your data is not send! Please try again later!','warning');
                console.log({ xhr, txtStatus, errThrown });
            });
            return false;
	    }
	    
        $('form#registration_form').on('submit', function(e) {
            e.preventDefault();
            return false;
            // submitRegform();
        });
    });
</script>
