<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1 class="head head_type_banners">Баннеры.</h1>
            </div>
            <?php if (empty($banners) === true): ?>
                <p>На данный момент баннеров нет.</p>
            <?php else: ?>
                <div class="banners">
                <?php foreach ($banners as $banner): ?>
                    <div class="banners__item banner">
                        <div class="banner__title">
                            <a href="/banners/<?= $banner['id'] ?>/"><?= $banner['title'] ?></a>
                        </div>
                        <div class="banner__thumb">
                            <a href="/banners/<?= $banner['id'] ?>/">
                                <img src="<?= $banner['thumbnail_url'] ?>" class="" alt="">
                            </a>
                            <div class="banner__type banner__type_<?= strtolower($banner['t_name']) ?>">
                                <?= $banner['t_name'] ?>
                            </div>
                            <div class="banner__size">
                                <?= $banner['width'] . ' x ' . $banner['height'] ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


