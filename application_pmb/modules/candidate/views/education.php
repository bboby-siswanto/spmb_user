<?=modules::run('candidate/questionnaire/load_questionnaire_modal', 2)?>

<div class="card">
    <div class="card-header"><?= $pageChildTitle ?></div>
    <div class="card-body">
        <form method="post" id="form_edit_academic_history" onsubmit="return false;">
            <div class="form-group m-form__group m--margin-top-10 d-none col" id="alert_wrapper">
                <div class="alert m-alert m-alert--default" id="text_alert_wrapper" role="alert"></div>
            </div>
            <label><b>Your Choice of Study Program </b></label>
            <div class="form-group <?= (in_array($student_data->program_id, ['9'])) ? 'd-none' : '';?>">
                <label for="admission_type" class="required_text">Type of Admission</label>
                <select class="form-control" id="admission_type" name="admission_type" <?=($student_data->student_type == 'exchange') ? 'readonly' : '';?>>
                    <option value="">---</option>
                    <option value="regular" <?=($student_data->student_type == 'regular') ? 'selected' : '';?>>Non Transfer Student</option>
                    <option value="transfer" <?=($student_data->student_type == 'transfer') ? 'selected' : '';?>>Transfer Student</option>
                    <?php
	                if($student_data->student_type == 'exchange'){
		            ?>
		            <option value="exchange" <?=($student_data->student_type == 'exchange') ? 'selected' : '';?>>Exchange Student</option>
		            <?php  
	                }
	                ?>
                </select>
            </div>
            <!-- <div class="form-group">
                <label for="admission_type">Your Choice of Institution</label>
                <select class="form-control" id="program" name="program">
                    <option value="">---</option>
                    <?php
                        foreach ($programs as $program) {
                    ?>
                    <option value="<?=$program->program_id?>" <?=(($study_program_data) AND ($study_program_data->program_id == $program->program_id)) ? 'selected' : '';?>><?=$program->type_of_admission_name;?></option>
                    <?php
                        }
                    ?>
                </select>
            </div> -->
            <div class="form-group <?= (in_array($student_data->program_id, ['9'])) ? 'd-none' : '';?>">
                <label for="admission_type" class="required_text">Your Choice of Study Program</label>
				<select class="form-control" id="study_program" name="study_program">
					<option value="">---</option>
				</select>
            </div>
            <div class="form-group <?= (in_array($student_data->program_id, ['9'])) ? 'd-none' : '';?>">
                <label for="admission_type" class="required_text">Your Choice of Study Program Optional 1</label>
				<select class="form-control" id="study_program_alt1" name="study_program_alt1">
					<option value="">---</option>
				</select>
            </div>
            <div class="form-group <?= (in_array($student_data->program_id, ['9'])) ? 'd-none' : '';?>">
                <label for="admission_type">Your Choice of Study Program Optional 2</label>
				<select class="form-control" id="study_program_alt2" name="study_program_alt2">
					<option value="">---</option>
				</select>
            </div>
            <input type="hidden" name="attend_un_yes" value="no">
            <!-- <div class="form-group">
                <label for="attend_un">Did you attend UN?</label>
                <div class="custom-control custom-radio">
                    <input type="radio" name="attend_un" value="yes" class="custom-control-input" id="attend_un_yes" <?=($student_data->student_un_status == 'yes') ? 'checked="checked"' : ''?>>
                    <label class="custom-control-label" for="attend_un_yes">Yes</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" name="attend_un" value="no" class="custom-control-input" id="attend_un_no" <?=($student_data->student_un_status == 'no') ? 'checked="checked"' : ''?>>
                    <label class="custom-control-label" for="attend_un_no">No</label>
                </div>
            </div> -->
<!--
            <label for="test"><b>Your SGS Code</b></label>
            <div class="form-group">
                <label for="sgs_code">SGS Code (optional)</label>
                <input type="text" name="sgs_code" id="sgs_code" class="form-control" value="<?=($sgs_data) ? $sgs_data->student_sgs_code : ''?>">
            </div>
-->
            <label for="test"><b>Your Educational Background</b></label>
            <input type="hidden" name="academic_history_id" id="academic_history_id" value="<?= (isset($student_data->academic_history_id) AND ($student_data->academic_history_id != NULL)) ? $student_data->academic_history_id : ''; ?>" placeholder="academic history id">
            <div class="form-group">
                <label for="school_nisn">NISN <i>(Student Number)</i></label>
                <input type="text" class="form-control" name="student_nisn" id="student_nisn" value=" <?=$student_data->student_nisn;?>">
            </div>
            <div class="form-group">
                <label for="school_name" class="required_text">High School Name</label>
                <input type="text" name="school_name" id="school_name" placeholder="School Name" class="form-control" value="<?=($educational_background) ? $educational_background->institution_name : '';?>">
                <input type="hidden" name="school_id" id="school_id" value="<?=($educational_background) ? $educational_background->institution_id : '';?>" placeholder="institution id">
                <input type="hidden" name="school_found_status" id="school_found_status" value="<?=($educational_background) ? '1' : '0';?>" placeholder="school found status">
                <small id="text_school_not_found">School not found? <a href="#" id="activated_school">Click here</a></small>
            </div>
            <div class="form-group">
                <label for="school_address">School Address</label>
                <textarea name="school_address" id="school_address" class="form-control locked" cols="30" rows="3" disabled="true"><?=($educational_background) ? $educational_background->address_street : ''?></textarea>
            </div>
            <div class="form-group">
                <label for="school_phone_number">School Phone Number</label>
                <input type="text" class="form-control locked" name="school_phone_number" id="school_phone_number" disabled="true" value="<?=($educational_background) ? $educational_background->institution_phone_number : '';?>">
            </div>
            <div class="form-group">
                <label for="school_email">School Email</label>
                <input type="text" class="form-control locked" name="school_email" id="school_email" disabled="true" value="<?=($educational_background) ? $educational_background->institution_email : '';?>">
            </div>
            <div class="form-group">
                <label for="school_zipcode">Zip Code</label>
                <input type="text" class="form-control locked" name="school_zipcode" id="school_zipcode" disabled="true" value="<?=($educational_background) ? $educational_background->address_zipcode : '';?>">
            </div>
            <div class="form-group">
                <label for="school_country">Country</label>
                <input type="text" class="form-control locked" name="school_country" id="school_country" disabled="true" value="<?=($educational_background) ? $educational_background->country_name : '';?>">
                <input type="hidden" name="school_country_id" id="school_country_id" value="<?=($educational_background) ? $educational_background->country_id : '';?>" placeholder="country id">
            </div>
            <div class="form-group">
                <label for="school_province">Province</label>
                <input type="text" class="form-control locked" name="school_province" id="school_province" disabled="true" value="<?=($educational_background) ? $educational_background->address_province : '';?>">
            </div>
            <div class="form-group">
                <label for="school_city">City</label>
                <input type="text" class="form-control locked" name="school_city" id="school_city" disabled="true" value="<?=($educational_background) ? $educational_background->address_city : '';?>">
            </div>
            <div class="form-group">
                <label for="school_graduation_year" class="required_text">Graduation Year</label>
                <input type="text" class="form-control" name="school_graduation_year" id="school_graduation_year" value="<?=($educational_background) ? $educational_background->academic_history_graduation_year : '';?>">
            </div>  
    <?php
    if ((isset($student_data)) AND ($student_data->program_id != 9)) {
    ?>
            <div class="form-group">
                <label for="major" class="required_text">Major/Discipline</label>
                <select class="form-control" id="major" name="major">
                    <option value="">---</option>
                    <option value="IPA" <?=(($educational_background) AND($educational_background->academic_history_major=='IPA')) ? 'selected' : '';?>>IPA</option>
                    <option value="IPS" <?=(($educational_background) AND($educational_background->academic_history_major=='IPS')) ? 'selected' : '';?>>IPS</option>
                </select>
            </div>
    <?php
    }
    ?>
        
        </form>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-primary" id="save_academic_history">Save</button>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        var locked_input = $('.locked');
        locked_input.prop('disabled', true);

		$('select#program').on('change', function(e){
			e.preventDefault();
			change_study_program();
		});
        change_study_program();

        function change_study_program() {
            // let program_id = $('select#program').val();
            var program_id = '<?= ($study_program_data) ? $study_program_data->program_id : 1 ?>';
            program_id = (program_id == 3) ? 1 : program_id;
			$.post('<?=site_url('candidate/education/get_study_programs_by_program_id/'.$student_data->student_id)?>', { program_id: program_id, type: 'html' }, function(rtn){
				$('select#study_program').html(rtn);
			}, 'html');

            $.post('<?=site_url('candidate/education/get_study_programs_by_program_id/'.$student_data->student_id)?>', { program_id: program_id, type: 'html', alt: '1' }, function(rtn){
				$('select#study_program_alt1').html(rtn);
			}, 'html');

            $.post('<?=site_url('candidate/education/get_study_programs_by_program_id/'.$student_data->student_id)?>', { program_id: program_id, type: 'html', alt: '2' }, function(rtn){
				$('select#study_program_alt2').html(rtn);
			}, 'html');
        }

        $('a#activated_school').on('click', function(e) {
            e.preventDefault();
            locked_input.prop('disabled', false);
            $('#school_found_status').val('0');
            $('#school_id').val('');
        });

        $('input#school_name').autocomplete({
            autoFocus: true,
			minLength: 1,
			source: function(request, response){
				var url = '<?=site_url('candidate/education/get_institution_by_name')?>';
				var data = {
					term: request.term,
					type: 'highschool'
				};
				$.post(url, data, function(rtn){
					if(rtn.code == 0){
						var arr = [];
						arr = $.map(rtn.data, function(m){
							return {
								id: m.institution_id,
								value: m.institution_name,
								edu_data: m
							};
						});
						response(arr);
                        // $('small#text_school_not_found').addClass('d-none');
					}
					else{
						$('input#school_id').val('');
                        // $('small#text_school_not_found').removeClass('d-none');
					}
				}, 'json');
			},
			select: function(event, ui){
				var id = ui.item.id;
				var edu_data = ui.item.edu_data;
				locked_input.prop('disabled', true);
				$('input#school_id').val(id);
				$('input#school_found_status').val('1');
				$('textarea#school_address').val(edu_data.address_street);
				$('input#school_phone_number').val(edu_data.institution_phone_number);
				$('input#school_email').val(edu_data.institution_email);
				$('input#school_zipcode').val(edu_data.address_zipcode);
				$('input#school_country').val(edu_data.country_name);
				$('input#school_country_id').val(edu_data.country_id);
				$('input#school_province').val(edu_data.address_province);
				$('input#school_city').val(edu_data.address_city);
				// $('small#text_school_not_found').addClass('d-none');
                
			},
			change: function(event, ui){
				if(ui.item === null){
                    $('textarea#school_address').val('');
                    $('input#school_phone_number').val('');
                    $('input#school_email').val('');
                    $('input#school_zipcode').val('');
                    $('input#school_country').val('');
                    $('input#school_country_id').val('');
                    $('input#school_province').val('');
                    $('input#school_city').val('');

					$('input#school_id').val('');
					$('input#school_found_status').val('0');
                    // $('small#text_school_not_found').removeClass('d-none');
				}
			}
        });

        $('input#school_country').autocomplete({
			minLength: 1,
			source: function(request, response){
				var url = '<?=site_url('candidate/profile/get_country')?>';
				var data = {
					term: request.term
				};
				$.post(url, data, function(rtn){
					if(rtn.code == 0){
						var arr = [];
						arr = $.map(rtn.data, function(m){
							return {
								id: m.country_id,
								value: m.country_name
							}
						});
						response(arr);
					}
				}, 'json');
			},
			select: function(event, ui){
				var id = ui.item.id;
				$('input#school_country_id').val(id);
			},
			change: function(event, ui){
				if(ui.item === null){
                    $('input#school_country').val('');
					$('input#school_country_id').val('');
					swal.fire('','Please use the selection provided','warning');
				}
			}
		});

        $('button#save_academic_history').on('click', function(e) {
            e.preventDefault();
            $.blockUI();
            
            var form = $('form#form_edit_academic_history');
			var url = "<?=site_url('candidate/education/save_academic_history')?>";
            var data = form.serialize();
            $.post(url, data, function(rtn){
				if(rtn.code == 0){
                    $.unblockUI();
					$('div#alert_wrapper').removeClass('d-none');
					$('div#text_alert_wrapper').addClass('alert-success');
					$('div#text_alert_wrapper').html(rtn.message);
					setTimeout(function(){
						window.location.replace('<?=site_url('candidate/profile')?>');
						$('div#alert_wrapper').addClass('d-none');
						$('div#text_alert_wrapper').removeClass('alert-success');
					}, 5000);
				}
				else{
                    $.unblockUI();
                    $('div#alert_wrapper').removeClass('d-none');
					$('div#text_alert_wrapper').addClass('alert-warning');
					$('div#text_alert_wrapper').html(rtn.message);
					setTimeout(function(){
						$('div#alert_wrapper').addClass('d-none');
						$('div#text_alert_wrapper').removeClass('alert-warning');
					},7000);
				}
				
				$('html, body').animate({
					scrollTop: $('div#alert_wrapper')
				});
            }, 'json').fail(function(xhr, txtStatus, errThrown) {
                $.unblockUI();
            });
        });
    });
</script>