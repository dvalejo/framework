<?php if (!defined('ABSPATH')) die('-1'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1 class="head head_type_entity">Загрузки.</h1>
                <a href="/admin/uploads/clean" class="headline__btn">Удалить неиспользуемые</a>
            </div>
            <?php if (empty($uploads) === true) { ?>
                <p>Загрузок пока нет.</p>
            <?php } else { ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>directory</th>
                        <th>created_at</th>
                        <th>delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($uploads as $upload): ?>
                        <tr>
                            <td><?= $upload['id'] ?></td>
                            <td><?= $upload['directory_temp'] ?></td>
<!--                            --><?php //if ($upload['in_use'] == 1) { ?>
<!--                                <td><span class="label label-success">--><?//= $upload['in_use'] ?><!--</span></td>-->
<!--                            --><?php //} else { ?>
<!--                                <td><span class="label label-warning">--><?//= $upload['in_use'] ?><!--</span></td>-->
<!--                            --><?php //} ?>
                            <td><?= $upload['created_at'] ?></td>
                            <td><a href="/admin/uploads/<?= $upload['directory_temp'] ?>/delete">delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>