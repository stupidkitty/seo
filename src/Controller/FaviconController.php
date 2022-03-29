<?php
namespace SK\SeoModule\Controller;

use Yii;
use yii\web\Controller;
use yii\web\Response;
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
    public function behaviors(): array
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
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Upload favicon.ico
     *
     * @return Response
     */
    public function actionUpload(): Response
    {
        $form = new IconUploadForm();

        if ($form->isValid()) {
            $path = Yii::getAlias('@root/web');
            $form->icon->saveAs("{$path}/{$form->icon->baseName}.{$form->icon->extension}");
        } else {
            Yii::$app->session->addFlash('error', implode('<br>', $form->getErrorSummary(true)));
        }

        return $this->redirect(['index']);
    }
}
