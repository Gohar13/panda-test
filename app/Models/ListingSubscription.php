<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ListingSubscription
 *
 * @property int $id
 * @property string $email
 * @property string $url
 * @property string|null $last_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class ListingSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'url',
        'last_price'
    ];
}

