<div class="row">
    <div class="col text-center my-auto">
        <div class="p-3">
            <h3>Welcome IULI's candidate!</h3>
            <p>Use the form on the right to activated your account. </p>
        </div>
    </div>
    <div class="col text-center">
        <h3>Set your password</h3>
        <hr/>
        <form id="form_reset">
            <input type="hidden" id="personal_data_id" name="personal_data_id" value="<?= $personal_data_id; ?>">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                </div>
                <input class="form-control" type="password" placeholder="Password" id="password" name="password" autofocus="true" required="true">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                </div>
                <input class="form-control" type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required="true">
            </div>
            <button class="btn btn-block btn-success" type="submit">Confirm Password</button>
        </form>
    </div>
</div>
<script>
    $(function() {
        $('#form_reset').on('submit', function(e) {
            e.preventDefault();
            $.blockUI();
            
            var data = $("#form_reset").serialize();
            $.post(base_url+'registration/Auth/activated_password', data, function(result) {
                $.unblockUI();
                if (result.code == 0) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Your account has been activated, please log in with your email and new password',
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
                } else {
                    swal.fire('Error', result.message, 'warning');
                }
            }, 'json').fail(function(xhr, txtStatus, errThrown) {
                $.unblockUI();
                console.log('err:'+txtStatus);
            });

            return false;
        });
    });
</script>