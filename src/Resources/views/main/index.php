<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Чекер';
$this->params['subtitle'] = 'robots.txt';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['main/index'],
];

$this->params['breadcrumbs'][] = $this->params['subtitle'];

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-edit"></i><h3 class="box-title">Редактирование robots.txt</h3>
    </div>

    <div class="box-body pad">

    </div>

    <div class="box-footer">
        <div class="col-md-3 col-md-offset-1">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
