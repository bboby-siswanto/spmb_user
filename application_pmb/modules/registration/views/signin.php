<div class="row">
    <div class="col text-center my-auto">
        <div class="p-3">
            <h3>Welcome IULI's candidate!</h3>
            <p>Use the form on the right to proceed with your existing account. </p>
        </div>
    </div>
    <div class="col text-center">
        <h3>Authentication</h3>
        <hr/>
        <form id="form_login">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-at"></i>
                </span>
                </div>
                <input class="form-control" type="text" autocomplete="off" placeholder="IULI ID/Email" name="email" autofocus="true" required="true">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>
                </div>
                <input class="form-control" type="password" placeholder="Password" name="password" required="true">
            </div>
            <button id="btn_signin" class="btn btn-block btn-facebook" type="submit">Sign In</button>
        </form>
        <div class="mt-2">
            <div class="row">
                <div class="col-6">
                    <a href="<?= base_url()?>" class="btn btn-block btn-success">
                        <span>Create Account</span>
                    </a>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#forgot_password_modals">
                        <span>Forgot Password</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="forgot_password_modals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Forget Password</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" id="form_forget_password" onsubmit="return false">
                <label>Enter your email to reset your password:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-at"></i>
                    </span>
                    </div>
                    <input class="form-control" type="email" placeholder="Email" id="email" name="email">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            <button class="btn btn-info" type="button" id="submit_form_forget_password">Request</button>
        </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#form_login').on('submit', function(e) {
            e.preventDefault();
            $.blockUI();
            var data = $("#form_login").serialize();
            $.post(base_url+'registration/Auth/login', data, function(result) {
                $.unblockUI();
                if (result.code == 0) {
                    window.location.href = result.redirect;
                } else if (result.code == 44){
                    swal.fire({
                        type:'warning',
                        title:'Warning!',
                        text:'Please sign in on the IULI portal'
                    }).then(res => {
                        window.location.href = result.redirect;
                    });
                }else{
                    swal.fire('', result.message, 'warning');
                }
            }, 'json').fail(function(xhr, txtStatus, errThrown) {
                swal.fire('Warning!', 'Unable to login', 'error');
                $.unblockUI();
                console.log('err:'+txtStatus);
            });

            return false;
        })

        $('button#submit_form_forget_password').on('click', function(e) {
            e.preventDefault();
            $.blockUI();

            var data = $('#form_forget_password').serialize();
            $.post(base_url+'registration/Auth/forget_password', data, function(result) {
                $.unblockUI();
                if (result.code == 0) {
                    swal.fire({
                        type:'success',
                        title:'Success',
                        text:'Email has been sending to your email account, please check your email'
                    }).then(res => {
                        $('#forgot_password_modals').modal('hide');
                    });
                } else {
                    swal.fire('Error', result.message, 'warning');
                }
            }, 'json').fail(function(xhr, txtStatus, errThrown) {
                $.unblockUI();
                console.log('err:'+txtStatus);
            });
        });
    });
</script>