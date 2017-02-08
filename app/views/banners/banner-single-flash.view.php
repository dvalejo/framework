<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php if (empty($banner)) { ?>
                <h1>Извините, не можем найти этот баннер.</h1>
            <?php } else { ?>
                <h1 class="head"><?= $banner['title'] ?></h1>
                <div class="banner-single">
                    <div class="banner-single__block">
                        <object type="application/x-shockwave-flash" data="<?= $banner['url'] ?>" width="<?= $banner['width'] ?>" height="<?= $banner['height'] ?>" style="float: none; vertical-align:middle">
                            <param name="movie" value="ssk-inform-225-328-v4_flash.swf" />
                            <param name="quality" value="high" />
                            <param name="bgcolor" value="#ffffff" />
                            <param name="play" value="true" />
                            <param name="loop" value="true" />
                            <param name="wmode" value="window" />
                            <param name="scale" value="showall" />
                            <param name="menu" value="true" />
                            <param name="devicefont" value="false" />
                            <param name="salign" value="" />
                            <param name="allowScriptAccess" value="sameDomain" />
                            <a href="http://www.adobe.com/go/getflash">
                                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                            </a>
                        </object>
                    </div>
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
