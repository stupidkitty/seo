<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('seo', 'seo');
$this->params['subtitle'] = 'favicons';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['main/index'],
];

$this->params['breadcrumbs'][] = $this->params['subtitle'];

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-upload"></i><h3 class="box-title">Загрузка иконки</h3>
    </div>

    <div class="box-body pad">
        <div class="" style="margin-bottom:10px;">
            <img src="/favicon.ico?t=<?= time() ?>" alt="favicon">
        </div>
        <?= Html::beginForm(['upload'], 'post', ['id' => 'favicon-upload', 'enctype' => 'multipart/form-data']) ?>
            <?= Html::fileInput('icon') ?>
        <?= Html::endForm() ?>
    </div>

    <div class="box-footer">
        <div class="col-md-3 col-md-offset-1">
            <div class="form-group">
                <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary', 'form' => 'favicon-upload']) ?>
            </div>
        </div>
    </div>
</div>

<?php
/*
$js = <<< 'JS'
    let robotsForm = document.querySelector('#robots-update');

    robotsForm.addEventListener('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();

        let sendUrl = robotsForm.getAttribute('action');
        let formData = new FormData(robotsForm);

        fetch(sendUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        }).then(function(response) {
            if (!response.ok) {
                throw new Error(response.statusText);
            }

            return response.json();
        }).then(function(data) {
            if (data.error !== undefined) {
                throw new Error(data.error.message);
            }

            toastr.success('File robots.txt updated');
        }).catch(function(error) {
            toastr.error(error.message);
        });
    });
JS;

$this->registerJs($js, View::POS_END);*/
