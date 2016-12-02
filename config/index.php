<?php
// download constants
require_once('const.php');

// returned configurations
return array(
    'name' => 'Service',
    'db' => require_once('db.php'),
    'urls' => array(
        401 => 'site/login', // Unauthorized
        400 => '', // Bad Request
        403 => 'site/page403', // Forbidden («запрещено»)
        404 => 'site/page404', // Not Found
        410 => '', // Gone («удалён»)
        503 => 'site/page503', // Service Unavailable («сервер временно не имеет возможности обрабатывать запросы по техническим причинам»)
    ),
);