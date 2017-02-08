<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1 class="head head_type_entity">Редактирование профиля пользователя.</h1>
            </div>
            <form action="/admin/users/post-edit" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Name:</label>
                            <input type="text" name="user_name" value="<?= $user['name'] ?>" class="form-control">
                        </div>
                    </div>
                </div>
<!--                    <div class="row">-->
<!--                        <div class="col-sm-12">-->
<!--                            <div class="form-group">-->
<!--                                <label for="">Password:</label>-->
<!--                                <input type="text" name="user_password" value="--><?//= $user['password'] ?><!--" class="form-control">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="submit" name="user_add" value="Submit changes" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>