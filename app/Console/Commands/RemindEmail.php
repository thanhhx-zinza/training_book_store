<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class RemindEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sevenDayAgo = Carbon::now()->subDay(7)->toDateString();
        $users = User::whereDate('created_at', '<=', $sevenDayAgo)->where('email_verified_at', null)->get();
        foreach ($users as $user) {
            $user->sendEmailVerificationNotification();
        }
    }
}
