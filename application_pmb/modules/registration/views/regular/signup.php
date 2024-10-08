<style>
    hr {
        margin-top: 5px !important;
        margin-bottom: 5px !important;
        margin-left: 0 !important
    }
    .text-info-header {
        /* background-color: #001489 !important; */
        background-color: #060541 !important;
        color: #fff;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .close_flow_modal {
        position: absolute;
        right: 20px;
        top: 10px;
        color: #fff;
    }
    .image-modal-show {
        overflow: auto !important;
    }
    .image-modal-show .modal {
        overflow: hidden !important;
    }
    .marquee {
        background-color: #001489 !important;
        color: #fff;
        position: relative;
        width: 100vw;
        max-width: 100%;
        height: 33px;
        overflow-x: hidden;
    }

    .track {
        position: absolute;
        white-space: nowrap;
        will-change: transform;
        animation: marquee 27s linear infinite;
    }

    @keyframes marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }
</style>
<?php
// if ($_SERVER['REMOTE_ADDR'] == '202.93.225.254') {
?>
<h4 class="text-center mb-3">
<!-- <marquee behavior="alternate" direction="" scrollamount="4" style="gap: var(--gap);">ENGLISH INTERNATIONAL CLASS</marquee> -->
<div class="marquee">
    <div class="track">
        <div class="content">&nbsp;ENGLISH INTERNATIONAL CLASS | ENGLISH INTERNATIONAL CLASS | ENGLISH INTERNATIONAL CLASS | ENGLISH INTERNATIONAL CLASS | ENGLISH INTERNATIONAL CLASS | ENGLISH INTERNATIONAL CLASS | ENGLISH INTERNATIONAL CLASS | ENGLISH INTERNATIONAL CLASS</div>
    </div>
</div>
</h4>
<div id="carouselExampleIndicators" class="carousel slide mb-3" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
        <!-- d-md-none -->
            <img class="w-100 d-none d-lg-block" src="<?=base_url()?>assets/img/banner/01/Profile-1208px.jpg" alt="">
            <!-- <img class="w-100 d-none d-md-block d-lg-none" src="<?=base_url()?>assets/img/banner/01/Profile-604px.jpg" alt=""> -->
            <img class="w-100 d-block d-lg-none" src="<?=base_url()?>assets/img/banner/01/Profile-537px.jpg" alt="">
        </div>
        <div class="carousel-item">
            <img class="w-100 d-none d-lg-block" src="<?=base_url()?>assets/img/banner/02/Why_Choose-1208px.jpg" alt="">
            <!-- <img class="w-100 d-none d-md-block d-lg-none" src="<?=base_url()?>assets/img/banner/02/Why_Choose-604px.jpg" alt=""> -->
            <img class="w-100 d-block d-lg-none" src="<?=base_url()?>assets/img/banner/02/Why_Choose-537px.jpg" alt="">
        </div>
        <!-- <div class="carousel-item"> -->
            <!-- <img class="w-100 d-none d-lg-block" src="<?=base_url()?>assets/img/banner/03/Besiswa-1208px.jpg" alt=""> -->
            <!-- <img class="w-100 d-none d-md-block d-lg-none" src="<?=base_url()?>assets/img/banner/03/Besiswa-604px.jpg" alt=""> -->
            <!-- <img class="w-100 d-block d-lg-none" src="<?=base_url()?>assets/img/banner/03/Besiswa-537px.jpg" alt=""> -->
        <!-- </div> -->
        <div class="carousel-item">
            <img class="w-100 d-none d-lg-block" src="<?=base_url()?>assets/img/banner/04/Employee-Class-1208px.jpg" alt="">
            <!-- <img class="w-100 d-none d-md-block d-lg-none" src="<?=base_url()?>assets/img/banner/04/Employee-Class-604px.jpg" alt=""> -->
            <img class="w-100 d-block d-lg-none" src="<?=base_url()?>assets/img/banner/04/Employee-Class-537px.jpg" alt="">
        </div>
        <div class="carousel-item">
            <img class="w-100 d-none d-lg-block" src="<?=base_url()?>assets/img/banner/05/Semester.jpg" alt="">
            <!-- <img class="w-100 d-none d-md-block d-lg-none" src="<?=base_url()?>assets/img/banner/05/Semester-604px.jpg" alt=""> -->
            <img class="w-100 d-block d-lg-none" src="<?=base_url()?>assets/img/banner/05/Semester-537px.jpg" alt="">
        </div>
        <!-- <div class="carousel-item"> -->
            <!-- <img class="w-100 d-none d-lg-block" src="<?=base_url()?>assets/img/banner/06/DAAD-1208px.jpg" alt=""> -->
            <!-- <img class="w-100 d-none d-md-block d-lg-none" src="<?=base_url()?>assets/img/banner/05/Semester-604px.jpg" alt=""> -->
            <!-- <img class="w-100 d-block d-lg-none" src="<?=base_url()?>assets/img/banner/06/DAAD-537px .jpg" alt=""> -->
        <!-- </div> -->
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<div class="modal modal_show" tabindex="-1" role="dialog" id="modal_flow" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="">
                <button type="button" class="close close_flow_modal text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- <img src="<?=base_url()?>assets/img/banner/popup_info/admission-flow.jpeg" alt="" class="img-fluid w-100 d-sm-none">
                <img src="<?=base_url()?>assets/img/banner/popup_info/admission-flow-md.jpeg" alt="" class="img-fluid w-100 d-none d-sm-block"> -->
                <img src="<?=base_url()?>assets/img/banner/popup_info/university-partner-md.jpeg" alt="" class="img-fluid w-100 d-sm-none">
                <img src="<?=base_url()?>assets/img/banner/popup_info/university-partner.jpeg" alt="" class="img-fluid w-100 d-none d-sm-block">
            </div>
        </div>
    </div>
</div>
<?php
// }
// else {
?>
<!-- <div id="carouselExampleIndicators" class="carousel slide mb-3" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="<?=base_url()?>assets/img/banner/Profile-Campus.jpg" alt="">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="<?=base_url()?>assets/img/banner/Beasiswa.jpg" alt="">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="<?=base_url()?>assets/img/banner/Employee-Class.jpg" alt="">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div> -->
<?php
// }
?>

<div class="row">
    <div class="col-md-8">
        <h4 class="text-info-header pl-3 mb-3">Bachelor Degree Study Programs</h4>
        <div class="row">
            <div class="col-md-6">
                <h5>Faculty of Engineering</h5>
                <hr class="w-75 bg-info">
                <hr class="bg-primary">
                <ul style="list-style: none; padding-left: 15px !important;">
            <?php
            if ((isset($study_programs)) AND ($study_programs)) {
                foreach($study_programs as $sp) {
                    if (in_array($sp->faculty_id, ['51e2f6ff-c394-44c1-8658-7bd9dd46c654', '301a3e19-348d-4398-b640-c9d2acc491fa'])) {
            ?>
                    <li class="pt-2">
                        <a href="<?=base_url()?>registration/direct_link?mtm_campaign=<?=$sp->study_program_abbreviation;?>" target="blank"><?=$sp->study_program_name;?></a>
                    </li>
            <?php
                    }
                }
            }
            ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h5>Faculty of Business and Social Sciences</h5>
                <hr class="w-75 bg-info">
                <hr class="bg-primary">
                <ul style="list-style: none; padding-left: 15px !important;">
            <?php
            if ((isset($study_programs)) AND ($study_programs)) {
                foreach($study_programs as $sp) {
                    if (in_array($sp->faculty_id, ['f9f52242-983d-4e4c-8d5c-7c4575de0679'])) {
            ?>
                    <li class="pt-2">
                        <a href="<?=base_url()?>registration/direct_link?mtm_campaign=<?=$sp->study_program_abbreviation;?>" target="blank"><?=$sp->study_program_name;?></a>
                    </li>
            <?php
                    }
                }
            }
            ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div id="registration_page">
            <h4 class="text-info-header">Registration Form</h4>
            <hr/>
            <?= (isset($registration_page)) ? $registration_page : ''; ?>
            <span>Or</span>
            <div class="mt-2">
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-block btn-success" id="btn-signin-registration">
                        Sign In if you already have your login data
                        </button>
                        <!-- <a href="<?= base_url()?>registration/sign_in" class="btn btn-block btn-success">
                            <span>Sign In if you already have your login data</span>
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
        <div id="signin_page" class="d-none">
            <h4 class="text-info-header">Authentication</h4>
            <hr/>
            <?= (isset($signin_page)) ? $signin_page : ''; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-3">
        <div class="mt-3 border-top border-info pl-2 pr-2 mt-3 pt-2">
            <p>International University Liasion Indonesia accepts registration of new students for the 2023 school year through several programs to make it easier for them to realize their aspirations of getting an international scale education in the future to face global competition by being able to get education in Germany or Taiwan.</p>
            <p><strong>Student Exchange Program IULI University in Germany:</strong> <br>
            Avalaible for All Program Studies for 1 - 2 Semesters in Germany.</p>
            <p><strong>Double Degree Program IULI University in Germany:</strong> <br>
                Chemical Engineering, Food Technology, International Business Administration, Hotel and Tourism Management, International Relations, International Business Administration.</p>
            <p><strong>Master Degree Program IULI University at NFU Taiwan:</strong> <br>
                Mechanical and Computer Engineering, Material Science & Engineering, Mechanical Design Engineering, Power Mechanical Engineering, Automation Engineering, Aeronautical Engineering, Electrical Engineering, Computer Science and Information Engineering, Industrial Management, Information Management, Financial, Business Administration.</p>
            <p><strong>New Student Admission Program at IULI University in 2023:</strong></p>
        </div>
        <div class="accordion border-info" id="info1">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <span id="sign_collapse"><i class="fas fa-plus-square"></i></span> 1. Regular Class (Day Time)
                </button>
            </h2>
            <div id="collapseOne" class="collapse pl-3 pr-3" aria-labelledby="headingOne" data-parent="#info1">
                <p class="pl-3">Tuition fee at IULI University is IDR 29,900,000 Per-Semester and No Development Fee, (Applies to All Majors and can be paid in installments)</p>
                <!-- <ol type="a">IULI University Scholarship Program :
                    <li>
                        Academic Scholarship Pathway for 8 semesters
                        <ul>
                            <li>Free 75% discount per semester</li>
                            <li>Free 50% discount per semester</li>
                            <li>Free 30% discount per semester</li>
                        </ul>
                    </li>
                    <li>
                        Non-Academic Scholarship Pathway for 8 semesters
                        <ul>
                            <li>Free 75% discount per semester</li>
                            <li>Free 50% discount per semester</li>
                            <li>Free 30% discount per semester</li>
                        </ul>
                    </li>
                </ol> -->
            </div>
        </div>
        <div class="accordion border-bottom border-info" id="info2">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <span id="sign_collapse_two"><i class="fas fa-plus-square"></i></span> 2. Employee Class (Evening and Weekend)
                </button>
            </h2>
            <div id="collapseTwo" class="collapse pl-3 pr-3" aria-labelledby="headingTwo" data-parent="#info2">
                <p class="pl-3">Cost 1 Million Per Month and No Development Fee</p>
            </div>
        </div>
    </div>
</div>
<div class="row pb-1 pl-1">
    <div class="col-12 ml-2 d-none">
        <a href="<?=base_url()?>registration/brochure" target="_blank"><i class="fas fa-newspaper"></i> Download Brochure (Tuition Fee Information)</a>
    </div>
    <div class="col-12 ml-2 mt-2">
        <a href="<?=base_url()?>registration/study_abroad" target="_blank"><i class="fas fa-newspaper"></i> Download Study Abroad Information</a>
    </div>
</div>
<script>
$(function() {
    $('#collapseOne').on('shown.bs.collapse', function () {
        $('#sign_collapse').html('<i class="fas fa-minus-square"></i>');
    });
    $('#collapseOne').on('hidden.bs.collapse', function () {
        $('#sign_collapse').html('<i class="fas fa-plus-square"></i>');
    });
    $('#collapseTwo').on('shown.bs.collapse', function () {
        $('#sign_collapse_two').html('<i class="fas fa-minus-square"></i>');
    });
    $('#collapseTwo').on('hidden.bs.collapse', function () {
        $('#sign_collapse_two').html('<i class="fas fa-plus-square"></i>');
    });

    $('#btn-signin-registration').on('click', function(e) {
        e.preventDefault();

        var anim = animateCanvas('#registration_page', '#signin_page');
    });

    $('#modal_flow').on('show.bs.modal', function (e) {
        $('body').addClass('image-modal-show');
    });
    $('#modal_flow').on('hide.bs.modal', function (e) {
        $('body').removeClass('image-modal-show');
    });
<?php
// if ($_SERVER['REMOTE_ADDR'] == '202.93.225.254') {
    if (!$this->session->has_userdata('has_show_flow_infront')) {
        $this->session->set_userdata('has_show_flow_infront', true);
    ?>
        $('#modal_flow').modal('show');
    <?php
    }
// }
?>
});
</script>