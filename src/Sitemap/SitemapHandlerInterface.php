<?php
namespace SK\SeoModule\Sitemap;

use samdark\sitemap\Sitemap;

interface SitemapHandlerInterface
{
    public function getFilename(): string;

    public function create(Sitemap $sitemap, $urlManager);
}
