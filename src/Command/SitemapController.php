<?php
namespace SK\SeoModule\Command;

use Yii;
use yii\console\Controller;
use SK\SeoModule\Sitemap\SitemapBuilder;

class SitemapController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionCreate()
    {
        $sitemapBuilder = Yii::$container->get(SitemapBuilder::class);

        $sitemapGenerator = $sitemapBuilder->build();
        $sitemapGenerator->generate();
    }

}
