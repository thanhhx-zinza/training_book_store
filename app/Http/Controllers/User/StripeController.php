<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Stripe;

class StripeController extends Controller
{
    public function __construct()
    {
        $this->UNIT_NUMBER = 100;
        /* https://stripe.com/docs/currencies#zero-decimal
        All API requests expect amounts to be provided in a currency’s smallest unit.
        for example 100 cents = 1$. So UNIT_NUMBER is used to make sure that you pay $
        not cents
        */
    }
    /**
     * Success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('frontend.stripe.stripe');
    }

    /**
     * Success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge = Stripe\Charge::create([
            "amount" => $request->amount * $this->UNIT_NUMBER,
            "currency" => 'usd',
            "source" => $request->stripeToken,
        ]);
        if ($charge) {
            $payment =
            [
                'amount' => $request->amount,
                'currency' => $request->currency,
                'charge_id' => $charge->id,
            ];
            if ($this->currentUser()->payment()->create($payment)) {
                $premium = [
                    'status' => "premium",
                ];
                if ($this->currentUser()->update($premium)) {
                    return redirect('/home')->with('success', "upgrade account successfully");
                }
                return redirect('/home')->with('error', " can not upgrade your account");
            }
        }
    }
}
