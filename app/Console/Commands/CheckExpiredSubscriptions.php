<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Carbon\Carbon;

class CheckExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expired';
    protected $description = 'Check for expired subscriptions and update their status to canceled';

    public function handle()
    {
        $now = Carbon::now();

        $expiredSubscriptions = Subscription::where('end_date', '<', $now)
            ->where('stripe_status', '!=', 'canceled')
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update(['stripe_status' => 'canceled']);
            $this->info("Subscription ID {$subscription->id} has been canceled.");
        }

        $this->info('Expired subscriptions check completed.');
    }
}
