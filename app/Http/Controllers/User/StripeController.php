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
            "currency" => $request->currency,
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
