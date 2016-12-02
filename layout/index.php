<!DOCTYPE html>
<?php
/**
 * @var $this Srv_Core_View
 */
?>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= Srv_Page::getCurrentHeadTitle() ?></title>
    
    <meta name="description" content="<?= Srv_Page::getCurrentDesc() ?>">
    <meta name="keywords" content="<?= Srv_Page::getCurrentKeywords() ?>">

    <!-- For IE 9 and below. ICO should be 32x32 pixels in size -->
    <!--[if IE]><link rel="shortcut icon" href="/images/favicon.ico"><![endif]-->

    <!-- Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. -->
    <link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon-precomposed.png">

    <!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. image/gif или image/png -->
    <link rel="icon" href="/images/favicon.png">
    
    <!-- plugins -->
    <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="/plugins/animate.css">

    <?php foreach ($r = $this->getPluginCss() as $v) { ?>
        <link rel="stylesheet" href="/plugins/<?= $v ?>.css">
    <?php } ?>

    <?php $r = $this->getExtPluginCss(); ?>
    <?php if ($r) { ?>
        <!--noindex-->
        <?php foreach ($r = $this->getExtPluginCss() as $v) { ?>
            <link rel="stylesheet" href="<?= $v ?>.css">
        <?php } ?>
        <!--/noindex-->
    <?php } ?>

    <!-- custom -->
    <link rel="stylesheet" href="/css/main.css">
    <?php foreach ($r = $this->getCss() as $v) { ?>
        <link rel="stylesheet" href="/css/<?= $v ?>.css">
    <?php } ?>
</head>
<body class="main">
<header class="main">
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/view/debug.php'); ?>
    <div class="navbar navbar-full navbar-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <a class="navbar-brand" href="/"><?= Srv_Settings::getName() ?></a>
                </div>
                <div class="col-lg-10">
                    <ul class="nav navbar-nav d-inline-block float-lg-right">
                        <li class="nav-item <?= (Srv_Page::hasHandler('site/about') ? 'active' : null) ?>">
                            <a class="nav-link" href="<?= Srv_Page::getUrl('site/about') ?>">О проекте</a>
                        </li>
                        <?php if (Srv_User::getCurrent()) { ?>
                            <li class="nav-item <?= (Srv_Page::hasHandler('user/index') ? 'active' : null) ?>">
                                <a class="nav-link" href="<?= Srv_Page::getUrl('user/index') ?>">
                                    <?= Srv_User::getCurrentName() ?>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item <?= (Srv_Page::hasHandler('site/login') ? 'active' : null) ?>">
                                <a class="nav-link" href="<?= Srv_Page::getUrl('site/login') ?>">
                                    Вход
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<section>
    <?php $this->render_view(); ?>
</section>
<footer class="main">
    <div class="navbar navbar-full navbar-light text-xs-center">
        <div class="container">
            <ul class="nav navbar-nav d-inline-block float-sm-right">
                <li class="nav-item">
                    <a class="nav-link" href="#">Контакты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Помощь</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Соглашение</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fa fa-vk" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
            <div class="float-sm-left text-muted copyright">
                <?= Srv_Settings::getCopyright() ?>
            </div>
        </div>
    </div>
</footer>
<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="/plugins/jquery.min.js"></script>
<script src="/plugins/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script>

<?php $r = $this->getExtPluginJs(); ?>
<?php if ($r) { ?>
    <!--noindex-->
    <?php foreach ($r = $this->getExtPluginJs() as $v) { ?>
        <script src="<?= $v ?>.js"></script>
    <?php } ?>
    <!--/noindex-->
<?php } ?>

<?php foreach ($r = $this->getPluginJs() as $v) { ?>
    <script src="/plugins/<?= $v ?>.js"></script>
<?php } ?>

<!-- CUSTOM JS -->
<script src="/js/main.js"></script>
<?php foreach ($r = $this->getJs() as $v) { ?>
    <script src="/js/<?= $v ?>.js"></script>
<?php } ?>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="/plugins/html5shiv.js"></script>
<script src="/plugins/respond.min.js"></script>
<![endif]-->
</body>
</html>