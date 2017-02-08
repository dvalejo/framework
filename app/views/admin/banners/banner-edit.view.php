<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="headline">
                <h1 class="head head_type_entity">Banner <?= $banner['title'] ?> edit.</h1>
            </div>
            <form action="/admin/banners/post-edit" method="post">

                <fieldset class="fieldset fieldset_type_banner-project">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    Project directory &nbsp;/&nbsp; Каталог проекта:
                                    <span class="form__requied-mark">*</span>
                                </label>
                                <input type="text" name="banner_project" value="<?= $banner['project'] ?>" id="" class="form-control js-banner-project-input" readonly>
                                <p class="help-block help-block_type_error js-banner-project-output"></p>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="fieldset fieldset_type_banner-props">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    Banner type &nbsp;/&nbsp; Тип баннера:
                                    <span class="form__requied-mark">*</span>
                                </label>
                                <input type="hidden" name="banner_type" value="<?= $banner['type_slug'] ?>">
                                <select name="banner_type" class="form-control js-banner-type-input" disabled>
                                    <option value="">Тип баннера</option>
                                    <?php foreach ($types as $type): ?>
                                        <?php if ($type['slug'] === $banner['type_slug']) { ?>
                                            <option value="<?= $type['slug'] ?>" selected><?= $type['name'] ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $type['slug'] ?>"><?= $type['name'] ?></option>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </select>
                                <p class="help-block help-block_type_error js-banner-type-output"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    Width &nbsp;/&nbsp; Ширина:
                                    <span class="form__requied-mark">*</span>
                                </label>
                                <input type="text" name="banner_width" value="<?= $banner['width'] ?>" class="form-control js-banner-width-input">
                                <p class="help-block help-block_type_error js-banner-width-output"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="form-label">
                                    Height &nbsp;/&nbsp; Высота:
                                    <span class="form__requied-mark">*</span>
                                </label>
                                <input type="text" name="banner_height" value="<?= $banner['height'] ?>" class="form-control js-banner-height-input">
                                <p class="help-block help-block_type_error js-banner-height-output"></p>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="fieldset fieldset_type_upload js-banner-file">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">
                                    Banner file &nbsp;/&nbsp; Файл баннера:
                                    <span class="form__requied-mark">*</span>
                                </label>
                                <input type="file" name="banner_file" class="form-control form__file js-banner-file-input">
                            </div>
                            <div class="form__block form__block_is_hidden js-banner-file-status"></div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="fieldset fieldset_type_banner-title js-banner-title">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">Title &nbsp;/&nbsp; Название:</label>
                                <input type="text" name="banner_title" value="<?= $banner['title'] ?>" class="form-control js-banner-title-input">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="fieldset fieldset_type_banner-paths js-banner-paths">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">Banner directory &nbsp;/&nbsp; Каталог баннера:</label>
                                <input type="text" name="banner_directory" value="<?= $banner['directory'] ?>" class="form-control form__input js-banner-dir-input">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">Banner URL &nbsp;/&nbsp; Ссылка на баннер:</label>
                                <div class="js-banner-urls">
                                    <?php foreach ($bannersUrls as $bannerUrl): ?>
                                        <input type="text" name="banner_url[]" value="<?= $bannerUrl ?>" class="form-control form__input form__input_type_url js-banner-url-input">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="form-label">Thumbnail URL &nbsp;/&nbsp; Ссылка на миниатюру:</label>
                                <input type="text" name="banner_thumb_url" value="<?= $banner['thumb_url'] ?>" class="form-control form__input js-banner-thumb-url-input">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="hidden" name="banner_id" value="<?= $banner['id'] ?>">
                            <input type="submit" name="banner_edit" id="" value="Сохранить изменения" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-4">
            <h1 class="head">Help</h1>
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

<script src="<?= HTTP_JS_DIR ?>/validate.js"></script>