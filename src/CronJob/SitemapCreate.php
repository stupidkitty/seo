<?php
namespace SK\SeoModule\CronJob;

use Yii;
use SK\SeoModule\Sitemap\SitemapGenerator;
use SK\CronModule\Handler\HandlerInterface;

class SitemapCreate implements HandlerInterface
{
    public function run()
    {
        $sitemapGenerator = Yii::$container->get(SitemapGenerator::class);
        $sitemapGenerator->generate();
    }
}
