<?php
namespace SK\SeoModule\Controller;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use SK\SeoModule\Form\IconUploadForm;

/**
 * FaviconController
 */
class FaviconController extends Controller
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
                    'upload' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Show upload favicon form;
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Upload favicon.ico
     *
     * @return mixed
     */
    public function actionUpload()
    {
        $form = new IconUploadForm();
        $form->icon = UploadedFile::getInstance($form, 'icon');

        if ($form->isValid()) {
            $path = Yii::getAlias('@root/web');
            $form->icon->saveAs("{$path}/{$form->icon->baseName}.{$form->icon->extension}");
        } else {
            Yii::$app->session->addFlash('error', implode('<br>', $form->getErrorSummary(true)));
        }

        $this->redirect(['index']);
    }
}
