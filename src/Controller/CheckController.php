<?php
namespace SK\SeoModule\Controller;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use RS\Component\Core\Traits\ContainerAwareTrait;

/**
 * CheckController
 */
class CheckController extends Controller
{
    use ContainerAwareTrait;

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

        //dump($pagesInfo); exit;

        /*$baseUrl = rtrim(Yii::$app->frontUrlManager->createAbsoluteUrl(['/']), '/');

        $robots = '';
        $errors = [];
        try {
            $robots = file_get_contents(Yii::getAlias('@root/web/robots.txt'));
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        $headers = get_headers("{$baseUrl}/robots.txt");
        $responseCode = $headers[0];*/

        return $this->render('index', [
            'reportFiles' => $reportFiles,
            'reportPages' => $reportPages,
        ]);
    }
}
