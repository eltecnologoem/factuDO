<html class="wide wow-animation" lang="en">

<head>
  <title>
    <?= $title . ' ::GamerClub::' ?>
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="facebook-domain-verification" content="2c66zqng3huh8eriq97q7qz7uu4i1p" />
  <!-- <meta http-equiv="Content-Security-Policy" content="default-src https:"> -->
  <?php
  if (isset($fb_meta)) {
    echo $fb_meta;
  }
  ?>
  <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.9.55/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="/css/bootstrap.css?<?= time() ?>">
  <link rel="stylesheet" href="/css/fonts.css?<?= time() ?>">
  <link rel="stylesheet" href="/css/style.css?<?= time() ?>">
  <style>
    .ie-panel {
      display: none;
      background: #212121;
      padding: 10px 0;
      box-shadow: 3px 3px 5px 0 rgba(0, 0, 0, .3);
      clear: both;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    html.ie-10 .ie-panel,
    html.lt-ie-10 .ie-panel {
      display: block;
    }
  </style>
</head>

<body>
    <div class="preloader">
      <div class="preloader-body">
        <img src="/images/preloader.gif" alt="">
      </div>
    </div>
  <div class="page">
    <!-- Page Header-->
    <header class="section page-header">
      <!-- RD Navbar-->
      <div class="rd-navbar-wrap">
        <nav class="rd-navbar rd-navbar-wide" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
          <div class="rd-navbar-main-outer">
            <div class="rd-navbar-main">
              <!-- RD Navbar Panel-->
              <div class="rd-navbar-panel">
                <!-- RD Navbar Toggle-->
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                <!-- RD Navbar Brand-->
                <div class="rd-navbar-brand"><a class="brand" href="/"><img src="/images/brand.png" alt="">
                    <h4>FactusDO</h4>
                  </a>
                </div>
              </div>
              <?php Controller::GetModules('navbars/navbar'); ?>
            </div>
          </div>
        </nav>
      </div>
    </header>

    <section class="section section-relative section-header">
      <?php Controller::GetModules('Errors/View'); ?>
    </section>