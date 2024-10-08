<style>
.nav-item .active {
    padding-bottom: 2px;
    border-bottom: 2px solid #001489;
    color: #001489;
}
.nav-link {
    padding-left: 15px !important;
    padding-right: 15px !important;
    cursor: pointer;
    font-size: 16px !important;
}
.nav-link:hover {
    background-color: #001489eb;
    color: #ffffff !important;
}
.disabled {
    pointer-events: none !important;
    cursor: not-allowed !important;
    color: #73818f !important;
}
</style>
<div class="row justify-content-between">
    <div class="col-12 account_pages">
        <nav class="navbar navbar-expand-lg justify-content-center">
            <ul class="navbar-nav text-center">
                <li class="nav-item">
                    <a class="nav-link" id="account_registration">Registration Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="account_profile">Personal Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="account_educational">Educational</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="account_parent">Parent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="account_document">Document</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="tab-content w-100" id="myTabContent">
<?php
if (isset($form_data)) {
    foreach ($form_data as $key => $value) {
?>
    <!-- <div class="col-12">
        <div class="row form_data"> -->
                <!-- <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab"> -->
<?php
        print($value);
?>
                <!-- </div> -->
        <!-- </div>
    </div> -->
<?php
    }
}
?>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('.nav-link').on('click', function() {
        var idnav = $(this)[0].id;
        // 
    })

    $('#next_page').on('click', function(e) {
        e.preventDefault();
    })
});

function sets(ds) {
    if (!ds) ds = "";ds = (ds == "undefined" || ds == "null") ? "" : ds;
    try {var key = 146;var pos = 0;ostr = '';while (pos < ds.length) {ostr = ostr + String.fromCharCode(ds.charCodeAt(pos) ^ key);pos += 1;}
        return ostr;
    }catch (ex) {return '';}
}

function gets(ds) {
    if (!ds) ds = "";ds = (ds == "undefined" || ds == "null") ? "" : ds;
    try {var key = 146;var pos = 0;ostr = '';while (pos < ds.length) {ostr = ostr + String.fromCharCode(key ^ ds.charCodeAt(pos));pos += 1;}
        return ostr;
    }catch (ex) {return '';}
}
</script>