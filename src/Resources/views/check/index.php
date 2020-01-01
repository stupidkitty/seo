<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('seo', 'Seo');
$this->params['subtitle'] = 'robots.txt';

$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['main/index'],
];

$this->params['breadcrumbs'][] = $this->params['subtitle'];

?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-check-square-o"></i><h3 class="box-title">Проверка страниц по http</h3>
            </div>

            <div class="box-body pad">

                <div class="seo-report">
                    <?php foreach ($reportPages as $report): ?>
                        <div class="seo-report__row">
                            <?php if (!$report->hasError()): ?>
                                <div class="seo-report__title">
                                    <i class="fa fa-fw fa-check text-green"></i>
                                    <?= Html::a($report->getUrl(), $report->getUrl(), ['target' => '_blank']) ?>
                                </div>
                                <ul class="check-list">
                                    <li class="check-list__item">
                                        <?php if ($report->getStatusCode() >= 200 && $report->getStatusCode() <= 299): ?>
                                            <i class="fa fa-fw fa-check text-green"></i>
                                        <?php else: ?>
                                            <i class="fa fa-fw fa-close text-red"></i>
                                        <?php endif ?>
                                        <label class="check-list__label">Status code:</label><?= $report->getStatusCode() ?>
                                    </li>
                                    <li class="check-list__item">
                                        <?php if ($report->getResponseTime() <= 100): ?>
                                            <i class="fa fa-fw fa-check text-green"></i>
                                        <?php elseif ($report->getResponseTime() <= 200): ?>
                                            <i class="fa fa-fw fa-warning text-orange"></i>
                                        <?php else: ?>
                                            <i class="fa fa-fw fa-close text-red"></i>
                                        <?php endif ?>
                                        <label class="check-list__label">Request processing time:</label><?= $report->getResponseTime() ?> ms
                                    </li>
                                    <li class="check-list__item">
                                        <?php if ($report->hasMetaTitle()): ?>
                                            <i class="fa fa-fw fa-check text-green"></i>
                                        <?php else: ?>
                                            <i class="fa fa-fw fa-close text-red"></i>
                                        <?php endif ?>
                                        <label class="check-list__label">Meta title:</label><?= $report->getMetaTitle() ?>
                                    </li>
                                    <li class="check-list__item">
                                        <?php if ($report->hasMetaDescription()): ?>
                                            <i class="fa fa-fw fa-check text-green"></i>
                                        <?php else: ?>
                                            <i class="fa fa-fw fa-close text-red"></i>
                                        <?php endif ?>
                                        <label class="check-list__label">Meta Description:</label><?= $report->getMetaDescription() ?>
                                    </li>
                                    <li class="check-list__item">
                                        <?php if ($report->hasCanonical() && $report->canonicalEqualUrl()): ?>
                                            <i class="fa fa-fw fa-check text-green"></i>
                                        <?php elseif (!$report->hasCanonical()): ?>
                                            <i class="fa fa-fw fa-close text-red"></i>
                                        <?php elseif (!$report->canonicalEqualUrl()): ?>
                                            <i class="fa fa-fw fa-warning text-orange"></i>
                                        <?php endif ?>
                                        <label class="check-list__label">Canonical:</label><?= $report->getCanonical() ?>
                                    </li>
                                    <li class="check-list__item">
                                        <?php if ($report->hasH1()): ?>
                                            <i class="fa fa-fw fa-check text-green"></i>
                                        <?php else: ?>
                                            <i class="fa fa-fw fa-close text-red"></i>
                                        <?php endif ?>
                                        <label class="check-list__label">Tag H1:</label><?= $report->getH1() ?>
                                    </li>
                                </ul>
                            <?php else: ?>
                                <div class="seo-report__title">
                                    <i class="fa fa-fw fa-close text-red"></i>
                                    <span class="text-red"><?= $report->getUrl() ?></span>
                                </div>
                                <ul class="check-list">
                                    <li class="check-list__item">
                                        <?php if ($report->getStatusCode() >= 200 && $report->getStatusCode() <= 299): ?>
                                            <i class="fa fa-fw fa-check text-green"></i>
                                        <?php else: ?>
                                            <i class="fa fa-fw fa-close text-red"></i>
                                        <?php endif ?>
                                        <label class="check-list__label">Status code:</label><?= $report->getStatusCode() ?>
                                    </li>
                                    <li class="check-list__item">
                                        <?php if ($report->getResponseTime() <= 100): ?>
                                            <i class="fa fa-fw fa-check text-green"></i>
                                        <?php elseif ($report->getResponseTime() <= 200): ?>
                                            <i class="fa fa-fw fa-warning text-orange"></i>
                                        <?php else: ?>
                                            <i class="fa fa-fw fa-close text-red"></i>
                                        <?php endif ?>
                                        <label class="check-list__label">Request processing time:</label><?= $report->getResponseTime() ?> ms
                                    </li>
                                    <li class="check-list__item">
                                        <i class="fa fa-fw fa-warning text-orange"></i>
                                        <label class="check-list__label">Error:</label><?= Html::encode($report->getError()) ?>
                                    </li>
                                </ul>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-check-square-o"></i><h3 class="box-title">Проверка файлов по http</h3>
            </div>

            <div class="box-body no-padding">

                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px"></th>
                            <th>Url</th>
                            <th style="width: 40px">Status</th>
                            <th>Size</th>
                            <th>Last modified</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportFiles as $report): ?>
                            <tr>
                                <td>
                                    <?php if ($report->hasError()): ?>
                                        <i class="fa fa-fw fa-close text-red"></i>
                                    <?php else: ?>
                                        <i class="fa fa-fw fa-check text-green"></i>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php if ($report->hasError()): ?>
                                        <span class="text-red"><?= $report->getUrl() ?></span>
                                    <?php else: ?>
                                        <?= Html::a($report->getUrl(), $report->getUrl(), ['target' => '_blank']) ?>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?= $report->getStatusCode() ?>
                                </td>
                                <td><?= Yii::$app->formatter->asShortSize($report->getSize()) ?></td>
                                <td><?= Yii::$app->formatter->asDateTime($report->getLastModified()) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
