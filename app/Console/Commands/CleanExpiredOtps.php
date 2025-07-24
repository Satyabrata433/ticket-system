<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanExpiredOtps extends Command
{
    protected $signature = 'otp:clean';
    protected $description = 'Remove expired OTPs';

    public function handle()
    {
        DB::table('otp_requests')
            ->where('expires_at', '<', Carbon::now())
            ->delete();
        $this->info('Expired OTPs cleaned successfully.');
    }
}