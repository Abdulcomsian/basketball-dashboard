<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\StripeKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class StripeKeysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stripeKeys = StripeKey::latest()->get();
        return view('admin.stripe_keys.index', ['stripeKeys' => $stripeKeys]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stripe_keys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stripe_key' => 'required|string|max:255',
            'stripe_secret' => 'required|string|max:255',
        ]);

        try {
            StripeKey::create([
                'user_id' => auth()->id(),
                'key' => $request->input('stripe_key'),
                'secret' => $request->input('stripe_secret'),
            ]);

            return redirect()->route('admin.stripekey.index')->with('success', 'Keys Created Successfully');
        } catch (Exception $e) {
            Log::error('Failed to create Stripe key: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to create keys. Please try again.')->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $StripeKey = StripeKey::find($id);
        return view('admin.stripe_keys.edit', ['StripeKey' => $StripeKey]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'stripe_key' => 'required|string|max:255',
            'stripe_secret' => 'required|string|max:255',
        ]);

        try {
            $stripeKey = StripeKey::findOrFail($id);

            $stripeKey->update([
                'key' => $request->input('stripe_key'),
                'secret' => $request->input('stripe_secret'),
            ]);

            return redirect()->route('admin.stripekey.index')->with('success', 'Keys Updated Successfully');
        } catch (Exception $e) {
            Log::error('Failed to update Stripe key: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to update keys. Please try again.')->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stripeKey = stripeKey::find($id);
        $stripeKey->delete();

        return redirect()->route('admin.stripekey.index')->with('success', 'Keys Deleted Successfully');
    }
}
