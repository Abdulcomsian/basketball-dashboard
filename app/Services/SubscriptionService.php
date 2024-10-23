<?php

namespace App\Services;

use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class SubscriptionService
{
    public function saveSubscription(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'stripe_subscription_id' => 'required|string',
            'stripe_status' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $startDate = Carbon::parse($data['start_date'])->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($data['end_date'])->format('Y-m-d H:i:s');

        return Subscription::updateOrCreate(
            ['stripe_subscription_id' => $data['stripe_subscription_id']],
            [
                'user_id' => $data['user_id'],
                'stripe_status' => $data['stripe_status'],
                'amount' => $data['amount'],
                'currency' => $data['currency'],
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        );
    }
}
