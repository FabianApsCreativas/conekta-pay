<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::prefix('conekta')->group(function () {
    Route::post('webhook', function (Request $request) {
        switch ($request->data['type']) {
            case 'order.paid':
                $chargeable = config('conekta.chargeable');
                $chargeable = new $chargeable;
                $chargeable = $chargeable->where('conekta_order_id', $request->data['object']['id'])->first();
                $chargeable->update([
                    'conekta_order_status' => $request->data['object']['payment_status']
                ]);
                break;
            default:
                Log::info($request->all());
                break;
        }
    })->name('conekta.webhook');
});
