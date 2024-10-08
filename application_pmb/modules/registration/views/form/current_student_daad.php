<!-- <div class="row"> -->
    <div class="col-md-6 text-center my-auto">
	    <div class="my-3 pb-5">
		    <i class="fas fa-award fa-3x"></i>
		    <p>
                Scholarships for IULI students in Germany (For Sem 6 IULI Student Only)<br>(Travel Expenses plus living costs for 1 full year)
		    </p>
	    </div>
	    <div class="my-3 pb-5">
		    <i class="fas fa-medal fa-3x"></i>
		    <p>
                Scholarships for 4 weeks German Language Course at TU Ilmenau (For Sem 6 IULI Student Only
		    </p>
	    </div>
    </div>
    <div class="col-md-6 text-center">
        <h4 class="text-info-header mt-3">Enter your Student ID</h4>
        <hr/>
        <form method="post" id="registration_form_current_student">
            <!-- <input type="hidden" name="scholarship_id" id="scholarship_id" value="9034c460-87a0-11eb-a945-52540039e1c3"> -->
            <!-- <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-at"></i>
                </span>
                </div>
                <input class="form-control" type="email" id="email" name="email" placeholder="Email" required="true">
            </div> -->
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-tag"></i>
                    </span>
                </div>
                <select name="scholarship_id" id="scholarship_id" class="form-control">
            <?php
            if ($scholarship_data) {
                foreach ($scholarship_data as $o_scholarhsip) {
            ?>
                    <option value="<?=$o_scholarhsip->scholarship_id;?>"><?=$o_scholarhsip->scholarship_name.' ('.$o_scholarhsip->scholarship_description.')';?></option>
            <?php
                }
            }
            ?>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-user"></i>
                </span>
                </div>
                <input class="form-control" type="text" id="student_number" name="student_number" placeholder="Student ID" required="true">
            </div>
            <button id="btn_register" class="btn btn-block btn-facebook" type="submit">Register</button>
        </form>
        <!-- <span>Or</span>
        <div class="mt-2">
            <div class="row">
                <div class="col">
                    <a href="<?= $portal_uri?>" class="btn btn-block btn-success">
                        <span>Go to portal student</span>
                    </a>
                </div>
            </div>
        </div> -->
    </div>
<!-- </div> -->

<script type="text/javascript">
    $(function() {
	    $('button#btn_register').on('click', function(e){
		    e.preventDefault();
		    submitRegformCurrent();
	    });
	    
	    function submitRegformCurrent(){
		    $.blockUI();
		    
            var data = $('form#registration_form_current_student').serialize();
            // console.log(data);
            $.post('<?=base_url('registration/Student/registration_scholarship_student')?>', data, function(result){
                $.unblockUI();
                console.log(result);
                if (result.code == 0){
                    Swal.fire({
                        title: 'Success',
                        text: 'We just send you the request data via student mail. Please check your SPAM folder if you haven’t received this mail!',
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
                swal.fire('Warning', 'Sorry, your data is not send! Please try again later!','warning');
                console.log(xhr);
            });
            return false;
	    }
	    
        $('form#registration_form_current_student').on('submit', function(e) {
            e.preventDefault();
            submitRegformCurrent();
        })
    });
</script>