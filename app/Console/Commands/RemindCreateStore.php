<?php

namespace App\Console\Commands;

use App\Mail\RemindCreateStoreMail;
use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Mail;

class RemindCreateStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:remind';

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
        $monthAgo = Carbon::now()->subMonth(1)->toDateString();
        $users = User::with('stores')->whereDate('email_verified_at', '<=', $monthAgo)->get();
        foreach ($users as $user) {
            if (count($user->stores) == 0) {
                Mail::to($user->email)->send(new RemindCreateStoreMail);
            }
        }
    }
}
