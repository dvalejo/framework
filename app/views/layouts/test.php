<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Site</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= HTTP_STYLESHEET_DIR . '/main.css?' . date('dmy-Gis', filemtime(LOCAL_STYLESHEET_DIR . '/main.css')) ?>">
    <!-- Place favicon.ico in the root directory -->
</head>
<body>

<div class="main-menu-bg">
    <div class="container">
        <div class="main-menu">
            <div class="main-menu__item">
                <a class="main-menu__link" href="/">Главная</a>
            </div>
            <div class="main-menu__item">
                <a class="main-menu__link" href="/banners/">Баннеры</a>
            </div>
            <div class="main-menu__item">
                <a class="main-menu__link" href="/prices/">Цены</a>
            </div>
            <div class="main-menu__item">
                <a class="main-menu__link" href="/about/">О нас</a>
            </div>
        </div>
    </div>
</div>

<div class="test">
    <?= $content ?>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="<?= HTTP_JS_DIR ?>/main.js?<?= date('dmy-Gis', filemtime(LOCAL_JS_DIR . '/main.js')) ?>"></script>
<script src="<?= HTTP_JS_DIR ?>/menu.js?<?= date('dmy-Gis', filemtime(LOCAL_JS_DIR . '/menu.js')) ?>"></script>
</body>
</html>