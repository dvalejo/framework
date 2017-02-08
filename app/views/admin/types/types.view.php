<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1 class="head head_type_entity">Типы.</h1>
                <a href="/admin/types/add" class="headline__btn">Добавить тип</a>
            </div>
            <?php if (empty($types) === true) { ?>
                <p>Типов пока нет.</p>
            <?php } else { ?>
                <table class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>slug</th>
                    <th>banners quantity</th>
                    <th>edit</th>
                    <th>delete</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($types as $type): ?>
                    <tr>
                        <td><?= $type['id'] ?></td>
                        <td><?= $type['name'] ?></td>
                        <td><?= $type['slug'] ?></td>
                        <td><?= $type['quantity'] ?></td>
                        <td>
                            <a href="/admin/types/<?= $type['id'] ?>/edit">edit</a>
                        </td>
                        <td>
                            <a href="/admin/types/<?= $type['id'] ?>/delete">delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>
</div>