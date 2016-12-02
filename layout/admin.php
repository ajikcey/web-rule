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
    <!--[if IE]>
    <link rel="shortcut icon" href="/images/favicon.ico"><![endif]-->

    <!-- Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. -->
    <link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon-precomposed.png">

    <!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. image/gif или image/png -->
    <link rel="icon" href="/images/favicon.png">

    <!-- plugins -->
    <link rel="stylesheet" href="/plugins/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/plugins/animate.css">
    <link rel="stylesheet" href="/plugins/fancyBox/jquery.fancybox.css">
    <link rel="stylesheet" href="/plugins/jstree/themes/default/style.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">

    <?php foreach ($r = $this->getPluginCss() as $v) { ?>
        <link rel="stylesheet" href="/plugins/<?= $v ?>.css">
    <?php } ?>

    <!--noindex-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://studio-42.github.io/elFinder/demo/css/elfinder.min.css">
    <link rel="stylesheet" href="http://studio-42.github.io/elFinder/demo/css/theme.css">

    <?php $r = $this->getExtPluginCss(); ?>
    <?php foreach ($r = $this->getExtPluginCss() as $v) { ?>
        <link rel="stylesheet" href="<?= $v ?>">
    <?php } ?>
    <!--/noindex-->

    <!-- custom -->
    <link rel="stylesheet" href="/css/admin.css">
    <?php foreach ($r = $this->getCss() as $v) { ?>
        <link rel="stylesheet" href="/css/<?= $v ?>.css">
    <?php } ?>
</head>
<body class="mainbody">
<header>
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/view/debug.php'); ?>
    <div class="headerwrapper">

        <?php if (!Srv_User::getCurrentEmailConfirm()) { ?>
            <div class="alert alert-dismissible fade in" role="alert">
                <div class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </div>
                <form class="simple-admin-form-ajax" action="<?= Srv_Page::getUrl('admin/confirm_email_json', 0) ?>"
                      method="post">
                    <div class="container-fluid text-xs-center">
                        <span>Завершите регистрацию, пройдя по ссылку в письме.</span>
                        <a class="btn btn-sm btn-success" href="//<?= explode('@', Srv_User::getCurrentEmail())[1] ?>"
                           target="_blank">Проверить почту</a>
                        <div class="d-inline form-response-success">
                            <span>или</span>
                            <div class="btn btn-submit btn-sm btn-outline-secondary">Отправить еще письмо</div>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>

        <div class="header-left">
            <a href="#" class="menu-collapse"><i class="fa fa-bars"></i></a>
            <a href="/">
                <div class="logo"><?= Srv_Settings::getName() ?></div>
            </a>
        </div>
        <div class="header-right">
            <div class="float-xs-right">

                <?php $webnotices = Srv_Webnotice::getNews(); ?>

                <div class="btn-group btn-group-list btn-group-notification">
                    <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="tag tag-pill tag-default"><?= count($webnotices) ?></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right">

                        <div class="text-xs-center card-header text-muted">
                            Новые уведомления
                        </div>
                        <div class="card-block dropdown-webnotices">

                            <?php if ($webnotices) { ?>
                                <?php foreach ($webnotices as $value) { ?>
                                    <div class="dropdown-webnotice-item clearfix">
                                        <div class="dropdown-webnotice-img card-img"></div>
                                        <div class="dropdown-webnotice-r">

                                            <div class="dropdown-webnotice-name text-muted small">
                                                <?= Srv_Settings::getName() ?>

                                                <a class="webnotice-old float-xs-right btn btn-outline-secondary btn-sm"
                                                   href="<?= Srv_Page::getUrl('user/webnotice_old', 0) ?>/<?= $value['webnotice_id'] ?>"
                                                   title="Отметить прочитанным">

                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                            <div class="dropdown-webnotice-text"><?= $value['text'] ?></div>
                                            <div class="dropdown-webnotice-date small text-muted"><?= $value['date'] ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="text-xs-center text-muted">Новых уведомлений не найдено</div>
                            <?php } ?>

                        </div>
                        <div class="text-xs-center card-footer text-muted">
                            <a href="<?= Srv_Page::getUrl('user/webnotices') ?>" class="small">Посмотреть все
                                уведомления</a>
                        </div>

                    </div>
                </div>
                <div class="btn-group btn-group-option">
                    <?php $user = Srv_User::getCurrent(); ?>
                    <div class="btn btn-default dropdown-toggle btn-profile" data-toggle="dropdown">
                        <span><?= $user['first_name'] ?></span>
                        <div class="user-avatar user-avatar-sm"
                             style="<?= ($user['avatar'] ? "background-image: url('" . Srv_User::$avatar_paths['small'] . $user['avatar'] . "')" : null) ?>"></div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a href="<?= Srv_Page::getUrl('user/profile') ?>" class="dropdown-item">
                            <i class="fa fa-user" aria-hidden="true"></i> Мой профиль</a>
                        <a href="<?= Srv_Page::getUrl('user/settings') ?>" class="dropdown-item">
                            <i class="fa fa-cog" aria-hidden="true"></i> Настройки</a>
                        <a href="<?= Srv_Page::getUrl('site/help') ?>" class="dropdown-item">
                            <i class="fa fa-info-circle" aria-hidden="true"></i> Помощь</a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= Srv_Page::getUrl('site/logout') ?>" class="dropdown-item">
                            <i class="fa fa-sign-out" aria-hidden="true"></i> Выход</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section>
    <div class="mainwrapper">

        <!--leftpanel-->
        <div class="leftpanel slideOutLeft">
            <?php
            function printMenu($menu, $actives, $parent_id = 0)
            {
                $a = in_array($parent_id, $actives);
                $collapse = ($a ? 'collapse in' : ($parent_id ? 'collapse' : ''));
                ?>
                <ul id="admin_menu_collapse_<?= $parent_id ?>" class="nav nav-pills nav-stacked <?= $collapse ?>">
                    <?php if (is_array($menu)) foreach ($menu as $key => $value) {
                        if ($value['parent_id'] == $parent_id) { ?>

                            <?php
                            unset($menu[$key]);
                            if ($value['page_id']) {
                                $page = Srv_Page::getEnablePage($value['page_id']);

                                if (!$page) continue;

                                $value['title'] = $value['title'] ? $value['title'] : $page['title'];
                                $value['icon'] = $value['icon'] ? $value['icon'] : $page['icon'];
                                $value['handler'] = $page['handler'];
                            }

                            $item_id = $value['menu_admin_id'];
                            $a = in_array($item_id, $actives);

                            $active = ($a ? 'active' : '');
                            $data_parent = (!$parent_id ? 'data-parent="#admin_menu_collapse_' . $parent_id . '"' : '');
                            $data_toggle = ($a ? 'collapse' : 'collapse');

                            $has_childs = false;
                            foreach ($menu as $v) {
                                if ($v['parent_id'] == $value['menu_admin_id']) {
                                    $has_childs = true;
                                    break;
                                }
                            }
                            ?>

                            <?php if ($has_childs) { ?>
                                <li class="nav-item panel card parent">
                                    <a class="nav-link text-truncate <?= $active ?>"
                                       href="#admin_menu_collapse_<?= $item_id ?>"
                                       onclick="return false;" data-toggle="<?= $data_toggle ?>" <?= $data_parent ?>
                                       title="<?= $value['title'] ?>">

                                        <?php if (isset($value['icon']) && $value['icon']) { ?>
                                            <i class="<?= $value['icon'] ?>"></i>
                                        <?php } ?> <?= $value['title'] ?>
                                    </a>

                                    <?php printMenu($menu, $actives, $item_id); ?>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item panel card">
                                    <a class="nav-link text-truncate <?= $active ?>" title="<?= $value['title'] ?>"
                                       href="<?= (isset($value['handler']) ? Srv_Page::getUrl($value['handler']) : '#') ?>">

                                        <?php if (isset($value['icon']) && $value['icon']) { ?>
                                            <i class="<?= $value['icon'] ?>"></i>
                                        <?php } ?> <?= $value['title'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php }
                    } ?>
                </ul>
                <?php
            }

            $menu = Srv_MenuAdmin::menu4user();
            $actives = Srv_MenuAdmin::getActiveItemIDs($menu);
            printMenu($menu, $actives);
            ?>
        </div>
        <!--/leftpanel-->

        <!--mainpanel-->
        <div class="mainpanel">
            <div class="pageheader">
                <div class="media">
                    <div class="media-left">
                        <div class="pageicon">
                            <i class="<?= Srv_Page::getCurrentIcon() ? Srv_Page::getCurrentIcon() : 'fa fa-file-o' ?>"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <?php
                            $way = Srv_Page::getPages();
                            foreach ($way as $key => $value) { ?>
                                <?php if ($key == 0) { ?>
                                    <li><a href="<?= Srv_Page::getUrl($value['handler']) ?>"><i
                                                    class="<?= $value['icon'] ? $value['icon'] : 'fa fa-home' ?>"></i></a>
                                    </li>
                                <?php } elseif ($key < (count($way) - 1)) { ?>
                                    <li><a href="<?= Srv_Page::getUrl($value['handler']) ?>"><?= $value['title'] ?></a>
                                    </li>
                                <?php } ?>

                                <?php if ($key == (count($way) - 1)) { ?>
                                    <li><?= $value['title'] ?></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                        <h4 class=""><?= Srv_Page::getTitle() ?></h4>
                    </div>
                </div>
            </div>
            <div class="contentpanel">

                <?php
                /**
                 * render_view
                 */
                $this->render_view();
                ?>
            </div>
        </div>
        <!--/mainpanel-->

    </div>
</section>

<footer>
    <div class="footerwrapper">
        <span><?= Srv_Settings::getCopyright() ?></span>
    </div>
</footer>

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="/plugins/jquery.min.js"></script>
<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/plugins/tether.min.js"></script>
<script src="/plugins/pace.min.js"></script>
<script src="/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="/plugins/fancyBox/jquery.fancybox.pack.js"></script>
<script src="/plugins/jstree/jstree.min.js"></script>
<script src="/plugins/select2/js/select2.min.js"></script>
<script src="/plugins/select2/js/i18n/ru.js"></script>

<!--noindex-->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script>
<script src="//studio-42.github.io/elFinder/demo/js/elfinder.min.js"></script>
<script src="//studio-42.github.io/elFinder/demo/js/i18n/elfinder.ru.js"></script>

<?php $r = $this->getExtPluginJs(); ?>
<?php foreach ($r as $v) { ?>
    <script src="<?= $v ?>"></script>
<?php } ?>
<!--/noindex-->

<?php foreach ($r = $this->getPluginJs() as $v) { ?>
    <script src="/plugins/<?= $v ?>.js"></script>
<?php } ?>

<!-- CUSTOM JS -->
<script src="/js/main.js"></script>
<script src="/js/admin.js"></script>
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