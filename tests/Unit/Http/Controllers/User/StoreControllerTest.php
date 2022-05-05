<?php

namespace Tests\Unit\Http\Controllers\User;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class StoreControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testDestroyStore()
    {
        Session::start();
        $user = User::where('email_verified_at', '!=', null)->first();
        $this->be($user);
        $response = $this->delete('/store/'.$user->stores->first()->id);
        $response->assertRedirect('/home');
    }
}
