<?php

namespace App\Mail;

use App\Models\ListingSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceChangedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public ListingSubscription $listingSubscription;

    /**
     * Create a new message instance.
     */

    public function __construct(ListingSubscription $listingSubscription)
    {
        $this->listingSubscription = $listingSubscription;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Price Changed Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.price-changed',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build(): PriceChangedNotification
    {
        return $this->subject('Цена объявления изменена')->view('emails.price-changed');
    }
}
