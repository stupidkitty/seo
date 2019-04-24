<?php
namespace SK\SeoModule\Controller;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\base\DynamicModel;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RobotsController
 */
class RobotsController extends Controller
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
        $baseUrl = rtrim(Yii::$app->frontUrlManager->createAbsoluteUrl(['/']), '/');

        $robots = '';
        $errors = [];
        try {
            $robots = file_get_contents(Yii::getAlias('@root/web/robots.txt'));
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        $headers = get_headers("{$baseUrl}/robots.txt");
        $responseCode = $headers[0];

        return $this->render('index', [
            'robots' => $robots,
            'responseCode' => $responseCode,
        ]);
    }

    /**
     * Update robots.txt
     *
     * @return mixed
     */
    public function actionUpdate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $robots = Yii::$app->request->post('robots', '');

        $robotsForm = new DynamicModel(compact('robots'));
        $robotsForm->addRule(['robots'], 'string', ['max' => 3000]);

        if (!$robotsForm->validate()) {
            return [
                'error' => [
                    'code' => 422,
                    'message' => implode('<br>', $robotsForm->gerErrorSummary(true)),
                ]
            ];
        }

        try {
            file_put_contents(Yii::getAlias('@root/web/robots.txt'), trim($robots));

            return '';
        } catch (\Exception $e) {
            return [
                'error' => [
                    'code' => 422,
                    'message' => $e->getMessage(),
                ]
            ];
        }

    }
}
