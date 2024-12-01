<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\ListingSubscriptionRequest;
use Illuminate\Support\Facades\Validator;

class ListingSubscriptionRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function validates_email_and_url()
    {
        $data = [
            'email' => 'user@example.com',
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/novinka-turetska-plitonoska-rozgruzka-sword-na-4-tochki-plitonoska-IDUqjf0.html',
        ];

        $request = new ListingSubscriptionRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function rejects_invalid_email()
    {
        $data = [
            'email' => 'invalid-email',
            'url' => 'https://www.olx.ua/d/uk/obyavlenie/novinka-turetska-plitonoska-rozgruzka-sword-na-4-tochki-plitonoska-IDUqjf0.html',
        ];

        $request = new ListingSubscriptionRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals('The email field must be a valid email address.', $validator->errors()->first('email'));
    }

    /** @test */
    public function rejects_invalid_url()
    {
        $data = [
            'email' => 'user@example.com',
            'url' => 'invalid-url',
        ];

        $request = new ListingSubscriptionRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals('The url field must be a valid URL.', $validator->errors()->first('url'));
    }
}

