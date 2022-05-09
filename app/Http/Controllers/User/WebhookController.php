<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Webhook;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = str_replace('.', '_', $payload['type']);
        $payment = Payment::where('charge_id', $payload['data']['object']['id'])->first();
        Webhook::create(
            [
                'event' => $method,
                'payload_id' => $payload['id'],
                'user_id' => $payment->user_id,
                'amount (cent)' => $payload['data']['object']['amount'],
            ]
        );
    }
}
