<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailConfirmReseting extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $getemailing;

    public function __construct($getemailing)
    {
        $this->getemailing = $getemailing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Resetting password completed ')
            ->markdown('mail.emailConfirmation')
            ->with([
                'name' => $this->getemailing,
            ]);
    }
}
