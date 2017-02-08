<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1 class="head head_type_entity">Добавление пользователя.</h1>
            </div>
            <form action="/admin/users/post-add" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Имя:</label>
                            <input type="text" name="user_name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Пароль:</label>
                            <input type="password" name="user_password" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Повтор пароля:</label>
                            <input type="password" name="user_password_repeat" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="submit" name="user_add" value="Добавить нового пользователя" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>