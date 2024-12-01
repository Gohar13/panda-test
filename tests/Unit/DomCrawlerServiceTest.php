<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

class DomCrawlerServiceTest extends TestCase
{
    /** @test */
    public function handles_html_content_correctly()
    {
        $htmlContent = '<html><body><h1>Title</h1><p>Test content</p></body></html>';
        $crawler = new Crawler();
        $crawler->addHtmlContent($htmlContent);

        $this->assertEquals('Title', $crawler->filter('h1')->text());
        $this->assertEquals('Test content', $crawler->filter('p')->text());
    }
}
