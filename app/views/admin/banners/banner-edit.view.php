<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
  <div class="row">
    <div class="col-sm-8">
      <div class="headline">
        <h1 class="head head_type_entity">Banner <?= $banner['title'] ?> edit.</h1>
      </div>
      <form action="/admin/banners/post-edit" method="post" enctype="multipart/form-data">

        <fieldset class="fieldset fieldset_type_banner-props">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="" class="form-label">
                  Project directory &nbsp;/&nbsp; Каталог проекта:
                  <span class="form__requied-mark">*</span>
                </label>
                <input type="text" name="banner_project" value="<?= $banner['project'] ?>" class="form-control js-banner-project-input" readonly>
                <p class="help-block help-block_type_error js-banner-project-output"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="" class="form-label">
                  Banner type &nbsp;/&nbsp; Тип баннера:
                  <span class="form__requied-mark">*</span>
                </label>
                <input type="text" name="banner_type" value="<?= $banner['type_slug'] ?>" class="form-control js-banner-type-input" readonly>
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

        <fieldset class="fieldset fieldset_type_banner-file js-banner-file">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="">
                  File &nbsp;/&nbsp; Файл:
                  <span class="form__requied-mark">*</span>
                </label>
                <input type="file" name="banner_file" class="form-control form__file js-banner-file-input">
                <input type="hidden" name="banner_directory" value="<?= $bannerDirectory ?>" class="js-banner-directory-input">
              </div>
              <div class="upload-progress js-upload-progress">
                <span class="upload-progress__status js-upload-progress-status">Готов загружать!</span>
                <span class="upload-progress__result js-upload-progress-result"></span>
              </div>
            </div>
          </div>
        </fieldset>

        <div class="banner-errors banner-errors_is_hidden js-banner-errors"></div>

        <fieldset class="fieldset fieldset_type_banner-paths js-banner-paths">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="" class="form-label">Title &nbsp;/&nbsp; Название:</label>
                <input type="text" name="banner_title" value="<?= $banner['title'] ?>" class="form-control js-banner-title-input" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="" class="form-label">Thumbnail url &nbsp;/&nbsp; Ссылка на миниатюру:</label>
                <input type="text" name="banner_thumb_url" value="<?= $banner['thumbnail_url'] ?>" class="form-control js-banner-thumb-url-input" readonly>
              </div>
              <div class="form-group">
                <label for="" class="form-label">Banner url &nbsp;/&nbsp; Ссылка на баннер:</label>
                <div class="js-banner-urls">
                  <?php foreach ($bannerUrls as $url): ?>
                    <input type="text" name="banner_url[]" value="<?= $url ?>" class="form-control form__input_type_url js-banner-url-input" readonly>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </fieldset>

        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <input type="hidden" name="banner_id" value="<?= $banner['id'] ?>">
              <input type="submit" id="" value="Сохранить изменения" class="btn btn-primary">
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

<script src="<?= HTTP_JS_DIR ?>/validate.js?<?= date('dmy-Gis', filemtime(LOCAL_JS_DIR . '/validate.js')) ?>"></script>
<script src="<?= HTTP_JS_DIR ?>/functions.js?<?= date('dmy-Gis', filemtime(LOCAL_JS_DIR . '/functions.js')) ?>"></script>