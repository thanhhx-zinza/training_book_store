<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PremiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->where('status', 'premium')->orderBy('id', 'asc')->chunk(500, function($users) {
            $faker = Factory::create();
            foreach ($users as $user) {
                for ($i = 1; $i <=  rand(1, 3); $i++) {
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
            }
            DB::table('stores')->upsert($stores, ['id']);
        });
        DB::table('stores')->where('id', '>', 400)->chunkById(500, function($stores) {
            $faker = Factory::create();
            $name = $faker->word(5, true);
            foreach ($stores as $store) {
                for ($i = 1; $i <= rand(1, 100); $i++) {
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
            }
            DB::table('products')->upsert($products, ['id']);
        });
    }
}
