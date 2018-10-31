<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.10.2018
 * Time: 16:50
 */

namespace controllers;


use lib\Controller;
use lib\View;

class InfrastructureController extends Controller
{

    public function actionMaps() {

        return new View('maps');
    }
}