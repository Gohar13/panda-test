<?php

namespace App\Observers;

use App\Jobs\SendPriceChangedEmail;
use App\Models\ListingSubscription;

class ListingSubscriptionObserver
{
    /**
     * Handle the Balance "saving" event.
     */
    public function saved(ListingSubscription $listingSubscription): void
    {
        if ($listingSubscription->isDirty('last_price') &&  $listingSubscription->getOriginal('last_price')) {
            SendPriceChangedEmail::dispatch($listingSubscription);
        }
    }

    /**
     * Handle the ListingSubscription "created" event.
     */
    public function created(ListingSubscription $listingSubscription): void
    {
        //
    }

    /**
     * Handle the ListingSubscription "updated" event.
     */
    public function updated(ListingSubscription $listingSubscription): void
    {
        //
    }

    /**
     * Handle the ListingSubscription "deleted" event.
     */
    public function deleted(ListingSubscription $listingSubscription): void
    {
        //
    }

    /**
     * Handle the ListingSubscription "restored" event.
     */
    public function restored(ListingSubscription $listingSubscription): void
    {
        //
    }

    /**
     * Handle the ListingSubscription "force deleted" event.
     */
    public function forceDeleted(ListingSubscription $listingSubscription): void
    {
        //
    }
}
