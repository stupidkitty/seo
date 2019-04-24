<?php
namespace SK\SeoModule\Report;

/**
 * Value object of file check result.
 */
class FileCheckReport
{
    private $url;
    private $statusCode;
    private $size;
    private $error;
    private $last_modified;

    public function __construct(
        $url,
        $status_code = 0,
        $size = 0,
        $error = '',
        $last_modified = null
    ) {
        $this->url = $url;
        $this->statusCode = (int) $status_code;
        $this->size = (int) $size;
        $this->error = (string) $error;
        $this->last_modified = $last_modified;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getError()
    {
        return $this->error;
    }

    public function hasError()
    {
        return !empty($this->error);
    }

    public function getLastModified()
    {
        return $this->last_modified;
    }
}
