<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.10.2018
 * Time: 14:00
 */

use lib\App;
?>
<div class="main" style="background-image: url('<?= App::$image_path.'backgrounds/'.rand(1, 5).'.jpg'?>');">
    <form id="auth_form" action="/crm_v2/auth/authentication" method="post" class="auth_container">

        <div class="logo_container">
            <img src="<?= App::$image_path ?>logo.png">
        </div>

        <div id="answer" class="answer" style="display: none">Ошибка авторизации!</div>

        <!-- Spinner animation -->
        <div id="loader" class="lds-ellipsis" style="display: none"><div></div><div></div><div></div><div></div></div>
        <!-- End spinner -->

        <input id="login" type="text" class="form-control" placeholder="+79XXXXXXXXX">

        <input id="password" type="password" class="form-control" style="display: none" placeholder="+79XXXXXXXXX">

        <div class="button_block">
            <button type="button" id="enter_btn" class="auth_button">ВХОД</button>
        </div>
    </form>


</div>