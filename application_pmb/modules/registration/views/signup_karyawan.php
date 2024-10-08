<div class="row">
    <div class="col-md-6 text-center my-auto">
	    <!-- <div class="my-3 pb-1">
		    <i class="fas fa-plane-departure fa-3x"></i>
		    <p>
                <strong class="text-danger">NO DEVELOPMENT FEE!</strong>
                 Make use of our early bird and sibling discounts, <strong class="text-danger">50% scholarships</strong> for excellent students
			    and government and industrial scholarships!
                Kesempatan mengikuti <strong class="text-danger">student exchange</strong> dan <strong class="text-danger">internship</strong> di Jerman
		    </p>
	    </div> -->
	    <!-- <div class="my-3 pb-1">
		    <i class="fas fa-scroll fa-3x mr-2"></i>  <i class="ml-2 mr-2 fas fa-plus fa-2x"></i> <i class="fas fa-scroll fa-3x ml-2"></i>
			<p>Kesempatan mendapatkan <strong class="text-danger">gelar S1 + S2</strong> di Taiwan</p>
	    </div> -->
	    <div class="my-3 pb-1">
		    <i class="fas fa-building fa-3x"></i>
			<p>Kelas kecil untuk mengoptimalkan proses belajar</p>
	    </div>
	    <div class="my-3 pb-1">
		    <i class="fas fa-language fa-3x"></i>
			<p><strong class="text-danger">Gratis</strong> belajar Bahasa Inggris!</p>
	    </div>
	    
<!--
        <div class="p-3">
            <h3>Welcome IULI's candidate!</h3>
            <p>This page offers you the opportunity to apply for a place at IULI. Please complete the form on the right.</p>
        </div>
-->
    </div>
    <div class="col-md-6 text-center">
        <div class="alert alert-danger alert-dismissible d-none" id="alert_message" role="alert">
            <strong>Oops...!</strong> <span id="message_text"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <h4 class="text-info-header">Register Now</h4>
        <hr/>
        <form method="post" id="registration_form">
            <input type="hidden" name="program_id" id="program_id" value="1">
            <input type="hidden" name="class_type" id="class_type" value="karyawan">
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
                            // $('<small class="error-field text-danger">' + v + '</small>').insertAfter($('input[name=' + i + ']').closest('.form-group'));
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
