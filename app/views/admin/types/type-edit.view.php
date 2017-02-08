<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1 class="head head_type_entity">Редактировать тип.</h1>
            </div>
            <form action="/admin/types/post-edit" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Название:</label>
                            <input type="text" name="type_name" value="<?= $type['name'] ?>" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Slug:</label>
                            <input type="text" name="type_slug" value="<?= $type['slug'] ?>" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="hidden" name="type_id" value="<?= $type['id'] ?>">
                            <input type="submit" name="type_edit" value="Сохранить изменения" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>