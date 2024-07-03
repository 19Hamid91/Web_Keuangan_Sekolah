<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClearExpiredSessions extends Command
{
    protected $signature = 'sessions:clear';
    protected $description = 'Clear expired sessions from the database';

    protected $lifetime = 120;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $expiredTime = Carbon::now()->subMinutes($this->lifetime)->getTimestamp();

        $deletedSessions = DB::table('sessions')
            ->where('last_activity', '<', $expiredTime)
            ->delete();

        $this->info("Expired sessions cleared successfully. Count: " . $deletedSessions);
    }
}