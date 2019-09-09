<?php

namespace ApsCreativas\ConektaPay;

use Conekta\Conekta;

class ConektaPay
{
    public function __construct()
    {
        Conekta::setApiKey(config('conekta.api_key'));
        Conekta::setApiVersion(config('conekta.api_version'));
        Conekta::setLocale(config('app.locale'));
    }
}
