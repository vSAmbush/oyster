<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.10.2018
 * Time: 14:04
 */

use lib\Config;

/**
 * Site name
 */
Config::set('site_name', 'CRM');

/**
 * Languages
 */
Config::set('lang', ['en', 'ru']);

/**
 * Database config settings
 *
 * Enter your host and database name here
 */
Config::set('db', [
    'dsn' => 'mysql:host=dev.oyster.su;dbname=crm;charset=utf8',
    'username' => 'ryashentsev',
    'password' => 'TooManySecrets',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
]);

/**
 * Method prefixes. Need to different admin and client pages
 */
Config::set('routes', [
    'default' => 'action',
    'admin' => 'actionAdmin',
]);

/**
 * Put the default values
 */
Config::set('default_route', 'default');
Config::set('default_language', 'ru');
Config::set('default_controller', 'auth');
Config::set('default_action', 'index');