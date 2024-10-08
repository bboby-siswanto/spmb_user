<?php
if(!is_null($personal_data->personal_data_date_of_birth)){
	$dobDate = date('d', strtotime($personal_data->personal_data_date_of_birth));
	$dobMonth = date('m', strtotime($personal_data->personal_data_date_of_birth));
	$dobYear = date('Y', strtotime($personal_data->personal_data_date_of_birth));
}
else{
	$dobDate = $dobMonth = $dobYear = null;
}
?>

<div class="card">
    <div class="card-header"><?= $pageChildTitle ?> <span id="hidden_agenda">Form</span></div>
    <div class="card-body">
        <div class="row">
            <div class="form-group m-form__group m--margin-top-10 d-none col" id="alert_wrapper">
				<div class="alert m-alert m-alert--default" id="text_alert_wrapper" role="alert"></div>
			</div>
            <form method="post" id="form_edit_personal_data" onsubmit="return false;" class="w-100">
                <input id="personal_data_id" name="personal_data_id" type="hidden" value="<?=$personal_data->personal_data_id?>">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="required_text">Email</label>
                        <input class="form-control" id="email" name="email"type="email" value="<?=$personal_data->personal_data_email?>" <?=($personal_data->personal_data_email_confirmation == 'yes') ? 'disabled' : ''?>>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="phone_number">Phone Number</label>
                                <input class="form-control" id="phone_number" name="phone_number" type="text" value="<?=$personal_data->personal_data_phone?>" <?=($personal_data->personal_data_email_confirmation == 'yes') ? 'disabled' : ''?>>
                            </div>
                            <div class="col-sm-6">
                                <label for="cellular_number" class="required_text">Cellular Number</label>
                                <input class="form-control" id="cellular_number" name="cellular_number" type="text" value="<?=$personal_data->personal_data_cellular?>" <?=($personal_data->personal_data_email_confirmation == 'yes') ? 'disabled' : ''?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="identification_number" class="required_text">Your Identification Number (KTP / Passport)</label>
                        <input type="text" class="form-control" id="identification_number" name="identification_number" value="<?=$personal_data->personal_data_id_card_number?>">
                    </div>
                    <div class="form-group">
                        <label for="birth_place" class="required_text">Place of Birth</label>
                        <input type="text" class="form-control" id="birth_place" name="birth_place" value="<?=$personal_data->personal_data_place_of_birth?>">
                    </div>
                    <div class="form-group">
                        <label class="required_text">Birthday</label>
                        <div class="row">
                            <div class="col">
                                <select name="date_of_birth" id="date_of_birth" class="form-control">
                                    <option value="">---</option>
                                    <?php
                                        for ($i=1; $i <=31 ; $i++) { 
                                    ?>
                                    <option value="<?=$i?>" <?= ($dobDate==$i)?'selected':''; ?>><?=$i?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="month_of_birth" id="month_of_birth" class="form-control">
                                    <option value="">---</option>
                                    <?php
                                        for ($i=0; $i < count($month_list) ; $i++) { 
                                            $x = $i+1;
                                    ?>
                                        <option value="<?=$x?>" <?= ($dobMonth==$x)?'selected':'' ?>><?= $month_list[$i] ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="year_of_birth" id="year_of_birth" class="form-control">
                                    <option value="">---</option>
                                    <?php
                                        for ($i=$year_now; $i >= $year_start; $i--) { 
                                    ?>
                                    <option value="<?=$i?>" <?= ($dobYear==$i)?'selected':'' ?>><?=$i?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-12 text-danger">
                                <small>Please be extra careful with your birthday. Candidates often place current year as their birthday</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birth_country" class="required_text">Country of Birth</label>
                        <input type="text" class="form-control" id="birth_country" name="birth_country" value="<?= $personal_data->birth_country ?>">
                        <input type="hidden" id="birth_country_id" name="birth_country_id" value="<?=$personal_data->country_of_birth?>">
                    </div>
                    <div class="form-group">
                        <label for="gender" class="required_text">Gender</label>
                        <select type="text" class="form-control" id="gender" name="gender">
                            <option value="">---</option>
                            <option value="M" <?= ($personal_data->personal_data_gender == 'M') ? 'selected' : ''; ?>>Male</option>
                            <option value="F" <?= ($personal_data->personal_data_gender == 'F') ? 'selected':'' ; ?>>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="religion" class="required_text">Religion</label>
                        <select class="form-control" id="religion" name="religion">
                            <option value="">---</option>
                            <?php
                                if ($list_religion) {
                                    foreach ($list_religion as $list) {
                            ?>
                                        <option value="<?= $list->religion_id?>" <?= ($personal_data->religion_id==$list->religion_id) ? 'selected' : '' ?>><?=$list->religion_name?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="gender" class="required_text">Nationality</label>
                                <select type="text" class="form-control" id="nationality" name="nationality">
                                    <option value="">---</option>
                                    <option value="WNI" <?= ($personal_data->personal_data_nationality == 'WNI') ? 'selected' : '' ?>>WNI</option>
                                    <option value="WNA" <?= ($personal_data->personal_data_nationality == 'WNA') ? 'selected' : '' ?>>WNA</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="citizenship" class="required_text">Citizenship</label>
                                <input type="text" class="form-control" id="citizenship_name" name="citizenship_country_name" value="<?=$personal_data->city_country?>">
                                <input type="hidden" id="citizenship_id" name="citizenship_id" value="<?=$personal_data->citizenship_id?>">
                            </div>
                        </div>
                    </div>
                    <label><b>Your Address Data</b></label>
                    <input type="hidden" id="address_id" name="address_id" value="<?=$personal_data->personal_address_id?>">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="country" class="required_text">Country</label>
                                <input type="text" class="form-control" id="address_country_name" name="address_country_name" value="<?= $personal_data->address_country; ?>">
                                <input type="hidden" name="address_country_id" id="address_country_id" value="<?= $personal_data->citizenship_id;?>">
                            </div>
                        </div>
                        <!-- <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="address_province">Province</label>
                                <input type="text" class="form-control" id="address_province" name="address_province" value="<?= $personal_data->address_province?>">
                            </div>
                        </div> -->
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="city" class="required_text">City</label>
                                <input type="text" class="form-control" id="address_city" name="address_city" value="<?=$personal_data->address_city?>">
                            </div>
                        </div>
                        <!-- <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="address_street">Street</label>
                                <input type="text" class="form-control" id="address_street" name="address_street" value="<?= $personal_data->address_street?>">
                            </div>
                        </div> -->
                        <!-- <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="address_district">District / Kecamatan</label>
                                <input type="text" class="form-control" id="address_district" name="address_district" value="<?=(isset($personal_data->nama_wilayah)) ? $personal_data->nama_wilayah : ''?>">
                                <input type="hidden" name="address_district_id" id="address_district_id" value="<?=(isset($personal_data->dikti_wilayah_id)) ? $personal_data->dikti_wilayah_id : ''?>">
                                <span class="text-danger"><small>You will see the suggestions after typing at least 3 letters. Select ONLY from the suggestion provided</small></span>
                            </div>
                        </div> -->
                        <!-- <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="sub_district">Sub-District / Kelurahan</label>
                                <input type="text" class="form-control" id="address_sub_district" name="address_sub_district" value="<?=$personal_data->address_sub_district ?>">
                            </div>
                        </div> -->
                        <!-- <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="rt">RT</label>
                                <input type="text" class="form-control" id="rt" name="rt" maxlength="3" value="<?=$personal_data->address_rt?>">
                            </div>
                        </div> -->
                        <!-- <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="rw">RW</label>
                                <input type="text" class="form-control" id="rw" name="rw" maxlength="3" value="<?=$personal_data->address_rw?>">
                            </div>
                        </div> -->
                        <!-- <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="zip_code">ZIP Code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?=$personal_data->address_zipcode?>">
                            </div>
                        </div> -->
                    </div>
                    <label><b>Your Reference Code</b></label>
                    <div class="row">
	                    <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="reference_code"><a target="_blank" href="https://www.iuli.ac.id/admissions/info/student-referral-program/">Reference code</a></label>
                                <input type="text" class="form-control" id="reference_code" name="reference_code" value="<?=($sgs_data) ? $sgs_data->sgs_code : ''?>" <?=($sgs_data) ? 'disabled' : ''?>>
                                <span class="text-muted">
                                	<small><a target="_blank" href="https://www.iuli.ac.id/admissions/info/student-referral-program/">Reference code</a> usually starts with SGSXX.XXX OR REFXX.XXX.</small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card-footer">
        <button type="button" id="save_personal_data" class="btn btn-primary">Save</button>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var completed_data = '<?=$has_completed_data;?>';
        var program_id = '<?=($student_data) ? $student_data->program_id : "";?>';
        console.log(program_id);
        
        function countryAutocomplete(el, idcontainer){
            el.autocomplete({
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
					idcontainer.val(id);
				},
				change: function(event, ui){
					if(ui.item === null){
						idcontainer.val('');
						el.val('');
						swal.fire('Please use the selection provided');
					}
				}
			});
		};
		
		countryAutocomplete($('input#birth_country'), $('input#birth_country_id'));
		countryAutocomplete($('input#citizenship_name'), $('input#citizenship_id'));
        countryAutocomplete($('input#address_country_name'), $('input#address_country_id'));
		
		$('span#hidden_agenda').on('click', function(){
			$('div#modal_how_did_you_know').modal('toggle');
		});
		
        // $('input#address_district').autocomplete({
		// 	minLength: 3,
		// 	source: function(request, response){
        //         var url = '<?=site_url('candidate/profile/get_wilayah_by_name')?>';
        //         var data = {
        //             term: request.term
        //         };
                
        //         $.post(url, data, function(rtn){
        //             if(rtn.code == 0){
        //                 var arr = [];
        //                 arr = $.map(rtn.data, function(m){
        //                     return {
        //                         id: m.id_wilayah,
        //                         value: m.nama_wilayah
        //                     }
        //                 });
        //                 response(arr);
        //             }
        //         }, 'json').fail(function(xhr, textStatus, errorThrown) {
        //             console.log(xhr.responseText);
        //         });
		// 	},
		// 	select: function(event, ui){
		// 		var id = ui.item.id;
		// 		$('input#address_district_id').val(id);
		// 	},
		// 	change: function(event, ui){
		// 		if(ui.item === null){
        //             $('input#address_district').val('');
		// 			$('input#address_district_id').val('');
		// 			swal.fire('Please use the selection provided');
		// 		}
		// 	}
		// });
        
        $('button#save_personal_data').on('click', function(e){
            e.preventDefault();
            $.blockUI();
			var form = $('form#form_edit_personal_data');
			var url = "<?=site_url('candidate/profile/save_personal_data')?>";
            var data = form.serialize();
			
			$.post(url, data, function(rtn){
				if(rtn.code == 0){
                    $.unblockUI();

                    if (completed_data == '') {
                        Swal.fire(
                            'Success!',
                            'Thank you for completing all data, then your data will be processed by the admission department, and we will inform you about the test after January 16 2024',
                            'success'
                        );

                        if (program_id == 1){
                            gtag_report_conversion(window.location.href);
                        }
                    }else{
                        $('div#alert_wrapper').removeClass('d-none');
                        $('div#text_alert_wrapper').addClass('alert-success');
                        $('div#text_alert_wrapper').html(rtn.message);
                        setTimeout(function(){
                            $('div#alert_wrapper').addClass('d-none');
                            $('div#text_alert_wrapper').removeClass('alert-success');
                            window.location.reload();
                        }, 5000);
                    }
				}
				else{
                    $.unblockUI();
                    $('div#alert_wrapper').removeClass('d-none');
					$('div#text_alert_wrapper').addClass('alert-warning');
					$('div#text_alert_wrapper').html(rtn.message);
					setTimeout(function(){
						$('div#alert_wrapper').addClass('d-none');
						$('div#text_alert_wrapper').removeClass('alert-warning');
					}, 5000);
				}
				
				$('html, body').animate({
					scrollTop: $('div#alert_wrapper')
				});

            }, 'json').fail( function(xhr, textStatus, errorThrown) {
                $.unblockUI();
	            console.log(xhr.responseText);
	        });
		});
    });

    function gtag_report_conversion(url) {
        var callback = function() {
            if (typeof(url) != 'undefined') {
                window.location = url;
            }
        };

        gtag('event', 'conversion', {
            'send_to': 'AW-640179922/4cQLCL2A7foBENK9obEC',
            'edu_pagetype': ' '
        });
        return false;
    }
</script>