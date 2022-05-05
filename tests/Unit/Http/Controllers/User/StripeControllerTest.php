<?php

namespace Tests\Unit\Http\Controllers\User;

use App\Models\User;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StripeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStripe()
    {
        $response = $this->get('/stripe');
        $response->assertViewIs('frontend.stripe.stripe');
    }
}
