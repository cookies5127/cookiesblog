<?php

namespace App\Listeners;

use App\Events\Art;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArtListener
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
     * @param  ArtUpdate  $event
     * @return void
     */
    public function handle(Art $event)
    {
        //
    }
}
