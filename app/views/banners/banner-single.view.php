<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php if (empty($banner)) { ?>
                <h1>Извините, не можем найти этот баннер.</h1>
            <?php } else { ?>
                <h1 class="head"><?= $banner['title'] ?></h1>
                <div class="banner-single">
                    <div class="banner-single__img">
                        <img src="<?= $banner['url'] ?>" class="img-responsive" alt="">
                    </div>
                    <div class="banner-single__block"></div>
                    <div class="banner-single__type">
                        <?= $banner['type_slug'] ?>
                    </div>
                    <div class="banner-single__size">
                        <?= $banner['width'] . ' x ' . $banner['height'] ?>
                    </div>
                    <div class="banner-single__description">
                        <?= $banner['description'] ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>