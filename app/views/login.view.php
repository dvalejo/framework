<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container container_type_login">
    <div class="row">
        <div class="col-sm-2 col-md-3"></div>
        <div class="col-sm-8 col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="headline">
                        <h1 class="head head_type_entity">Вход для пользователей.</h1>
                    </div>
                    <form action="/post-login" method="post">
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
                                    <input type="submit" name="user_login" value="Войти" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-2 col-md-3"></div>
    </div>
</div>