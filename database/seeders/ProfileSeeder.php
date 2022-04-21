<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        DB::table('profile')->insert(
            [
                'name' => $faker->name,
                'first_name' => $faker->word,
                'last_name' => $faker->word,
                'dob' => $faker->date('Y-m-d'),
                'phone_number' => $faker->phoneNumber,
                'gender' => $faker->randomElement($array = array ('male', 'female')) ,
                'address' => $faker->city,
                'user_id' => User::orderBy('id', 'DESC')->first()->id,
                'created_at' => $faker->date('Y-m-d H:i:s'),
            ]
        );
    }
}
