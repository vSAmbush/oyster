<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.10.2018
 * Time: 11:31
 */

namespace assets;

/**
 * Class AssetLoader
 *
 * Here you need to write paths of your css and js files accordingly
 */
class AssetLoader
{
    public $css = [
        'css/auth.css',
        'css/spinner.css',
        'css/fonts.css',
        'css/site.css'
    ];

    public $js = [
        'js/auth.js',
        'js/site.js',
    ];

    //jQuery must be first
    public $js_lib = [
        'js/js_lib/jquery-3.3.1.min.js',
        'js/js_lib/maskedinput.js',
    ];
}