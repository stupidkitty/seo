<?php
namespace SK\SeoModule\Sitemap;

use Yii;
use yii\helpers\FileHelper;
use RS\Component\Core\Settings\SettingsInterface;

class SitemapBuilder
{
    public $generators = [];
    public $baseSitemapUrl;
    public $outputDirectory = '@app/web/sitemap';

    private $settings;

    public function __construct(SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    public function build()
    {
        $sitemapGenerator = $this->buildGenerator();

        if (empty($this->baseSitemapUrl)) {
            $siteUrl = rtrim($this->settings->get('site_url', 'https://site.com/'), '/');

            $sitemapGenerator->setBaseSitemapUrl("{$siteUrl}/sitemap/");
        } else {
            $sitemapGenerator->setBaseSitemapUrl($this->baseSitemapUrl);
        }

        $outputDirectory = Yii::getAlias($this->outputDirectory);

        if (!is_dir($outputDirectory)) {
            FileHelper::createDirectory($outputDirectory, 0755);
        }

        $sitemapGenerator->setOutputDirectory($outputDirectory);

        foreach ($this->generators as $generatorConfig) {
            $generator = Yii::createObject($generatorConfig);

            $sitemapGenerator->addGenerator($generator);
        }

        return $sitemapGenerator;
    }

    public function buildGenerator()
    {
        return new SitemapGenerator;
    }

    public function addGenerator($generator): self
    {
        $this->generators[] = $generator;

        return $this;
    }

    public function setBaseSitemapUrl(string $baseSitemapUrl): self
    {
        $this->baseSitemapUrl = $baseSitemapUrl;

        return $this;
    }

    public function setOutputDirectory(string $outputDirectory = '@app/web'): self
    {
        $this->outputDirectory = $outputDirectory;

        return $this;
    }
}
