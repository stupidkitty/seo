<?php
namespace SK\SeoModule\Sitemap;

use samdark\sitemap\Index;
use samdark\sitemap\Sitemap;

/**
 * https://github.com/samdark/sitemap
 */
class SitemapGenerator
{
    private $baseSitemapUrl;
    private $outputDirectory;

    private $generators = [];

    /**
     * Генерация карт сайта.
     */
    public function generate()
    {
        $index = new Index("{$this->outputDirectory}/index.xml");

        $createdSitemaps = [];
        foreach ($this->generators as $generator) {
            $urls = $this->handle($generator);

            $createdSitemaps = \array_merge($createdSitemaps, $urls);
        }

        foreach ($createdSitemaps as $url) {
            $index->addSitemap($url);
        }

        $index->write();
    }

    /**
     * Создание сайт мапы из коллекции тасков.
     *
     * @param callable $callback Функция генерации урлов.
     * @param string $filename Название файла, в который будут записаны урлы.
     * @return array Список сгенерированных файлов.
     */
    private function handle(SitemapHandlerInterface $generator): array
    {
        try {
            $filename = $generator->getFilename();
            $filepath = "{$this->outputDirectory}/{$filename}";
            $sitemap = new Sitemap($filepath);

            $generator->create($sitemap);

            $sitemap->write();

            return $sitemap->getSitemapUrls($this->baseSitemapUrl);
        } catch (\Throwable $e) {
            echo $e->getMessage() . "\n";

            return [];
        }
    }

    /**
     * Устанавливает массив генераторов карт сайта.
     *
     * @param array $generators
     * @return self
     */
    public function setGenerators(SitemapHandlerInterface ...$generators): self
    {
        $this->generators = $generators;

        return $this;
    }

    /**
     * Добавляет генератор карты мапы.
     *
     * @param SitemapHandlerInterface $generators
     * @return self
     */
    public function addGenerator(SitemapHandlerInterface $generator): self
    {
        $this->generators[] = $generator;

        return $this;
    }

    public function setBaseSitemapUrl(string $baseSitemapUrl): self
    {
        $baseSitemapUrl = rtrim($baseSitemapUrl, '/') . '/';
        $this->baseSitemapUrl = $baseSitemapUrl;

        return $this;
    }

    public function setOutputDirectory(string $outputDirectory = '@app/web'): self
    {
        $outputDirectory = rtrim($outputDirectory, '/') . '/';
        $this->outputDirectory = $outputDirectory;

        return $this;
    }
}
