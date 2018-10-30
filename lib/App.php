<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.10.2018
 * Time: 14:20
 */

namespace lib;

use assets\AssetLoader;

/**
 * Class App
 * @package lib
 *
 * Main class contains main function (run)
 */
class App
{
    /**
     * @var Router
     */
    protected static $router;

    /**
     * @var string - path to resources directory
     */
    private static $resource_path;

    /**
     * @var string - path to images directory
     */
    public static $image_path;

    /**
     * @var string - is used to different localhost and remote host
     */
    public static $link_path;

    /**
     * @var SQLHandler
     */
    public static $sql_handler;

    /**
     * Main function
     *
     * @param $uri
     * @throws \Exception
     */
    public static function run($uri) {

        /**
         * Starting session on all files
         */
        session_start();

        self::$router = new Router($uri);

        //first line need to avoid links errors while testing in localhost
        self::$resource_path = (preg_match('/\bcrm_v2\b/', $_SERVER['REQUEST_URI'])) ? '/crm_v2' : '';

        self::$link_path = self::$resource_path;

        self::$resource_path .= '/resources/';

        self::$image_path = self::$resource_path.'images/';

        self::$sql_handler = new SQLHandler();

        $controller_name = '\controllers\\'.self::$router->getController();
        $method_name = self::$router->getMethodPrefix().self::$router->getAction();

        $controller = new $controller_name();

        //Calling controller's method if it exits
        if(method_exists($controller, $method_name)) {

            //Getting the View object from controller method
            $view = $controller->$method_name();
            if($view != null && $view instanceof View) {
                //Rendering the view file
                $content = $view->render();

                //Rendering the layout
                $layout_path = VIEWS_PATH . DS . 'layouts' . DS . $controller->layoutName();
                $layout_view = new View($layout_path, compact('content'), true);
                echo $layout_view->render();
            }
        } else {
            throw new \Exception('Method '.$method_name.' of class '.$controller_name.' doesn\'t exist');
        }
    }

    /**
     * @return Router
     */
    public static function getRouter() {
        return self::$router;
    }

    /**
     * Including css files
     *
     * @return string
     */
    public static function includingLinkTags() {
        $includes = '';

        $assets = new AssetLoader();

        for($i = 0; $i < count($assets->css); $i++) {
            $includes .= '<link rel="stylesheet" type="text/css" href="'.self::$resource_path.$assets->css[$i].'">';
        }

        return $includes;
    }

    /**
     * Including js files
     *
     * @return string
     */
    public static function includingScriptTags() {
        $includes = '';

        $assets = new AssetLoader();

        for($i = 0; $i < count($assets->js); $i++) {
            $includes .= '<script type="text/javascript" src="'.self::$resource_path.$assets->js[$i].'"></script>';
        }

        return $includes;
    }

    /**
     * Including js libraries
     * Function to include same scripts one more time in different layouts
     *
     * @return string
     */
    public static function includeLibraryScripts() {

        $includes = '';
        $assets = new AssetLoader();

        for($i = 0; $i < count($assets->js_lib); $i++) {
            $includes .= '<script type="text/javascript" src="'.self::$resource_path.$assets->js_lib[$i].'"></script>';
        }

        //Here you can include scripts with internet links
        $includes .= '<script
                          src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
                          integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
                          crossorigin="anonymous"></script>';

        return $includes;
    }
}