<?php
namespace SK\SeoModule\Controller;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CheckController
 */
class CheckController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'update' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Show robot edit form;
     * @return mixed
     */
    public function actionIndex()
    {
        $fileChecker = Yii::$container->get('SK\SeoModule\Checker\FileChecker');
        $pageChecker = Yii::$container->get('SK\SeoModule\Checker\PageChecker');

        $reportFiles = $fileChecker->checkAll();
        $reportPages = $pageChecker->checkAll();

        return $this->render('index', [
            'reportFiles' => $reportFiles,
            'reportPages' => $reportPages,
        ]);
    }
}
