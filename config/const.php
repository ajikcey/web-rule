<?php
define('DS', '/');
define('FS', '_');

define('PHP_EXT', '.php');
define('LOG_EXT', '.log');

define('HOST', $_SERVER["HTTP_HOST"]);
define('PROTOCOL', 'http');

define('CTRL_PREFIX', 'Ctrl');

define('CTRL_DIR', CTRL_PREFIX . DS);
define('MODEL_DIR', 'model' . DS);
define('Srv_DIR', 'srv' . DS);
define('VIEW_DIR', 'view' . DS);
define('LAYOUT_DIR', 'layout' . DS);

// Кодировка сервера
// Используется для загрузки файлов с русским названием Elfinder
define('SERVER_ENCODING', "CP1251"); // https://gist.github.com/nao-pon/78d64ad9a89d0267833564e5d61f0001

define('COOKIE_TIME', 2592000); // 30 суток
define('ACCESS_TIME', 86400); // 1 суток
define('AUTH_TIME', 60); // 1 минут