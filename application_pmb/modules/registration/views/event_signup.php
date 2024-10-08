<div class="row">
    <div class="col text-center my-auto">
        <div class="p-3">
<!--             <h3>Welcome IULI's to <?=$event_data->event_name?>!</h3> -->
			<h3>IULI <?=$event_data->event_name?></h3>
			<h3><?=date('j F, Y G:i', strtotime($event_data->event_start_date))?> - <?=date('G:i', strtotime($event_data->event_end_date))?></h3>
        </div>
        <i class="fas fa-sign-in-alt fa-2x" aria-hidden="true"></i>
        <h4>Please sign up</h4>
        <i class="far fa-calendar-check fa-2x"></i>
        <h4>to secure a place at the event,</h4>
        <i class="fas fa-file-signature fa-2x" aria-hidden="true"></i>
        <h4>to get a free entrance test,</h4>
        <i class="fas fa-gifts fa-2x" aria-hidden="true"></i>
        <h4>and to get a chance to win an e-scooter!</h4>
    </div>
    <div class="col text-center">
        <h3>Registration Form</h3>
        <hr/>
        <form method="post" id="registration_form">
	        <input type="hidden" id="event_id" name="event_id" value="<?=$event_data->event_id?>">
	        <div class="form-group">
		        <div class="input-group mb-3">
	                <div class="input-group-prepend">
		                <span class="input-group-text">
		                    <i class="fa fa-user"></i>
		                </span>
	                </div>
	                <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Fullname" required="true" autofocus="true">
	            </div>
	        </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-at"></i>
                </span>
                </div>
                <input class="form-control" type="email" id="email" name="email" placeholder="Email" required="true">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-phone"></i>
                </span>
                </div>
                <input class="form-control" type="tel" id="mobile_phone" name="mobile_phone" placeholder="Mobile Phone" required="true" oninput="this.value=this.value.replace(/[^\d\+]/,'')">
            </div>
            <div class="input-group mb-3">
	            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-graduation-cap"></i>
                </span>
                </div>
                <select class="form-control" id="booking_seat" name="booking_seat">
	                <option value="1">1</option>
	                <option value="2">2</option>
	                <option value="3">3</option>
	                <option value="4">4</option>
                </select>
            </div>
            <button class="btn btn-block btn-facebook" type="submit">Register</button>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('form#registration_form').on('submit', function(e) {
            e.preventDefault();
            $.blockUI();

            var data = $('form#registration_form').serialize();
            $.post(base_url+'registration/register_event', data, function(result){
                $.unblockUI();
                console.log(result);
                if (result.code == 0){
                    Swal.fire({
                        title: 'Success',
                        text: 'Your registration details will be sent to your email',
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
                }
                else{
                    swal.fire('Error', result.message,'error');
                }
            }, 'json').fail(function(xhr, txtStatus, errThrown) {
                $.unblockUI();
                console.log({ xhr, txtStatus, errThrown });
            });
            return false;
        })
    });
</script>