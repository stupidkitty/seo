<?php
namespace SK\SeoModule\Command;

use Yii;
use yii\console\Controller;
use SK\SeoModule\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionCreate()
    {
        $sitemapGenerator = Yii::$container->get(SitemapGenerator::class);
        $sitemapGenerator->generate();
    }

}
