<?php
namespace SK\SeoModule\CronJob;

use Yii;
use SK\SeoModule\Sitemap\SitemapBuilder;
use App\Infrastructure\Cron\HandlerInterface;

class SitemapCreate implements HandlerInterface
{
    public function run(): void
    {
        $sitemapBuilder = Yii::$container->get(SitemapBuilder::class);

        $sitemapGenerator = $sitemapBuilder->build();
        $sitemapGenerator->generate();
    }
}
