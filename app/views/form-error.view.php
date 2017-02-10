<div class="container">
    <div class="errors">
        <div class="errors__head">Пожалуйста, обратите внимание:</div>
        <ol class="errors__list">
            <?php foreach ($formErrors as $error): ?>
                <li class="errors__item"><?= $error ?></li>
            <?php endforeach; ?>
        </ol>
        <p><a href="<?= Request::referer() ?>">Обратно к форме</a></p>
    </div>
</div>