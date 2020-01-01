<?php
namespace SK\SeoModule\Report;

/**
 * Value object of page check result.
 */
class PageCheckReport
{
    private $url;
    private $statusCode;
    private $error;
    private $response_time;
    private $meta_title;
    private $meta_description;
    private $h1;
    private $canonical;

    public function __construct(
        $url,
        $status_code = 0,
        $error = '',
        $response_time = '',
        $meta_title = '',
        $meta_description = '',
        $h1 = '',
        $canonical = ''
    ) {
        $this->url = $url;
        $this->statusCode = (int) $status_code;
        $this->error = (string) $error;
        $this->response_time = (string) $response_time;
        $this->meta_title = (string) $meta_title;
        $this->meta_description = (string) $meta_description;
        $this->h1 = (string) $h1;
        $this->canonical = (string) $canonical;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getError()
    {
        return $this->error;
    }

    public function hasError()
    {
        return !empty($this->error);
    }

    public function getResponseTime()
    {
        return $this->response_time;
    }

    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    public function hasMetaTitle()
    {
        return !empty($this->meta_title);
    }

    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    public function hasMetaDescription()
    {
        return !empty($this->meta_description);
    }

    public function getH1()
    {
        return $this->h1;
    }

    public function hasH1()
    {
        return !empty($this->h1);
    }

    public function getCanonical()
    {
        return $this->canonical;
    }

    public function hasCanonical()
    {
        return !empty($this->canonical);
    }

    public function canonicalEqualUrl()
    {
        return $this->canonical === $this->url;
    }
}
