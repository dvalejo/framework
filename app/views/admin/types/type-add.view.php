<?php if (!defined('ABSPATH')) die('-1'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="headline">
                <h1 class="head head_type_entity">Добавить тип.</h1>
            </div>
            <form action="/admin/types/post-add" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Название:</label>
                            <input type="text" name="type_name" class="form-control" placeholder="название типа...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Slug:</label>
                            <input type="text" name="type_slug" class="form-control" placeholder="slug типа...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="submit" value="Добавить новый тип" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>