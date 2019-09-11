<?php

use App\Events\ConektaEvent;
use Illuminate\Http\Request;

Route::prefix('conekta')->group(function () {
    Route::post('webhook', function (Request $request) {
        switch ($request->type) {
            case 'order.paid':
                $chargeable = config('conekta.chargeable');
                $chargeable = new $chargeable;
                $chargeable = $chargeable->where('conekta_order_id', $request->data['object']['id'])->first();
                $chargeable->update([
                    'conekta_order_status' => $request->data['object']['payment_status']
                ]);
                break;
            default:
                break;
                
            event(new ConektaEvent($request));
        }
    })->name('conekta.webhook');
});
