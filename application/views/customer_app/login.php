<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title><?=(!empty(SITENAME))?SITENAME:""?></title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/customer_app/styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/customer_app/styles/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/customer_app/fonts/css/fontawesome-all.min.css">
    <link rel="manifest" href="<?= base_url() ?>assets/customer_app/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/customer_app/images/icon/192.png">
</head>

<body class="theme-light">
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
<div id="page">

    
    <div class="page-content">
        <div class="page-title page-title-small">
            <h2><a href="#" ></a>Sign In</h2>
           
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="<?=base_url() ?>assets/customer_app/images/pictures/20s.jpg"></div>
        </div>
        <form id="loginform" action="<?=base_url('customerApp/login/auth');?>" method="POST">
            <div class="card card-style">
                <div class="content mt-2 mb-0">
                    <div class="input-style no-borders has-icon validate-field mb-4">
                        <i class="fa fa-user"></i>
                        <input type="name" class="form-control validate-name"  id="user_name" name="user_name" placeholder="Name">
                        <label for="form1a" class="color-blue-dark font-10 mt-1">Name</label>
                        <i class="fa fa-times disabled invalid color-red-dark"></i>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <em>(required)</em>
                    </div>

                    <div class="input-style no-borders has-icon validate-field mb-4">
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control validate-password" id="password" name="password" placeholder="Password">
                        <label for="form3a" class="color-blue-dark font-10 mt-1">Password</label>
                        <i class="fa fa-times disabled invalid color-red-dark"></i>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <em>(required)</em>
                    </div>

                    <button class="btn btn-block btn-m mt-4 mb-4 btn-full bg-green-dark rounded-sm text-uppercase font-900">Login</button>

                    <div class="divider"></div>
                </div>
            </div>
        </form>
        <!-- footer and footer card-->
    </div>
    <!-- end of page content-->
</div>

<script type="text/javascript" src="<?= base_url() ?>/assets/customer_app/scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/customer_app/scripts/custom.js"></script>
</body>
