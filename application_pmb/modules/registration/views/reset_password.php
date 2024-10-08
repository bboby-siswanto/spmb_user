<div class="row">
    <div class="col text-center my-auto">
        <div class="p-3">
            <h3>Welcome IULI's candidate!</h3>
            <p>Use the form on the right to reset your password account. </p>
        </div>
    </div>
    <div class="col text-center">
        <h3>Reset your password</h3>
        <hr/>
        <form id="form_reset">
            <input type="hidden" value="<?= $data_personal->personal_data_id;?>" name="personal_data_id" id="personal_data_id">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                </div>
                <input class="form-control" type="password" placeholder="New Password" id="password" name="password" autofocus="true" required="true">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                </div>
                <input class="form-control" type="password" placeholder=" Confirm Password" id="confirm_password" name="confirm_password" required="true">
            </div>
            <button class="btn btn-block btn-facebook" type="submit">Reset Password</button>
        </form>
        <div class="mt-2">
            <div class="row">
                <div class="col-6">
                    <a href="<?= base_url()?>registration/sign_in" class="btn btn-block btn-success">
                        <span>Sign In</span>
                    </a>
                </div>
                <div class="col-6">
                    <a href="<?= base_url()?>registration/sign_up" class="btn btn-block btn-success">
                        <span>Create Account</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#form_reset').on('submit', function(e) {
            e.preventDefault();
            $.blockUI();

            var data = $("#form_reset").serialize();
            $.post(base_url+'registration/Auth/reset_password', data, function(result) {
                $.unblockUI();
                if (result.code == 0) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Password has been successfully changed, please log in with your new password',
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