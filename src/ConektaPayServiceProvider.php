<?php

namespace ApsCreativas\OxxoPay;

use Illuminate\Support\ServiceProvider;

class OxxoPayServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('conektapay', function() {
            return new ConektaPay();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__ . '/functions/functions.php';
        
        $this->loadRoutesFrom(__DIR__ . '/routes/webhooks.php');

        

        $this->publishes([
            __DIR__ . '/config/conekta.php' => config_path('conekta.php'),
            __DIR__ . '/migrations/2019_08_28_161440_add_conekta_pay_to_users.php' => database_path('/migrations'.'/2019_08_28_161440'.'_add_conekta_pay_to_users.php'),
            __DIR__ . '/migrations/2019_08_28_183530_create_orders_table.php' => database_path('/migrations/2019_08_28_183530_create_orders_table.php'),

        ], 'conektapay');
    }
}
