<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ListingSubscriptionRequest;
use App\Jobs\ParseListingPrice;
use App\Models\ListingSubscription;
use App\Services\DomCrawlerService;
use Illuminate\Http\JsonResponse;

class ListingController extends Controller
{
    /**
     * @param DomCrawlerService $crawlerService
     */
    public function __construct(
        protected DomCrawlerService $crawlerService,
    ){}

    /**
     * @OA\Post(
     *       path="/subscribe-to-price-change",
     *       summary="Subscribe to price change email",
     *       description="Subscribe a user to receive email when the price of the specified listing changes.",
     *       operationId="subscribeToPriceChange",
     *       tags={"Subscription"},
     *       security={{"sanctum": {}}},
     *       @OA\RequestBody(
     *           required=true,
     *           description="Data required to subscribe to a price change notification",
     *           @OA\JsonContent(ref="#/components/schemas/ListingSubscriptionRequest")
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="Subscription successfully created",
     *           @OA\JsonContent(
     *               @OA\Property(property="status", type="boolean", example=true),
     *               @OA\Property(property="message", type="string", example="Subscription successfully created"),
     *               @OA\Property(property="data", type="object", example={})
     *           )
     *       ),
     *       @OA\Response(
     *           response=422,
     *           description="Invalid data or duplicate subscription",
     *           @OA\JsonContent(
     *               @OA\Property(property="status", type="boolean", example=false),
     *               @OA\Property(property="message", type="string", example="Please provide the listing URL."),
     *               @OA\Property(property="errors", type="object", example={})
     *           )
     *       )
     *  )
     */
    public function subscribeToPriceChange(ListingSubscriptionRequest $request): JsonResponse
    {
        ListingSubscription::create([
            'email' => $request->email,
            'url' => $request->url,
        ]);

        ParseListingPrice::dispatch($request->url, app(DomCrawlerService::class));

        return $this->respondSuccess([], 'Subscription successfully created');
    }
}
