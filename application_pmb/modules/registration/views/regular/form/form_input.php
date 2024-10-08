<form method="post" id="registration_form">
    <input type="hidden" name="scholarship_id" id="scholarship_id" value="">
    <input type="hidden" name="program_id" id="program_id" value="1">
    <input type="hidden" name="class_type" id="class_type" value="regular">
    <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-user"></i>
                </span>
            </div>
            <!-- <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Fullname" required="true" autofocus="true"> -->
            <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Fullname" required="true">
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
    <!-- <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">
            <i class="fa fa-pen-nib"></i>
        </span>
        </div>
        <select class="form-control" id="registration_ex" name="registration_ex">
            <option value="1">International Class</option>
            <option value="6">National Class</option>
            <option value="2">Employee Class</option>
            <option value="5">Hotel Training Center</option>
        </select>
    </div> -->
    <div id="group_study_program" class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">
            <i class="fa fa-graduation-cap"></i>
        </span>
        </div>
        <select class="form-control" id="study_program_id" name="study_program_id">
            <option value="">Please select study programs</option>
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
    <button id="btn_register" class="btn btn-block btn-facebook" type="submit">Register Now</button>
</form>

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
        let prodilist = $("#study_program_id").html();
        // console.log(prodilist);
	    $('button#btn_register').on('click', function(e){
		    e.preventDefault();
            
            submitRegform();
	    });

        $('#registration_ex').on('change', function(e) {
            e.preventDefault();

            var type_selected = $(this).val();
            $("#study_program_id").empty();
            $('#group_study_program').removeClass('d-none');
            if (type_selected == '1') {
                $('#scholarship_id').val('');
                $('#program_id').val('1');
                $('#class_type').val('regular');
                $('#study_program_id').html(prodilist);
            }
            else if (type_selected == '2') {
                $('#scholarship_id').val('');
                $('#program_id').val('2');
                $('#class_type').val('karyawan');
                // $("#study_program_id").empty();
                $("#study_program_id").append('<option value="">Please select study program</option>');
                $("#study_program_id").append('<option value="226f91bc-81cd-11e9-bdfc-5254005d90f6">Manajemen Bisnis</option>');
            }
            else if (type_selected == '3') {
                $('#scholarship_id').val('5e824656-bad9-11ec-b716-52540039e1c3');
                $('#program_id').val('1');
                $('#class_type').val('regular');
                $('#study_program_id').html(prodilist);
            }
            else if (type_selected == '4') {
                $('#scholarship_id').val('39b636a7-7b5e-11eb-9c69-52540001273f');
                $('#program_id').val('1');
                $('#class_type').val('regular');
                $('#study_program_id').html(prodilist);
            }
            else if (type_selected == '5') {
                $('#scholarship_id').val('');
                $('#program_id').val('9');
                $('#class_type').val('course');
                $('#study_program_id').html(prodilist);
                $("#study_program_id").val('903eb8ee-159e-406b-8f7e-38d63a961ea4').trigger('change');
                $('#group_study_program').addClass('d-none');
            }
            else if (type_selected == '6') {
                $('#scholarship_id').val('');
                $('#program_id').val('3');
                $('#class_type').val('regular');
                $('#study_program_id').html(prodilist);
            }
        });

        function submitRegform(){
		    $.blockUI();

            var data = $('form#registration_form').serialize();
            $.post('<?=base_url('registration/Student/registration_first_step')?>', data, function(result){
                $.unblockUI();
                console.log(result);
                if (result.code == 0){
                    // if ('<?=$_SERVER['REMOTE_ADDR']?>' == '202.93.225.254') {
                    //     $.unblockUI();
                    //     swal.fire('Warning', 'ADM Wifi detected!, site under maintenance, please use another network/wifi','warning');
                    //     return false;
                    // }
                    
                    Swal.fire({
                        title: 'Success',
                        // text: 'We just send you the login data and the GII info sheet via mail. Please check your SPAM folder if you haven’t received this mail!',
                        text: 'We just send you a link to confirm your email address via mail. Please check your SPAM folder if you haven’t received this mail!',
                        type: 'success',
                        showCancelButton: false,
                        showConfirmButton: true,
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showCloseButton: false,
                        timer: 3000
                    }).then(res => {
                        // if (gtag_report_conversion(result.redirect) == false) {
                            <?php
                            // if ($_SERVER['REMOTE_ADDR'] != '202.93.225.254') {
                            ?>
                                window.location = result.redirect;
                            <?php
                            // }
                            ?>
                        // }
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

    function set_prodi() {
        $("#study_program_id").clear();
    }
</script>
