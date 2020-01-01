<?php
namespace SK\SeoModule\Checker;

use Yii;
use yii\db\Expression;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\TransferException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

use SK\VideoModule\Model\Video;
use SK\VideoModule\Model\Category;
use SK\SeoModule\Factory\PageCheckReportFactory;


class PageChecker
{
    protected $client;
    protected $urlManager;

    public function __construct()
    {
        $this->urlManager = Yii::$app->get('frontUrlManager');
        $this->client = new Client([
            'timeout'  => 5.0,
        ]);
    }

    /**
     * Проверяет список страниц.
     *
     * @return VO collection
     */
    public function checkAll()
    {
        $urlList = $this->buildUrlList();
        $info = [];

        foreach ($urlList as $url) {
            $info[] = $this->checkByUrl($url);
        }

        return $info;
    }

    /**
     * Проверяет страницу и строит отчет.
     *
     * @param string $url Урл проверяемой страницы.
     *
     * @return SK\SeoModule\Report\PageCheckReport
     */
    public function checkByUrl($url)
    {
        $data = [
            'url' => $url,
        ];

        try {
            $time_start = microtime(true);
            $response = $this->client->request('GET', $url);
            $data['response_time'] = (int) ((microtime(true) - $time_start) * 1000);

            $data['status_code'] = $response->getStatusCode();

            $result = $this->parse($response->getBody()->getContents());
            $data = array_merge($data, $result);
        } catch (TransferException $e) {
            $data['error'] = $e->getMessage();

            if (empty($data['response_time'])) {
                $data['response_time'] = (int) ((microtime(true) - $time_start) * 1000);
            }

            if ($e->hasResponse()) {
                $data['status_code'] = $e->getResponse()->getStatusCode();
            }
        }

        return PageCheckReportFactory::createFromArray($data);
    }



    /**
     * Создает список урлов страниц, которые необходимо проверить.
     *
     * @return array
     */
    protected function buildUrlList()
    {
        $urls = [];

        $video = Video::find()
            ->where(['status' => Video::STATUS_ACTIVE])
            ->andWhere(['<=', 'published_at', new Expression('NOW()')])
            ->limit(1)
            ->one();

        $category = Category::findOne(['enabled' => 1]);

        $urls[] = $this->urlManager->createAbsoluteUrl(['/site/index']);
        $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/recent/index']);
        $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/recent/index', 'page' => 2]);

        if (null !== $video) {
            $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/view/index', 'slug' => $video->getSlug()]);
            //$urls[] = $this->urlManager->createAbsoluteUrl(['/videos/view/index', 'id' => $video->getId()]);
        }

        if (null !== $category) {
            $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/ctr', 'slug' => $category->getSlug()]);
            $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/ctr', 'slug' => $category->getSlug(), 'page' => 2]);

            $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/index', 'slug' => $category->getSlug(), 'sort' => 'recent']);
            $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/index', 'slug' => $category->getSlug(), 'sort' => 'recent', 'page' => 2]);

            $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/index', 'slug' => $category->getSlug(), 'sort' => 'views']);
            $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/index', 'slug' => $category->getSlug(), 'sort' => 'views', 'page' => 2]);

            $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/index', 'slug' => $category->getSlug(), 'sort' => 'rating']);
            $urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/index', 'slug' => $category->getSlug(), 'sort' => 'rating', 'page' => 2]);
            //$urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/ctr', 'id' => $category->getId()]);
            //$urls[] = $this->urlManager->createAbsoluteUrl(['/videos/category/ctr', 'id' => $category->getId(), 'page' => 2]);
        }


        return $urls;
    }

    /**
     *
     */
    protected function parse($html)
    {
        $data = [];

        $crawler = new Crawler($html);

        $data['meta_title'] = $crawler->filterXPath('//title')->text();

        $descriptionNode = $crawler->filterXPath('//meta[@name=\'description\']');
        if ($descriptionNode->count() > 0) {
            $data['meta_description'] = $descriptionNode->attr('content');
        }

        $h1Node = $crawler->filterXPath('//h1');
        if ($h1Node->count() > 0) {
            $data['h1'] = $crawler->filterXPath('//h1')->text();
        }

        $canonicalNode = $crawler->filterXPath('//link[@rel=\'canonical\']');
        if ($canonicalNode->count() > 0) {
            $data['canonical'] = $canonicalNode->attr('href');
        }

        return $data;
    }
}
