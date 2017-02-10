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
        <div class="menu main-menu">
            <div class="menu__item main-menu__item">
                <a class="menu__link main-menu__link" href="/admin/">Главная</a>
            </div>
            <div class="menu__item main-menu__item">
                <a class="menu__link main-menu__link" href="/admin/banners/">Баннеры</a>
                <div class="submenu submenu_type_main is_hidden">
                    <div class="submenu__item">
                        <a class="submenu__link" href="/admin/banners/add">Добавить баннер</a>
                    </div>
                </div>
            </div>
            <div class="menu__item main-menu__item">
                <a class="menu__link main-menu__link" href="/admin/types/">Типы</a>
            </div>
            <div class="menu__item main-menu__item">
                <a class="menu__link main-menu__link" href="/admin/uploads/">Загрузки</a>
            </div>
            <div class="menu__item main-menu__item main-menu__separator">|</div>
            <div class="menu__item main-menu__item">
                <a class="menu__link main-menu__link" href="/admin/users/">Пользователи</a>
            </div>
            <div class="menu__item main-menu__item main-menu__item_type_logout">
                <a class="menu__link main-menu__link main-menu__link_type_logout" href="/logout">Выйти</a>
            </div>
        </div>
    </div>
</div>

<?= $content ?>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="footer__content">

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="<?= HTTP_JS_DIR ?>/main.js?<?= date('dmy-Gis', filemtime(LOCAL_JS_DIR . '/main.js')) ?>"></script>
<script src="<?= HTTP_JS_DIR ?>/menu.js?<?= date('dmy-Gis', filemtime(LOCAL_JS_DIR . '/menu.js')) ?>"></script>
</body>
</html>