<head>
<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>assets/img/iuli-owl.png">
  <meta name="description" content="IULI PMB">
<style>
body {
    background: #595BD4;
    font-family: 'Titillium Web', sans-serif;
}
.loading {
    position: absolute;
    left: 0;
    right: 0;
    top: 50%;
    width: 100px;
    color: #FFF;
    margin: auto;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
}
.loading span {
    position: absolute;
    height: 10px;
    width: 84px;
    top: 50px;
    overflow: hidden;
}
.loading span > i {
    position: absolute;
    height: 4px;
    width: 4px;
    border-radius: 50%;
    -webkit-animation: wait 4s infinite;
    -moz-animation: wait 4s infinite;
    -o-animation: wait 4s infinite;
    animation: wait 4s infinite;
}
.loading span > i:nth-of-type(1) {
    left: -28px;
    background: yellow;
}
.loading span > i:nth-of-type(2) {
    left: -21px;
    -webkit-animation-delay: 0.8s;
    animation-delay: 0.8s;
    background: lightgreen;
}

@-webkit-keyframes wait {
    0%   { left: -7px  }
    30%  { left: 52px  }
    60%  { left: 22px  }
    100% { left: 100px }
}
@-moz-keyframes wait {
    0%   { left: -7px  }
    30%  { left: 52px  }
    60%  { left: 22px  }
    100% { left: 100px }
}
@-o-keyframes wait {
    0%   { left: -7px  }
    30%  { left: 52px  }
    60%  { left: 22px  }
    100% { left: 100px }
}
@keyframes wait {
    0%   { left: -7px  }
    30%  { left: 52px  }
    60%  { left: 22px  }
    100% { left: 100px }
}
</style>
<!-- Matomo -->
<script>
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//trac.iuli.ac.id/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '<?= (isset($site_id)) ? $site_id : '1'; ?>']);
<?php
if ((isset($userid)) AND (!empty($userid))) {
?>
    _paq.push(['setUserId', '<?=$userid;?>']);
<?php
}
?>
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
<meta http-equiv="Refresh" content="0; url=<?=(isset($url)) ? $url : base_url();?>">
</head>
<body>
  <div class="loading">
      <p>Please wait</p>
      <span><i></i><i></i></span>
  </div>
</body>
