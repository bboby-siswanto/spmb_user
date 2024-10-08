<?php
if ((isset($question_master)) AND ($question_master)) {
?>
<div class="modal" id="modal_question_section_<?=$question_master->question_section_id?>" tabindex="-1" role="dialog" 
	data-backdrop="static"
	data-keyboard="false"
	>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?=$question_master->question_section_name?></h5>
			</div>
			<div class="modal-body">
				<?=modules::run('questionnaire/load_section', $question_master->question_section_id)?>
			</div>
		</div>
	</div>
</div>

<script>
	let qa_<?=$question_master->question_section_id?> = '<?=$questionnaire_answered?>';
	if(qa_<?=$question_master->question_section_id?> == 1){
		$('div#modal_question_section_<?=$question_master->question_section_id?>').modal('toggle');
	}
</script>
<?php
}
?>