<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.10.2018
 * Time: 16:48
 */

use lib\App;
use lib\Config;

/**
 * App::$image_path - path to image resources, ends on '/'
 */
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
