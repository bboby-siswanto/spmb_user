<div class="form cf">
    <div class="wizard">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li role="presentation" class="nav-item">
                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1" class="nav-link active">
                        <span class="round-tab">
                            <i class="fa fa-university"></i>
                        </span>
                    </a>
                </li>
                <li role="presentation" class="nav-item">
                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2" class="nav-link disabled">
                        <span class="round-tab">
                            <i class="fas fa-file-invoice"></i>
                        </span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane active text-center" role="tabpanel" id="step1">
                <!-- <h1 class="text-md-center">Step 1</h1> -->
                <ul class="list-inline text-md-center">
                    <li>
                        <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <button id="go_to_new" type="button" class="btn btn-block btn-info">
                                    <p><h1><i class="fas fa-user"></i></h1></p>
                                    New Student
                                </button>
                            </div>
                            <div class="col-6">
                                <button id="go_to_current" type="button" class="btn btn-block btn-success">
                                    <p><h1><i class="fas fa-user-graduate"></i></h1></p>
                                    Current Student
                                </button>
                            </div>
                        </div>
                        </div>
                    </li>
                    <!-- <li><button type="button" class="btn btn-lg btn-common next-step next-button">Get Started Now</button></li> -->
                </ul>
            </div>
            <div class="tab-pane" role="tabpanel" id="step2">
                <div class="row d-none" id="page_new_student">
                    <?=$pages_candidate;?>
                </div>
                <div class="row d-none" id="page_current_student">
                    <?=$pages_student;?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
</div>
<script>
    $(function() {
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

            var $target = $(e.target);

            if ($target.hasClass('disabled')) {
                return false;
            }
        });

        $("button#go_to_new").click(function (e) {
            var $active = $('.wizard .nav-tabs .nav-item .active');
            var $activeli = $active.parent("li");

            $('div#page_new_student').removeClass('d-none');
            $('div#page_current_student').addClass('d-none');
            $($activeli).next().find('a[data-toggle="tab"]').removeClass("disabled");
            $($activeli).next().find('a[data-toggle="tab"]').click();
        });
        
        $("button#go_to_current").click(function (e) {
            var $active = $('.wizard .nav-tabs .nav-item .active');
            var $activeli = $active.parent("li");

            $('div#page_new_student').addClass('d-none');
            $('div#page_current_student').removeClass('d-none');
            $($activeli).next().find('a[data-toggle="tab"]').removeClass("disabled");
            $($activeli).next().find('a[data-toggle="tab"]').click();
        });

        $(".prev-step").click(function (e) {

            var $active = $('.wizard .nav-tabs .nav-item .active');
            var $activeli = $active.parent("li");

            $($activeli).prev().find('a[data-toggle="tab"]').removeClass("disabled");
            $($activeli).prev().find('a[data-toggle="tab"]').click();

        });

    });
</script>