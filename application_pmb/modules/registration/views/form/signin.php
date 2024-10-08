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
            <button type="button" class="btn btn-block btn-success" id="btn-signup-registration">
                <span>Create Account</span>
            </button>
        </div>
        <div class="col-6">
        <?php
        // if ($_SERVER['REMOTE_ADDR'] == '202.93.225.254') {
        ?>
            <button type="button" class="btn btn-block btn-warning" data-toggle="modal" data-target="#forgot_password_modals">
                <span>Forgot Password</span>
            </button>
        <?php
        // }
        ?>
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
                <div class="form-input" id="form-input">
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
                <div class="form-found d-none text-left" id="form-found">
                    <label>Account found:</label>
                    <p><i class="fas fa-user"></i> <span id="found-name"></span></p>
                    <p><i class="fas fa-envelope"></i> <span id="found-email"></span></p>
                    <p><i class="fas fa-phone"></i> <span id="found-cellular"></span></p>
                </div>
            </div>
            <div class="modal-footer" id="footer-forget">
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
        });

        $('#btn-signup-registration').on('click', function(e) {
            e.preventDefault();
            console.log('click');
            var anim = animateCanvas('#signin_page', '#registration_page');
        });

        $('button#submit_form_forget_password').on('click', function(e) {
            e.preventDefault();
            $.blockUI({ baseZ: 2000 });

            var data = $('#form_forget_password').serialize();
            $.post(base_url+'registration/Auth/forget_password', data, function(result) {
            // $.post(base_url+'registration/Auth/check_user', data, function(result) {
                $.unblockUI();
                // console.log(result);
                // if (result.code == 0) {
                //     var datares = result.data;
                //     // $('#found-name').html(datares.pname);
                //     // $('#found-email').html(datares.pemail);
                //     // $('#found-cellular').html(datares.pnumber);

                //     // $('#footer-forget').addClass('d-none');
                //     // $('#form-found').removeClass('d-none');
                //     // $('#form-input').addClass('d-none');
                //     // $('#swal2-content').addClass('text-left');
                    
                //     Swal.fire({
                //         title: '<strong>Account found!</strong>',
                //         icon: 'info',
                //         html:
                //             '<div class="text-left"><p></p>' + 
                //             '<p><i class="fas fa-user"></i> ' + datares.pname + '</p>' +
                //             '<p class="text-lowercase"><i class="fas fa-envelope"></i> ' + datares.pemail + '</p>' +
                //             '<p class="text-lowercase"><i class="fas fa-phone"></i> ' + datares.pnumber + '</p>' +
                //             '<p></p><p>Please select one of the following options to send a password reset link!</p>' +
                //             '</div>' +
                //             '<button type="button" class="btn btn-success btn-block mr-4" id="btn_send_email">Email</button>' +
                //             '<button type="button" class="btn btn-primary btn-block mr-4" id="btn_send_whatsapp">Whatsapp (if available)</button>' +
                //             '<button type="button" class="btn btn-secondary btn-block btn_send_cancel">Cancel</button>',
                //         showCloseButton: false,
                //         showCancelButton: false,
                //         showConfirmButton: false,
                //     });
                // }
                // else {
                //     swal.fire('Error', result.message, 'warning');
                // }
                if (result.code == 0) {
                    swal.fire({
                        type:'success',
                        title:'Success',
                        text:'Email has been sending to your email account, please check your email'
                    }).then(res => {
                        $('#forgot_password_modals').modal('hide');
                    });
                } else {
                    
                }
            }, 'json').fail(function(xhr, txtStatus, errThrown) {
                $.unblockUI();
                console.log('err:'+txtStatus);
            });
        });

        $('.btn_send_cancel').on('click', function(e) {
            e.preventDefault();

            console.log('click cancel');
            Swal.close();
        });
    });
</script>