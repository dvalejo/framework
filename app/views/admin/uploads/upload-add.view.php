<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="headline">
                <h1 class="head head_type_entity">Загрузить.</h1>
            </div>
            <form action="/admin/uploads/post-add" method="post">
                <fieldset class="fieldset fieldset_type_upload-file js-upload-file">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">
                                    File &nbsp;/&nbsp; Файл:
                                    <span class="form__requied-mark">*</span>
                                </label>
                                <input type="file" name="upload_file" class="form-control form__file js-upload-file-input">
                            </div>
                            <div class="upload-progress js-upload-progress">
                                <span class="upload-progress__status js-upload-progress-status">Готов загружать!</span>
                                <span class="upload-progress__result js-upload-progress-result"></span>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="fieldset fieldset_type_upload-directory js-upload-directory" disabled>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">Directory &nbsp;/&nbsp; Каталог:</label>
                                <input type="text" name="upload_directory" value="" class="form-control js-upload-directory-input">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="submit" id="" value="Добавить в базу" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-4">
            <h1 class="head">Помощь</h1>
            <p>Общая структура портфолио выглядит так:</p>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="portfolio-scheme">
                        <div class="portfolio-scheme__item portfolio-scheme__item-1">portfolio</div>
                        <div class="portfolio-scheme__item portfolio-scheme__item-2">banners</div>
                        <div class="portfolio-scheme__item portfolio-scheme__item-3">Тип баннера</div>
                        <div class="portfolio-scheme__item portfolio-scheme__item-4">Название проекта</div>
                        <div class="portfolio-scheme__item portfolio-scheme__item-5">Каталог баннера</div>
                        <div class="portfolio-scheme__item portfolio-scheme__item-6">Файл баннера</div>
                    </div>
                </div>
            </div>

            <p><strong>Project directory</strong> - это название проекта. Также, является именем каталога проекта.
                То есть, например, вы указываете название проекта - «ferma.ru».
                Создаётся каталог с именем проекта и в него помещается баннер.
                В одном проекте может быть более одного баннера.
            </p>
            <p><strong>Banner type</strong> - тип баннера. У каждого типа баннера есть свой каталог. Общая структура портфолио выглядит </p>
        </div>
    </div>
</div>

<!--<script src="--><?//= HTTP_JS_DIR ?><!--/validate.js"></script>-->