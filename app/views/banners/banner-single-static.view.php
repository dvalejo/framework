<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php if (empty($banner)) { ?>
                <h1>Извините, не можем найти этот баннер.</h1>
            <?php } else { ?>
                <h1 class="head"><?= $banner['title'] ?></h1>
                <div class="banner-single">
                    <?php foreach ($banner['url'] as $bannerUrl): ?>
                    <div class="banner-single__block">
                        <img src="<?= $bannerUrl ?>" class="img-responsive">
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
