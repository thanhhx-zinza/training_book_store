<?php

namespace Tests\Unit\Http\Controllers\User;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateProduct()
    {
        Session::start();
        $user = User::NormalUser();
        foreach ($user as $user) {
            if ($user->totalProductCount() < 10) {
                $this->be($user);
                $response = $this->get(
                    'product/create',
                );
                $response->assertViewIs('User.Product.create');
                break;
            }
        }
    }

    public function testCreateProductFail()
    {
        Session::start();
        $users = User::NormalUser();
        foreach ($users as $user) {
            if ($user->totalProductCount() >= 10) {
                $this->be($user);
                $response = $this->get(
                    'product/create',
                );
                $response->assertRedirect('store');
                break;
            }
        }
    }

    public function testStoreProduct()
    {
        Session::start();
        $users = User::NormalUser();
        foreach ($users as $user) {
            if ($user->totalProductCount() < 10) {
                $this->be($user);
                foreach ($user->stores as $store) {
                    $faker = Factory::create();
                    $productName = $faker->name;
                    $response = $this->post(
                        '/product',
                        [
                            "_token" => csrf_token(),
                            "name" => $productName,
                            "description" => $faker->text(),
                            "image" => $this->uploadFile(),
                            'slug' => Str::slug($productName),
                            "price" => $faker->randomNumber(3, false),
                            'id' => $store->id,
                        ],
                    );
                    $response->assertRedirect('/store/'.$store->id);
                    break;
                }
                break;
            }
        }
    }

    public function testStoreProductFail()
    {
        Session::start();
        $faker = Factory::create();
        $productName = $faker->name;
        $users = User::NormalUser();
        foreach ($users as $user) {
            if ($user->totalProductCount() >= 9) {
                $this->be($user);
                $response = $this->post(
                    '/product',
                    [
                        "_token" => csrf_token(),
                        "name" => $productName,
                        "description" => $faker->text(),
                        "image" => $this->uploadFile(),
                        'slug' => Str::slug($productName),
                        "price" => $faker->randomNumber(3, false),
                        'id' => $user->stores->first()->id,
                    ],
                );
                $response->assertRedirect('store/'.$user->stores->first()->id);
                break;
            }
        }
    }

    public function testEditProduct()
    {
        Session::start();
        $user = User::NormalUser()->first();
        $this->be($user);
        $storeId = $user->stores->first()->id;
        $product = $user->stores->first()->products->first();
        $response = $this->get(
            'product/'.$product->id.'/edit?storeId='.$storeId,
        );
        $response->assertViewIs('User.Product.edit');
    }

    public function testUpdateProduct()
    {
        Session::start();
        $user = User::NormalUser()->first();
        $this->be($user);
            $product = $user->stores->first()->products->first();
            $faker = Factory::create();
            $productName = $faker->name;
            $response = $this->put(
                '/product/'.$product->id,
                [
                    "_token" => csrf_token(),
                    "name" => $productName,
                    "description" => $faker->text(),
                    "image" => $this->uploadFile(),
                    'slug' => Str::slug($productName),
                    "price" => $faker->randomNumber(3, false),
                    'storeId' => $user->stores->first()->id,
                ],
            );
        $response->assertRedirect('/store');
    }

    public function testDestroyProduct()
    {
        Session::start();
        $user = User::NormalUser()->first();
        $this->be($user);
            $product = $user->stores->first()->products->first();
            $response = $this->delete(
                '/product/'.$product->id,
                [
                    "_token" => csrf_token(),
                    'storeId' => $user->stores->first()->id,
                ],
            );
        $response->assertRedirect('/store');
    }
}
