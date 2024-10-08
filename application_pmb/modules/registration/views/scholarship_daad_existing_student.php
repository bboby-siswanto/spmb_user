<div class="row">
    <div class="col-md-6 text-center my-auto">
	    <div class="my-3">
		    <i class="far fa-money-bill-alt fa-3x"></i>
		    <p>
                <!-- <strong class="text-danger">NO DEVELOPMENT FEE!</strong> -->
                 Make use of our early bird and sibling discounts, <strong class="text-danger">50% scholarships</strong> for excellent students
			    and government and industrial scholarships!
		    </p>
	    </div>
	    <div class="my-3">
		    <i class="fas fa-scroll fa-3x mr-2"></i>  <i class="ml-2 mr-2 fas fa-plus fa-2x"></i> <i class="fas fa-scroll fa-3x ml-2"></i>
			<p>Get a national and <strong class="text-danger">international</strong> bachelor degree in <strong class="text-danger">only 4 years!</strong></p>
	    </div>
	    <div class="my-3">
		    <i class="fas fa-plane-departure fa-3x"></i>
			<p>Spend up to <strong class="text-danger">2 semesters in Germany</strong> for studying, research, internship and writing your first bachelor thesis!</p>
	    </div>
	    <div class="my-3">
		    <i class="fas fa-language fa-3x"></i>
			<p><strong class="text-danger">FREE</strong> English and German classes held by native speakers!</p>
	    </div>
	    
    </div>
    <div class="col-md-6 text-center">
        <!-- <h5>Enter your Student ID </h5>
        <hr/> -->
        <form method="post" id="registration_form">
            <!-- <input type="hidden" name="scholarship_id" id="scholarship_id" value="39b636a7-7b5e-11eb-9c69-52540001273f"> -->
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
                <input class="form-control" type="text" id="student_number" name="student_number" placeholder="Student ID (NIM)" required="true">
            </div>
            <button id="btn_register" class="btn btn-block btn-facebook" type="submit">Register</button>
        </form>
        <span>Or</span>
        <div class="mt-2">
            <div class="row">
                <div class="col">
                    <a href="<?= $portal_uri?>" class="btn btn-block btn-success">
                        <span>Go to portal student</span>
                    </a>
                </div>
            </div>
        </div>
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
            // console.log(data);
            $.post('<?=base_url('registration/Student/registration_scholarship_student')?>', data, function(result){
                $.unblockUI();
                console.log(result);
                if (result.code == 0){
                    Swal.fire({
                        title: 'Success',
                        text: 'We just send you the request data via mail. Please check your SPAM folder if you haven’t received this mail!',
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
	    
        $('form#registration_form').on('submit', function(e) {
            e.preventDefault();
            submitRegform();
        })
    });
</script>