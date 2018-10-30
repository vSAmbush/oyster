<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.10.2018
 * Time: 16:39
 */
namespace controllers;

use lib\App;
use lib\View;
use lib\Controller;
use models\Permission;
use models\Session;
use models\User;

/**
 * Class AuthController
 * @package controllers
 *
 * Handles auth page
 *
 * ATTENTION. If the method doesn't returns a View object - layout doesn't display
 */
class AuthController extends Controller
{
    /**
     * Overflow parent function
     *
     * @return string
     */
    public function layoutName()
    {
        return 'auth_lay.php';
    }

    /**
     * Sending code to phone number
     *
     * @param $phone
     * @param $code
     */
    private function sendCode($phone, $code) {
        $url = 'http://spot.oyster.su/api.php';
        $data = array(
            'key' => 'oVaMJGDeAb8CANZ',
            'phone' => $phone,
            'message' => "Code: $code"
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
    }

    /**
     * Checking if the user authorization has already completed
     *
     * @param $session Session
     * @return bool
     */
    private function checkAuthorization($session) {
        return $_SERVER['REMOTE_ADDR'] === $session->getIp() && time() < strtotime($session->getExpired());
    }

    /**
     * Handling of displaying the auth page
     *
     * @return View
     */
    public function actionIndex() {
        /**
         * All functions WORK!!!
         */
        /*var_dump(User::findUser([
            'mobile' => '+79111111111'
        ]));*/

        /*var_dump(User::update([
            'pin' => 1111
        ], [
            'mobile' => '+79111111111'
        ]));*/

        /*var_dump(Session::insert([
            'key' => $_COOKIE['key'],
            'user' => 1,
            'ip' => '::1',
            'expired' => date("Y-m-d H:i:s", time() + 60 * 60 * 24 * 3)
        ]))*/

        /*var_dump($permissions = Permission::getPermissions([
            'object' => 1,
            'type' => 'user'
        ]));*/
        //setcookie('key', '', time() - 60 * 60 * 24 * 3, '/');

        if(isset($_COOKIE['key'])) {
            $session = Session::findSession([
                'key' => $_COOKIE['key'],
            ]);

            if ($session && $this->checkAuthorization($session)) {
                $str = App::$link_path.'/site/index';
            } else {
                $str = App::$link_path.'/auth/index';
            }
            header('Location: '.$str);
        }

        return new View('index');
    }

    /**
     * Handling authentication
     */
    public function actionAuthentication() {
        $login = $_POST['login'];
        $password = $_POST['password'];

        if($password === '') {

            $res = User::findUser([
                'mobile' => $login,
                'disabled' => 0,
            ]);
            if($res) {
                //$NewCode=rand(1000,9999);
                $newCode = 1234;

                User::update([
                    'pin' => $newCode
                ], [
                    'mobile' => $login
                ]);

                //sendCode($login, $newCode);
                echo 'code';
            }
            else
                echo 'fail';
        }
        else {
            $user = User::findUser([
                'mobile' => $login,
                'pin' => $password,
            ]);
            if($user) {
                $expired = time() + 60 * 60 * 24 * 3;
                $key = md5($expired);

                /**
                 * REMEMBER THAT COOKIE WOULD BE AVAILABLE ONLY AFTER RELOAD
                 * In this case create the temp page SaveUser
                 */
                setcookie('key', $key, $expired, '/');
                //var_dump($_COOKIE['key']) = outputs null;

                //save variables to pass on them in actionSaveUser
                $_SESSION['user'] = $user;
                $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

                //Y-m-d H:i:s - mysql format of datetime!!!
                $_SESSION['expired'] = date("Y-m-d H:i:s", $expired);

                //Permissions
                $permissions = Permission::getPermissions([
                    'object' => $user->getId(),
                    'type' => 'user'
                ]);

                if($permissions) {
                    for($i = 0; $i < count($permissions); $i++)
                        $_SESSION['permissions'][$permissions[$i]->getFlag()] = true;
                }

                echo 'success';
            }
            else {
                echo 'wrong';
            }
        }
    }

    /**
     * Saving user session in db
     */
    public function actionSaveUser() {

        if(isset($_COOKIE['key'])) {
            $_SESSION['key'] = $_COOKIE['key'];

            Session::insert([
                'key' => $_SESSION['key'],
                'user' => $_SESSION['user']->getId(),
                'ip' => $_SESSION['ip'],
                'expired' => $_SESSION['expired']
            ]);
        }
        header('Location:'.App::$link_path.'/site/index');

        /**
         * WORKS
         */
        /*return new View('index', [
            'test' => 15,
            'a1' => 'YEEEAAAA',
        ]);*/
    }
}