<?php

namespace Aggregators\Dyrynda;

use Carbon\Carbon;
use InvalidArgumentException;
use Aggregators\Support\BaseAggregator;
use Symfony\Component\DomCrawler\Crawler;

class Aggregator extends BaseAggregator
{
    /**
     * {@inheritDoc}
     */
    public string $uri = 'https://dyrynda.com.au/blog';

    /**
     * {@inheritDoc}
     */
    public string $provider = 'Dyrynda';

    /**
     * {@inheritDoc}
     */
    public string $logo = 'logo.jpg';

    /**
     * {@inheritDoc}
     */
    public function articleIdentifier(): string
    {
        return 'div.flex.flex-col.pt-4.mt-4.border-t';
    }

    /**
     * {@inheritDoc}
     */
    public function nextUrl(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('div.container > div.mt-8 > nav > div:not(.mr-2) > a')->first()->attr('href');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function image(Crawler $crawler): ?string
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function title(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('a.mr-2.text-xl.font-semibold.leading-tight.font-purple-700')->text();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function content(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('div:last-of-type')->text();
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function link(Crawler $crawler): ?string
    {
        try {
            return $crawler->filter('a.mr-2.text-xl.font-semibold.leading-tight.font-purple-700')->attr('href');
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function dateCreated(Crawler $crawler): Carbon
    {
        try {
            return Carbon::parse($crawler->filter('div.text-gray-700')->text());
        } catch (InvalidArgumentException $e) {
            return Carbon::now();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function dateUpdated(Crawler $crawler): Carbon
    {
        return $this->dateCreated($crawler);
    }
}
