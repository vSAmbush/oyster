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
    <script type="text/javascript">
        $('#enter_btn').on('click', function (e) {

            e.preventDefault();

            $(this).hide();
            $('#login').hide();
            $('#password').hide();
            $('#answer').hide();
            $('#loader').show();

            var phone = $('#login').val();
            var passwd = $('#password').val();

            $.ajax({
                type: 'POST',
                //clear /crm on remote server
                url: '<?= App::$link_path ?>/auth/authentication/',
                data: {
                    login: phone,
                    password: passwd
                },
                success: function(answer) {
                    console.log(answer);
                    if (answer === 'code') {
                        setTimeout(showCode, 1000);
                    }
                    if (answer === 'wrong') {
                        //setTimeout with parameters
                        setTimeout(showError, 1000, 'code');
                    }
                    if (answer === 'fail') {
                        setTimeout(showError, 1000, 'phone');
                    }
                    if (answer === 'success') {
                        flag = false;
                        //AND HERE CLEAR /crm on remote server
                        setTimeout(window.location.href = '<?= App::$link_path ?>/auth/saveuser', 1000);
                    }
                    return false;
                },
                error: function() {
                    alert('Error!');
                    window.location.reload();
                }
            });
        });
    </script>
</body>
<!-- Body end -->
</html>
