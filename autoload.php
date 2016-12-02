<?php

spl_autoload_register(function ($class) {
    // maximum class file path depth in this project is 3.
    $path = implode(DS, array_slice(explode(FS, $class), 0, 3)) . PHP_EXT;
    if (file_exists($path)) {
        require_once($path);
    }
});

require_once 'vendor/autoload.php';