<?php

namespace App\Listeners;

use App\Events\BillingEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBillingNotification
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
     * @param  \App\Events\BillingEvents  $event
     * @return void
     */
    public function handle(BillingEvents $event)
    {
        //
    }
}