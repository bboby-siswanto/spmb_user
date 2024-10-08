<div class="row">
    <div class="col-md-6 text-center my-auto">
	    <div class="my-3 pb-4">
		    <i class="fas fa-award fa-3x"></i>
		    <p>
                <!-- <strong class="text-danger">NO DEVELOPMENT FEE!</strong> -->
                Pendidikan yang berkualitas
		    </p>
	    </div>
	    <div class="my-3 pb-4">
		    <i class="fas fa-scroll fa-3x mr-2"></i>  <i class="ml-2 mr-2 fas fa-plus fa-2x"></i>
			<p>Mendapatkan gelar sarjana dalam <strong class="text-danger">4 tahun!</strong></p>
	    </div>
	    <div class="my-3">
		    <i class="fas fa-language fa-3x"></i>
			<p>Pembelajaran dalam Bahasa Indonesia</p>
	    </div>
    </div>
    <div class="col-md-6 text-center">
        <h4 class="text-info-header">Register now and get the NI info sheet via mail</h4>
        <hr/>
        <form method="post" id="registration_form">
            <input type="hidden" name="program_id" id="program_id" value="3">
	        <div class="form-group">
		        <div class="input-group mb-3">
	                <div class="input-group-prepend">
		                <span class="input-group-text">
		                    <i class="fa fa-user"></i>
		                </span>
	                </div>
	                <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Nama Lengkap" required="true" autofocus="true">
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
                <input class="form-control" type="text" id="mobile_phone" name="mobile_phone" placeholder="Nomor Handphone" required="true" oninput="this.value=this.value.replace(/[^\d\+]/,'')">
            </div>
            <div class="input-group mb-3">
	            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-graduation-cap"></i>
                </span>
                </div>
                <select class="form-control" id="study_program_id" name="study_program_id">
	                <option value="">Pilih Program Studi</option>
	                <?php
		            foreach($study_programs as $sp){
			        ?>
			        <option value="<?=$sp->study_program_id?>"><?=$sp->study_program_ni_name?></option>
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
                <input class="form-control" type="password" id="password" name="password" placeholder="Kata Sandi" required="true">
            </div>
            <div class="input-group mb-3 d-none">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                </div>
                <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi Kata Sandi" required="true">
            </div>
            <button id="btn_register" class="btn btn-block btn-facebook" type="submit">Daftar</button>
        </form>
        <span>Or</span>
        <div class="mt-2">
            <div class="row">
                <div class="col">
                    <a href="<?= base_url()?>registration/sign_in" class="btn btn-block btn-success">
                        <span>Login jika kamu sudah pernah mendaftar</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- <div class="mt-2">
            <div class="row">
                <div class="col">
                    <a onclick="return gtag_report_conversion('<?= base_url()?>GII');" href="<?= base_url()?>GII" class="btn btn-block btn-link">
                        <span>Registration Form German International Institute</span>
                    </a>
                </div>
            </div>
        </div> -->
    </div>
</div>

<script type="text/javascript">
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
                    gtag('event', 'conversion', {
                        'send_to': 'AW-640179922/uWu_CMzBk_QBENK9obEC'
                    });

                    Swal.fire({
                        title: 'Success',
                        text: 'We just send you the login data and the NI info sheet via mail. Please check your SPAM folder if you haven’t received this mail!',
                        type: 'success',
                        showCancelButton: false,
                        showConfirmButton: true,
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showCloseButton: false,
                        timer: 3000
                    }).then(res => {
                        window.location.href = result.redirect;
                    });
                }
                else{
                    swal.fire('Warning', result.message,'warning');
                }
            }, 'json').fail(function(xhr, txtStatus, errThrown) {
                $.unblockUI();
                swal.fire('Warning', 'Mohon maaf, data tidak dapat disimpan! Mohon reload browser anda dan ulang beberapa saat lagi!','warning');
                console.log({ xhr, txtStatus, errThrown });
            });
            return false;
	    }
	    
        $('form#registration_form').on('submit', function(e) {
            e.preventDefault();
            submitRegform();
        })
    });
</script>