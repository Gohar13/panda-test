<?php

namespace App\Jobs;

use App\Models\ListingSubscription;
use App\Services\DomCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseListingPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected DomCrawlerService $domCrawlerService;
    protected string $listingUrl;

    /**
     * Create a new job instance.
     *
     * @param string $listingUrl
     * @param DomCrawlerService $domCrawlerService
     */
    public function __construct(string $listingUrl, DomCrawlerService $domCrawlerService)
    {
        $this->listingUrl = $listingUrl;
        $this->domCrawlerService = $domCrawlerService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $crawler = $this->domCrawlerService->getCrawler($this->listingUrl);

        if ($crawler->filter('div[data-testid="ad-price-container"] h3')->count()) {
            $priceText = $crawler->filter('div[data-testid="ad-price-container"] h3')->text();

            $listingSubscriptions = ListingSubscription::where('url', $this->listingUrl)->get();

            foreach ($listingSubscriptions as $listingSubscription) {

                /* @var ListingSubscription $listingSubscription */
                if ($listingSubscription->last_price !== $priceText) {
                    $listingSubscription->last_price = trim($priceText);
                    $listingSubscription->save();
                }
            }
        }
    }
}
