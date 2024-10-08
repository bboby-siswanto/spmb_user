<div class="card">
    <div class="card-header"><?= $pageChildTitle ?></div>
    <div class="card-body">
        <form method="post" id="upload_supporting_document" onsubmit="return false;">
            <div class="form-group m-form__group m--margin-top-10 d-none" id="alert_wrapper">
				<div class="alert m-alert m-alert--default" id="text_alert_wrapper" role="alert"></div>
			</div>
            <div class="form-group">
                <label for="document_type">Document Type</label>
                <select name="document_type" id="document_type" class="form-control">
                    <option value="">---</option>
                    <?php
					foreach($required_documents as $doc){
					?>
					<option value="<?=$doc->document_id?>"><?=$doc->document_name?></option>
					<?php
					}
					?>
                </select>
            </div>
            <div class="form-group">
                <!-- <label for="document_upload"></label> -->
                <div class="row">
                    <div class="col-md-4">
                        <input type="file">
                    </div>
                </div>
                <small class="text-danger">File should be less than 2MB and allowed extensions are jpg|jpeg|png|pdf</small>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-primary" id="upload_support_document">Save</button>
    </div>
</div>

<div class="card">
    <div class="card-header"><?= $pageChildTitleDocument ?></div>
    <div class="card-body">
    <table class="table table-striped table-bordered table-hover" id="uploaded_document">
            <thead>
                <tr>
                    <th>Document Name</th>
                    <th>Document Requirement Type</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($personal_data_documents){	
                foreach($personal_data_documents as $key => $value){
            ?>
                <tr>
					<td><?=$value->document_name?></td>
                    <td><?=strtoupper(str_replace('_', ' ', $value->document_type_name))?></td>
<!--                     <td><a href="<?= site_url().'application/uploads/'.$personal_data_id.'/'.$value->document_requirement_link; ?>" class="btn btn-success btn-sm">Download</a></td> -->
                    <td><a 
	                    href="<?=site_url('download/attachment/'.$value->document_id.'/'.$personal_data_id)?>" 
		                class="btn btn-success btn-sm"
			            target="_blank"
						>Download</a></td>
				</tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div id="modal_percentage" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Please complete your data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="25" style="width: 5%"></div>
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="25" style="width: 25%"></div>
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="25" style="width: 25%"></div>
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="25" style="width: 25%"></div>
        </div>
        <p></p>
        <div class="progress">
            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="25" style="width: 25%"><a href="#" class="white-color">Personal Data : 100%</a></div>
            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="25" style="width: 25%"><a href="#" class="white-color">Academic History : 0%</a></div>
            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="25" style="width: 25%"><a href="#" class="white-color">Parent Data : 0%</a></div>
            <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="25" style="width: 25%"><a href="#" class="whire-color">Supporting Document : 0%</a></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(function() {
        // $('#modal_percentage').modal('show');
        $('#uploaded_document').DataTable({
            order: [
				[1, 'asc'],
				[0, 'asc']
			],
            "columnDefs": [
                {"searchable": false, "orderable":false, "targets": 2}
            ]
        });

        $('button#upload_support_document').on('click', function(e){
			e.preventDefault();
            $.blockUI();
			var form = $('form#upload_supporting_document');
			
			var formData = new FormData();
			formData.append('document_type', $('select#document_type').val());
			formData.append('file', $('input[type=file]')[0].files[0]);
			formData.append('personal_data_id', '<?=$personal_data_id?>');
			
			var url = '<?= base_url()?>candidate/supporting_document/upload_supporting_document';
			
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				cache: false,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(rtn, status, jqXHR){
					if(rtn.code == 0){
                        $.unblockUI();
						window.location.reload();
					}else{
                        $.unblockUI();
                        $('div#alert_wrapper').removeClass('d-none');
                        $('div#text_alert_wrapper').addClass('alert-danger');
                        $('div#text_alert_wrapper').html(rtn.message);
                        setTimeout(function(){
                            $('div#alert_wrapper').addClass('d-none');
                            $('div#text_alert_wrapper').removeClass('alert-danger');
                        }, 5000);
                    }
				},
                fail: function(xhr, textStatus, errorThrown){
                    $.unblockUI();
                    $('div#alert_wrapper').removeClass('d-none');
                    $('div#text_alert_wrapper').addClass('alert-danger');
                    $('div#text_alert_wrapper').html("Sorry, there was an interruption in our system, and the document was not sent to our admissions team!");
                    setTimeout(function(){
                        $('div#alert_wrapper').addClass('d-none');
                        $('div#text_alert_wrapper').removeClass('alert-danger');
                    }, 5000);
                }
			});
		});
    });
</script>