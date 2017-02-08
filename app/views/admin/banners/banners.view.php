<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1 class="head head_type_entity">Баннеры.</h1>
                <a href="/admin/banners/add" class="headline__btn">Добавить баннер</a>
            </div>
            <?php if (empty($banners) === true) { ?>
                <p>Баннеров пока нет.</p>
            <?php } else { ?>
                <table class="table table_type_admin">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>project</th>
                        <th>upload_id</th>
                        <th>title</th>
                        <th>type</th>
                        <th>size</th>
                        <th>edit</th>
                        <th>delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($banners as $banner): ?>
                        <tr>
                            <td><?= $banner['id'] ?></td>
                            <td><?= $banner['project'] ?></td>
                            <td><?= $banner['upload_id'] ?></td>
                            <td><?= $banner['title'] ?></td>
                            <td><?= $banner['type_name'] ?></td>
                            <td><?= $banner['width'] ?> x <?= $banner['height'] ?></td>
                            <td>
                                <a href="/admin/banners/<?= $banner['id'] ?>/edit">edit</a>
                            </td>
                            <td>
                                <a href="/admin/banners/<?= $banner['id'] ?>/delete">delete</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>


