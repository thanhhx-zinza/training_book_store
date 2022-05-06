<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Webhook;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = str_replace('.', '_', $payload['type']);
        Webhook::create(
            [
                'name' => $method,
                'payload' => $payload['id'],
            ]
        );
    }
}
