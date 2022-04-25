<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unVeriUsers = User::factory()->count(100)->unverified()->make();
        $veriUsers = User::factory()->count(400)-> make();
        $premiumUsers = User::factory()->count(500)->premium()->make();
        DB::table('users')->upsert($veriUsers->toArray(), ['id']);
        DB::table('users')->upsert($unVeriUsers->toArray(), ['id']);
        DB::table('users')->upsert($premiumUsers->toArray(), ['id']);
    }
}

