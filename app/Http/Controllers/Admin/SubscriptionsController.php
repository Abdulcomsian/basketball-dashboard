<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::latest()->get();
        return view('admin.subscriptions.index', ['subscriptions' => $subscriptions]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stripeKey = Subscription::find($id);
        $stripeKey->delete();

        return redirect()->route('admin.subscriptions.index')->with('success', 'Keys Deleted Successfully');
    }
}
