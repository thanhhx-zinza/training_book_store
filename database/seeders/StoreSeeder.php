<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        DB::table('stores')->insert(
            [
                'name' => $faker->words(2, true),
                'description' => $faker->paragraphs(2, true),
                'images' => $faker->text(10),
                'rates' => $faker->randomDigit(),
                'followers' => $faker->randomNumber(5, false),
                'follow' => $faker->randomNumber(5, false),
                'created_at' => date('Y-m-d H:i:s'),
                'user_id' => User::orderBy('id', 'DESC')->first()->id,
            ]
        );
    }
}
