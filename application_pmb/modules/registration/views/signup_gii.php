<div class="row pb-2">
    <div class="col-12">
        <a href="<?=base_url()?>registration/brochure" target="_blank">Download Brochure (Tuition Fee Information)</a>
    </div>
</div>
<div id="carouselExampleIndicators" class="carousel slide mb-3" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <!-- <li data-target="#carouselExampleIndicators" data-slide-to="2"></li> -->
    </ol>
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
<div class="row">
    <div class="col-md-6 text-center my-auto">
	    <div class="my-3 pb-1">
		    <i class="far fa-money-bill-alt fa-3x"></i>
		    <p>
                <!-- <strong class="text-danger">NO DEVELOPMENT FEE!</strong> -->
                 <!-- Make use of our early bird and sibling discounts, <strong class="text-danger">50% scholarships</strong> for excellent students
			    and government and industrial scholarships! -->
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
	    
<!--
        <div class="p-3">
            <h3>Welcome IULI's candidate!</h3>
            <p>This page offers you the opportunity to apply for a place at IULI. Please complete the form on the right.</p>
        </div>
-->
    </div>
    <div class="col-md-6 text-center">
        <h4 class="text-info-header">Register Now</h4>
        <hr/>
        <form method="post" id="registration_form">
            <input type="hidden" name="program_id" id="program_id" value="1">
            <input type="hidden" name="class_type" id="class_type" value="regular">
	        <div class="form-group">
		        <div class="input-group mb-3">
	                <div class="input-group-prepend">
		                <span class="input-group-text">
		                    <i class="fa fa-user"></i>
		                </span>
	                </div>
	                <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Fullname" required="true" autofocus="true">
	                <input type="hidden" id="sign_up_type" name="sign_up_type" value="<?=$sign_up_type?>">
	            </div>
<!-- 	            <small>Your full name must match your birth certificate</small> -->
	        </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-at"></i>
                    </span>
                </div>
                <input class="form-control" type="email" id="email" name="email" placeholder="Email" required="true">
            </div>
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-map-marker"></i>
                        </span>
                        </div>
                        <input class="form-control" type="text" id="pob" name="pob" placeholder="Place of Birth" required="true">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-calendar-alt"></i>
                        </span>
                        </div>
                        <input class="form-control" type="date" id="dob" name="dob" placeholder="Date of Birth" required="true">
                    </div>
                </div>
            </div> -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-phone"></i>
                </span>
                </div>
                <input class="form-control" type="text" id="mobile_phone" name="mobile_phone" placeholder="Mobile Phone" required="true" oninput="this.value=this.value.replace(/[^\d\+]/,'')">
            </div>
            <div class="input-group mb-3">
	            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-graduation-cap"></i>
                </span>
                </div>
                <select class="form-control" id="study_program_id" name="study_program_id">
	                <option value="">Please select study program</option>
	                <?php
		            foreach($study_programs as $sp){
			        ?>
			        <!-- <option value="<?=$sp->study_program_id?>"><?=$sp->faculty_name?> - <?=$sp->study_program_gii_name?> (<i><?=$sp->study_program_name?></i>)</option> -->
			        <option value="<?=$sp->study_program_id?>"><?=$sp->study_program_gii_name?> (<i><?=$sp->study_program_name?></i>)</option>
			        <?php
		            }  
		            ?>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                </div>
                <input class="form-control" type="password" id="password" name="password" placeholder="Password" required="true">
            </div>
            <div class="input-group mb-3 d-none">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                </div>
                <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required="true">
            </div>
            <button id="btn_register" class="btn btn-block btn-facebook" type="submit">Register</button>
        </form>
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
        <!-- <div class="mt-2">
            <div class="row">
                <div class="col">
                    <a onclick="return gtag_report_conversion('<?= base_url()?>NI');" href="<?= base_url()?>NI" class="btn btn-block btn-link">
                        <span>Registration Form National Institute</span>
                    </a>
                </div>
            </div>
        </div> -->
    </div>

<?php
// if ($_SERVER['REMOTE_ADDR'] == '114.10.72.72') {
?>
    <div class="col-12 mb-3">
        <div class="mt-3 border-top border-info pl-2 pr-2 mt-3 pt-2">
            <p>International University Liasion Indonesia accepts registration of new students for the 2023 school year through several programs to make it easier for them to realize their aspirations of getting an international scale education in the future to face global competition by being able to get education in Germany or Taiwan.</p>
        <!-- </div>
        <div class="mt-3 border-bottom pl-2 pr-2"> -->
            <p>New Student Admission Program at IULI University in 2023:</p>
        </div>
        <div class="accordion border-info" id="info1">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <span id="sign_collapse"><i class="fas fa-plus-square"></i></span> 1. Regular Class (Day Time)
                </button>
            </h2>
            <div id="collapseOne" class="collapse pl-3 pr-3" aria-labelledby="headingOne" data-parent="#info1">
                <p class="pl-3">Tuition fee at IULI University is IDR 29,900,000 Per-Semester and No Development Fee, (Applies to All Majors and can be paid in installments)</p>
                <ol type="a">IULI University Scholarship Program :
                    <li>
                        Academic Scholarship Pathway for 8 semesters
                        <ul>
                            <li>Free 75% discount per semester</li>
                            <li>Free 50% discount per semester</li>
                            <li>Free 30% discount per semester</li>
                        </ul>
                    </li>
                    <li>
                        Non-Academic Scholarship Pathway for 8 semesters
                        <ul>
                            <li>Free 75% discount per semester</li>
                            <li>Free 50% discount per semester</li>
                            <li>Free 30% discount per semester</li>
                        </ul>
                    </li>
                </ol>
            </div>
        </div>
        <div class="accordion border-bottom border-info" id="info2">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <span id="sign_collapse_two"><i class="fas fa-plus-square"></i></span> 2. Employee Class (Evening and Weekend)
                </button>
            </h2>
            <div id="collapseTwo" class="collapse pl-3 pr-3" aria-labelledby="headingTwo" data-parent="#info2">
                <p class="pl-3">Cost 1 Million Per Month and No Development Fee <a href="https://pmb.iuli.ac.id/karyawan" target="_blank">(Register Here)</a></p>
            </div>
        </div>
    </div>
<?php
// }
?>
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

        $('#btn_test').on('click', function(e) {
            e.preventDefault();

            var _paq = window._paq = window._paq || [];
            /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u="//trac.iuli.ac.id/";
                _paq.push(['setTrackerUrl', u+'matomo.php']);
                _paq.push(['setSiteId', '2']);
                var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
            })();
        })

        $('#collapseOne').on('shown.bs.collapse', function () {
            $('#sign_collapse').html('<i class="fas fa-minus-square"></i>');
        });
        $('#collapseOne').on('hidden.bs.collapse', function () {
            $('#sign_collapse').html('<i class="fas fa-plus-square"></i>');
        });
        $('#collapseTwo').on('shown.bs.collapse', function () {
            $('#sign_collapse_two').html('<i class="fas fa-minus-square"></i>');
        });
        $('#collapseTwo').on('hidden.bs.collapse', function () {
            $('#sign_collapse_two').html('<i class="fas fa-plus-square"></i>');
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
                        var _paq = window._paq = window._paq || [];
                        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
                        _paq.push(['trackPageView']);
                        _paq.push(['enableLinkTracking']);
                        (function() {
                            var u="//trac.iuli.ac.id/";
                            _paq.push(['setTrackerUrl', u+'matomo.php']);
                            _paq.push(['setSiteId', '2']);
                            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                            g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
                        })();
                        
                        gtag_report_conversion(result.redirect);
                    });
                }
                else{
                    swal.fire('Warning', result.message,'warning');
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
