<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.10.2018
 * Time: 14:27
 */

namespace lib;

/**
 * Class Router
 * @package lib
 *
 * Class, which parses http queries
 */
class Router
{
    protected $uri;

    protected $controller;

    protected $action;

    protected $route;

    protected $language;

    protected $method_prefix;

    protected $params;

    /**
     * Router constructor.
     *
     * @param $uri
     */
    public function __construct($uri)
    {
        $this->uri = urldecode(trim(str_replace('crm_v2/', '', $uri), '/'));

        //Set defaults
        $routes = Config::get('routes');
        $this->route = Config::get('default_route');
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->controller = ucfirst(Config::get('default_controller')).'Controller';
        $this->action = ucfirst(Config::get('default_action'));
        $this->language = Config::get('default_language');

        $uri_without_get = explode('?', $this->uri)[0];

        $uri_units = explode('/', $uri_without_get);

        if(count($uri_units)) {

            //Check is the admin rights set
            $temp = strtolower(current($uri_units));
            if(in_array($temp, array_keys($routes))) {

                $this->route = $temp;
                $this->method_prefix = $routes[$this->route];
                array_shift($uri_units);
            }

            //Check is the language set
            $temp = strtolower(current($uri_units));
            if (in_array($temp, Config::get('lang'))) {

                $this->language = $temp;
                array_shift($uri_units);
            }

            //Set controller
            if(current($uri_units)) {
                $this->controller = ucfirst(current($uri_units)).'Controller';
                array_shift($uri_units);
            }

            //Set action
            if(current($uri_units)) {
                $this->action = ucfirst(current($uri_units));
                array_shift($uri_units);
            }

            //Set params if they exist
            $this->params = $uri_units;
        }

        //var_dump($this);
    }

    /**
     * @return string - name of controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string - name of action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string - name of route (default - user, admin - admin)
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return string - language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return array | string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string - name of admin or client action
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }


}