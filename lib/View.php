<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.10.2018
 * Time: 16:16
 */

namespace lib;

/**
 * Class View
 * @package lib
 *
 * This class need to render and handle view files
 */
class View
{
    /**
     * @var array - data that will be display in the page
     */
    protected $data;

    /**
     * @var string - path to view file
     */
    protected $path;

    /**
     * View constructor.
     * @param null $path
     * @param array $data
     * @param bool $isLayout
     */
    public function __construct($path = null, $data = [], $isLayout = false)
    {
        try {
            if ($isLayout)
                $this->path = $path;
            else
                $this->path = $this->getDefaultViewPath($path);
        } catch(\Exception $e) {
            die($e->getMessage());
        }
        $this->data = $data;
    }

    /**
     * Returns default view path
     *
     * @param null $view_name
     * @return string
     * @throws \Exception
     */
    private function getDefaultViewPath($view_name = null) {
        $parse = explode('.', $view_name);

        //Checking is set extension
        if(!isset($parse[1])) {
            $parse[1] = 'php';
        }
        $router = App::getRouter();

        if(!$router) {
            throw new \Exception('Object "router" is not exits');
        }

        $controller_dir = str_replace('controller', '', strtolower($router->getController()));

        return VIEWS_PATH.DS.$controller_dir.DS.$parse[0].'.'.$parse[1];
    }

    /**
     * Saving all content of view file and returns it
     *
     * @return false|string
     */
    public function render() {
        $data = $this->data;

        if($this->path) {
            ob_start();
            extract($data);
            include($this->path);
            $content = ob_get_clean();

            return $content;
        }
        else
            return null;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}