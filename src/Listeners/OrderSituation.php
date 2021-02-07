<?php

namespace Armincms\Sofre\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Armincms\Sofre\Models\Order;

class OrderSituation
{ 
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if(get_class($event->resource) != Order::class) {
            return;
        }

        switch ($event->key) {
            case 'order-preparing':
                $event->resource->asPreparing();
                break;

            case 'order-shipped':
                $event->resource->asShipped();
                break;

            case 'order-completed':
                $event->resource->asCompleted();
                $event->resource->invoice->asCompleted();
                break;
            
            default:
                # code...
                break;
        }
    }
}
