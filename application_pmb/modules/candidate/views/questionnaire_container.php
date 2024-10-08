<div class="card">
	<div class="card-header">
		Please answer the following to continue.
	</div>
	<div class="card-body">
		<form id="form_questionnaire_<?=$question_master->question_section_id?>" action="<?=site_url('candidate/questionnaire/submit_questionnaire')?>">
			<input type="hidden" id="question_section_id" name="question_section_id" value="<?=$question_master->question_section_id?>">
		<?php
		$iteration = 0;
		foreach($questions as $question){
		?>
		<!-- <div class="form-group form-check">
			<input class="form-check-input" type="radio" name="answers[<?=$question->question_id?>][value]" id="question_section_group_<?=$question->question_section_group_id;?>">
			<label class="form-check-label" for="question_section_group_<?=$question->question_section_group_id;?>"><?=$question->question_content?></label>
			<?php
			if($question->question_has_free_text == 'yes'){
			?>
			<input type="text" class="form-control" name="answers[<?=$question->question_id?>][specify]">
			<?php
			}	
			?>
		</div> -->
		<div class="custom-control custom-radio pb-2">
			<input type="radio" id="question_section_group_<?=$question->question_section_group_id;?>" name="answers" class="custom-control-input" value="<?=$question->question_id?>">
			<label class="custom-control-label" for="question_section_group_<?=$question->question_section_group_id;?>"><?=$question->question_content?></label>
		</div>
		<?php
			$iteration++;
		}	
		?>
			<button type="submit" id="btn_submit_questionnaire" class="btn btn-info">Submit</button>
		</form>
	</div>
</div>

<script>
	$('button#btn_submit_questionnaire').on('click', function(e){
		e.preventDefault();
		// $.blockUI({ message: 'Please wait...' });
		let form = $('form#form_questionnaire_<?=$question_master->question_section_id?>');
		let data = form.serialize();
		let url = form.attr('action');
		// console.log(data);return false;
		
		$.post(url, data, function(rtn){
			// $.unblockUI();
			if(rtn.code == 0){
				$('div#modal_question_section_<?=$question_master->question_section_id?>').modal('toggle');
			}
			else{
				alert(rtn.message);
			}
		}, 'json');
	});
</script>