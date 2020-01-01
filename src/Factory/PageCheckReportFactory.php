<?php
namespace SK\SeoModule\Factory;

use SK\SeoModule\Report\PageCheckReport;

class PageCheckReportFactory
{
    public static function createFromArray(array $data)
    {
        $url = '';
        $status_code = 0;
        $error = '';
        $response_time = '';
        $meta_title = '';
        $meta_description = '';
        $h1 = '';
        $canonical = '';

        extract($data, EXTR_OVERWRITE);

        return new PageCheckReport(
            $url,
            $status_code,
            $error,
            $response_time,
            $meta_title,
            $meta_description,
            $h1,
            $canonical
        );
    }
}
