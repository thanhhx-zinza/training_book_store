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
        $unVerifyUsers = User::factory()->count(100)->unverified()->make();
        $verifyUsers = User::factory()->count(400)-> make();
        $premiumUsers = User::factory()->count(500)->premium()->make();
        DB::table('users')->upsert($unVerifyUsers->toArray(), ['id']);
        DB::table('users')->upsert($verifyUsers->toArray(), ['id']);
        DB::table('users')->upsert($premiumUsers->toArray(), ['id']);
    }
}

