<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\CurlHttpClient;

class LyceeStVincentHomepageTest extends TestCase
{
    public function testSeeInformation(): void
    {
        $client = new CurlHttpClient();
        $request = $client->request('GET', 'https://www.lycee-stvincent.fr/');

        $crawler = new Crawler($request->getContent());
        $content = $crawler->filterXPath('//div[@id="bandeau-niveaux"]//h2')->text();

        $this->assertEquals('Secondaire', $content);
    }
}