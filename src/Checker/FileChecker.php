<?php
namespace SK\SeoModule\Checker;

use Yii;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\TransferException;
use Psr\Http\Message\ResponseInterface;

use SK\SeoModule\Factory\FileCheckReportFactory;

class FileChecker
{
    protected $client;

    protected $checkFiles = [
        '/robots.txt',
        '/favicon.ico',
        '/sitemap/index.xml',
        '/sitemap/videos.xml',
        '/sitemap/videos_categories.xml',
    ];

    public function __construct()
    {
        $this->client = new Client([
            'timeout'  => 5.0,
        ]);
    }

    public function checkAll()
    {
        $baseUrl = rtrim(Yii::$app->frontUrlManager->createAbsoluteUrl(['/']), '/');
        $info = [];

        foreach ($this->checkFiles as $fileUrl) {
            $info[] = $this->checkByUrl("{$baseUrl}{$fileUrl}");
        }

        return $info;
    }

    public function checkByUrl($url)
    {
        $data = [
            'url' => $url,
        ];

        try {
            $response = $this->client->request('GET', $url);

            $data['status_code'] = $response->getStatusCode();

            if ($response->hasHeader('Last-Modified')) {
                $rawDateTime = $response->getHeader('Last-Modified');

                $data['last_modified'] = \DateTime::createFromFormat('D, d M Y H:i:s T', (string) $rawDateTime[0], new \DateTimeZone('UTC'));
            }

            if ($response->hasHeader('Content-Length')) {
                $size = $response->getHeader('Content-Length');

                $data['size'] = (int) $size[0];
            }
        } catch (TransferException $e) {
            $data['error'] = $e->getMessage();

            if ($e->hasResponse()) {
                $data['status_code'] = $e->getResponse()->getStatusCode();
            }
        }

        return FileCheckReportFactory::createFromArray($data);
    }
}
