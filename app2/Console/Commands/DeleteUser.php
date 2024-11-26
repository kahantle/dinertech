<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Schedule;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Deleteuser:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unverified user.';

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
        \DB::table('users')
            ->whereNull('is_verified_at')
            ->where('status','INACTIVE')
            ->delete();
    }
}
