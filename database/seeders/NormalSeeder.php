<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory;

class NormalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->where('status', 'normal')->orderBy('id', 'asc')->chunk(400, function($users) {
            $faker = Factory::create();
            foreach ($users as $user) {
                $stores[] = [
                    'name' => $faker->unique()->words(2, true),
                    'description' => $faker->paragraphs(2, true),
                    'images' => $faker->text(10),
                    'rates' => $faker->randomDigit(),
                    'followers' => $faker->randomNumber(5, false),
                    'follow' => $faker->randomNumber(5, false),
                    'user_id' => $user->id
                ];
            }
            DB::table('stores')->upsert($stores, ['id']);
        });
        DB::table('stores')->orderBy('id', 'asc')->limit(400)->get()->each(function($store) {
            $faker = Factory::create();
            $name = $faker->word(5, true);
            for ($i = 1; $i <= rand(1, 10); $i++) {
                $products[] = [
                    'name' => $name,
                    'images' => $faker->text(10),
                    'description' => $faker->paragraphs(3, true),
                    'price' => $faker->randomNumber(4, true),
                    'sales' => $faker->randomNumber(2, false),
                    'slug' => Str::slug($name),
                    'store_id' => $store->id,
                ];
            }
            DB::table('products')->upsert($products, ['id']);
        });
    }
}
