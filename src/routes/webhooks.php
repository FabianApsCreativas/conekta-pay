<?php

use App\Events\ConektaEvent;
use Illuminate\Http\Request;

Route::prefix('conekta')->group(function () {
    Route::post('webhook', function (Request $request) {
        event(new ConektaEvent($request));
    })->name('conekta.webhook');
});