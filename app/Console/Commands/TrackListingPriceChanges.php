<?php

namespace App\Console\Commands;

use App\Jobs\ParseListingPrice;
use App\Models\ListingSubscription;
use App\Services\DomCrawlerService;
use Illuminate\Console\Command;

class TrackListingPriceChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:track-changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check price changes for subscribed ads';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $listingUrls = ListingSubscription::distinct('url')->pluck('url');

        foreach ($listingUrls as $url) {
            ParseListingPrice::dispatch($url, app(DomCrawlerService::class));
        }
    }
}
