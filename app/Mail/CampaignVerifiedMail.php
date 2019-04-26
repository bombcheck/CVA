<?php

namespace App\Mail;

use App\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CampaignVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    private $campaign;

    /**
     * Create a new message instance.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email')
            ->with([
                'title' => $this->campaign->title,
                'client_name' => $this->campaign->client->name,
                'brand_name' => $this->campaign->brand->name,
            ])
            ->subject("CAV: Campaign " .$this->campaign->title. " has been verified!");
    }
}
