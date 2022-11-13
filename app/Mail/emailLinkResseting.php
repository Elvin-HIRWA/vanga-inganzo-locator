<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailLinkResseting extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $resettingurl;
    protected $useremail;

    public function __construct($resettingurl, $useremail)
    {
        $this->resettingurl = $resettingurl;
        $this->useremail = $useremail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Resetting password')
            ->markdown('mail.resetingEmail')
            ->with([
                'name' => $this->useremail,
                'link' => $this->resettingurl
            ]);
    }
}
