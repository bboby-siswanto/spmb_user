<div class="card">
    <div class="card-header">
        Job History
        <div class="card-header-actions">
            <a href="<?=base_url()?>candidate/employment/submit_employment" class="card-header-action btn btnk-link">
                <i class="fa fa-plus"></i> Employement Data
            </a>
            <!-- <button class="card-header-action btn btn-link" id="btn_new_employment">
                <i class="fa fa-plus"></i> Employement Data
            </button> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="job_list" class="table table-hover">
                <thead>
                    <tr class="bg-dark">
                        <th>Company</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <!-- <th>Country</th>
                        <th>City</th> -->
                        <th>Working Date</th>
                        <th>Job Title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            if ((isset($employment_data)) AND ($employment_data)) {
                foreach ($employment_data as $o_job_data) {
            ?>
                    <tr>
                        <td><?=$o_job_data->institution_name;?></td>
                        <td><?=$o_job_data->address_street.' '.$o_job_data->address_city.' '.$o_job_data->country_name;?></td>
                        <td><?=$o_job_data->institution_phone_number;?></td>
                        <td><?=$o_job_data->institution_email;?></td>
                        <td><?=date('d F Y', strtotime($o_job_data->academic_year_start_date)).((!is_null($o_job_data->academic_year_end_date)) ? ' - '.date('d F Y', strtotime($o_job_data->academic_year_end_date)) : '');?></td>
                        <td><?=$o_job_data->ocupation_name;?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="<?=base_url()?>candidate/employment/submit_employment/<?=$o_job_data->academic_history_id;?>" target="blank" class="btn btn-warning btn-sm" title="update"><i class="fas fa-edit"></i></a>
                            </div>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
var job_list = $('#job_list').DataTable({
    paging: false,
    "columnDefs": [
        {"searchable": false, "orderable":false, "targets": 6}
    ]
});
</script>