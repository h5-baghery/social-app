<?php
namespace App\Listeners;

use App\Events\OurExampleEvent;
use Illuminate\Support\Facades\Log;

class OurExampleListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OurExampleEvent $event)
    {

        Log::debug("the user {$event->username} has just performed {$event->action}.");
    }
}
