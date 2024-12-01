<?php

namespace App\Jobs;

use App\Mail\PriceChangedNotification;
use App\Models\ListingSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPriceChangedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ListingSubscription $listingSubscription;

    /**
     * Create a new job instance.
     */
    public function __construct(ListingSubscription $listingSubscription)
    {
        $this->listingSubscription = $listingSubscription;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->listingSubscription->email)
            ->send(new PriceChangedNotification($this->listingSubscription));
    }
}
