<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

class DomCrawlerService
{
    const MIN_DELAY = 2000;
    const MAX_DELAY = 5000;

    protected $client;

    protected array $options = [];

    public function __construct()
    {

    }

    /**
     * @param array $options
     * @return DomCrawlerService
     */
    public function setOptions(array $options): DomCrawlerService
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param array $options
     * @return DomCrawlerService
     */
    public function addOptions(array $options): DomCrawlerService
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @throws GuzzleException
     * @throws RandomException
     */
    public function newRequest(string $url, array $options = [], string $method = 'GET'): \Psr\Http\Message\ResponseInterface
    {
        if (!$this->client) {
            $this->client = new Client();
        }

        $options = array_merge($this->getDefaultOptions(), $this->options, $options);

        return $this->client->request($method, $url, $options);
    }

    /**
     * @throws GuzzleException
     * @throws RandomException
     */
    protected function getHtml(string $url, array $options = [], string $method = 'GET'): string
    {
        return $this->newRequest($url, $options, $method)->getBody()->getContents();
    }

    /**
     * @throws GuzzleException
     * @throws RandomException
     */
    public function getCrawler(string $url, array $options = [], string $method = 'GET'): Crawler
    {
        $html = $this->getHtml($url, $options, $method);

        $crawler = new Crawler();
        $crawler->addHtmlContent($html, 'UTF-8');

        return $crawler;
    }

    /**
     * @throws RandomException
     * @throws RandomException
     */
    protected function getDefaultOptions(): array
    {
        return ['delay' => random_int(static::MIN_DELAY, static::MAX_DELAY)];
    }
}
