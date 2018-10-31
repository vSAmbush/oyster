<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.10.2018
 * Time: 16:47
 */

use lib\App;
use lib\Config;
?>
<!-- USE THE KEYS NAMES OF PARAMS TO USE THEM
    <?= $test ?>
    <?= $a1 ?>
-->
<!DOCTYPE html>
<html>
<head lang="<?= App::getRouter()->getLanguage() ?>">

    <!-- Link including -->
    <link rel="shortcut icon" href="<?= App::$image_path ?>favicon/favicon.ico" type="image/x-icon">
    <?= App::includingLinkTags() ?>
    <!-- End link including (Add css files in assets/AssetLoader) -->

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <title><?= Config::get('site_name') ?></title>
</head>

<!-- Body begin -->
<body>

    <div class="header">
        <div class="header-logo">
            <a href="<?= App::$link_path?>/site/index"><img src="<?= App::$image_path?>logo.png"></a>
        </div>

        <ul class="navigation">
            <li><a class="nav-item" href="#">Рабочий стол</a></li>
            <li>
                <a class="nav-item complex" href="#">Компания <i class="fa fa-angle-down"></i></a>
                <ul class="sub-navigation" style="display: none">
                    <li><a class="sub-nav-item" href="#">Сотрудники</a></li>
                    <li><a class="sub-nav-item" href="#">Документы</a></li>
                    <li><a class="sub-nav-item" href="#">Услуги</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-item complex" href="#">Клиенты <i class="fa fa-angle-down"></i></a>
                <ul class="sub-navigation" style="display: none">
                    <li><a class="sub-nav-item" href="#">События</a></li>
                    <li><a class="sub-nav-item" href="#">Мои клиенты</a></li>
                    <li><a class="sub-nav-item" href="#">Все клиенты</a></li>
                    <li><a class="sub-nav-item" href="#">Счета</a></li>
                    <li><a class="sub-nav-item" href="#">Бизнес-центры</a></li>
                    <li><a class="sub-nav-item" href="#">Агенты</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-item complex" href="#">Задачи <i class="fa fa-angle-down"></i></a>
                <ul class="sub-navigation" style="display: none">
                    <li><a class="sub-nav-item" href="<?= App::$link_path?>/task/new">Новые</a></li>
                    <li><a class="sub-nav-item" href="#">В работе</a></li>
                    <li><a class="sub-nav-item" href="#">Завершенные</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-item complex" href="#">Почта <i class="fa fa-angle-down"></i></a>
                <ul id="email_ul" class="sub-navigation" style="display: none">
                    <li><a class="sub-nav-item" href="#">e.logvin@oyster</a></li>
                    <li><a class="sub-nav-item" href="#">suppory@oyster</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-item complex" href="#">Инфраструктура <i class="fa fa-angle-down"></i></a>
                <ul class="sub-navigation" style="display: none">
                    <li><a class="sub-nav-item" href="<?= App::$link_path?>/infrastructure/maps">Карта</a></li>
                    <li><a class="sub-nav-item" href="#">Сети</a></li>
                    <li><a class="sub-nav-item" href="#">Узлы</a></li>
                    <li><a class="sub-nav-item" href="#">Телефонные номера</a></li>
                    <li><a class="sub-nav-item" href="#">Арендованные ресурсы</a></li>
                </ul>
            </li>
            <li><a class="nav-item" href="#">Бухгалтерия</a></li>
            <li><a class="nav-item" href="#">Склад</a></li>
            <li><a class="nav-item" href="#">Календарь</a></li>
            <li>
                <a class="nav-item complex" href="#">Поддержка <i class="fa fa-angle-down"></i></a>
                <ul class="sub-navigation" style="display: none">
                    <li><a class="sub-nav-item" href="#">Автоответчик</a></li>
                    <li><a class="sub-nav-item" href="#">Тикеты</a></li>
                    <li><a class="sub-nav-item" href="#">Оповещания</a></li>
                </ul>
            </li>
            <li><a class="nav-item" href="#">Статистика</a></li>
            <li>
                <a class="nav-item complex" href="#">Управление <i class="fa fa-angle-down"></i></a>
                <ul class="sub-navigation" style="display: none">
                    <li><a class="sub-nav-item" href="#">Отделы</a></li>
                    <li><a class="sub-nav-item" href="#">Сотрудники</a></li>
                    <li><a class="sub-nav-item" href="#">События</a></li>
                    <li><a class="sub-nav-item" href="#">Отладка</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- Displaying the view file -->
    <?= $content ?>
    <!-- End Displaying -->

    <!-- Scripts including -->
    <?= App::includeLibraryScripts() ?>

    <?= App::includingScriptTags() ?>
    <!-- End scripts including (Add js files in assets/AssetLoader) -->
</body>
<!-- Body end -->
</html>
