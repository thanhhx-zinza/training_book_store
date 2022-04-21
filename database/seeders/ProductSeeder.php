<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $name = $faker->word(2, true);
        DB::table('products')->insert(
            [
                'name' => $name,
                'images' => $faker->text(10),
                'description' => $faker->paragraphs(3, true),
                'price' => $faker->randomNumber(4, true),
                'sales' => $faker->randomNumber(2, false),
                'created_at' => date('Y-m-d H:i:s'),
                'store_id' => Store::orderBy('id', 'DESC')->first()->id,
                'slug' => Str::slug($name),
            ]
        );
    }
}
