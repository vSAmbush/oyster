<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.10.2018
 * Time: 16:33
 */

namespace lib;

/**
 * Class Controller
 * @package lib
 *
 * Class parent for all controllers
 * data - data, which is displayed in view
 * params - params for Controller, like $_GET
 */
class Controller
{
    protected $data;

    protected $params;

    /**
     * Controller constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->params = App::getRouter()->getParams();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array|string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Returns name of current layout
     *
     * @return string
     */
    public function layoutName() {
        return 'default.php';
    }
}