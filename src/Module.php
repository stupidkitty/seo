<?php
namespace SK\SeoModule;

use Yii;
use yii\base\Module as BaseModule;
use yii\i18n\PhpMessageSource;
use yii\console\Application as ConsoleApplication;

/**
 * This is the main module class of the seo extension.
 */
class Module extends BaseModule
{
    /**
     * @var string Module cotrollers namespace.
     */
    public $controllerNamespace = 'SK\SeoModule\Controller';

    /**
     * @var string Default route.
     */
    public $defaultRoute = 'main/index';

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, $config = [])
    {
        // default templates path
        $this->setViewPath(__DIR__ . '/Resources/views');

        parent::__construct ($id, $parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'SK\SeoModule\Command';
            $this->defaultRoute = 'run/index';
        }

        $this->initContainer();

        //translations
        if (!isset(Yii::$app->get('i18n')->translations['seo'])) {
            Yii::$app->get('i18n')->translations['seo'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/Resources/i18n',
                'sourceLanguage' => 'en-US',
            ];
        }
    }

    /**
     * Добавляет в контейнер DI необходимые классы.
     */
    protected function initContainer()
    {
        $di = Yii::$container;

        try {
            $di->set(Checker\FileChecker::class);
            $di->set(Checker\PageChecker::class);
            $di->set(Sitemap\SitemapGenerator::class);
        } catch (Exception $e) {
            die($e);
        }
    }
}
