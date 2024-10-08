<div class="alert alert-danger alert-dismissible d-none" id="alert_message" role="alert">
  <strong>Oops...!</strong> <span id="message_text"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form method="post" id="registration_form">
    <input type="hidden" name="scholarship_id" id="scholarship_id" value="5e824656-bad9-11ec-b716-52540039e1c3">
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
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">
            <i class="fa fa-at"></i>
        </span>
        </div>
        <input class="form-control" type="email" id="email" name="email" placeholder="Email" required="true">
    </div>
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
                        window.location.href = result.redirect;
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
            submitRegform();
        })
    });
</script>