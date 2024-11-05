<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Registered
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->generateLink();
    }
}
