<?php

namespace App\Listeners;

use App\Mail\CampaignVerifiedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class CampaignVerifiedListener
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
    public function handle($event)
    {
       // Mail::to('ruben@iwinback.com')->cc('ces@tricycleltd.com')->send(new CampaignVerifiedMail($event->campaign));
          Mail::to('triumf.maqedonci@gmail.com')->send(new CampaignVerifiedMail($event->campaign));

    }
}

