<?php

use Conekta\Conekta;

trait ConektaPay {

    public static function bootConektaPay()
    {
        Conekta::setApiKey(config('conekta.api_key'));
        Conekta::setApiVersion(config('conekta.api_version'));
        Conekta::setLocale('es');
    }
}