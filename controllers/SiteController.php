<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.10.2018
 * Time: 13:58
 */

namespace controllers;

use lib\Controller;
use lib\View;

/**
 * Class SiteController - Controls page after authorization
 * @package controllers
 *
 * ATTENTION. If the method doesn't returns a View object - layout doesn't display
 */
class SiteController extends Controller
{

    /**
     * Displays main page
     *
     * @return View
     */
    public function actionIndex() {



        return new View('index');
    }
}