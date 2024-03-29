<?php

namespace ApsCreativas\ConektaPay;

use Illuminate\Support\ServiceProvider;

class ConektaPayServiceProvider extends ServiceProvider
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
            __DIR__ . '/events/ConektaEvent.ph' => app_path('Events/ConektaEvent.php'),
            __DIR__ . '/listeners/ConektaListener.ph' => app_path('Listeners/ConektaListener.php'),

        ], 'conektapay');
    }
}
