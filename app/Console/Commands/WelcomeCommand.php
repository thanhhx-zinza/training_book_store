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
    protected $signature = 'command:welcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::whereDate('created_at', date('Y-m-d'))->get()->toArray();
        return array_map(function($users) {
            return Mail::to($users['email'])->send(new WelcomeMail());
        }, $users);
    }
}
