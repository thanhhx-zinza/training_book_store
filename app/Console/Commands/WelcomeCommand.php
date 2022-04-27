<?php

namespace App\Console\Commands;

use App\Mail\WelcomeMail;
use App\Models\User;
use Mail;
use Illuminate\Console\Command;

class WelcomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'welcome:mail';

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
        $users = User::whereDate('created_at', date('Y-m-d'))->get()->toArray();
        array_map(function ($users) {
            return Mail::to($users['email'])->send(new WelcomeMail());
        }, $users);
    }
}
