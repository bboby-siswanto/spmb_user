<div class="card">
    <div class="card-header"><?= $pageChildTitle ?> <span id="hidden_agenda">Form</span></div>
    <div class="card-body">
        <form method="post" id="form_edit_parent_data" onsubmit="return false;">
            <div class="form-group m-form__group m--margin-top-10 d-none" id="alert_wrapper">
				<div class="alert m-alert m-alert--default" id="text_alert_wrapper" role="alert"></div>
			</div>
            <label><b>Parents Data</b></label>
            <input type="hidden" name="family_id" id="family_id" value="<?=($student_data) ? $student_data->family_id : ''?>" placeholder="family_id">
            <input type="hidden" name="parent_exist" id="parent_exist" value="<?= ($parents_data) ? '1' : '0'?>" placeholder="parent_exist">
            <input type="hidden" name="personal_data_parent_id" id="personal_data_parent_id" value="<?= ($parents_data) ? $parents_data->personal_data_id : ''; ?>" placeholder="personal data parent id">
            <div class="form-group">
                <label for="parent_name" class="required_text">Parent/Guardian Name</label>
                <input type="text" class="form-control" name="parent_name" id="parent_name" value="<?=($parents_data) ? $parents_data->personal_data_name : ''?>">
            </div>
            <div class="form-group">
                <label for="parent_name" class="required_text">Relations</label>
                <select name="relation" id="relation" class="form-control">
                    <option value="">---</option>
                    <option value="father" <?=($parents_data) ? (($parents_data->family_member_status == 'father') ? 'selected' : '') : ''?>>Father</option>
                    <option value="mother" <?=($parents_data) ? (($parents_data->family_member_status == 'mother') ? 'selected' : '') : ''?>>Mother</option>
                    <option value="guardian" <?=($parents_data) ? (($parents_data->family_member_status == 'guardian') ? 'selected' : '') : ''?>>Guardian</option>
                </select>
            </div>
            <div class="form-group">
                <label for="mother_maiden_name" class="required_text">Mother's Maiden Name</label>
                <input type="text" class="form-control" name="mother_maiden_name" id="mother_maiden_name" value="<?=($student_data) ? $student_data->personal_data_mother_maiden_name : ''?>">
            </div>
            <div class="form-group">
                <label for="parent_email" class="required_text">Parent Email</label>
                <input type="text" class="form-control" name="parent_email" id="parent_email" value="<?=($parents_data) ? $parents_data->personal_data_email : ''?>">
            </div>
            <div class="form-group">
                <label for="parent_phone" class="required_text">Parent Phone</label>
                <input type="text" class="form-control" name="parent_phone" id="parent_phone" value="<?=($parents_data) ? $parents_data->personal_data_cellular : ''?>">
            </div>
            <div class="form-group">
                <label for="job_title">Job Title</label>
                <input type="text" class="form-control" name="occupation" id="occupation" value="<?=($parents_data) ? $parents_data->ocupation_name : ''?>">
                <input type="hidden" name="occupation_id" id="occupation_id" value="<?=($parents_data) ? $parents_data->ocupation_id : ''?>" placeholder="occupation_id">
            </div>
            <div class="form-group">
                <label for="company_name">Company Name</label>
                <input type="text" class="form-control" name="company_name" id="company_name" value="<?=($parents_data) ? $parents_data->institution_name : ''?>">
                <input type="hidden" name="company_id" id="company_id" value="<?=($parents_data) ? $parents_data->institution_id : ''?>" placeholder="institution_id">
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-primary" id="save_parent_data">Save</button>
    </div>
</div>

<?=modules::run('candidate/questionnaire/load_questionnaire_modal', 1)?>

<script type="text/javascript">
    $(function() {
	    $('span#hidden_agenda').on('click', function(){
			$('div#modal_question_section_1').modal('toggle');
		});
		
        $('input#company_name').autocomplete({
			source: function(request, response){
				var url = "<?=site_url('candidate/parent_data/get_institution_by_name')?>";
				var data = {
					term: request.term
				};
				$.post(url, data, function(rtn){
					if(rtn.code == 0){
						var arr = [];
						arr = $.map(rtn.data, function(m){
							return {
								id: m.institution_id,
								value: m.institution_name
							};
						});
						response(arr);
					}else{
						var arr = [];
						response(arr);
					}
				}, 'json');
			},
			select: function(event, ui){
				$('input#company_id').val(ui.item.id);
			},
			change: function(event, ui){
				if(ui.item === null){
					$('input#company_id').val('');
				}
			}
		});
		
		$('input#occupation').autocomplete({
			source: function(request, response){
				var url = "<?=site_url('candidate/parent_data/get_occupation_by_name')?>";
				var data = {
					term: request.term
				};
				$.post(url, data, function(rtn){
					if(rtn.code == 0){
						var arr = [];
						arr = $.map(rtn.data, function(m){
							return {
								id: m.ocupation_id,
								value: m.ocupation_name
							};
						});
						response(arr);
					}
				}, 'json');
			},
			select: function(event, ui){
				$('input#occupation_id').val(ui.item.id);
			},
			change: function(event, ui){
				if(ui.item === null){
					$('input#occupation_id').val('');
				}
			}
		});

        $('button#save_parent_data').on('click', function(e) {
            e.preventDefault();
			$.blockUI();

            var data = $('form#form_edit_parent_data').serialize();
            var url = '<?= base_url()?>candidate/parent_data/save_parent_data';

            $.post(url, data, function(res) {
                if (res.code == 0) {
					$.unblockUI();
                    $('div#alert_wrapper').removeClass('d-none');
					$('div#text_alert_wrapper').addClass('alert-success');
					$('div#text_alert_wrapper').html(res.message);
					setTimeout(function(){
						$('div#alert_wrapper').addClass('d-none');
						$('div#text_alert_wrapper').removeClass('alert-success');
						window.location.replace('<?=site_url('candidate/education')?>');
					}, 5000);
                }else{
					$.unblockUI();
                    $('div#alert_wrapper').removeClass('d-none');
					$('div#text_alert_wrapper').addClass('alert-warning');
					$('div#text_alert_wrapper').html(res.message);
					setTimeout(function(){
						$('div#alert_wrapper').addClass('d-none');
						$('div#text_alert_wrapper').removeClass('alert-warning');
					}, 5000);
                }
				$('html, body').animate({
					scrollTop: $('div#alert_wrapper')
				});
            }, 'json').fail(function(xhr, txtStatus, errThrown) {
				$.unblockUI();
				$('div#alert_wrapper').removeClass('d-none');
				$('div#text_alert_wrapper').addClass('alert-warning');
				$('div#text_alert_wrapper').html('Error processing your data!');
				setTimeout(function(){
					$('div#alert_wrapper').addClass('d-none');
					$('div#text_alert_wrapper').removeClass('alert-warning');
				}, 5000);
				$('html, body').animate({
					scrollTop: $('div#alert_wrapper')
				});
			});
        })
    });
</script>
