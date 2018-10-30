<?php
    use lib\App;

    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(__FILE__));
    define('VIEWS_PATH', ROOT.DS.'views');

    require_once(ROOT.DS.'lib'.DS.'init.php');

    try {
        App::run($_SERVER['REQUEST_URI']);
    } catch (Exception $e) {
        var_dump($e->getMessage());
    }