<?php

namespace App\Listeners;

use App\Events\ConektaEvent;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConektaListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ConektaEvent $event)
    {
        try {
            switch ($event->request->type) {
                case 'charge.created':
                    # code...
                    break;
                case 'order.created':
                    # code...
                    break;
                case 'charge.paid':
                    # code...
                    break;
                case 'order.paid':
                    $chargeable = config('conekta.chargeable');
                    $chargeable = new $chargeable;
                    $chargeable = $chargeable->where('conekta_order_id', $event->request->data['object']['id'])->update([
                        'conekta_order_status' => $event->request->data['object']['payment_status']
                    ]);
                    // Custom paid logic
                    break;
                case 'order.pending_payment':
                    # code...
                    break;
                case 'order.expired':
                    # code...
                    break;
                case 'charge.refunded':
                    # code...
                    break;
                default:
                    return;
                    break;
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
