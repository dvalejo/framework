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
                        <th>Проект</th>
                        <th>Название</th>
                        <th>Тип</th>
                        <th>Размеры</th>
                        <th>Дата обновления</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($banners as $banner): ?>
                        <tr>
                            <td><?= $banner['id'] ?></td>
                            <td><?= $banner['project'] ?></td>
                            <td><?= $banner['title'] ?></td>
                            <td><?= $banner['type_name'] ?></td>
                            <td><?= $banner['width'] ?> x <?= $banner['height'] ?></td>
                            <td><?= $banner['updated_at'] ?></td>
                            <td>
                                <a href="/admin/banners/<?= $banner['id'] ?>/edit" class="banners__link banners__link_type_edit">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </a>
                                <a href="/admin/banners/<?= $banner['id'] ?>/delete" class="banners__link banners__link_type_delete">
                                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>


