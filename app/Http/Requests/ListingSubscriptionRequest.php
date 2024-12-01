<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Http\Requests
 *
 * @property string $email
 * @property string $url
 *
 * @OA\Schema(
 *      schema="ListingSubscriptionRequest",
 *      type="object",
 *      required={"email", "url"},
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          description="Email пользователя",
 *          example="user@example.com"
 *      ),
 *      @OA\Property(
 *          property="url",
 *          type="string",
 *          description="URL объявления",
 *          example="https://www.olx.ua/ad/example"
 *      )
 * )
 */
class ListingSubscriptionRequest extends FormRequest
{
    /**
     * Определяет, может ли пользователь выполнить этот запрос.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Получить правила валидации, которые должны быть применены к запросу.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'url' => [
                'required',
                'url',
                'unique:listing_subscriptions,url,NULL,id,email,' . $this->email
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please provide an email address.',
            'email.email' => 'Please provide a valid email address',
            'url.required' => 'Please provide the listing URL.',
            'url.url' => 'Please provide a valid URL.',
            'url.unique' => 'You are already subscribed to this listing with the specified email.',
        ];
    }
}
