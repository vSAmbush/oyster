<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.10.2018
 * Time: 15:50
 */

namespace controllers;


use lib\Controller;
use lib\View;

class TaskController extends Controller
{
    /**
     * Displays tasks
     */
    public function actionNew() {

        return new View('new');
    }
}