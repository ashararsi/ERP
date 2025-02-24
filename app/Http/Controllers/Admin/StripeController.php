<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\Payout;
use App\Http\Controllers\Controller;

class StripeController extends Controller
{
    // 1️⃣ Create a Connected Account (For Clients)
    public function createConnectedAccount(Request $request)
    {
         Stripe::setApiKey(env('STRIPE_SECRET_KEY'));


        $account = Account::create([
            'type' => 'express', // Use 'custom' for full control
            'country' => 'US',
            'email' => $request->email,
            'capabilities' => [
                'transfers' => ['requested' => true],
            ],
        ]);

        return redirect()->route('admin.onboarding', ['accountId' => $account->id]);
    }

    // 2️⃣ Generate Onboarding Link (For Bank Details)
    public function createAccountLink($accountId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $accountLink = AccountLink::create([
            'account' => $accountId,
            'refresh_url' => route('admin.onboarding', ['accountId' => $accountId]), // If session expires
            'return_url' => route('admin.payout.form'), // After setup
            'type' => 'account_onboarding',
        ]);

        return redirect($accountLink->url);
    }

    // 3️⃣ Send Payment to Client's Bank Account
    public function sendPayout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $payout = Payout::create([
            'amount' => $request->amount * 100, // Convert to cents
            'currency' => 'usd',
            'method' => 'standard', // Use 'instant' for faster payout (higher fees)
        ], [
            'stripe_account' => $request->stripe_account_id, // Client's Stripe account ID
        ]);

        return back()->with('success', 'Payout sent successfully!');
    }

    // 4️⃣ Payout Form (HTML)
    public function payoutForm()
    {
        return view('admin.stripe.payout');
    }
}
