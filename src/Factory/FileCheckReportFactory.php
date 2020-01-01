<?php
namespace SK\SeoModule\Factory;

use SK\SeoModule\Report\FileCheckReport;

class FileCheckReportFactory
{
    public static function createFromArray(array $data)
    {
        $url = '';
        $status_code = 0;
        $size = 0;
        $error = '';
        $last_modified = null;

        extract($data, EXTR_OVERWRITE);

        return new FileCheckReport(
            $url,
            $status_code,
            $size,
            $error,
            $last_modified
        );
    }
}
