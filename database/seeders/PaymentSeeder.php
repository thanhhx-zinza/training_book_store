<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        DB::table('payment')->insert(
            [
                'amount' => $faker->randomFLoat(2),
                'currency' => 'USD',
                'charge_id' => 'ch_'.Str::random(10),
                'user_id' => User::orderBy('id', 'DESC')->first()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]
        );
    }
}
