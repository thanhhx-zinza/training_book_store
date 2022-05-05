<?php

namespace Tests\Unit\Http\Controllers\User;

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;

class StoreControllerTest extends TestCase
{
    use DatabaseTransactions;
  
    public function testIndexStore()
    {
        Session::start();
        $user = User::where('status', 'normal')->where('email_verified_at', '!=', null)->first();
        $this->be($user);
        $response = $this->get('/store');
        $response->assertViewIs('User.Store.index');
    }

    public function testCreateStore()
    {
        Session::start();
        $users = User::where('status', 'premium')->get();
        foreach ($users as $user) {
            if (count($user->stores) < 3) {
                $this->be($user);
                $response = $this->get('store/create');
                $response->assertViewIs('User.Store.create');
                break;
            }
        }
    }

    public function testCreateStoreFail()
    {
        Session::start();
        $users = User::where('status', 'normal')->where('email_verified_at', '!=', null)->get();
        foreach ($users as $user) {
            if (count($user->stores) >= 1) {
                $this->be($user);
                $response = $this->get('store/create');
                $response->assertRedirect('/home');
                break;
            }
        }
        $premiumUsers = User::where('status', 'premium')->where('email_verified_at', '!=', null)->get();
        foreach ($premiumUsers as $premiumUser) {
            if (count($premiumUser->stores) >= 3) {
                $this->be($premiumUser);
                $response = $this->get('store/create');
                $response->assertRedirect('/home');
                break;
            }
        }
    }

    public function testStore()
    {
        Session::start();
        $faker = Factory::create();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg', 500, 500)->size(100);
        $users = User::where('status', 'normal')->where('email_verified_at', '!=', null)->get();
        foreach ($users as $user) {
            if (count($user->stores) < 1) {
                $this->be($user);
                $response = $this->post(
                    'store',
                    [
                        "name" => $faker->name,
                        "description" => $faker->text(),
                        "image" => $file,
                    ]
                );
                $response->assertRedirect('/home');
                break;
            }
        }
        $premiumUsers = User::where('status', 'premium')->where('email_verified_at', '!=', null)->get();
        foreach ($premiumUsers as $premiumUser) {
            if (count($premiumUser->stores) < 3) {
                $this->be($premiumUser);
                $response = $this->post(
                    'store',
                    [
                        "name" => $faker->name,
                        "description" => $faker->text(),
                        "image" => $file,
                    ]
                );
                $response->assertRedirect('/home');
                break;
            }
        }
    }

    public function testStoreFail()
    {
        Session::start();
        $faker = Factory::create();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg', 500, 500)->size(100);
        $users = User::where('status', 'normal')->where('email_verified_at', '!=', null)->get();
        foreach ($users as $user) {
            if (count($user->stores) >= 1) {
                $this->be($user);
                $response = $this->post(
                    'store',
                    [
                        "name" => $faker->name,
                        "description" => $faker->text(),
                        "image" => $file,
                    ]
                );
                $response->assertRedirect('/home');
                $response->assertSessionHas('error');
                break;
            }
        }
        $premiumUsers = User::where('status', 'premium')->where('email_verified_at', '!=', null)->get();
        foreach ($premiumUsers as $premiumUser) {
            if (count($premiumUser->stores) >= 3) {
                $this->be($premiumUser);
                $response = $this->post(
                    'store',
                    [
                        "name" => $faker->name,
                        "description" => $faker->text(),
                        "image" => $file,
                    ]
                );
                $response->assertRedirect('/home');
                $response->assertSessionHas('error');
                break;
            }
        }
    }

    public function testShowStore()
    {
        Session::start();
        $user = User::where('status', 'normal')->where('email_verified_at', '!=', null)->first();
        $this->be($user);
        $response = $this->get('/store/'.$user->stores->first()->id);
        $response->assertViewIs('User.Store.show');
    }

    public function testEditStore()
    {
        Session::start();
        $user = User::where('status', 'normal')->where('email_verified_at', '!=', null)->first();
        $this->be($user);
        $response = $this->get('/store/'.$user->stores->first()->id.'/edit');
        $response->assertViewIs('User.Store.edit');
    }

    public function testUpdateStore()
    {
        Session::start();
        $faker = Factory::create();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg', 500, 500)->size(100);
        $users = User::where('status', 'normal')->where('email_verified_at', '!=', null)->get();
        foreach ($users as $user) {
            if (count($user->stores) <= 1) {
                $this->be($user);
                $response = $this->put(
                    'store/'.$user->stores->first()->id,
                    [
                        "name" => $faker->name,
                        "description" => $faker->text(),
                        "image" => $file,
                    ]
                );
                $response->assertRedirect('/store');
                break;
            }
        }
        $premiumUsers = User::where('status', 'premium')->where('email_verified_at', '!=', null)->get();
        foreach ($premiumUsers as $premiumUser) {
            if (count($premiumUser->stores) <= 3) {
                $this->be($premiumUser);
                foreach ($premiumUser->stores as $store) {
                    $response = $this->put(
                        'store/'.$store->id,
                        [
                            "name" => $faker->name,
                            "description" => $faker->text(),
                            "image" => $file,
                        ]
                    );
                    $response->assertRedirect('/store');
                    break;
                }
                break;
            }
        }
    }

    public function testDestroyStore()
    {
        Session::start();
        $user = User::where('status', 'normal')->where('email_verified_at', '!=', null)->first();
        $this->be($user);
        $response = $this->delete('/store/'.$user->stores->first()->id);
        $response->assertRedirect('/home');
    }
}
