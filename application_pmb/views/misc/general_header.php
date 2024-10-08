<style>
    .head-menu li a {
        color: #fff !important;
    }
    .head-menu li a:hover {
        background-color: #fff !important;
        color: #000 !important;
    }
    .list-column {
        font-size: 10px;
    }

    @media (min-width: 768px) {
        .list-column {
        font-size: 14px;
    }
    }
</style>
<!-- <div class="container"> -->
    <div class="row no-gutters align-items-center">
        <div class="col-6 col-lg-3">
            <a href="<?= (empty($this->uri->segment(1, 0))) ? 'https://www.iuli.ac.id/' : base_url() ?>" target="_blank">
                <img src="<?= base_url()?>assets/img/iuli_logo.png" class="img-fluid d-block w-75 d-md-none"/>
                <img src="<?= base_url()?>assets/img/iuli.png" class="img-fluid d-none d-md-block"/>
            </a>
        </div>
        <div class="col-6 col-lg-9 ml-auto">
            <div class="row">
                <div class="col-12">
                    <?php
                    // if ($_SERVER['REMOTE_ADDR'] == '202.93.225.254') {
                    ?>
                        <ul class="list-inline head-menu float-right mr-md-4">
                            <li class="list-inline-item list-column mb-3 mb-md-0">
                                <a class="border rounded-circle p-1" href="https://www.facebook.com/IULIndonesia/" target="_blank" style="padding-left: 10px !important; padding-right: 10px !important;">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="list-inline-item list-column mb-3 mb-md-0">
                                <a class="border rounded-circle p-1" href="https://www.instagram.com/IULIndonesia/" target="_blank" style="padding-left: 7px !important; padding-right: 7px !important;">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                            <li class="list-inline-item list-column mb-3 mb-md-0">
                                <a class="border rounded-circle p-1" href="https://twitter.com/IULIndonesia" target="_blank" style="padding-left: 7px !important; padding-right: 7px !important;">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                            <li class="list-inline-item list-column mb-3 mb-md-0">
                                <a class="border rounded-circle p-1" href="https://www.youtube.com/channel/UChIlfDUOeFamFxX3GdaXTcQ" target="_blank" style="padding-left: 7px !important; padding-right: 7px !important;">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    <?php
                    // }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <button class="btn btn-block btn-sm navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav head-menu">
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="<?=base_url()?>">Registration</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link" href="https://www.iuli.ac.id/" target="_blank" style="padding: 0.1rem 0.4rem;">IULI Website</a>
                                    <!-- <a class="nav-link" href="<?=base_url()?>registration/info" target="_blank" style="padding: 0.1rem 0.4rem;">Term and Condition</a> -->
                                </li>
                                <!-- <li class="nav-item"> -->
                                    <!-- <a class="nav-link" href="<?=base_url()?>registration/info" target="_blank" style="padding: 0.1rem 0.4rem;">Scholarship Information</a> -->
                                    <!-- <a class="nav-link" href="<?=base_url()?>registration/info" target="_blank" style="padding: 0.1rem 0.4rem;">Term and Condition</a> -->
                                <!-- </li> -->
                                <li class="nav-item">
                                    <!-- <a class="nav-link" href="<?=base_url()?>scholarship/info">Scholarship Information</a> -->
                                    <a class="nav-link" href="https://goo.gl/maps/1hAqYP2BXZweXT8U6" target="_blank" style="padding: 0.1rem 0.4rem;">Campus Location</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="#">Kelas Karyawan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">International</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Tuition Fee</a>
                                </li> -->
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->