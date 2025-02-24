<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Stripe\SetupIntent;
use Stripe\Customer;
use  Carbon\Carbon;
use  App\Models\CampaignDonors;
use  App\Models\Campaign;
use  App\Models\UserPurchasedTikets;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use function Spatie\ErrorSolutions\get;

//use Customer

class StripeService
{
    public function __construct()
    {
        // Set the secret key from .env
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    // Create a Payment Intent
    public function createPaymentIntent($amount)
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount, // Amount in cents
                'currency' => 'usd',
                'payment_method_types' => ['card'],
            ]);
            return $paymentIntent;
        } catch (ApiErrorException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function create_setup_intent($request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $intent = SetupIntent::create([
            'customer' => auth()->user()->stripe_customer_id,
        ]);
        return ['client_secret' => $intent->client_secret];
    }

    public function save_payment_method($request)
    {
        $paymentMethod = $request->input('paymentMethod');
        $user = auth()->user();
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        // Attach payment method to customer
        $customer = Customer::retrieve($user->stripe_customer_id);
        $customer->invoice_settings->default_payment_method = $paymentMethod;
        $customer->save();
        $user->payment_method = $paymentMethod;
        $user->last_card_no = $request->last_card_no;
        $user->save();


        return response()->json(['success' => true]);
    }

    public function donate($request, $team_member_id, $slug)
    {
        $amount = $request->input('amount');
        $user = auth()->user();
        $Campaign = Campaign::where('slug', $slug)->firstOrFail();
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        try {
            // Create a payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => ($amount * 100),
                'currency' => 'usd',
                'customer' => $user->stripe_customer_id,
                'payment_method' => $user->payment_method,
                'off_session' => true,
                'confirm' => true,
            ]);
            $status = $paymentIntent->status === 'succeeded' ? 1 : 0;
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            Transaction::create([
                'name' => 'donate',
                'amount' => $amount,
                'user_id' => $user->id,
                'currency' => "USD",
                'campaign_id' => $Campaign->id,
                'transaction_date' => now(),
                'method' => 'default',
                'payload_data' => json_encode($paymentIntent),
                'status' => $status,
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            CampaignDonors::create([
                'user_id' => $user->id,
                'campaigns_id' => $Campaign->id,
                'total_donate' => $amount,
                'team_member_id' => $team_member_id,
            ]);
            return [
                'success' => true,
                'paymentIntent' => $paymentIntent,
            ];

        } catch (\Exception $e) {
            // Log or handle the error
            \Log::error('Stripe Payment Error: ' . $e->getMessage());
            // Return error response
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function donate_list($request)
    {
        $amount = $request->input('amount');
        $user = auth()->user();
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        try {

            $donate = CampaignDonors::where('user_id', $user->id)->with('user','Campaign_detail')
                ->where('campaigns_id', $request->campaigns_id)
                ->get();
            // Return success response
            return [
                'success' => true,
                'data' => $donate,
            ];

        } catch (\Exception $e) {
            // Log or handle the error
            \Log::error('Stripe Payment Error: ' . $e->getMessage());

            // Return error response
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function ticket_purchase($request,$team_member_id)
    {
        $amount = $request->input('amount');
        $user = auth()->user();
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => ($amount * 100), // Stripe expects the amount in cents
                'currency' => 'usd',
                'customer' => $user->stripe_customer_id, // Assumes the user has a stored Stripe customer ID
                'payment_method' => $user->payment_method, // Assumes payment method is stored in your database
                'off_session' => true,
                'confirm' => true,
            ]);

            // Handle payment intent success
            $status = $paymentIntent->status === 'succeeded' ? 1 : 0;
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            // Log the transaction
            Transaction::create([
                'name' => 'donate',
                'amount' => $amount,
                'user_id' => $user->id,
                'currency' => "USD",
                'campaign_id' => $request->campaign_id,
                'transaction_date' => now(),
                'method' => 'default', // You can replace 'default' with the actual payment method
                'payload_data' => json_encode($paymentIntent), // You can replace 'default' with the actual payment method
                'status' => $status,
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            // Update campaign donors
            $t = UserPurchasedTikets::create([
                'user_id' => $user->id,
                'campaigns_id' => $request->campaigns_id,
                'ticket_id' => $request->ticket_id,
                'price' => $amount,
                'team_member_id' => $team_member_id,
            ]);
            // Return success response
            return [
                'success' => true,
                'paymentIntent' => $paymentIntent,
                'ticket' => $t
            ];

        } catch (\Exception $e) {
            // Log or handle the error
            \Log::error('Stripe Payment Error: ' . $e->getMessage());

            // Return error response
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function ticket_purchase_list($request)
    {

        $user = auth()->user();
        try {

            $t = UserPurchasedTikets::where('user_id', $user->id)->with('user','Campaign_detail')
//                ->where('campaigns_id', $request->campaigns_id)
                ->get();
//            $t = UserPurchasedTikets::where(['user_id' => $user->id, 'campaigns_id', $request->campaigns_id])->get();
            return [
                'ticket' => $t
            ];

        } catch (\Exception $e) {
            // Log or handle the error
            \Log::error('Stripe Payment Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
    public function transaction_list($request)
    {
     return   Transaction::where('user_id',auth()->id())->get();

    }

}
