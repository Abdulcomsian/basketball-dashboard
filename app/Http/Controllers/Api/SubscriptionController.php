<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use App\Http\Resources\SubscriptionResource;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function saveSubscription(Request $request)
    {
        try {
            $subscription = $this->subscriptionService->saveSubscription($request->all());

            $subscriptionResource =  new SubscriptionResource($subscription);

            return response()->json([
                'success' => true,
                'message' => 'Subscription saved successfully!',
                'data' => $subscriptionResource,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
