<?php

    /**
     * Class autoload
     *
     * @param $className
     */
    function autoload($className) {

        $className = str_replace('\\', DS, $className);
        $path = ROOT.DS.$className.'.php';

        if(file_exists($path)) {
            require_once($path);
        }
    }

    spl_autoload_register('autoload');

    require_once(ROOT.DS.'config'.DS.'config.php');