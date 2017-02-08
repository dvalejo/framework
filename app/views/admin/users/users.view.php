<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1 class="head head_type_entity">Пользователи.</h1>
                <a href="/admin/users/add" class="headline__btn">Добавить пользователя</a>
            </div>
            <?php if (empty($users) === true) { ?>
                <p>Пользователей пока нет.</p>
            <?php } else { ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>token</th>
                        <th>created_at</th>
                        <th>delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['token'] ?></td>
                            <td><?= $user['created_at'] ?></td>
                            <td>
                                <a href="/admin/users/<?= $user['id'] ?>/delete">delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>