<div class="card">
    <div class="card-header">
        Job Data
    </div>
    <div class="card-body">
        <form method="post" onsubmit="return false" id="form_employment_data" url="<?=base_url()?>candidate/employment/submit_job_data">
            <input type="hidden" name="history_id" id="history_id" value="<?= ((isset($employment_data)) AND ($employment_data)) ? $employment_data[0]->academic_history_id : ''; ?>">
            <div class="form-group m-form__group m--margin-top-10 d-none col" id="alert_wrapper">
                <div class="alert m-alert m-alert--default" id="text_alert_wrapper" role="alert"></div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-8">
                    <div class="form-group">
                        <label for="employment_company_name">Company Name</label>
                        <input type="text" name="employment_company_name" id="employment_company_name"  class="form-control" value="<?= ((isset($employment_data)) AND ($employment_data)) ? $employment_data[0]->institution_name : ''; ?>">
                        <input type="hidden" name="institution_id" id="institution_id" placeholder="institution id" value="<?= ((isset($employment_data)) AND ($employment_data)) ? $employment_data[0]->institution_id : ''; ?>">
                        <input type="hidden" name="company_found_status" id="company_found_status" placeholder="company found status" value="<?= ((isset($employment_data)) AND ($employment_data)) ? '1' : '0'; ?>">
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="form-group">
                        <label for="employment_job_title">Job Title</label>
                        <input type="text" class="form-control" id="employment_job_title" name="employment_job_title" value="<?= ((isset($employment_data)) AND ($employment_data)) ? $employment_data[0]->ocupation_name : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-5">
                    <div class="form-group">
                        <label for="employment_company_addess">Address</label>
                        <textarea name="employment_company_addess" id="employment_company_addess" class="form-control">
                            <?= ((isset($employment_data)) AND ($employment_data)) ? trim($employment_data[0]->address_street) : ''; ?>
                        </textarea>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group">
                        <label for="employment_company_city">City</label>
                        <input type="text" class="form-control" id="employment_company_city" name="employment_company_city" value="<?= ((isset($employment_data)) AND ($employment_data)) ? $employment_data[0]->address_city : ''; ?>">
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="form-group">
                        <label for="employment_company_country">Country</label>
                        <select name="employment_company_country" id="employment_company_country" class="form-control">
                        <option value=""></option>
                <?php
                if ($country_list) {
                    foreach ($country_list as $key => $value) {
                        $selected = ((isset($employment_data)) AND ($employment_data) AND ($employment_data[0]->country_id == $value->country_id)) ? 'selected="selected"' : '';
                ?>
                        <option value="<?=$value->country_id;?>" <?=$selected;?>><?=$value->country_name;?></option>
                <?php
                    }
                }
                ?>
                    </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="employment_company_phone">Phone Number</label>
                                <input type="text" class="form-control" id="employment_company_phone" name="employment_company_phone" value="<?= ((isset($employment_data)) AND ($employment_data)) ? $employment_data[0]->institution_phone_number : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="employment_company_email">Email</label>
                                <input type="text" class="form-control" id="employment_company_email" name="employment_company_email" value="<?= ((isset($employment_data)) AND ($employment_data)) ? $employment_data[0]->institution_email : ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="employment_start_date">Start Working Date</label>
                                <input type="date" class="form-control" id="employment_start_date" name="employment_start_date" value="<?= ((isset($employment_data)) AND ($employment_data)) ? $employment_data[0]->academic_year_start_date : ''; ?>">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="employment_end_date">End Working Date</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="employment_end_date" id="employment_end_date" value="<?= ((isset($employment_data)) AND ($employment_data)) ? $employment_data[0]->academic_year_end_date : '' ?>" <?= ((isset($employment_data)) AND ($employment_data) AND (is_null($employment_data[0]->academic_year_end_date))) ? 'readonly=""' : '' ?>>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="is_available" name="is_available" <?= ((isset($employment_data)) AND ($employment_data) AND (is_null($employment_data[0]->academic_year_end_date))) ? 'checked' : 'false' ?>>
                                            <input type="hidden" name="string_still_working" id="string_still_working" value="<?= ((isset($employment_data)) AND ($employment_data) AND (is_null($employment_data[0]->academic_year_end_date))) ? 'yes' : 'no' ?>">
                                            <label class="custom-control-label" for="is_available">Still working</label>
                                        </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-info" id="btn_submit_employment">Submit</button>
    </div>
</div>
<script>
$(function() {
    $('#is_available').on('change', function(e) {
        e.preventDefault();

        if (this.checked) {
            $('input#employment_end_date').attr('readonly','true');
            $('input#string_still_working').val('yes');
        }else{
            $('input#employment_end_date').removeAttr('readonly');
            $('input#string_still_working').val('no');
        }
    });

    $('#employment_company_country').select2({
        allowClear: true,
        placeholder: "Please select..",
        theme: "bootstrap",
        minimumInputLength: 2
    });

    $('input#employment_company_name').autocomplete({
        autoFocus: true,
        minLength: 1,
        // appendTo: 'div#new_job_history_modal, div#modal_new_job_vacancy',
        source: function(request, response){
            var url = '<?=site_url('candidate/employment/get_institution_suggestions')?>';
            var data = {
                term: request.term
            };
            $.post(url, data, function(rtn){
                if(rtn.data){
                    var arr = [];
                    arr = $.map(rtn.data, function(m){
                        var inst_name = m.institution_name;
                        return {
                            id: m.institution_id,
                            value: inst_name.replace('&amp;', '&'),
                            edu_data: m
                        };
                    });
                    response(arr);
                    // $('small#text_company_not_found').addClass('d-none');
                }
                else{
                    $("#employment_company_name").autocomplete('close');
                    $('input#institution_id').val('');
                    // $('small#text_company_not_found').removeClass('d-none');
                }
            }, 'json');
        },
        select: function(event, ui){
            var id = ui.item.id;
            var edu_data = ui.item.edu_data;
            // locked_input.prop('disabled', true);
            // $('input#institution_id').val(id);
            $('input#company_found_status').val('1');
            $('textarea#institution_address').val(edu_data.address_street);
            $('input#institution_phone_number').val(edu_data.institution_phone_number);
            $('input#institution_email').val(edu_data.institution_email);
            // $('input#institution_zipcode').val(edu_data.address_zipcode);
            // $('input#institution_country').val(edu_data.country_name);
            // $('input#institution_country_id').val(edu_data.country_id);
            $('#institution_country_id').val(edu_data.country_id).trigger('change');
            // $('input#institution_province').val(edu_data.address_province);
            $('input#institution_city').val(edu_data.address_city);
            
        },
        change: function(event, ui){
            if(ui.item === null){
                $('textarea#institution_address').val('');
                $('input#institution_phone_number').val('');
                $('input#institution_email').val('');
                // $('input#institution_zipcode').val('');
                // $('input#institution_country').val('');
                // $('input#institution_country_id').val('');
                $('#institution_country_id').val('').trigger('change');
                // $('input#institution_province').val('');
                $('input#institution_city').val('');

                $('input#institution_id').val('');
                $('input#company_found_status').val('0');
            }
        }
    });
    
    $('input#employment_job_title').autocomplete({
        autoFocus: true,
        minLength: 1,
        // appendTo: 'div#new_job_history_modal, div#modal_new_job_vacancy',
        source: function(request, response){
            var url = '<?=site_url('candidate/employment/get_occupation_suggestions')?>';
            var data = {
                term: request.term
            };
            $.post(url, data, function(rtn){
                if(rtn.data){
                    var arr = [];
                    arr = $.map(rtn.data, function(m){
                        return {
                            id: m.ocupation_name,
                            value: m.ocupation_name,
                            edu_data: m
                        };
                    });
                    response(arr);
                    // $('small#text_company_not_found').addClass('d-none');
                }
                else{
                    $("#employment_job_title").autocomplete('close');
                }
            }, 'json');
        },
        select: function(event, ui){
            var id = ui.item.id;
            var edu_data = ui.item.edu_data;
        },
        change: function(event, ui){
            // if(ui.item === null){
            //     $('textarea#institution_address').val('');
            //     $('input#institution_phone_number').val('');
            //     $('input#institution_email').val('');
            //     // $('input#institution_zipcode').val('');
            //     // $('input#institution_country').val('');
            //     // $('input#institution_country_id').val('');
            //     $('#institution_country_id').val('').trigger('change');
            //     // $('input#institution_province').val('');
            //     $('input#institution_city').val('');
            // }
        }
    });

    $('#btn_submit_employment').on('click', function(e) {
        e.preventDefault();
        $.blockUI();
        var form = $('#form_employment_data');
        var data = form.serialize();
        var url = form.attr('url');

        $.post(url, data, function(result) {
            $.unblockUI();
            if (result.code == 0) {
                $('div#alert_wrapper').removeClass('d-none');
                $('div#text_alert_wrapper').addClass('alert-success');
                $('div#text_alert_wrapper').html("Success");
                setTimeout(function(){
                    window.location.replace('<?=site_url('candidate/employment')?>');
                    $('div#alert_wrapper').addClass('d-none');
                    $('div#text_alert_wrapper').removeClass('alert-success');
                }, 5000);
            }
            else {
                // toastr.warning(result.message, "Warning!");
                $('div#alert_wrapper').removeClass('d-none');
                $('div#text_alert_wrapper').addClass('alert-warning');
                $('div#text_alert_wrapper').html(result.message);
                setTimeout(function(){
                    $('div#alert_wrapper').addClass('d-none');
                    $('div#text_alert_wrapper').removeClass('alert-warning');
                },7000);
            }
        }, 'json').fail(function(params) {
            $.unblockUI();
            // toastr.error('Error processing your data!');
            $('div#alert_wrapper').removeClass('d-none');
            $('div#text_alert_wrapper').addClass('alert-danger');
            $('div#text_alert_wrapper').html("error processing your data");
            setTimeout(function(){
                $('div#alert_wrapper').addClass('d-none');
                $('div#text_alert_wrapper').removeClass('alert-danger');
            },7000);
        });
    });
});
</script>