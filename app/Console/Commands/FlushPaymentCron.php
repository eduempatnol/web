<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FlushPaymentCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flushpayment:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush payment pending to expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Cronjob ready every one minute ". date("Y-m-d H:i:s"));
    }
}
