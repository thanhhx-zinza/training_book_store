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
        if (array_key_exists('data', $payload) && array_key_exists('object', $payload['data'])) {
            $payloadObject = $payload['data']['object'];
        } else {
            $payloadObject = [];
        }
        if (array_key_exists('id', $payloadObject)) {
            $payment = Payment::where('charge_id', $payloadObject['id'])->first();
        } else {
            $payment = null;
        }
        Webhook::create(
            [
                'event' => $method,
                'payload_id' => array_key_exists('id', $payload) ? $payload['id'] : null,
                'user_id' => $payment != null ? $payment->user_id : null,
                'amount (cent)' => array_key_exists('amount', $payloadObject) ? $payloadObject['amount'] : null,
            ]
        );
    }
}
