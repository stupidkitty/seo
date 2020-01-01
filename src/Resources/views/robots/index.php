<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Seo';
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
        <?= Html::beginForm(['update'], 'post', ['id' => 'robots-update']) ?>
            <?= Html::textarea('robots', $robots, ['rows' => 10, 'style' => 'width:100%;max-width:100%']) ?>
        <?= Html::endForm() ?>
    </div>

    <div class="box-footer">
        <div class="col-md-3 col-md-offset-1">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'form' => 'robots-update']) ?>
            </div>
        </div>
    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <i class="fa fa-info"></i><h3 class="box-title">Полезное</h3>
    </div>

    <div class="box-body pad">
        <a href="https://yandex.ru/support/webmaster/controlling-robot/robots-txt.html" target="_blank">Яндекс: Использование robots.txt</a><br>
        <a href="https://developers.google.com/search/reference/robots_txt?hl=ru" target="_blank">Google: Спецификации файла robots.txt</a><br>
        <br>

        <a href="https://webmaster.yandex.ru/tools/robotstxt/?hostName=<?= $_SERVER['HTTP_HOST'] ?>" target="_blank">Проверить роботс в яндексе</a><br>
    </div>
</div>

<?php

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

$this->registerJs($js, View::POS_END);
