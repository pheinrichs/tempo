<?php

namespace App\Listeners;

use App\Events\AccountModified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogEvent
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
     * @param  AccountModified  $event
     * @return void
     */
    public function handle(AccountModified $event)
    {
        logger()->info(json_encode($event));
    }
}
