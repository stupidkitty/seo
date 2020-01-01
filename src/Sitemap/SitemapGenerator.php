<?php
namespace SK\SeoModule\Sitemap;

use Yii;
use yii\base\Event;
use samdark\sitemap\Index;
use yii\helpers\FileHelper;
use samdark\sitemap\Sitemap;
use RS\Component\Core\Settings\SettingsInterface;

/**
 * https://github.com/samdark/sitemap
 */
class SitemapGenerator
{
    public $baseSitemapUrl;
    public $baseDirectory;

    private $urlManager;
    private $index;
    private $sitemapCollection = [];

    const EVENT_BEFORE_GENERATE = 'beforeGenerate';

    public function __construct(SettingsInterface $settings)
    {
        $siteUrl = $settings->get('site_url');

        $this->urlManager = Yii::$app->urlManager;
        $this->urlManager->setScriptUrl('/web/index.php');
        $this->urlManager->setHostInfo($siteUrl);

        $this->baseSitemapUrl = "{$siteUrl}/sitemap/";
        $this->baseDirectory = Yii::getAlias('@root/web/sitemap');

        if (!is_dir($this->baseDirectory)) {
            FileHelper::CreateDirectory($this->baseDirectory, 0755);
        }

        $indexFilepath = $this->baseDirectory . '/index.xml';
        $this->index = new Index($indexFilepath);
    }

    /**
     * Генерация карт сайта.
     */
    public function generate()
    {
        Event::trigger(static::class, static::EVENT_BEFORE_GENERATE, new Event(['sender' => $this]));

        foreach ($this->sitemapCollection as $row) { //['callback' => $callback, 'filename' => $filename]
            $this->handle($row['callback'], $row['filename']);
        }

        $this->index->write();
    }

    /**
     * Добавление обработчиков для генерации карт.
     *
     * @param callable $callback Функция генерации урлов.
     * @param string $filename Название файла, в который будут записаны урлы.
     */
    public function addSitemap(callable $callback, $filename = '')
    {
        if ('' === $filename) {
            $sitemapNum = count($this->sitemapCollection) + 1;
            $filename = "sitemap{$sitemapNum}.xml";
        }

        $this->sitemapCollection[] = [
            'filename' => $filename,
            'callback' => $callback,
        ];
    }

    /**
     * Создание сайт мапы из коллекции тасков.
     *
     * @param callable $callback Функция генерации урлов.
     * @param string $filename Название файла, в который будут записаны урлы.
     */
    private function handle(callable $callback, $filename)
    {
        $filepath = "{$this->baseDirectory}/{$filename}";
        $sitemap = new Sitemap($filepath);

        $callback($sitemap, $this->urlManager);

        $sitemap->write();

        $sitemapFileUrls = $sitemap->getSitemapUrls($this->baseSitemapUrl);
        $this->addSitemapToIndex($sitemapFileUrls);
    }

    /**
     * Добавление сгенерированных файлов в индексный файл.
     *
     * @param array $sitemapFileUrls Коллекция урлов сгенерированных карт сайта.
     */
    private function addSitemapToIndex($sitemapFileUrls)
    {
        if (empty($sitemapFileUrls))
            return;

        foreach ($sitemapFileUrls as $sitemapUrl) {
            $this->index->addSitemap($sitemapUrl);
        }
    }
}
