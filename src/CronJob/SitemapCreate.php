<?php
namespace SK\SeoModule\CronJob;

use Yii;
use SK\SeoModule\Sitemap\SitemapBuilder;
use SK\CronModule\Handler\HandlerInterface;

class SitemapCreate implements HandlerInterface
{
    public function run()
    {
        $sitemapBuilder = Yii::$container->get(SitemapBuilder::class);

        $sitemapGenerator = $sitemapBuilder->build();
        $sitemapGenerator->generate();
    }
}
